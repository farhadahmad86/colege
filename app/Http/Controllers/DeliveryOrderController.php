<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\CreditCardMachineModel;
use App\Models\DayEndModel;
use App\Models\DeliveryChallanModel;
use App\Models\DeliveryOrderItemsModel;
use App\Models\DeliveryOrderModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductModel;
use App\Models\ProductPackagesModel;
use App\Models\ReportConfigModel;
use App\Models\SaleInvoiceItemsModel;
use App\Models\SaleInvoiceModel;
use App\Models\ServicesInvoiceModel;
use App\Models\ServicesModel;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryOrderController extends Controller
{
    public function delivery_order()
    {

//        $accounts = $this->get_account_query('sale')[0];

        $services = ServicesModel::where('ser_delete_status', '!=', 1)->where('ser_disabled', '!=', 1)->orderBy('ser_id', 'ASC')->get();

        $service_code = '';
        $service_name = '';

        foreach ($services as $service) {
            $service_code .= "<option value='$service->ser_id'>$service->ser_id</option>";
            $service_name .= "<option value='$service->ser_id'>$service->ser_title</option>";
        }

        $machines = CreditCardMachineModel::where('ccm_delete_status', '!=', 1)->where('ccm_disabled', '!=', 1)->orderBy('ccm_title', 'ASC')->get();

        $packages = ProductPackagesModel::where('pp_delete_status', '!=', 1)->where('pp_disabled', '!=', 1)->orderBy('pp_name', 'ASC')->get();

        $sale_persons = User::where('user_id', '!=', 1)->where('user_login_status', '=', 'ENABLE')->where('user_delete_status', '!=', 1)->orderBy('user_role_id', 'DESC')->orderBy('user_name', 'ASC')->get();

//        $warehouses = $this->get_all_warehouse();
//        $posting_references = PostingReferenceModel::where('pr_disabled', '=', 0)->get();

        return view('delivery_order', compact( 'sale_persons', 'machines', 'service_code', 'service_name', 'packages'));
    }

    public function submit_delivery_order(Request $request)
    {

        $this->delivery_order_validation($request);

        $product_total_items = 0;

        $delivery_array = [];

        $requested_arrays = $request->pro_code;

        foreach ($requested_arrays as $index => $requested_array) {

            $item_code = $request->pro_code[$index];
            $item_name = $request->pro_name[$index];
            $item_remarks = $request->product_remarks[$index];
            $item_warehouse = isset($request->warehouse[$index]) ? $request->warehouse[$index] : 0;
            $item_unit_measurement = $request->unit_measurement[$index];
            $item_unit_measurement_scale_size = $request->unit_measurement_scale_size[$index];
            $item_quantity = $request->quantity[$index];
            $item_bonus = isset($request->bonus[$index]) ? $request->bonus[$index] : 0;
            $item_rate = $request->rate[$index];
            $item_amount = $request->amount[$index];

            if ($request->product_or_service_status[$index] == 0) {

                $product_total_items++;

                $delivery_array[] = [
                    'product_code' => $item_code,
                    'product_name' => $item_name,
                    'product_remarks' => $item_remarks,
                    'warehouse' => $item_warehouse,
                    'product_qty' => $item_quantity,
                    'product_unit_measurement' => $item_unit_measurement,
                    'product_unit_measurement_scale_size' => $item_unit_measurement_scale_size,
                    'product_bonus_qty' => $item_bonus,
                    'product_rate' => $item_rate,
                    'product_amount' => $item_amount,

                ];
            }
        }

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $rollBack = false;
        $account_code = $request->account_name;
        $account_name = $this->get_account_name($account_code);

        $user = Auth::user();


        DB::beginTransaction();

        $delivery_prefix = 'do';
        $delivery_items_prefix = 'doi';
        $delivery_qty_hold_prefix = 'doqh';
        $qty_hold_table = 'financials_delivery_order_qty_hold_log';

        $delivery_chalan = new DeliveryOrderModel();
        $item_table = 'financials_delivery_order_items';


        $notes = 'DELIVERY_ORDER';


        $voucher_code = config('global_variables.DELIVERY_ORDER_VOUCHER_CODE');

        //sale invoice
        if (!empty($delivery_array)) {

//            array_walk($delivery_array, function (&$a) {
//                $a['warehouse'] = 1;
//            });


            //////////////////////////// Sale Invoice Insertion ////////////////////////////////////

            $delivery_chalan = $this->AssignDeliveryOrderInvoiceValues($request, $delivery_chalan, $day_end, $user, $delivery_prefix, $account_code, $account_name, $request->remarks, $product_total_items);

            if ($delivery_chalan->save()) {

                $s_id = $delivery_prefix . '_id';

                $delivery_chalan_id = $delivery_chalan->$s_id;

                $delivery_chalan_number = $voucher_code . $delivery_chalan_id;
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Sale Invoice Items Insertion ////////////////////////////////////
            $detail_remarks = '';

            $item = $this->AssignDeliveryOrderInvoiceItemsValues($delivery_chalan_id, $delivery_array, $delivery_items_prefix, 1);

            foreach ($item as $value) {

                $detail_remarks .= $value[$delivery_items_prefix . '_product_name'] . ', ' . $value[$delivery_items_prefix . '_qty'] . config('global_variables.Line_Break');
            }

            if (!DB::table($item_table)->insert($item)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }
            $item_qty = $this->AssignDeliveryOrderQty($delivery_chalan_id, $delivery_array, $delivery_qty_hold_prefix, 1);
            if (!DB::table($qty_hold_table)->insert($item_qty)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Details Remarks of Sale Invoice Insertion ////////////////////////////////////

            $sale_detail_remarks = $delivery_prefix . '_detail_remarks';

            $delivery_chalan->$sale_detail_remarks = $detail_remarks;

            if (!$delivery_chalan->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Product Inventory Insertion ////////////////////////////////////

//            $inventory = $this->AssignProductInventoryValues($delivery_array, 2);
//
//            if (!$inventory) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            //////////////////////////// Warehouse Stock Insertion ////////////////////////////////////

            $warehouses = [];
            $warehouse = $this->AssignWarehouseStocksValues($warehouses, $delivery_array, 2);

            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////

            $warehouses_summary = [];
            $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $delivery_array, 'DELIVERY-ORDER');

            if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Stock Movement Insertion ////////////////////////////////////

            $stock_movement = $this->stock_movement_module_delivery($delivery_array, $voucher_code . $delivery_chalan_id, 'DELIVERY-ORDER', 'DELIVERY-ORDER');

            if (!$stock_movement) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Stock Movement Child Insertion ////////////////////////////////////
            $stock_movement_child = $this->stock_movement_child($delivery_array, $delivery_chalan_id, $account_code, $account_name, 'DELIVERY_ORDER');

            if (!$stock_movement_child) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $delivery_chalan_id);

        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function delivery_order_validation($request)
    {
        return $this->validate($request, [
            'account_name' => ['required', 'numeric'],
            "remarks" => ['nullable', 'string'],
            "customer_name" => ['nullable', 'string'],
            "total_items" => ['required', 'numeric', 'min:1'],
            'customer_email' => ['nullable', 'string', 'email'],
            'customer_phone_number' => ['nullable', 'numeric'],
            'product_or_service_status' => ['required', 'array'],
            'product_or_service_status.*' => ['required', 'string'],
            'pro_code' => ['required', 'array'],
            'pro_code.*' => ['required', 'string'],
            'pro_name' => ['required', 'array'],
            'pro_name.*' => ['required', 'string'],
            'product_remarks' => ['nullable', 'array'],
            'product_remarks.*' => ['nullable', 'string'],
            'unit_measurement' => ['nullable', 'array'],
            'unit_measurement.*' => ['nullable', 'string'],
            'warehouse' => ['nullable', 'array'],
            'warehouse.*' => ['nullable', 'numeric'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric'],
            'bonus' => ['nullable', 'array'],
            'bonus.*' => ['nullable', 'numeric'],

        ]);
    }

    public function AssignDeliveryOrderInvoiceValues($request, $delivery_chalan, $day_end, $user, $prfx, $account_code, $account_name, $remarks, $total_item, $invoice_no = 0)
    {//status 1 for products and 2 for services
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $col_party_code = $prfx . '_party_code';
        $col_party_name = $prfx . '_party_name';
        $col_posting_reference = $prfx . '_pr_id';
        $col_customer_name = $prfx . '_customer_name';
        $col_remarks = $prfx . '_remarks';
        $col_total_items = $prfx . '_total_items';

        $col_cash_paid = $prfx . '_cash_received';
        $col_datetime = $prfx . '_datetime';
        $col_day_end_id = $prfx . '_day_end_id';
        $col_day_end_date = $prfx . '_day_end_date';
        $col_createdby = $prfx . '_createdby';
        $col_detail_remarks = $prfx . '_detail_remarks';
        $col_ip_adrs = $prfx . '_ip_adrs';
        $col_brwsr_info = $prfx . '_brwsr_info';
        $col_update_datetime = $prfx . '_update_datetime';
        $col_invoice_number = $prfx . '_invoice_number';
        $col_email = $prfx . '_email';

        $col_dc_id = $prfx . '_dc_id';


        $delivery_chalan->$col_party_code = $account_code;
        $delivery_chalan->$col_party_name = $account_name;
        $delivery_chalan->$col_posting_reference = $request->posting_reference;
        $delivery_chalan->$col_customer_name = ucwords($request->customer_name);
        $delivery_chalan->$col_remarks = ucfirst($remarks);
        $delivery_chalan->$col_total_items = $request->total_items;


        $delivery_chalan->$col_datetime = Carbon::now()->toDateTimeString();
        $delivery_chalan->$col_day_end_id = $day_end->de_id;
        $delivery_chalan->$col_day_end_date = $day_end->de_datetime;
        $delivery_chalan->$col_createdby = $user->user_id;
        $delivery_chalan->$col_brwsr_info = $brwsr_rslt;
        $delivery_chalan->$col_ip_adrs = $ip_rslt;
        $delivery_chalan->$col_update_datetime = Carbon::now()->toDateTimeString();

        if ($invoice_no > 0 && !empty($invoice_no)) {
            $delivery_chalan->$col_invoice_number = $invoice_no;
        } else {
            $delivery_chalan->$col_email = $request->customer_email;
//            $delivery_chalan->$col_dc_id = $request->customer_phone_number;

        }

        return $delivery_chalan;
    }

    public function AssignDeliveryOrderInvoiceItemsValues($invoice_id, $array, $prfx, $status)
    {//status 1 for products and 2 for services

        $data = [];

        if ($status == 1) {

            foreach ($array as $value) {
                $gross_amount = 0;
                $average_rate = $this->product_stock_movement_last_row($value['product_code']);

                if ($average_rate->sm_bal_total_qty_wo_bonus < 0) {
                    $gross_amount = 0;
                } else {
                    $gross_amount = $value['product_amount'];
                }
//                if (isset($average_rate)) {
//                    $this->actual_stock_price += $average_rate->sm_bal_rate * $value['product_qty'];
//                } else {
//
//                    $purchase_rate = $this->get_product_purchase_rate($value['product_code']);
//
//                    $this->actual_stock_price += $purchase_rate * $value['product_qty'];
//                }


//                $this->product_total_rate += $value['product_qty'] * $value['product_rate'];

                $delivery_chalan = $prfx . '_invoice_id';
                $product_code = $prfx . '_product_code';
                $product_name = $prfx . '_product_name';
                $remarks = $prfx . '_remarks';
                $warehouse = $prfx . '_warehouse_id';
                $qty = $prfx . '_qty';
                $due_qty = $prfx . '_due_qty';
                $uom = $prfx . '_uom';
                $scale_size = $prfx . '_scale_size';
                $rate = $prfx . '_rate';
                $bonus_qty = $prfx . '_bonus_qty';
                $amount = $prfx . '_amount';


                $data[] = [
                    $delivery_chalan => $invoice_id,
                    $product_code => $value['product_code'],
                    $product_name => ucwords($value['product_name']),
                    $remarks => ucfirst($value['product_remarks']),
                    $warehouse => ucfirst($value['warehouse']),
                    $qty => $value['product_qty'],
                    $due_qty => $value['product_qty'],
                    $uom => $value['product_unit_measurement'],
                    $scale_size => $value['product_unit_measurement_scale_size'],
                    $bonus_qty => $value['product_bonus_qty'],
                    $rate => $value['product_rate'],
                    $amount => $gross_amount,
                ];
            }
        }

        return $data;
    }

    public function AssignDeliveryOrderQty($invoice_id, $array, $prfx, $status)
    {//status 1 for products and 2 for services

        $data = [];

        if ($status == 1) {

            foreach ($array as $value) {

                $delivery_chalan = $prfx . '_do_id';
                $warehouse = $prfx . '_warehouse_id';
                $product_code = $prfx . '_product_code';
                $qty = $prfx . '_total_qty';
                $balance_qty = $prfx . '_balance_qty';


                $data[] = [
                    $delivery_chalan => $invoice_id,
                    $warehouse => $value['warehouse'],
                    $product_code => $value['product_code'],
                    $qty => $value['product_qty'],
                    $balance_qty => $value['product_qty'],
                ];
            }
        }

        return $data;
    }

    public function get_delivery_order_items_for_sale(Request $request)
    {
        //$invoice_type = $request->invoice_type;
        $invoice_no = $request->invoice_no;
        //$desktop_invoice_id = $request->desktop_invoice_id;

        $array = [];

        $day_end_date = DayEndModel::orderBy('de_id', 'DESC')->pluck('de_datetime')->first();
        $sale = DeliveryOrderModel::where('do_id', $invoice_no)->first();
        $do_date = date('Y-m-d', strtotime($sale->do_datetime));
        if ($day_end_date >= $do_date) {
            if ($sale != null) {

                $items = DB::table('financials_delivery_order_items as doi')
                    ->leftJoin('financials_products as pro', 'pro.pro_p_code', 'doi.doi_product_code')
                    ->where('doi.doi_invoice_id', '=', $invoice_no)
                    ->where('doi.doi_due_qty', '>', 0)
                    ->select('doi.doi_invoice_id', 'doi.doi_product_code', 'doi.doi_product_name', 'doi.doi_remarks', 'doi.doi_qty', 'doi.doi_due_qty', 'doi.doi_uom', 'doi.doi_bonus_qty', 'doi.doi_warehouse_id', 'pro.pro_sale_price as doi_rate')
                    ->get();

                $array[] = $sale;
                $array[] = $items;
                return response()->json($array);
            } else {
                return response()->json(['message' => 'No data Found']);
            }
        } else {
            return response()->json(['message' => 'not eligible','deliveryDate'=>$do_date,'dayEndDate'=>$day_end_date]);
        }
    }

    public function get_sale_order_delivery_order_items_for_sale(Request $request)
    {
        //$invoice_type = $request->invoice_type;
        $invoice_no = $request->invoice_no;
        //$desktop_invoice_id = $request->desktop_invoice_id;

        $array = [];

        $day_end_date = DayEndModel::orderBy('de_id', 'DESC')->pluck('de_datetime')->first();
        $sale = DeliveryOrderModel::where('do_id', $invoice_no)->first();

        $do_date = date('Y-m-d', strtotime($sale->do_datetime));
        if ($day_end_date >= $do_date) {
            if ($sale != null) {

                $items = DB::table('financials_delivery_order_items as doi')
                    ->leftJoin('financials_products as pro', 'pro.pro_p_code', 'doi.doi_product_code')
                    ->where('doi.doi_invoice_id', '=', $invoice_no)
                    ->where('doi.doi_due_qty', '>', 0)
                    ->select('doi.doi_invoice_id', 'doi.doi_product_code', 'doi.doi_product_name', 'doi.doi_remarks', 'doi.doi_qty', 'doi.doi_due_qty', 'doi.doi_uom', 'doi.doi_bonus_qty', 'doi.doi_warehouse_id', 'doi.doi_rate as doi_service_rate', 'pro.pro_sale_price as doi_rate', 'doi.doi_scale_size', 'doi.doi_pro_ser_status')
                    ->get();

                $array[] = $sale;
                $array[] = $items;
                return response()->json($array);
            } else {
                return response()->json(['message' => 'No data Found']);
            }
        } else {
            return response()->json(['message' => 'not eligible']);
        }
    }


// update code by shahzaib start
    public
    function delivery_order_invoice_list(Request $request, $array = null, $str = null)
    {
        $heads = config('global_variables.payable_receivable_cash');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::orderBy('pro_title', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $check_desktop = $request->check_desktop;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.delivery_order_list.delivery_order_list';
        $pge_title = 'Delivery Order List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_delivery_order')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_delivery_order.do_createdby');

        if (!empty($search)) {

            $query->where(function ($query) use ($search) {
                $query->where('do_party_code', 'like', '%' . $search . '%')
                    ->orWhere('do_party_name', 'like', '%' . $search . '%')
                    ->orWhere('do_remarks', 'like', '%' . $search . '%')
                    ->orWhere('do_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });

        }

        if (!empty($search_account)) {
            $query->where('do_party_code', $search_account);
        }

        if (!empty($search_product)) {
            $get_p_id = DeliveryOrderItemsModel::where('doi_product_code', $search_product)->pluck('doi_invoice_id')->all();
            $query->whereIn('do_id', $get_p_id);
        }

        if (!empty($search_by_user)) {
            $query->where('do_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('do_day_end_date', [$start, $end]);
            $query->whereDate('do_day_end_date', '>=', $start)
                ->whereDate('do_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('do_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('do_day_end_date', $end);
        }

        $datas = $query->orderBy('do_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl'=>[
                    'verify_peer'=>FALSE,
                    'verify_peer_name'=>FALSE,
                    'allow_self_signed'=>TRUE,
                ]
            ]);
            $optionss =[
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
            $pdf->getDomPDF()->setHttpContext($options,$optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('delivery_order_list', compact('datas', 'search', 'party', 'accounts', 'search_account', 'search_product', 'products', 'search_to', 'search_from', 'check_desktop', 'search_by_user'));
        }
    }

// update code by shahzaib end

    public
    function delivery_order_items_view_details(Request $request)
    {
        $items = DeliveryOrderItemsModel::where('doi_invoice_id', $request->id)->orderby('doi_product_name', 'ASC')->get();

        return response()->json($items);
    }

    public
    function delivery_order_items_view_details_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice', 'rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0) {
            $sim = DeliveryOrderModel::where('do_id', $id)->first();
        } else {
            $sim = DB::table('financials_delivery_order')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_delivery_order.do_party_code')
                ->where('do_id', $id)
                ->select('financials_accounts.account_urdu_name as do_party_name', 'do_id', 'do_party_code', 'do_customer_name', 'do_remarks', 'do_total_items', 'do_day_end_id', 'do_day_end_date',
                    'do_createdby')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $sim->do_party_code)->first();
        if ($urdu_eng->rc_invoice == 0) {
            $siims = DB::table('financials_delivery_order_items')
                ->where('doi_invoice_id', $id)
                ->orderby('doi_product_name', 'ASC')
                ->select('doi_product_name as name', 'doi_remarks as remarks', 'doi_qty as qty', 'doi_due_qty as due_qty', 'doi_bonus_qty as bonus', 'doi_status as status')
                ->get();
        } else {
            $siims = DB::table('financials_delivery_order_items')
                ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_delivery_order_items.doi_product_code')
                ->where('doi_invoice_id', $id)
                ->orderby('doi_product_name', 'ASC')
                ->select('financials_products.pro_urdu_title as name', 'doi_remarks as remarks', 'doi_qty as qty', 'doi_due_qty as due_qty', 'doi_bonus_qty as bonus', 'doi_status as status')
                ->get();
        }

//        $si_grand_total = (isset($sim->si_grand_total) && !empty($sim->si_grand_total)) ? $sim->si_grand_total : 0;
//        $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;
//        $mainGrndTtl = +$si_grand_total + +$sei_grand_total;
//        $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
        $invoice_nbr = $sim->do_id;
        $invoice_date = $sim->do_day_end_date;
        $type = 'grid';
        $pge_title = 'Delivery Order Invoice';

        return view('invoice_view.delivery_order_invoice.delivery_order_invoice_list_modal', compact('siims', 'sim', 'accnts', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));
    }

    public
    function delivery_order_items_view_details_pdf_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice', 'rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0) {
            $sim = DeliveryOrderModel::where('do_id', $id)->first();
        } else {
            $sim = DB::table('financials_delivery_order')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_delivery_order.do_party_code')
                ->where('do_id', $id)
                ->select('financials_accounts.account_urdu_name as do_party_name', 'do_id', 'do_party_code', 'do_customer_name', 'do_remarks', 'do_total_items', 'do_day_end_id', 'do_day_end_date',
                    'do_createdby')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $sim->do_party_code)->first();
        if ($urdu_eng->rc_invoice == 0) {
            $siims = DB::table('financials_delivery_order_items')
                ->where('doi_invoice_id', $id)
                ->orderby('doi_product_name', 'ASC')
                ->select('doi_product_name as name', 'doi_remarks as remarks', 'doi_qty as qty', 'doi_due_qty as due_qty', 'doi_bonus_qty as bonus', 'doi_status as status')
                ->get();
        } else {
            $siims = DB::table('financials_delivery_order_items')
                ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_delivery_order_items.doi_product_code')
                ->where('doi_invoice_id', $id)
                ->orderby('doi_product_name', 'ASC')
                ->select('financials_products.pro_urdu_title as name', 'doi_remarks as remarks', 'doi_qty as qty', 'doi_due_qty as due_qty', 'doi_bonus_qty as bonus', 'doi_status as status')
                ->get();
        }

        //$nbrOfWrds = $this->myCnvrtNbr($sim->si_grand_total);
        $invoice_nbr = $sim->do_id;
        $invoice_date = $sim->do_day_end_date;
        $type = 'pdf';
        $pge_title = 'Delivery Order Invoice';


        $footer = view('invoice_view._partials.pdf_footer')->render();
        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
        $options = stream_context_create([
            'ssl'=>[
                'verify_peer'=>FALSE,
                'verify_peer_name'=>FALSE,
                'allow_self_signed'=>TRUE,
            ]
        ]);
        $optionss =[
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 24,
        ];
        $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
        $pdf->getDomPDF()->setHttpContext($options,$optionss);
        $pdf->loadView('invoice_view.delivery_order_invoice.delivery_order_invoice_list_modal', compact('siims', 'sim', 'accnts', 'type', 'pge_title','invoice_nbr','invoice_date'));
        // $pdf->setOptions($options);

        return $pdf->stream('Deliver-Order-Invoice.pdf');
    }

// update code by shahzaib start
}
