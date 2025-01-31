<?php

namespace App\Http\Controllers\TradeInvoices;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\DayEndController;
use App\Models\AccountRegisterationModel;
use App\Models\DeliveryChallanItemsModel;
use App\Models\DeliveryChallanModel;
use App\Models\DeliveryOrderItemsModel;
use App\Models\DeliveryOrderModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductModel;
use App\Models\ProductPackagesModel;
use App\Models\SaleDeliveryChallanExtensionModel;
use App\Models\SaleInvoiceItemsModel;
use App\Models\SaleInvoiceModel;
use App\Models\SaleSaletaxInvoiceItemsModel;
use App\Models\SaleSaletaxInvoiceModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TradeDeliveryChallanController extends Controller
{
    public function trade_delivery_challan()
    {
        $accounts = $this->get_account_query('sale')[0];

        $products = $this->get_all_products();
        $pro_code = '';
        $pro_name = '';
        foreach ($products as $product) {
            $pro_title = $this->RemoveSpecialChar($product->pro_title);

            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'>$product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'>$pro_title</option>";
        }

        $packages = ProductPackagesModel::where('pp_delete_status', '!=', 1)->where('pp_disabled', '!=', 1)->orderBy('pp_name', 'ASC')->get();

//        $sale_persons = User::where('user_id', '!=', 1)->orderBy('user_role_id', 'DESC')->orderBy('user_name', 'ASC')->get();

//        $warehouses = $this->get_all_warehouse();
//        $posting_references = PostingReferenceModel::where('pr_disabled', '=', 0)->get();

        return view('Trade_Invoices/trade_delivery_challan', compact('pro_code', 'pro_name', 'accounts', 'products', 'packages'));


//
//        return view('delivery_challan', compact('accounts', 'sale_persons', 'machines', 'service_code', 'service_name', 'packages', 'warehouses'));
    }

    public function submit_trade_delivery_challan(Request $request)
    {
//        dd($request);
        $this->delivery_challan_validation($request);

        $product_total_items = 0;
        $invoice_type = $request->invoice_type;
        $delivery_array = [];

        $requested_arrays = $request->pro_code;

        foreach ($requested_arrays as $index => $requested_array) {

            $item_code = $request->pro_code[$index];
            $item_name = $request->pro_name[$index];
            $item_remarks = $request->remarks[$index];
            $item_warehouse = isset($request->warehouse[$index]) ? $request->warehouse[$index] : 0;
            $item_unit_measurement = $request->unit_measurement[$index];
            $item_unit_measurement_scale_size = $request->unit_measurement_scale_size[$index];
            $item_quantity = $request->quantity[$index];
            $item_bonus = isset($request->bonus[$index]) ? $request->bonus[$index] : 0;


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

        $delivery_prefix = 'dc';
        $delivery_items_prefix = 'dci';
        $delivery_qty_hold_prefix = 'doqh';
        $qty_hold_table = 'financials_delivery_order_qty_hold_log';

        $delivery_chalan = new DeliveryChallanModel();
        $item_table = 'financials_delivery_challan_items';


        $notes = 'DELIVERY_CHALLAN';


        $voucher_code = config('global_variables.DELIVERY_CHALLAN_VOUCHER_CODE');

        //sale invoice
        if (!empty($delivery_array)) {

//            array_walk($delivery_array, function (&$a) {
//                $a['warehouse'] = 1;
//            });


            //////////////////////////// Sale Invoice Insertion ////////////////////////////////////

            $delivery_chalan = $this->AssignSaleInvoiceValues($request, $delivery_chalan, $day_end, $user, $delivery_prefix, $account_code, $account_name, $request->remarks, $product_total_items);

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

            $item = $this->AssignSaleInvoiceItemsValues($delivery_chalan_id, $delivery_array, $delivery_items_prefix, 1);

            foreach ($item as $value) {

                $detail_remarks .= $value[$delivery_items_prefix . '_product_name'] . ', ' . $value[$delivery_items_prefix . '_qty'] . PHP_EOL;
            }

            if (!DB::table($item_table)->insert($item)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }
            if ($invoice_type == 1) {
                $sale_invoice_id = new SaleDeliveryChallanExtensionModel();
//                $sale_invoice_id = SaleInvoiceModel::where('si_id', $request->invoice_nbr_chk)->first();
                $sale_invoice_id->sde_dc_id = 'DC-' . $delivery_chalan_id;
                $sale_invoice_id->sde_sale_id = $request->invoice_nbr_chk;
                $sale_invoice_id->save();
            } else if ($invoice_type == 2) {
                $sale_invoice_id = new SaleDeliveryChallanExtensionModel();
//                $sale_invoice_id = SaleSaletaxInvoiceModel::where('ssi_id', $request->invoice_nbr_chk)->first();
                $sale_invoice_id->sde_sale_tax_id = 'DC-' . $delivery_chalan_id;
                $sale_invoice_id->sde_sale_tax_id = $request->invoice_nbr_chk;
                $sale_invoice_id->save();
            } else {
                $delivery_invoice_id = DeliveryOrderModel::where('do_id', $request->invoice_nbr_chk)->first();
                $delivery_invoice_id->do_dc_id = 'DC-' . $delivery_chalan_id;
                $delivery_invoice_id->save();
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

//            $warehouses = [];
//            $warehouse = $this->AssignWarehouseStocksValues($warehouses, $delivery_array, 2);
//
//            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }


            //////////////////////////// Stock Movement Insertion ////////////////////////////////////

//            $stock_movement = $this->stock_movement_module_delivery($delivery_array, $voucher_code . $delivery_chalan_id, 'DELIVERY', 'DELIVERY');

//            if (!$stock_movement) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $delivery_chalan_id);

        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            DB::commit();
//            return redirect()->back()->with('success', 'Successfully Saved');
            return redirect()->back()->with(['dci_id' => $delivery_chalan_id]);
        }
    }

    public function delivery_challan_validation($request)
    {
        return $this->validate($request, [
            'account_name' => ['required', 'numeric'],
            "package" => ['nullable', 'string'],
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

    public function AssignSaleInvoiceValues($request, $delivery_chalan, $day_end, $user, $prfx, $account_code, $account_name, $remarks, $total_item, $invoice_no = 0)
    {//status 1 for products and 2 for services
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $col_party_code = $prfx . '_party_code';
        $col_party_name = $prfx . '_party_name';
        $col_posting_reference = $prfx . '_pr_id';
        $col_customer_name = $prfx . '_customer_name';
        $col_remarks = $prfx . '_remarks';
        $col_total_items = $prfx . '_total_items';


        $col_datetime = $prfx . '_datetime';
        $col_day_end_id = $prfx . '_day_end_id';
        $col_day_end_date = $prfx . '_day_end_date';
        $col_createdby = $prfx . '_createdby';
        $col_detail_remarks = $prfx . '_detail_remarks';
        $col_ip_adrs = $prfx . '_ip_adrs';
        $col_brwsr_info = $prfx . '_brwsr_info';
        $col_update_datetime = $prfx . '_update_datetime';
        $col_invoice_number = $prfx . '_sale_invoice_id';

        if ($request->invoice_type == 1) {
            $delivery_chalan->$col_invoice_number = 'SI-' . $request->invoice_nbr_chk;
        } else if ($request->invoice_type == 2) {
            $delivery_chalan->$col_invoice_number = 'STSI-' . $request->invoice_nbr_chk;
        } else {
            $delivery_chalan->$col_invoice_number = 'DO-' . $request->invoice_nbr_chk;
        }


        $delivery_chalan->$col_party_code = $account_code;
        $delivery_chalan->$col_party_name = $account_name;
        $delivery_chalan->$col_posting_reference = $request->posting_reference;
        $delivery_chalan->$col_customer_name = ucwords($request->customer_name);
        $delivery_chalan->$col_remarks = ucfirst($remarks);
        $delivery_chalan->$col_total_items = $total_item;


        $delivery_chalan->$col_datetime = Carbon::now()->toDateTimeString();
        $delivery_chalan->$col_day_end_id = $day_end->de_id;
        $delivery_chalan->$col_day_end_date = $day_end->de_datetime;
        $delivery_chalan->$col_createdby = $user->user_id;
        $delivery_chalan->$col_brwsr_info = $brwsr_rslt;
        $delivery_chalan->$col_ip_adrs = $ip_rslt;
        $delivery_chalan->$col_update_datetime = Carbon::now()->toDateTimeString();


        return $delivery_chalan;
    }

    public function AssignSaleInvoiceItemsValues($invoice_id, $array, $prfx, $status)
    {//status 1 for products and 2 for services

        $data = [];

        if ($status == 1) {

            foreach ($array as $value) {

//                $average_rate = $this->product_stock_movement_last_row($value['product_code']);
//
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
//                    $rate => $value['product_rate'],
                ];
            }
        }

        return $data;
    }

    public function get_sale_items_for_delivery_challan(Request $request)
    {
        $invoice_type = $request->invoice_type;
        $invoice_no = $request->invoice_no;
        $desktop_invoice_id = $request->desktop_invoice_id;

        $array = [];

        if ($invoice_type == 1) {

            if ($desktop_invoice_id == 0) {
                $sale_id = SaleDeliveryChallanExtensionModel::where('sde_sale_id', $invoice_no)->first();
                $si_id = DeliveryChallanModel::where('dc_sale_invoice_id', 'SI-' . $invoice_no)->first();
                if ($si_id != null) {
                    $message = 'Sale Invoice';
                    return response()->json(['do' => $si_id, 'message' => $message]);
                } else if ($sale_id == null) {
                    $sale = SaleInvoiceModel::where('si_id', $invoice_no)->first();
                    if ($sale != null) {
                        $items = SaleInvoiceItemsModel::where('sii_invoice_id', $invoice_no)->get();
                    } else {
                        $items = '';
                        $message = 'Sale Invoice';
                        $array[] = $sale;
                        $array[] = $items;
                        $array[] = $message;
                        return response()->json($array);
//                        return response()->json(['not_exist' => $sale, 'message' => $message]);
                    }
                } else {
                    $array = [];
                    return response()->json($array);
                }
            } else {
                $sale_id = SaleDeliveryChallanExtensionModel::where('sde_sale_id', $invoice_no)->first();
                $si_id = DeliveryChallanModel::where('dc_sale_invoice_id', 'SI-' . $invoice_no)->first();
                if ($si_id != null) {
                    $message = 'Sale Invoice';
                    return response()->json(['do' => $si_id, 'message' => $message]);
                } else if ($sale_id == null) {
                    $sale = SaleInvoiceModel::where('si_local_invoice_id', $invoice_no)->first();
                    if ($sale != null) {
                        $items = SaleInvoiceItemsModel::where('sii_invoice_id', $invoice_no)->get();
                    } else {
                        $items='';
                        $message = 'Sale Invoice';
                        $array[] = $sale;
                        $array[] = $items;
                        $array[] = $message;
                        return response()->json($array);

//                        return response()->json(['not_exist' => $sale, 'message' => $message]);
                    }
                } else {
                    $array = [];
                    return response()->json($array);
                }
            }

            // $items = SaleInvoiceItemsModel::where('sii_invoice_id', $invoice_no)->get();

        } else if ($invoice_type == 2) {

            if ($desktop_invoice_id == 0) {
                $sale_id = SaleDeliveryChallanExtensionModel::where('sde_sale_tax_id', $invoice_no)->first();
                $do_id = DeliveryChallanModel::where('dc_sale_invoice_id', 'STSI-' . $invoice_no)->first();
                if ($do_id != null) {
                    $message = 'Sale Invoice';
                    return response()->json(['do' => $do_id, 'message' => $message]);
                } else if ($sale_id == null) {
                    $sale = SaleSaletaxInvoiceModel::where('ssi_id', $invoice_no)->first();
                    if ($sale != null) {
                        $items = SaleSaletaxInvoiceItemsModel::where('ssii_invoice_id', $invoice_no)->get();
                    } else {
                        $message = 'Sale Tax Invoice';
                        $items='';
                        $array[] = $sale;
                        $array[] = $items;
                        $array[] = $message;
                        return response()->json($array);
//                        return response()->json(['not_exist' => $sale, 'message' => $message]);
                    }
                } else {
                    $array = [];
                    return response()->json($array);
                }
            } else {
                $sale_id = SaleDeliveryChallanExtensionModel::where('sde_sale_tax_id', $invoice_no)->first();
                $do_id = DeliveryChallanModel::where('dc_sale_invoice_id', 'STSI-' . $invoice_no)->first();
                if ($do_id != null) {
                    $message = 'Sale Tax Invoice';
                    return response()->json(['do' => $do_id, 'message' => $message]);
                } else if ($sale_id == null) {
                    $sale = SaleSaletaxInvoiceModel::where('ssi_local_invoice_id', $invoice_no)->first();
                    if ($sale != null) {
                        $items = SaleSaletaxInvoiceItemsModel::where('ssii_invoice_id', $invoice_no)->get();
                    } else {
                        $message = 'Sale Tax Invoice';
                        $items='';
                        $array[] = $sale;
                        $array[] = $items;
                        $array[] = $message;
                        return response()->json($array);
//                        return response()->json(['not_exist' => $sale, 'message' => $message]);
                    }
                } else {
                    $array = [];
                    return response()->json($array);
                }
            }


        } else {

            $sale = DeliveryOrderModel::where('do_id', $invoice_no)->where('do_dc_id', '=', null)->first();
            $do_id = DeliveryChallanModel::where('dc_sale_invoice_id', 'DO-' . $invoice_no)->first();
            if ($do_id != null) {
                $message = 'Delivery Order';
                return response()->json(['do' => $do_id, 'message' => $message]);
            } else if ($sale != null) {
                $items = DeliveryOrderItemsModel::where('doi_invoice_id', $invoice_no)->get();
            } else {
                $message = 'Delivery Order';
                $items='';
                $array[] = $sale;
                $array[] = $items;
                $array[] = $message;
                return response()->json($array);
//                return response()->json(['not_exist' => $sale, 'message' => $message]);
//                $array = [];
//                return response()->json($array);
            }
        }
        if ($sale != '') {
            $message = '';
            $array[] = $sale;
            $array[] = $items;
            $array[] = $message;

            return response()->json($array);
//            return response()->json(['array'=>$array,'do'=>$do_id , 'message' =>$message]);
        }
//        return response()->json(['array'=>$array,'sale'=>$sale,'items'=>$items]);

    }

    // update code by shahzaib start
    public
    function trade_delivery_challan_list(Request $request, $array = null, $str = null)
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
        $prnt_page_dir = 'print.delivery_challan.delivery_challan_list';
        $pge_title = 'Trade Delivery Challan List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_delivery_challan')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_delivery_challan.dc_createdby');

        if (!empty($search)) {

            $query->where(function ($query) use ($search) {
                $query->where('dc_party_code', 'like', '%' . $search . '%')
                    ->orWhere('dc_party_name', 'like', '%' . $search . '%')
                    ->orWhere('dc_remarks', 'like', '%' . $search . '%')
                    ->orWhere('dc_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });

        }

        if (!empty($search_account)) {
            $query->where('dc_party_code', $search_account);
        }

        if (!empty($search_product)) {
            $get_p_id = DeliveryChallanItemsModel::where('dci_product_code', $search_product)->pluck('dci_invoice_id')->all();
            $query->whereIn('dc_id', $get_p_id);
        }

        if (!empty($search_by_user)) {
            $query->where('dc_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('do_day_end_date', [$start, $end]);
            $query->whereDate('dc_day_end_date', '>=', $start)
                ->whereDate('dc_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('dc_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('dc_day_end_date', $end);
        }

        $datas = $query->orderBy('dc_id', config('global_variables.query_sorting'))
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
            return view('Trade_Invoices/trade_delivery_challan_list', compact('datas', 'search', 'party', 'accounts', 'search_account', 'search_product', 'products', 'search_to', 'search_from', 'check_desktop', 'search_by_user'));
        }
    }

// update code by shahzaib end

    public
    function trade_delivery_challan_items_view_details(Request $request)
    {
        $items = DeliveryChallanItemsModel::where('dci_invoice_id', $request->id)->orderby('dci_product_name', 'ASC')->get();

        return response()->json($items);
    }

    public
    function trade_delivery_challan_items_view_details_SH(Request $request, $id)
    {

        $sim = DeliveryChallanModel::where('dc_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $sim->dc_party_code)->first();

        $siims = DB::table('financials_delivery_challan_items')
            ->where('dci_invoice_id', $id)
            ->orderby('dci_product_name', 'ASC')
            ->select('dci_product_name as name', 'dci_remarks as remarks', 'dci_qty as qty', 'dci_scale_size as scale_size', 'dci_uom as uom', 'dci_bonus_qty as bonus'
            //    , 'doi_status as status','doi_rate as rate', 'doi_amount as amount'
            )
            ->get();
//        $si_grand_total = (isset($sim->si_grand_total) && !empty($sim->si_grand_total)) ? $sim->si_grand_total : 0;
//        $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;
//        $mainGrndTtl = +$si_grand_total + +$sei_grand_total;
//        $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
        $invoice_nbr = $sim->dc_id;
        $invoice_date = $sim->dc_day_end_date;
        $type = 'grid';
        $pge_title = 'Trade Delivery Challan Invoice';

        return view('trade_invoice_view.trade_delivery_challan.trade_delivery_challan_list_modal', compact('siims', 'sim', 'accnts', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));
    }

    public
    function trade_delivery_challan_items_view_details_pdf_SH(Request $request, $id)
    {

        $sim = DeliveryChallanModel::where('dc_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $sim->dc_party_code)->first();
        $siims = DB::table('financials_delivery_challan_items')
            ->where('dci_invoice_id', $id)
            ->orderby('dci_product_name', 'ASC')
            ->select('dci_product_name as name', 'dci_remarks as remarks', 'dci_qty as qty', 'dci_scale_size as scale_size', 'dci_uom as uom', 'dci_bonus_qty as bonus'
            //    , 'doi_status as status','doi_rate as rate', 'doi_amount as amount'
            )

            ->get();
        //$nbrOfWrds = $this->myCnvrtNbr($sim->si_grand_total);
        $invoice_nbr = $sim->dc_id;
        $invoice_date = $sim->dc_day_end_date;
        $type = 'pdf';
        $pge_title = 'Trade Delivery Challan Invoice';


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
        $pdf->loadView('trade_invoice_view.trade_delivery_challan.trade_delivery_challan_list_modal', compact('siims', 'sim', 'accnts', 'type', 'pge_title','invoice_nbr','invoice_date'));
        // $pdf->setOptions($options);

        return $pdf->stream('Trade-Deliver-Challan-Invoice.pdf');
    }
}
