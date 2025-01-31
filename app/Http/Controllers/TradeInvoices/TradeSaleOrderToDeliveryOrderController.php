<?php

namespace App\Http\Controllers\TradeInvoices;

use App\Http\Controllers\DayEndController;
use App\Models\BalancesModel;
use App\Models\CashReceiptVoucherItemsModel;
use App\Models\CashReceiptVoucherModel;
use App\Models\CreditCardMachineModel;
use App\Models\DeliveryOrderItemsModel;
use App\Models\DeliveryOrderModel;
use App\Models\DeliveryOrderQuantityHoldModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductPackagesModel;
use App\Models\SaleInvoiceModel;
use App\Models\SaleOrderItemsModel;
use App\Models\SaleOrderQuantityHoldModel;
use App\Models\SaleSaletaxInvoiceModel;
use App\Models\ServiceSaleTaxInvoiceModel;
use App\Models\ServicesInvoiceModel;
use App\Models\ServicesModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TradeSaleOrderToDeliveryOrderController extends Controller
{
    public function trade_so_to_do_invoice()
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

        return view('Trade_Invoices/trade_so_to_do', compact('pro_code', 'pro_name', 'accounts', 'products', 'packages'));
//        return view('Trade_Invoices/trade_so_to_do', compact('accounts', 'sale_persons', 'machines', 'service_code', 'service_name', 'packages', 'warehouses'));
    }

    public function submit_trade_so_to_do_invoice(Request $request)
    {

        $this->delivery_order_validation($request);

        $product_total_items = 0;
        $delivery_order = $request->invoice_nbr_chk;

        $delivery_array = [];

        $requested_arrays = $request->pro_code;

        foreach ($requested_arrays as $index => $requested_array) {

            $item_delivery_order_id = $request->delivery_order_id[$index];
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
            $item_product_or_service_status = $request->product_or_service_status[$index];

//            if ($request->product_or_service_status[$index] == 0) {

                $product_total_items++;

                $delivery_array[] = [
                    'delivery_order_id' => $item_delivery_order_id,
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
                    'product_or_service_status' => $item_product_or_service_status,

                ];
//            }
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

        $sale_qty_hold_prefix = 'soqh';
        $sale_qty_hold_table = 'financials_sale_order_qty_hold_log';

        $delivery_chalan = new DeliveryOrderModel();
        $item_table = 'financials_delivery_order_items';


        $notes = 'DELIVERY_ORDER';


        $voucher_code = config('global_variables.TRADE_DELIVERY_ORDER_VOUCHER_CODE');

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
                $qty = $value[$delivery_items_prefix . '_qty'];
                $scale_size = (float)$value[$delivery_items_prefix . '_scale_size'];
                $pack_qty = floor($qty / $scale_size);
                $loose_qty = fmod($qty, $scale_size);

                $detail_remarks .= $value[$delivery_items_prefix . '_product_name'] . ', Total QTY = ' . $value[$delivery_items_prefix . '_qty'] . ', Pack QTY = ' . $pack_qty . ', Loose QTY = ' .
                    $loose_qty. config('global_variables.Line_Break');
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
            $item_qty_hold = $this->AssignSaleOrderSaleQtyHoldValues($delivery_chalan_id, $delivery_order, $delivery_array, $sale_qty_hold_prefix, 1);
            if (!DB::table($sale_qty_hold_table)->insert($item_qty_hold)) {
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

//            $warehouses = [];
//            $warehouse = $this->AssignWarehouseStocksValues($warehouses, $delivery_array, 2);
//
//            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            //////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////

//            $warehouses_summary = [];
//            $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $delivery_array, 'DELIVERY-ORDER');
//
//            if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            //////////////////////////// Stock Movement Insertion ////////////////////////////////////

//            $stock_movement = $this->stock_movement_module_delivery($delivery_array, $voucher_code . $delivery_chalan_id, 'DELIVERY-ORDER', 'DELIVERY-ORDER');
//
//            if (!$stock_movement) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            //////////////////////////// Stock Movement Child Insertion ////////////////////////////////////
//            $stock_movement_child = $this->stock_movement_child($delivery_array,$delivery_chalan_id, $account_code, $account_name,'DELIVERY_ORDER');
//
//            if (!$stock_movement_child) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $delivery_chalan_id);

        }


            foreach ($delivery_array as $val) {

                $product_code = $val['product_code'];
                $warehouse = $val['warehouse'];
                $qty = $val['product_qty'];
                $sale_order = SaleOrderItemsModel::where('soi_product_code', $product_code)->where('soi_warehouse_id', $warehouse)->where('soi_invoice_id', '=', $val['delivery_order_id'])
                    ->first();

                    if ($sale_order->soi_status != null || $sale_order->soi_status != 0) {
                        $id = $sale_order->soi_status;
                        $sale_order->soi_status = $id . ',' . 'DO-' . $delivery_chalan_id;
                    } else {
                        $sale_order->soi_status = 'DO-' . $delivery_chalan_id;
                    }

                $sale_order->soi_due_qty = $sale_order->soi_due_qty - $qty;
                $sale_order->save();
            }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            DB::commit();
//            return redirect()->back()->with(['doi_id' => $delivery_chalan_id]);
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

        $order_status = $prfx . '_status';

        $col_dc_id = $prfx . '_dc_id';


        $delivery_chalan->$col_party_code = $account_code;
        $delivery_chalan->$col_party_name = $account_name;
        $delivery_chalan->$col_posting_reference = $request->posting_reference;
        $delivery_chalan->$col_customer_name = ucwords($request->customer_name);
        $delivery_chalan->$col_remarks = ucfirst($remarks);
        $delivery_chalan->$col_total_items = $request->total_items;
        $delivery_chalan->$order_status = 1;


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
                $pro_ser_status =$prfx . '_pro_ser_status';

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
                    $pro_ser_status => $value['product_or_service_status'],

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

    public
    function AssignSaleOrderSaleQtyHoldValues($invoice_id, $delivery_order_id, $array, $prfx, $status)
    {//status 1 for products and 2 for services

        $data = [];

        foreach ($array as $value) {

            $qty = SaleOrderQuantityHoldModel::where('soqh_product_code', $value['product_code'])->where('soqh_warehouse_id', $value['warehouse'])->orderBy('soqh_id', 'DESC')->first();

            $dc_invoice = $prfx . '_so_id';
            $sale_invoice = $prfx . '_sale_invoice_id';
            $sale_tax_invoice = $prfx . '_sale_tax_id';
            $do_invoice = $prfx . '_do_id';
            $product_code = $prfx . '_product_code';
            $warehouse = $prfx . '_warehouse_id';
            $sale_qty = $prfx . '_sale_qty';
            $balance_qty = $prfx . '_balance_qty';
            $invoice_no = '';
//            $invoice_sale_tax_no = '';
//            if ($invoice_type == 1) {
                $invoice_no = $invoice_id;
//            } else {
//                $invoice_sale_tax_no = $invoice_id;
//            }
            $data[] = [
                $dc_invoice => $value['delivery_order_id'],

//                $sale_invoice => $invoice_no,
                $do_invoice => $invoice_no,

                $product_code => $value['product_code'],
                $warehouse => $value['warehouse'],
                $sale_qty => $value['product_qty'],
                $balance_qty => $qty->soqh_balance_qty - $value['product_qty'],

            ];
        }

        return $data;
    }

    public function get_delivery_order_items_for_sale(Request $request)
    {
        //$invoice_type = $request->invoice_type;
        $invoice_no = $request->invoice_no;
        //$desktop_invoice_id = $request->desktop_invoice_id;

        $array = [];


        $sale = DeliveryOrderModel::where('do_id', $invoice_no)->first();
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
    }

}
