<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccountRegisterationModel;
use App\Models\AddToCartModal;
use App\Models\BrandModel;
use App\Models\CategoryInfoModel;
use App\Models\GroupInfoModel;
use App\Models\MainUnitModel;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\SaleOrderModel;
use App\Models\StockMovementModels;
use App\Models\UnitInfoModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function index(Request $request)
    {

        $groups = GroupInfoModel::where('grp_delete_status', '!=', 1)->where('grp_disabled', '!=', 1)->orderBy('grp_title', 'ASC')->get();
        $categories = CategoryInfoModel::where('cat_delete_status', '!=', 1)->where('cat_disabled', '!=', 1)->orderBy('cat_title', 'ASC')->get();
        $brands = BrandModel::where('br_delete_status', '!=', 1)->where('br_disabled', '!=', 1)->orderBy('br_title', 'ASC')->get();

        $pagination_number = (empty($ar)) ? 18 : 100000000;


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->group;
        $search_category = (!isset($request->category) && empty($request->category)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->category;
        $search_brand = (!isset($request->brand) && empty($request->brand)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->brand;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_group, $search_category);

        $query = DB::table('financials_products')

            ->leftJoin('financials_groups', 'financials_groups.grp_id', 'financials_products.pro_group_id')
            ->leftJoin('financials_categories', 'financials_categories.cat_id', 'financials_products.pro_category_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby')
            ->leftJoin('financials_units', 'financials_units.unit_id', 'financials_products.pro_unit_id');

        if (!empty($search)) {
            $query->where('pro_code', 'like', '%' . $search . '%')
                ->orWhere('pro_title', 'like', '%' . $search . '%')
                ->orWhere('pro_sale_price', 'like', '%' . $search . '%')
                ->orWhere('pro_remarks', 'like', '%' . $search . '%')
//                ->orWhere('invt_available_stock', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_group)) {
            $query->where('pro_group_id', $search_group);
        }

        if (!empty($search_category)) {
            $query->where('pro_category_id', $search_category);
        }

        if (!empty($search_brand)) {
            $query->where('pro_brand_id', $search_brand);
        }

        if (!empty($search_by_user)) {
            $query->where('pro_createdby', $search_by_user);
        }

        $datas = $query->where('pro_online_status', 1)
            ->where('pro_delete_status', '!=', 1)
            ->select('financials_units.unit_title', 'financials_products.pro_id', 'financials_products.pro_p_code', 'financials_products.pro_remarks', 'financials_products.pro_title', 'financials_products.pro_sale_price', 'financials_products.pro_qty_for_sale', 'financials_products.pro_image', 'financials_products.pro_stock_status', 'financials_products.pro_hold_qty_per')
            ->orderBy('pro_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        if ($request->ajax()) {
            $view = view('cart/cart_data', compact('datas'))->render();
            return response()->json(['html' => $view]);
        }

        $product = ProductModel::
        where('pro_delete_status', '!=', 1)->where('pro_online_status', 1)->
        orderBy('pro_title', 'ASC')->pluck('pro_title')->all();
        return view('cart.cart', compact('datas', 'search', 'product', 'groups', 'categories', 'brands', 'search_group', 'search_category', 'search_by_user', 'search_brand'));

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function cart()
    {
        $user_id = Auth::user()->user_id;
        $cart = AddToCartModal::where('atc_created_by', $user_id)
            ->leftJoin('financials_products', 'financials_products.pro_p_code', '=', 'financials_add_to_cart.atc_pro_code')
            ->select('financials_add_to_cart.*', 'financials_products.pro_qty_for_sale as sale_qty', 'financials_products.pro_stock_status as limited', 'financials_products.pro_hold_qty_per as percentage', 'financials_products.pro_image as image')
            ->get();
        return view('cart.cart-list', compact('cart'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart($id)
    {
        $user_id = Auth::user()->user_id;
        $product = ProductModel::where('pro_p_code', $id)->leftJoin('financials_units', 'financials_units.unit_id', 'financials_products.pro_unit_id')->first();
        $cart_product_code = AddToCartModal::where('atc_pro_code', $id)->where('atc_created_by', $user_id)->pluck('atc_qty')->first();
        if ($product->pro_stock_status == 0) {
            $online_qty = $product->pro_qty_for_sale * $product->pro_hold_qty_per / 100;
            if ($online_qty > 0) {
                if (isset($cart_product_code)) {
                    AddToCartModal::where('atc_pro_code', $id)->update([
                        'atc_qty' => $cart_product_code + 1
                    ]);
                } else {
                    $cart_data = new AddToCartModal;
                    $cart_data->atc_pro_code = $product->pro_p_code;
                    $cart_data->atc_pro_name = $product->pro_title;
                    $cart_data->atc_qty = 1;
                    $cart_data->atc_uom = $product->unit_title;
                    $cart_data->atc_scale_size = $product->unit_scale_size;
                    $cart_data->atc_price = $product->pro_sale_price;
                    $cart_data->atc_image = $product->pro_image;
                    $cart_data->atc_created_by = $user_id;
                    $cart_data->save();
                }
            } else {
                return redirect()->back()->with('success', 'Out Off Stock!');
            }
        } else {
            if (isset($cart_product_code)) {
                AddToCartModal::where('atc_pro_code', $id)->update([
                    'atc_qty' => $cart_product_code + 1
                ]);
            } else {
                $cart_data = new AddToCartModal;
                $cart_data->atc_pro_code = $product->pro_p_code;
                $cart_data->atc_pro_name = $product->pro_title;
                $cart_data->atc_qty = 1;
                $cart_data->atc_uom = $product->unit_title;
                $cart_data->atc_scale_size = $product->unit_scale_size;
                $cart_data->atc_price = $product->pro_sale_price;
                $cart_data->atc_image = $product->pro_image;
                $cart_data->atc_created_by = $user_id;
                $cart_data->save();
            }
        }
        $cart = AddToCartModal::where('atc_created_by', $user_id)->get();
        return response()->json(['success' => 'Add to Cart Successfully!', 'cart' => $cart]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $product = ProductModel::where('pro_p_code', $request->code)->first();
        $cart = AddToCartModal::where('atc_pro_code', $request->code)->where('atc_created_by', $user->user_id)->first();
        $online_qty = $product->pro_qty_for_sale * $product->pro_hold_qty_per / 100;
        if ($product->pro_stock_status == 0) {
            if ($online_qty >= $request->qty) {
                $cart->atc_qty = $request->qty;
                $cart->atc_price = $product->pro_sale_price;
                $cart->save();
                return response()->json(['response' => 'success', 'success' => 'Quantity Updated Successfully!']);

            } else {
                return response()->json(['response' => 'success', 'success' => 'No More Quantity Increase!']);
            }
        } else {
            $cart->atc_qty = $request->qty;
            $cart->atc_price = $product->pro_sale_price;
            $cart->save();
            return response()->json(['response' => 'success', 'success' => 'Quantity Updated Successfully!']);
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove($id)
    {
        $user_id = Auth::user()->user_id;
        AddToCartModal::where('atc_created_by', $user_id)->where('atc_pro_code', '=', $id)->delete();
        return redirect()->back()->with('success', 'Product removed successfully');

    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        $account_code = AccountRegisterationModel::where('account_employee_id', '=', $user->user_id)->pluck('account_uid')->first();

        $account_name = $this->get_account_name($account_code);
        $rollBack = false;

        $cart = AddToCartModal::where('atc_created_by', $user->user_id)->get();
        $sales_array = [];

        foreach ($cart as $index => $requested_array) {

            $item_code = $requested_array->atc_pro_code;
            $item_name = $requested_array->atc_pro_name;
            $item_remarks = '';
            $item_warehouse = 1;
            $item_quantity = $requested_array->atc_qty;
            $item_unit_measurement = $requested_array->atc_uom;
            $item_unit_measurement_scale_size = $requested_array->atc_scale_size;
            $item_bonus = 0;
            $item_rate = $requested_array->atc_price;
            $item_discount = 0;
            $item_discount_amount = 0;
            $item_inclusive_rate = $requested_array->atc_price;
            $item_after_disc_rate = $item_rate - ($item_discount_amount / $item_quantity);
            $item_sales_tax = 0;
            $item_inclusive_exclusive = 0;
            $item_sale_tax_amount = 0;
            $item_amount = $item_quantity * $item_rate;
            $item_product_or_service_status = 0;

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

            $sale_order = $this->AssignSaleOrderValues($request, $account_code, $sale_order, $day_end, $user, $sale_prefix);


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
            AddToCartModal::where('atc_created_by', $user->user_id)->delete();
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

    public function AssignSaleOrderValues($request, $account_code, $sale_invoice, $day_end, $user, $prfx)
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

        $sale_invoice->$col_party_code = $account_code;
        $sale_invoice->$col_party_name = $this->get_account_name($account_code);
        $sale_invoice->$col_posting_reference = 1;
        $sale_invoice->$col_customer_name = ucwords($this->get_account_name($account_code));
        $sale_invoice->$col_remarks = '';
        $sale_invoice->$col_total_items = $request->total_items;
        $sale_invoice->$col_total_price = $request->total_price;
        $sale_invoice->$col_product_discount = 0;
        $sale_invoice->$col_round_off_discount = 0;
        $sale_invoice->$col_cash_disc_percentage = 0;
        $sale_invoice->$col_cash_disc_amount = 0;
        $sale_invoice->$col_total_discount = 0;
        $sale_invoice->$col_inclusive_sales_tax = 0;
        $sale_invoice->$col_exclusive_sales_tax = 0;
        $sale_invoice->$col_total_sales_tax = 0;
        $sale_invoice->$col_grand_total = $request->total_price;
        $sale_invoice->$col_discount_type = 1;
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
}
