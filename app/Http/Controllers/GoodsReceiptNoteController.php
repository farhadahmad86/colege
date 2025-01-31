<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\CreditCardMachineModel;
use App\Models\DayEndModel;
use App\Models\FinancialPurchaseOrderModel;
use App\Models\GoodsReceiptNoteItemsModel;
use App\Models\GoodsReceiptNoteModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductModel;
use App\Models\ProductPackagesModel;
use App\Models\ReportConfigModel;
use App\Models\ServicesModel;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GoodsReceiptNoteController extends Controller
{
    public function goods_receipt_note()
    {

//        $accounts = $this->get_account_query('purchase')[0];

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


        $po = FinancialPurchaseOrderModel::all();


        return view('goods_receipt_note', compact('po', 'sale_persons', 'machines', 'service_code', 'service_name', 'packages'));
    }

    public function submit_goods_receipt_note(Request $request)
    {
//        dd($request);
        $this->goods_receipt_note_validation($request);

        $product_total_items = 0;

        $grn_array = [];

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
//            $item_rate = $request->rate[$index];
//            $item_amount = $request->amount[$index];

            if ($request->product_or_service_status[$index] == 0) {

                $product_total_items++;

                $grn_array[] = [
                    'product_code' => $item_code,
                    'product_name' => $item_name,
                    'product_remarks' => $item_remarks,
                    'warehouse' => $item_warehouse,
                    'product_qty' => $item_quantity,
                    'product_unit_measurement' => $item_unit_measurement,
                    'product_unit_measurement_scale_size' => $item_unit_measurement_scale_size,
                    'product_bonus_qty' => $item_bonus,
//                    'product_rate' => $item_rate,
//                    'product_amount' => $item_amount,

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

        $grn_prefix = 'grn';
        $grn_items_prefix = 'grni';
        $grn_log_prefix = 'grnl';
        $grn_log_table = 'financials_grn_log';
        $goods_receipt_note = new GoodsReceiptNoteModel();
        $item_table = 'financials_goods_receipt_note_items';


        $notes = 'GOODS_RECEIPT_NOTE';


        $voucher_code = config('global_variables.GOODS_RECEIPT_NOTE_CODE');

        //sale invoice
        if (!empty($grn_array)) {

//            array_walk($grn_array, function (&$a) {
//                $a['warehouse'] = 1;
//            });


            //////////////////////////// Sale Invoice Insertion ////////////////////////////////////

            $goods_receipt_note = $this->AssignGoodsReceiptNoteValues($request, $goods_receipt_note, $day_end, $user, $grn_prefix, $account_code, $account_name, $request->remarks,
                $product_total_items);

            if ($goods_receipt_note->save()) {

                $s_id = $grn_prefix . '_id';

                $goods_receipt_note_id = $goods_receipt_note->$s_id;

                $goods_receipt_note_number = $voucher_code . $goods_receipt_note_id;
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Sale Invoice Items Insertion ////////////////////////////////////
            $detail_remarks = '';

            $item = $this->AssignGoodsReceiptNoteItemsValues($goods_receipt_note_id, $grn_array, $grn_items_prefix, 1);

            foreach ($item as $value) {

                $detail_remarks .= $value[$grn_items_prefix . '_product_name'] . ', ' . $value[$grn_items_prefix . '_qty'] . config('global_variables.Line_Break');
            }

            if (!DB::table($item_table)->insert($item)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $item_qty = $this->AssignGRNOrderQty($goods_receipt_note_id, $grn_array, $grn_log_prefix, 1);
            if (!DB::table($grn_log_table)->insert($item_qty)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Details Remarks of Sale Invoice Insertion ////////////////////////////////////

            $grn_detail_remarks = $grn_prefix . '_detail_remarks';

            $goods_receipt_note->$grn_detail_remarks = $detail_remarks;

            if (!$goods_receipt_note->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Product Inventory Insertion ////////////////////////////////////

//            $inventory = $this->AssignProductInventoryValues($grn_array, 2);
//
//            if (!$inventory) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            //////////////////////////// Warehouse Stock Insertion ////////////////////////////////////

            $warehouses = [];
            $warehouse = $this->AssignWarehouseStocksValues($warehouses, $grn_array, 1);

            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////

            $warehouses_summary = [];
            $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $grn_array, 'GOODS-RECEIPT-NOTE');

            if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Stock Movement Insertion ////////////////////////////////////

            $stock_movement = $this->stock_movement_module_goods_receipt_note($grn_array, $voucher_code . $goods_receipt_note_id, 'GOODS-RECEIPT-NOTE', 'GOODS-RECEIPT-NOTE');

            if (!$stock_movement) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Stock Movement Child Insertion ////////////////////////////////////
//            $stock_movement_child = $this->stock_movement_child($grn_array, $goods_receipt_note_id, $account_code, $account_name, 'DELIVERY_ORDER');
//
//            if (!$stock_movement_child) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $goods_receipt_note_id);

        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function goods_receipt_note_validation($request)
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

    public function AssignGoodsReceiptNoteValues($request, $goods_receipt_note, $day_end, $user, $prfx, $account_code, $account_name, $remarks, $total_item, $invoice_no = 0)
    {//status 1 for products and 2 for services
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $col_party_code = $prfx . '_party_code';
        $col_party_name = $prfx . '_party_name';
        $col_posting_reference = $prfx . '_pr_id';
        $col_customer_name = $prfx . '_customer_name';
        $col_remarks = $prfx . '_remarks';
        $col_total_items = $prfx . '_total_items';
        $col_po_id = $prfx . '_po_id';

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

        $goods_receipt_note->$col_party_code = $account_code;
        $goods_receipt_note->$col_party_name = $account_name;
        $goods_receipt_note->$col_customer_name = ucwords($request->customer_name);
        $goods_receipt_note->$col_posting_reference = $request->posting_reference;
        $goods_receipt_note->$col_remarks = ucfirst($remarks);
        $goods_receipt_note->$col_total_items = $request->total_items;
        $goods_receipt_note->$col_po_id = $request->po;


        $goods_receipt_note->$col_datetime = Carbon::now()->toDateTimeString();
        $goods_receipt_note->$col_day_end_id = $day_end->de_id;
        $goods_receipt_note->$col_day_end_date = $day_end->de_datetime;
        $goods_receipt_note->$col_createdby = $user->user_id;
        $goods_receipt_note->$col_brwsr_info = $brwsr_rslt;
        $goods_receipt_note->$col_ip_adrs = $ip_rslt;
        $goods_receipt_note->$col_update_datetime = Carbon::now()->toDateTimeString();

        if ($invoice_no > 0 && !empty($invoice_no)) {
            $goods_receipt_note->$col_invoice_number = $invoice_no;
        } else {
            $goods_receipt_note->$col_email = $request->customer_email;
//            $goods_receipt_note->$col_dc_id = $request->customer_phone_number;

        }

        return $goods_receipt_note;
    }

    public function AssignGoodsReceiptNoteItemsValues($invoice_id, $array, $prfx, $status)
    {//status 1 for products and 2 for services

        $data = [];

        if ($status == 1) {

            foreach ($array as $value) {
                $gross_amount = 0;
                $average_rate = $this->product_stock_movement_last_row($value['product_code']);

                if ($average_rate->sm_bal_total_qty_wo_bonus < 0) {
                    $gross_amount = 0;
                } else {
//                    $gross_amount = $value['product_amount'];
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

                $goods_receipt_note = $prfx . '_invoice_id';
                $product_code = $prfx . '_product_code';
                $product_name = $prfx . '_product_name';
                $remarks = $prfx . '_remarks';
                $warehouse = $prfx . '_warehouse_id';
                $qty = $prfx . '_qty';
                $due_qty = $prfx . '_due_qty';
                $uom = $prfx . '_uom';
                $scale_size = $prfx . '_scale_size';
//                $rate = $prfx . '_rate';
                $bonus_qty = $prfx . '_bonus_qty';
//                $amount = $prfx . '_amount';


                $data[] = [
                    $goods_receipt_note => $invoice_id,
                    $product_code => $value['product_code'],
                    $product_name => ucwords($value['product_name']),
                    $remarks => ucfirst($value['product_remarks']),
                    $warehouse => ucfirst($value['warehouse']),
                    $qty => $value['product_qty'],
                    $due_qty => $value['product_qty'],
                    $uom => $value['product_unit_measurement'],
                    $scale_size => $value['product_unit_measurement_scale_size'],
                    $bonus_qty => $value['product_bonus_qty'],
//                    $rate => $value['product_rate'],
//                    $amount => $gross_amount,
                ];
            }
        }

        return $data;
    }

    public function AssignGRNOrderQty($invoice_id, $array, $prfx, $status)
    {//status 1 for products and 2 for services

        $data = [];

        if ($status == 1) {

            foreach ($array as $value) {

                $grn_id = $prfx . '_grn_id';
                $warehouse = $prfx . '_warehouse_id';
                $product_code = $prfx . '_product_code';
                $qty = $prfx . '_total_qty';
                $balance_qty = $prfx . '_balance_qty';

                $data[] = [
                    $grn_id => $invoice_id,
                    $warehouse => $value['warehouse'],
                    $product_code => $value['product_code'],
                    $qty => $value['product_qty'],
                    $balance_qty => $value['product_qty'],
                ];
            }
        }

        return $data;
    }

    public function get_goods_receipt_note_items_for_purchase(Request $request)
    {
        //$invoice_type = $request->invoice_type;
        $invoice_no = $request->invoice_no;
        //$desktop_invoice_id = $request->desktop_invoice_id;

        $array = [];

        $day_end_date = DayEndModel::orderBy('de_id', 'DESC')->pluck('de_datetime')->first();
        $purchase = GoodsReceiptNoteModel::where('grn_id', $invoice_no)->first();
        if ($purchase == '') {
            return $purchase;
        }
        $grn_date = date('Y-m-d', strtotime($purchase->grn_datetime));

        if ($grn_date <= $day_end_date) {
            if ($purchase != null) {

                $items = DB::table('financials_goods_receipt_note_items as grni')
                    ->leftJoin('financials_products as pro', 'pro.pro_p_code', 'grni.grni_product_code')
                    ->where('grni.grni_invoice_id', '=', $invoice_no)
                    ->where('grni.grni_due_qty', '>', 0)
                    ->select('grni.grni_invoice_id', 'grni.grni_product_code', 'grni.grni_product_name', 'grni.grni_remarks', 'grni.grni_qty', 'grni.grni_due_qty', 'grni.grni_uom', 'grni.grni_bonus_qty',
                        'grni.grni_warehouse_id',
                        'pro.pro_purchase_price as grni_rate', 'pro.pro_sale_price as grni_sale_price')
                    ->get();

                $array[] = $purchase;
                $array[] = $items;

                return response()->json($array);
            } else {
                return response()->json(['message' => 'No data Found']);
            }
        } else {
            return response()->json(['message' => 'not eligible']);
        }
    }

    public function get_goods_receipt_note_items_for_return(Request $request)
    {
        //$invoice_type = $request->invoice_type;
        $invoice_no = $request->invoice_no;
        //$desktop_invoice_id = $request->desktop_invoice_id;

        $array = [];

        $day_end_date = DayEndModel::orderBy('de_id', 'DESC')->pluck('de_datetime')->first();
        $purchase = GoodsReceiptNoteModel::where('grn_id', $invoice_no)->first();
        if ($purchase == '') {
            return $purchase;
        }
        $grn_date = date('Y-m-d', strtotime($purchase->grn_datetime));

//        if ($grn_date <= $day_end_date) {
            if ($purchase != null) {

                $items = DB::table('financials_goods_receipt_note_items as grni')
                    ->leftJoin('financials_products as pro', 'pro.pro_p_code', 'grni.grni_product_code')
                    ->where('grni.grni_invoice_id', '=', $invoice_no)
                    ->where('grni.grni_due_qty', '>', 0)
                    ->select('grni.grni_invoice_id', 'grni.grni_product_code', 'grni.grni_product_name', 'grni.grni_remarks', 'grni.grni_qty', 'grni.grni_due_qty', 'grni.grni_uom', 'grni.grni_bonus_qty',
                        'grni.grni_warehouse_id',
                        'pro.pro_purchase_price as grni_rate', 'pro.pro_sale_price as grni_sale_price')
                    ->get();

                $array[] = $purchase;
                $array[] = $items;

                return response()->json($array);
            } else {
                return response()->json(['message' => 'No data Found']);
            }
//        } else {
//            return response()->json(['message' => 'not eligible']);
//        }
    }

    // update code by mustafa start
    public
    function goods_receipt_note_list(Request $request, $array = null, $str = null)
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
        $prnt_page_dir = 'print.goods_receipt_note.goods_receipt_note_list';
        $pge_title = 'Goods Receipt Note List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_goods_receipt_note')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_goods_receipt_note.grn_createdby')
            ->leftJoin('financials_purchase_order', 'financials_purchase_order.po_id', 'financials_goods_receipt_note.grn_po_id');

        if (!empty($search)) {

            $query->where(function ($query) use ($search) {
                $query->where('grn_party_code', 'like', '%' . $search . '%')
                    ->orWhere('grn_party_name', 'like', '%' . $search . '%')
                    ->orWhere('grn_remarks', 'like', '%' . $search . '%')
                    ->orWhere('grn_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });

        }

        if (!empty($search_account)) {
            $query->where('grn_party_code', $search_account);
        }
        if (!empty($search_product)) {
            $get_p_id = GoodsReceiptNoteItemsModel::where('grni_product_code', $search_product)->pluck('grni_invoice_id')->all();
            $query->whereIn('grn_id', $get_p_id);
        }

        if (!empty($search_by_user)) {
            $query->where('grn_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('grn_day_end_date', [$start, $end]);
            $query->whereDate('grn_day_end_date', '>=', $start)
                ->whereDate('grn_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('grn_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('grn_day_end_date', $end);
        }

        $datas = $query->orderBy('grn_id', config('global_variables.query_sorting'))
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
            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('goods_receipt_note_list', compact('datas', 'search', 'party', 'accounts', 'search_account', 'search_product', 'products', 'search_to', 'search_from', 'check_desktop', 'search_by_user'));
        }
    }

// update code by mustafa end

    public
    function goods_receipt_note_items_view_details(Request $request)
    {
        $items = GoodsReceiptNoteItemsModel::where('grni_invoice_id', $request->id)->orderby('grni_product_name', 'ASC')->get();

        return response()->json($items);
    }

    public
    function goods_receipt_note_items_view_details_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice', 'rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0) {
            $sim = GoodsReceiptNoteModel::where('grn_id', $id)->first();
        } else {
            $sim = DB::table('financials_goods_receipt_note')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_goods_receipt_note.grn_party_code')
                ->where('grn_id', $id)
                ->select('financials_accounts.account_urdu_name as grn_party_name', 'grn_id', 'grn_party_code', 'grn_customer_name', 'grn_remarks', 'grn_total_items', 'grn_day_end_id', 'grn_day_end_date', 'grn_createdby')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $sim->grn_party_code)->first();

        if ($urdu_eng->rc_invoice == 0) {
            $siims = DB::table('financials_goods_receipt_note_items')
                ->where('grni_invoice_id', $id)
                ->orderby('grni_product_name', 'ASC')
                ->select('grni_product_name as name', 'grni_remarks as remarks', 'grni_qty as qty', 'grni_due_qty as due_qty', 'grni_bonus_qty as bonus', 'grni_status as status'
                //    ,'doi_rate as rate', 'doi_amount as amount'
                )->get();
        } else {

            $siims = DB::table('financials_goods_receipt_note_items')
                ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_goods_receipt_note_items.grni_product_code')
                ->where('grni_invoice_id', $id)
                ->select('financials_products.pro_urdu_title as name', 'grni_remarks as remarks', 'grni_qty as qty', 'grni_due_qty as due_qty', 'grni_bonus_qty as bonus', 'grni_status as status')
                ->orderby('grni_product_name', 'ASC')
                ->get();

        }


//        $si_grand_total = (isset($sim->si_grand_total) && !empty($sim->si_grand_total)) ? $sim->si_grand_total : 0;
//        $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;
//        $mainGrndTtl = +$si_grand_total + +$sei_grand_total;
//        $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
        $invoice_nbr = $sim->grn_id;
        $invoice_date = $sim->grn_day_end_date;
        $type = 'grid';
        $pge_title = 'Goods Receipt Note';

        return view('invoice_view.goods_receipt_note.goods_receipt_note_list_modal', compact('siims', 'sim', 'accnts', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));
    }

    public
    function goods_receipt_note_items_view_details_pdf_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice', 'rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0) {
            $sim = GoodsReceiptNoteModel::where('grn_id', $id)->first();
        } else {
            $sim = DB::table('financials_goods_receipt_note')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_goods_receipt_note.grn_party_code')
                ->where('grn_id', $id)
                ->select('financials_accounts.account_urdu_name as grn_party_name', 'grn_id', 'grn_party_code', 'grn_customer_name', 'grn_remarks', 'grn_total_items', 'grn_day_end_id', 'grn_day_end_date', 'grn_createdby')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $sim->grn_party_code)->first();
        if ($urdu_eng->rc_invoice == 0) {
            $siims = DB::table('financials_goods_receipt_note_items')
                ->where('grni_invoice_id', $id)
                ->orderby('grni_product_name', 'ASC')
                ->select('grni_product_name as name', 'grni_remarks as remarks', 'grni_qty as qty', 'grni_due_qty as due_qty', 'grni_bonus_qty as bonus', 'grni_status as status')->get();
        } else {

            $siims = DB::table('financials_goods_receipt_note_items')
                ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_goods_receipt_note_items.grni_product_code')
                ->where('grni_invoice_id', $id)
                ->select('financials_products.pro_urdu_title as name', 'grni_remarks as remarks', 'grni_qty as qty', 'grni_due_qty as due_qty', 'grni_bonus_qty as bonus', 'grni_status as status')
                ->orderby('grni_product_name', 'ASC')
                ->get();

        }

        //$nbrOfWrds = $this->myCnvrtNbr($sim->si_grand_total);
        $invoice_nbr = $sim->grn_id;
        $invoice_date = $sim->grn_day_end_date;
        $type = 'pdf';
        $pge_title = 'Goods Receipt Note';


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
        $pdf->loadView('invoice_view.goods_receipt_note.goods_receipt_note_list_modal', compact('siims', 'sim', 'accnts', 'type', 'pge_title','invoice_nbr','invoice_date'));
        // $pdf->setOptions($options);

        return $pdf->stream('Goods-Receipt-Note.pdf');
    }


// update code by mustafa start
}
