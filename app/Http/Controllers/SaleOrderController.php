<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\CreditCardMachineModel;
use App\Models\DayEndModel;
use App\Models\DeliveryOrderModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductModel;
use App\Models\ProductPackagesModel;
use App\Models\SaleInvoiceItemsModel;
use App\Models\SaleOrderItemsModel;
use App\Models\SaleOrderModel;
use App\Models\ServicesInvoiceModel;
use App\Models\ServicesModel;
use App\Models\StockMovementModels;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SaleOrderController extends Controller
{
    public function sale_order()
    {
//        $heads = explode(',', config('global_variables.payable_receivable_walk_in_customer'));
//        $query = AccountRegisterationModel::whereIn('account_parent_code', $heads)
//            ->whereNotIn(
//                'account_uid', AccountRegisterationModel::where('account_parent_code', config('global_variables.walk_in_customer_head'))
//                ->where('account_uid', '!=', config('global_variables.walk_in_customer'))
//                ->pluck('account_uid')->all()
//            );
//        $accounts = $query->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)
//            ->orderBy('account_uid', 'ASC')
//            ->get();
        $products = $this->get_all_products();

        $pro_code = '';
        $pro_name = '';

        foreach ($products as $product) {
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount' data-unit='$product->unit_title'  data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'>$product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'>$product->pro_title</option>";
        }

        $services = ServicesModel::where('ser_delete_status', '!=', 1)->where('ser_disabled', '!=', 1)->orderBy('ser_id', 'ASC')->get();

        $service_code = '';
        $service_name = '';

        foreach ($services as $service) {
            $service_code .= "<option value='$service->ser_id'>$service->ser_id</option>";
            $service_name .= "<option value='$service->ser_id'>$service->ser_title</option>";
        }

        $machines = CreditCardMachineModel::orderBy('ccm_title', 'ASC')->get();

        $packages = ProductPackagesModel::orderBy('pp_name', 'ASC')->get();

        $sale_persons = User::where('user_id', '!=', 1)->orderBy('user_role_id', 'DESC')->orderBy('user_name', 'ASC')->get();

//        $warehouses = $this->get_all_warehouse();
//        $posting_references = PostingReferenceModel::where('pr_disabled','=',0)->get();
        return view('supply_chain.sale_order', compact('pro_code', 'pro_name', 'products', 'sale_persons', 'machines', 'service_code', 'service_name', 'packages'));
    }

    public function submit_sale_order(Request $request)
    {
        $this->sale_order_validation($request);

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $account_code = $request->account_name;
        $account_name = $this->get_account_name($request->account_name);
        $rollBack = false;

        $sales_array = [];

        $requested_arrays = $request->pro_code;

        foreach ($requested_arrays as $index => $requested_array) {

            $item_code = $request->pro_code[$index];
            $item_name = $request->pro_name[$index];
            $item_remarks = $request->product_remarks[$index];
            $item_warehouse = isset($request->warehouse[$index]) ? $request->warehouse[$index] : 0;
            $item_quantity = $request->quantity[$index];
            $item_unit_measurement = $request->unit_measurement[$index];
            $item_unit_measurement_scale_size = isset($request->unit_measurement_scale_size[$index]) ? $request->unit_measurement_scale_size[$index] : 1;
            $item_bonus = isset($request->bonus[$index]) ? $request->bonus[$index] : 0;
            $item_rate = $request->rate[$index];
            $item_discount = $request->product_discount[$index];
            $item_discount_amount = $request->product_discount_amount[$index];
            $item_inclusive_rate = $request->product_inclusive_rate[$index];
            $item_after_disc_rate = $item_rate - ($item_discount_amount / $item_quantity);
            $item_sales_tax = $request->product_sales_tax[$index];
            $item_inclusive_exclusive = isset($request->inclusive_exclusive_status_value[$index]) ? $request->inclusive_exclusive_status_value[$index] : 0;
            $item_sale_tax_amount = $request->product_sale_tax_amount[$index];
            $item_amount = $request->amount[$index];
            $item_product_or_service_status = $request->product_or_service_status[$index];

            $sales_array[] = [
                'product_code' => $item_code,
                'product_name' => $item_name,
                'product_remarks' => $item_remarks,
                'warehouse' => $item_warehouse,
                'product_qty' => $item_quantity,
                'product_unit_measurement' => $item_unit_measurement,
                'product_unit_scale_size' => $item_unit_measurement_scale_size,
                'product_bonus_qty' => $item_bonus,
                'product_rate' => $item_rate,
                'product_discount' => $item_discount,
                'product_discount_amount' => $item_discount_amount,
                'product_inclusive_rate' => $item_inclusive_rate,
                'product_after_disc_rate' => $item_after_disc_rate,
                'product_sale_tax' => $item_sales_tax,
                'inclusive_exclusive_status' => $item_inclusive_exclusive,
                'product_sale_tax_amount' => $item_sale_tax_amount,
                'product_amount' => $item_amount,
                'product_or_service_status' => $item_product_or_service_status,
            ];
        }

        $user = Auth::user();

        DB::beginTransaction();


        $sale_prefix = 'so';
        $sale_items_prefix = 'soi';

        $sale_order = new SaleOrderModel();
        $item_table = 'financials_sale_order_items';

        $sale_qty_hold_prefix = 'soqh';
        $qty_hold_table = 'financials_sale_order_qty_hold_log';

        $notes = 'SALE_ORDER_INVOICE';

        $voucher_code = config('global_variables.SALE_ORDER_VOUCHER_CODE');

        $transaction_type = config('global_variables.SALE_ORDER');

        // sale invoice
        if (!empty($sales_array)) {

            //////////////////////////// Sale Order Insertion ////////////////////////////////////

            $sale_order = $this->AssignSaleOrderValues($request, $sale_order, $day_end, $user, $sale_prefix);


            if ($sale_order->save()) {

                $s_id = $sale_prefix . '_id';
                $sale_order_id = $sale_order->$s_id;

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $sale_order_id);
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Sale Order Items Insertion ////////////////////////////////////
            $detail_remarks = '';

            $item = $this->AssignSaleOrderItemsValues($sale_order_id, $sales_array, $sale_items_prefix, 1);

            foreach ($item as $value) {

                $pro_rate = (float)$value[$sale_items_prefix . '_rate'];
                $pro_amount = (float)$value[$sale_items_prefix . '_amount'];

                $detail_remarks .= $value[$sale_items_prefix . '_product_name'] . ', ' . $value[$sale_items_prefix . '_qty'] . '@' . number_format($pro_rate, 2) . ' = ' . number_format($pro_amount, 2) . PHP_EOL;
            }

            if (!DB::table($item_table)->insert($item)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $item_qty = $this->AssignSaleOrderQty($sale_order_id, $sales_array, $sale_qty_hold_prefix, 1);
            if (!DB::table($qty_hold_table)->insert($item_qty)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }
            //////////////////////////// Details Remarks of Sale Order Insertion ////////////////////////////////////

            $sale_detail_remarks = $sale_prefix . '_detail_remarks';

            $sale_order->$sale_detail_remarks = $detail_remarks;

            if (!$sale_order->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

//            /////////////mustafa/////////////// Warehouse Stock Insertion ////////////////////////////////////
//
//            $warehouses = [];
//            $warehouse = $this->AssignWarehouseStocksValues($warehouses, $sales_array, 2);
//
//            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            ////////////mustafa//////////////// Warehouse Stock Summary Insertion ////////////////////////////////////

            $warehouses_summary = [];
            $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $sales_array, 'SALE-ORDER');

            if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Stock Movement Insertion ////////////////////////////////////

            $stock_movement = $this->stock_movement_module_delivery($sales_array, $voucher_code . $sale_order_id, 'SALE-ORDER', 'SALE-ORDER');

            if (!$stock_movement) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Stock Movement Child Insertion ////////////////////////////////////
            $stock_movement_child = $this->stock_movement_child($sales_array, $sale_order_id, $account_code, $account_name, 'SALE_ORDER');

            if (!$stock_movement_child) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Warehouse Stock Insertion ////////////////////////////////////

            // $this->AssignStockMovementValues($sales_array, $user, $day_end, $voucher_code.$sale_order_id, $detail_remarks);

//            $warehouses = [];
//            $warehouse = $this->AssignWarehouseStocksValues($warehouses, $sales_array, 1);
//
//            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }


        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function AssignStockMovementValues($sales_array, $user, $day_end, $voucher_code, $detail_remarks)
    {
        foreach ($sales_array as $product) {
            $stock_movement_last_entry = StockMovementModels::where('sm_product_code', '=', $product['product_code'])->orderBy('sm_id', 'desc')->first();
            if (!isset($stock_movement_last_entry)) {
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $stock_movement = new StockMovementModels();
            $stock_movement->sm_type = 'SALE ORDER';
            $stock_movement->sm_product_code = $product['product_code'];
            $stock_movement->sm_product_name = $product['product_name'];
            $stock_movement->sm_in_qty = null;
            $stock_movement->sm_in_bonus = null;
            $stock_movement->sm_in_rate = null;
            $stock_movement->sm_in_total = null;
            $stock_movement->sm_out_qty = null;
            $stock_movement->sm_out_bonus = null;
            $stock_movement->sm_out_rate = null;
            $stock_movement->sm_out_total = null;

            $stock_movement->sm_internal_hold = $product['product_qty'];
            $stock_movement->sm_internal_bonus = null;
            $stock_movement->sm_internal_claim = null;

            $stock_movement->sm_bal_qty_for_sale = $stock_movement_last_entry->sm_bal_qty_for_sale - $product['product_qty'];

            $stock_movement->sm_bal_bonus_inward = 0;
            $stock_movement->sm_bal_bonus_outward = 0;
            $stock_movement->sm_bal_bonus_qty = $stock_movement_last_entry->sm_bal_bonus_qty;

            $stock_movement->sm_bal_hold = $product['product_qty'];
            $stock_movement->sm_bal_total_hold = $stock_movement_last_entry->sm_bal_total_hold + $product['product_qty'];
            $stock_movement->sm_bal_claims = $stock_movement_last_entry->sm_bal_claims;

            $stock_movement->sm_bal_total_qty_wo_bonus = $stock_movement_last_entry->sm_bal_total_qty_wo_bonus;
            $stock_movement->sm_bal_total_qty = $stock_movement_last_entry->sm_bal_total_qty;
            $stock_movement->sm_bal_rate = $stock_movement_last_entry->sm_bal_rate;
            $stock_movement->sm_bal_total = $stock_movement_last_entry->sm_bal_total;

            $stock_movement->sm_day_end_id = $day_end->de_id;
            $stock_movement->sm_day_end_date = $day_end->de_datetime;
            $stock_movement->sm_voucher_code = $voucher_code;
            $stock_movement->sm_remarks = $detail_remarks;
            $stock_movement->sm_user_id = $user->user_id;
            $stock_movement->sm_date_time = now();

            if (!$stock_movement->save()) {
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }
        }
    }

    public function sale_order_validation($request)
    {
        return $this->validate($request, [
            'account_name' => ['required', 'numeric'],
            "package" => ['nullable', 'string'],
            "remarks" => ['nullable', 'string'],
            "customer_name" => ['nullable', 'string'],
            "invoice_type" => ['required', 'numeric'],
            "discount_type" => ['required', 'numeric'],
            "total_items" => ['required', 'numeric', 'min:1'],
            "total_price" => ['required', 'numeric'],
            "total_product_discount" => ['nullable', 'numeric'],
            "round_off_discount" => ['nullable', 'numeric'],
            "disc_percentage" => ['nullable', 'numeric'],
            "disc_amount" => ['nullable', 'numeric'],
            "total_discount" => ['nullable', 'numeric'],
            "total_inclusive_tax" => ['nullable', 'numeric'],
            "total_exclusive_tax" => ['nullable', 'numeric'],
            "total_tax" => ['nullable', 'numeric'],
            "grand_total" => ['required', 'numeric'],

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
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric'],
            'bonus' => ['nullable', 'array'],
            'bonus.*' => ['nullable', 'numeric'],
            'rate' => ['required', 'array'],
            'rate.*' => ['required', 'numeric'],
            'product_inclusive_rate' => ['required', 'array'],
            'product_inclusive_rate.*' => ['required', 'numeric'],
            'product_discount' => ['nullable', 'array'],
            'product_discount.*' => ['nullable', 'numeric'],
            'product_discount_amount' => ['nullable', 'array'],
            'product_discount_amount.*' => ['nullable', 'numeric'],
            'product_sales_tax' => ['nullable', 'array'],
            'product_sales_tax.*' => ['nullable', 'numeric'],
            'product_sale_tax_amount' => ['nullable', 'array'],
            'product_sale_tax_amount.*' => ['nullable', 'numeric'],
            'amount' => ['required', 'array'],
            'amount.*' => ['required', 'numeric'],
        ]);
    }

    public function AssignSaleOrderValues($request, $sale_invoice, $day_end, $user, $prfx)
    {//status 1 for products and 2 for services
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $col_party_code = $prfx . '_party_code';
        $col_party_name = $prfx . '_party_name';
        $col_posting_reference = $prfx . '_pr_id';
        $col_customer_name = $prfx . '_customer_name';
        $col_remarks = $prfx . '_remarks';
        $col_total_items = $prfx . '_total_items';
        $col_total_price = $prfx . '_total_price';
        $col_product_discount = $prfx . '_product_disc';
        $col_round_off_discount = $prfx . '_round_off_disc';
        $col_cash_disc_percentage = $prfx . '_cash_disc_per';
        $col_cash_disc_amount = $prfx . '_cash_disc_amount';
        $col_total_discount = $prfx . '_total_discount';
        $col_inclusive_sales_tax = $prfx . '_inclusive_sales_tax';
        $col_exclusive_sales_tax = $prfx . '_exclusive_sales_tax';
        $col_total_sales_tax = $prfx . '_total_sales_tax';
        $col_grand_total = $prfx . '_grand_total';
        $col_datetime = $prfx . '_datetime';
        $col_day_end_id = $prfx . '_day_end_id';
        $col_day_end_date = $prfx . '_day_end_date';
        $col_createdby = $prfx . '_createdby';
        $col_detail_remarks = $prfx . '_detail_remarks';
        $col_ip_adrs = $prfx . '_ip_adrs';
        $col_brwsr_info = $prfx . '_brwsr_info';
        $col_discount_type = $prfx . '_discount_type';

        $sale_invoice->$col_party_code = $request->account_name;
        $sale_invoice->$col_party_name = $this->get_account_name($request->account_name);
        $sale_invoice->$col_posting_reference = $request->posting_reference;
        $sale_invoice->$col_customer_name = ucwords($request->customer_name);
        $sale_invoice->$col_remarks = ucfirst($request->remarks);
        $sale_invoice->$col_total_items = $request->total_items;;
        $sale_invoice->$col_total_price = $request->total_price;;
        $sale_invoice->$col_product_discount = $request->total_product_discount;;
        $sale_invoice->$col_round_off_discount = $request->round_off_discount == '' ? 0 : $request->round_off_discount;
        $sale_invoice->$col_cash_disc_percentage = $request->disc_percentage == '' ? 0 : $request->disc_percentage;
        $sale_invoice->$col_cash_disc_amount = $request->disc_amount == '' ? 0 : $request->disc_amount;
        $sale_invoice->$col_total_discount = $request->total_discount == '' ? 0 : $request->total_discount;
        $sale_invoice->$col_inclusive_sales_tax = $request->total_inclusive_tax == '' ? 0 : $request->total_inclusive_tax;
        $sale_invoice->$col_exclusive_sales_tax = $request->total_exclusive_tax == '' ? 0 : $request->total_exclusive_tax;
        $sale_invoice->$col_total_sales_tax = $request->total_tax == '' ? 0 : $request->total_tax;
        $sale_invoice->$col_grand_total = $request->grand_total;
        $sale_invoice->$col_discount_type = $request->discount_type;
        $sale_invoice->$col_datetime = Carbon::now()->toDateTimeString();
        $sale_invoice->$col_day_end_id = $day_end->de_id;
        $sale_invoice->$col_day_end_date = $day_end->de_datetime;
        $sale_invoice->$col_createdby = $user->user_id;
        $sale_invoice->$col_brwsr_info = $brwsr_rslt;
        $sale_invoice->$col_ip_adrs = $ip_rslt;

        return $sale_invoice;
    }

    public function AssignSaleOrderItemsValues($invoice_id, $array, $prfx, $status)
    {   //status 1 for products and 2 for services

        $data = [];

        foreach ($array as $value) {

            $sale_invoice = $prfx . '_invoice_id';
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
            $discount_per = $prfx . '_discount_per';
            $discount_amount = $prfx . '_discount_amount';
            $after_dis_rate = $prfx . '_after_dis_rate';
            $net_rate = $prfx . '_net_rate';
            $saletax_per = $prfx . '_saletax_per';
            $saletax_inclusive = $prfx . '_saletax_inclusive';
            $saletax_amount = $prfx . '_saletax_amount';
            $amount = $prfx . '_amount';
            $pro_ser_status = $prfx . '_pro_ser_status';


            $data[] = [
                $sale_invoice => $invoice_id,
                $product_code => $value['product_code'],
                $product_name => ucwords($value['product_name']),
                $remarks => ucfirst($value['product_remarks']),
                $warehouse => $value['warehouse'],
                $qty => $value['product_qty'],
                $due_qty => $value['product_qty'],
                $uom => $value['product_unit_measurement'],
                $scale_size => $value['product_unit_scale_size'],
                $bonus_qty => $value['product_bonus_qty'],
                $rate => $value['product_rate'],
                $net_rate => $value['product_inclusive_rate'],
                $discount_per => $value['product_discount'],
                $discount_amount => $value['product_discount_amount'],
                $after_dis_rate => $value['product_rate'] - ($value['product_discount_amount'] / $value['product_qty']),
                $saletax_per => $value['product_sale_tax'],
                $saletax_inclusive => $value['inclusive_exclusive_status'],
                $saletax_amount => $value['product_sale_tax_amount'],
                $amount => $value['product_amount'],
                $pro_ser_status => $value['product_or_service_status'],
                $pro_ser_status => $value['product_or_service_status'],
            ];
        }

        return $data;
    }

    public function AssignSaleOrderQty($invoice_id, $array, $prfx, $status)
    {//status 1 for products and 2 for services

        $data = [];

        if ($status == 1) {

            foreach ($array as $value) {

                $delivery_chalan = $prfx . '_so_id';
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

    public function sale_order_list(Request $request)
    {
        $heads = config('global_variables.payable_receivable_cash');
        $heads = explode(',', $heads);
        $user = Auth::user();
        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->get();
        if ($user->user_status == 'Employee') {
            $products = ProductModel::orderBy('pro_title', 'ASC')->get();
        } else {
            $products = ProductModel::where('pro_online_status',1)->orderBy('pro_title', 'ASC')->get();
        }
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $check_desktop = $request->check_desktop;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_order_list.sale_order_list';
        $pge_title = 'Sale Order List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        if ($user->user_status == 'Employee') {


            $query = DB::table('financials_sale_order')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_sale_order.so_createdby');
        } else {
            $query = DB::table('financials_sale_order')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_sale_order.so_createdby')
                ->where('so_createdby', $user->user_id);
        }
        if (!empty($search)) {
            if (isset($check_desktop) && !empty($check_desktop)) {
                $query->where(function ($query) use ($search) {
                    $query->where('so_local_order_id', 'like', '%' . $search . '%');
                });
            } else {
                $query->where(function ($query) use ($search) {
                    $query->where('so_party_code', 'like', '%' . $search . '%')
                        ->orWhere('so_party_name', 'like', '%' . $search . '%')
                        ->orWhere('so_remarks', 'like', '%' . $search . '%')
                        ->orWhere('so_id', 'like', '%' . $search . '%')
                        ->orWhere('user_designation', 'like', '%' . $search . '%')
                        ->orWhere('user_name', 'like', '%' . $search . '%')
                        ->orWhere('user_username', 'like', '%' . $search . '%');
                });
            }
        }

        if (!empty($search_account)) {
            $query->where('so_party_code', $search_account);
        }

        if (!empty($search_product)) {
            $get_p_id = SaleOrderItemsModel::where('soi_product_code', $search_product)->pluck('soi_invoice_id')->all();
            $query->whereIn('so_id', $get_p_id);
        }

        if (!empty($search_by_user)) {
            $query->where('so_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('si_day_end_date', [$start, $end]);
            $query->whereDate('so_day_end_date', '>=', $start)
                ->whereDate('so_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('so_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('so_day_end_date', $end);
        }

        $datas = $query->orderBy('so_id', config('global_variables.query_sorting'))
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
            return view('sale_order_list', compact('datas', 'search', 'party', 'accounts', 'search_account', 'search_product', 'products', 'search_to', 'search_from', 'check_desktop', 'search_by_user', 'user'));
        }
    }


    public function sale_order_items_view_details_SH(Request $request, $id)
    {
        $seim = ServicesInvoiceModel::where('sei_sale_invoice_id', $id)->first();
        $som = SaleOrderModel::where('so_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $som->so_party_code)->first();
        $services = DB::table('financials_service_invoice_items')
            ->where('seii_invoice_id', $som->so_service_invoice_id)
            ->orderby('seii_service_name', 'ASC')
//            ->select('sseii_service_name as name', 'sseii_remarks as remarks', 'sseii_qty as qty', 'sseii_rate as rate', 'sseii_discount as discount', 'sseii_saletax as sale_tax', 'sseii_amount as amount')
            ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount');
        $soims = DB::table('financials_sale_order_items')
            ->where('soi_invoice_id', $id)
            ->orderby('soi_product_name', 'ASC')
//            ->select('soi_product_name as name', 'soi_remarks as remarks', 'soi_qty as qty', 'soi_rate as rate', 'soi_discount as discount', 'soi_saletax as sale_tax', 'soi_amount as amount')
            ->select('soi_product_name as name', 'soi_remarks as remarks', 'soi_qty as qty', 'soi_rate as rate', 'soi_discount_per as discount', 'soi_after_dis_rate as after_discount', 'soi_saletax_per as sale_tax', 'soi_saletax_amount as sale_tax_amount', 'soi_saletax_inclusive as inclu_exclu', 'soi_amount as amount')
            ->union($services)
            ->get();
        $so_grand_total = (isset($som->so_grand_total) && !empty($som->so_grand_total)) ? $som->so_grand_total : 0;
        $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;
        $mainGrndTtl = +$so_grand_total + +$sei_grand_total;
        $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
        $invoice_nbr = $som->so_id;
        $invoice_date = $som->so_day_end_date;
        $type = 'grid';
        $pge_title = 'Sale Order';

        return view('invoice_view.sale_order.sale_order_list_modal', compact('soims', 'som', 'seim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));
    }

    public function sale_order_items_view_details_pdf_SH(Request $request, $id)
    {

        $seim = ServicesInvoiceModel::where('sei_sale_invoice_id', $id)->first();
        $som = SaleOrderModel::where('so_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $som->so_party_code)->first();
        $services = DB::table('financials_service_invoice_items')
            ->where('seii_invoice_id', $som->so_service_invoice_id)
            ->orderby('seii_service_name', 'ASC')
//            ->select('sseii_service_name as name', 'sseii_remarks as remarks', 'sseii_qty as qty', 'sseii_rate as rate', 'sseii_discount as discount', 'sseii_saletax as sale_tax', 'sseii_amount as amount')
            ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount');
        $soims = DB::table('financials_sale_order_items')
            ->where('soi_invoice_id', $id)
            ->orderby('soi_product_name', 'ASC')
//            ->select('soi_product_name as name', 'soi_remarks as remarks', 'soi_qty as qty', 'soi_rate as rate', 'soi_discount as discount', 'soi_saletax as sale_tax', 'soi_amount as amount')
            ->select('soi_product_name as name', 'soi_remarks as remarks', 'soi_qty as qty', 'soi_rate as rate', 'soi_discount_per as discount', 'soi_after_dis_rate as after_discount', 'soi_saletax_per as sale_tax', 'soi_saletax_amount as sale_tax_amount', 'soi_saletax_inclusive as inclu_exclu', 'soi_amount as amount')
            ->union($services)
            ->get();
        $nbrOfWrds = $this->myCnvrtNbr($som->so_grand_total);
        $invoice_nbr = $som->so_id;
        $invoice_date = $som->so_day_end_date;
        $type = 'pdf';
        $pge_title = 'Sale Order';


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
        $pdf->loadView('invoice_view.sale_order.sale_order_list_modal', compact('soims', 'som', 'seim', 'nbrOfWrds', 'accnts', 'type', 'pge_title','invoice_nbr','invoice_date'));
        // $pdf->setOptions($options);

        return $pdf->stream('Sale-Order.pdf');
    }

    public function get_sale_order_items_for_sale(Request $request)
    {
        //$invoice_type = $request->invoice_type;
        $invoice_no = $request->invoice_no;
        //$desktop_invoice_id = $request->desktop_invoice_id;

        $array = [];

//        $day_end_date = DayEndModel::orderBy('de_id', 'DESC')->pluck('de_datetime')->first();
        $sale = SaleOrderModel::where('so_id', $invoice_no)->first();
//        $do_date= date('Y-m-d', strtotime($sale->so_datetime));
//        if ($day_end_date >= $do_date) {

        if ($sale != null) {

            $items = DB::table('financials_sale_order_items as soi')
                ->leftJoin('financials_products as pro', 'pro.pro_p_code', 'soi.soi_product_code')
//                    ->leftJoin('financials_services as ser', 'ser.sr_id', 'soi.soi_product_code')
                ->where('soi.soi_invoice_id', '=', $invoice_no)
                ->where('soi.soi_due_qty', '>', 0)
                ->select('soi.soi_invoice_id', 'soi.soi_product_code', 'soi.soi_product_name', 'soi.soi_remarks', 'soi.soi_qty', 'soi.soi_due_qty', 'soi.soi_uom', 'soi.soi_bonus_qty', 'soi.soi_scale_size', 'soi.soi_pro_ser_status', 'soi.soi_warehouse_id', 'soi.soi_rate as soi_service_rate', 'pro.pro_sale_price as soi_rate')
                ->get();

            $array[] = $sale;
            $array[] = $items;
            return response()->json($array);
        } else {
            return response()->json(['message' => 'No data Found']);
        }
//        } else {
//            return response()->json(['message' => 'not eligible']);
//        }
    }
}
