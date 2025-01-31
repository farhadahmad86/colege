<?php

namespace App\Http\Controllers\ExcelForm\ProductForm;

use App\Http\Controllers\DayEndController;
use App\Http\Controllers\SaveImageController;
use App\Models\DayEndModel;
use App\Models\ProductModel;
use App\Models\StockMovementModels;
use App\Models\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function excel_form_product($request)
    {

        DB::beginTransaction();
        $rollBack = false;

        $product = new ProductModel();
        $product = $this->ExcelAssignProductValues($request, $product);

        if ($product->save()) {
            if (!empty($day_end)) {
                $stock_movement = new StockMovementModels();

                $this->ProductCreationStockMovementValues($product, $stock_movement);

                if (!$stock_movement->save()) {
                    DB::rollBack();
                    return true;
                }
            }


            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Product With Code: ' . $product->pro_code . ' And Name: ' . $product->pro_title);

            if (!$product->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }

        } else {
            $rollBack = true;
            DB::rollBack();
            return true;
        }

    }

    public
    function simple_form_product($request)
    {
        $user = Auth::user();
        $area_already_exist = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_title', '=', $request->product_name)->where('pro_unit_id', '=', $request->unit_name)->first();
        if ($area_already_exist != null) {
            return response()->json(['already_exist' => 'Product Name Already exist'], 200);
        }
        $area_already_exist = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', '=', $request->product_barcode)->first();
        if ($area_already_exist != null) {
            return response()->json(['already_exist' => 'Product Barcode Already exist'], 200);
        }

        $this->product_validation($request);
        $uniqueId = Utility::uniqidReal() . mt_rand();
        DB::beginTransaction();
        $product = new ProductModel();
        $day_end = DayEndModel::where('de_clg_id', $user->user_clg_id)->get();
        $product = $this->AssignProductValues($request, $product, $uniqueId);

        if ($product->save()) {
            if ($day_end != null) {
                $stock_movement = new StockMovementModels();

                $this->ProductCreationStockMovementValues($product, $stock_movement);

                if (!$stock_movement->save()) {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again!');
                }
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Product With Code: ' . $product->pro_code . ' And Name: ' . $product->pro_title);

            DB::commit();

            // WizardController::updateWizardInfo(['product'], ['product_clubbing', 'product_packages', 'product_recipe']);
            $pro_code = $product->pro_id + 1;

//            return response()->json(['message' => 'Successfully Saved!', 'name' => $product->pro_code, 'pro_code' => '00'.$pro_code], 200);
            return redirect()->back()->with('success', 'Successfully Saved ' . $product->pro_code);

        } else {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }

    public
    function product_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'group_name' => ['required', 'numeric'],
            'category_name' => ['required', 'numeric'],
            'product_group' => ['required', 'numeric'],
            'main_unit' => ['nullable', 'numeric'],
            'unit_name' => ['nullable', 'numeric'],
            'unit_allow_decimal' => ['nullable', 'numeric'],
            'product_name' => ['required', 'string', 'unique:financials_products,pro_title,NULL,pro_id,pro_unit_id,' . $request->unit_name . ',pro_clg_id,' . $user->user_clg_id],
            'product_barcode' => ['required', 'string', 'unique:financials_products,pro_p_code,NULL,pro_id,pro_clg_id,' . $user->user_clg_id],
            'product_code' => ['nullable', 'string'],
            'alternative_code' => ['nullable', 'string'],
            'isbn_number' => ['nullable', 'string'],
            'purchase_price' => ['nullable', 'numeric'],
            'bottom_price' => ['nullable', 'numeric'],
            'sale_price' => ['nullable', 'numeric'],
            'remarks' => ['nullable', 'string'],
            'expiry' => ['nullable', 'date'],
            'min_qty' => ['nullable', 'numeric'],
            'alert' => ['nullable', 'numeric'],
            'tax' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'retailer' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'wholesaler' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'loyalty_card' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'check_group' => ['nullable', 'numeric'],
            'pimage' => 'nullable|image|mimes:jpeg,jpg,png|max:180',
        ]);
    }

    public
    function excel_product_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'product_type' => ['required', 'numeric'],
            'group_name' => ['required', 'numeric'],
            'category_name' => ['required', 'numeric'],
            'product_group' => ['required', 'numeric'],
            'main_unit' => ['nullable', 'numeric'],
            'unit_name' => ['nullable', 'numeric'],
            'product_name' => ['required', 'string', 'unique:financials_products,pro_title,NULL,pro_id,pro_unit_id,' . $request->unit_name . ',pro_clg_id,' . $user->user_clg_id],
            'product_barcode' => ['required', 'unique:financials_products,pro_p_code,NULL,pro_id,pro_clg_id,' . $user->user_clg_id],
            'product_code' => ['nullable'],
            'purchase_price' => ['nullable', 'numeric'],
            'bottom_price' => ['nullable', 'numeric'],
            'sale_price' => ['nullable', 'numeric'],

        ]);
    }

    protected
    function AssignProductValues($request, $product, $uniqueid)
    {
        $pro_code = ProductModel::orderBy('pro_id', 'DESC')->pluck('pro_id')->first();
        $pro_code = $pro_code + 1;
        $user = Auth::User();
        $rand_number = Utility::uniqidReal();
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $product->pro_product_type_id = $request->product_type;
        $product->pro_group_id = $request->group_name;
        $product->pro_category_id = $request->category_name;
        $product->pro_reporting_group_id = $request->product_group;
        $product->pro_main_unit_id = $request->main_unit;
        $product->pro_unit_id = $request->unit_name;
        $product->pro_allow_decimal = $request->unit_allow_decimal;
        $product->pro_brand_id = $request->brand;
        $product->pro_code = '00' . $pro_code; //isset($request->product_code) ? $request->product_code : '';
        $product->pro_title = ucwords($request->product_name);
        $product->pro_urdu_title = ucwords($request->urdu_product_name);
        $product->pro_purchase_price = isset($request->purchase_price) ? $request->purchase_price : 0;
        $product->pro_last_purchase_rate = isset($request->purchase_price) ? $request->purchase_price : 0;
        $product->pro_createdby = $user->user_id;
        $product->pro_clg_id = $user->user_clg_id;
        $product->pro_day_end_id = $day_end->de_id;
        $product->pro_day_end_date = $day_end->de_datetime;
        $product->pro_average_rate = isset($request->purchase_price) ? $request->purchase_price : 0;

        $product->pro_quantity = 0;
        $product->pro_p_code = $request->product_barcode;
        $product->pro_alternative_code = isset($request->alternative_code) ? $request->alternative_code : '';
        $product->pro_ISBN = isset($request->isbn_number) ? $request->isbn_number : '';
//        $product->pro_flag = 0;

        $product->pro_tax = (isset($request->tax) || !empty($request->tax)) ? $request->tax : 0;
        $product->pro_retailer_discount = (isset($request->retailer) || !empty($request->retailer)) ? $request->retailer : 0;
        $product->pro_whole_seller_discount = (isset($request->wholesaler) || !empty($request->wholesaler)) ? $request->wholesaler : 0;
        $product->pro_loyalty_card_discount = (isset($request->loyalty_card) || !empty($request->loyalty_card)) ? $request->loyalty_card : 0;
        $product->pro_use_cat_fields = (isset($request->check_group) || !empty($request->check_group)) ? $request->check_group : 0;

        $product->pro_hold_qty_per = (isset($request->hold_per_online) || !empty($request->hold_per_online)) ? $request->hold_per_online : 0;
        $product->pro_stock_status = (isset($request->stock_status) || !empty($request->stock_status)) ? $request->stock_status : 0;
        $product->pro_edit = (isset($request->edit_status) || !empty($request->edit_status)) ? $request->edit_status : 0;
        $product->pro_net_weight = $request->net_weight;
        $product->pro_gross_weight = $request->gross_weight;

        $save_image = new SaveImageController();

        $common_path = config('global_variables.common_path');
        $product_path = config('global_variables.product_path');

        // Handle Image
        $fileNameToStore = $save_image->SaveImage($request, 'pimage', $uniqueid, $product_path, $rand_number . 'Product_Image');


        if ($request->hasFile('pimage')) {
            $product->pro_image = $common_path . $fileNameToStore;
        } else {
            $product->pro_image = $fileNameToStore;
        }


        // coding from shahzaib start
        $tbl_var_name = 'product';
        $prfx = 'pro';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        if (!empty($request->bottom_price)) {
            $product->pro_bottom_price = $request->bottom_price;
        }
        $product->pro_sale_price = isset($request->sale_price) ? $request->sale_price : 0;
        $product->pro_remarks = ucfirst($request->remarks);
        if (!empty($request->min_qty)) {
            $product->pro_min_quantity = $request->min_qty;
        }
        if (!empty($request->expiry)) {
            $product->pro_expiry_date = date('Y-m-d', strtotime($request->expiry));
        }
        if (!empty($request->alert)) {
            $product->pro_min_quantity_alert = $request->alert;
        }
        if (!empty($request->online_status)) {
            $product->pro_online_status = $request->online_status;
        }

        return $product;
    }

    protected
    function ExcelAssignProductValues($request, $product)
    {
        $pro_code = ProductModel::orderBy('pro_id', 'DESC')->pluck('pro_id')->first();
        $pro_code = $pro_code + 1;

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $product->pro_product_type_id = $request->product_type;
        $product->pro_group_id = $request->group_name;
        $product->pro_category_id = $request->category_name;
        $product->pro_reporting_group_id = $request->product_group;
        $product->pro_main_unit_id = $request->main_unit;
        $product->pro_unit_id = $request->unit_name;
        $product->pro_brand_id = null;
        $product->pro_code = '00' . $pro_code;//isset($request->product_code) ? $request->product_code : '';
        $product->pro_title = ucwords($request->product_name);
        $product->pro_purchase_price = isset($request->purchase_price) ? $request->purchase_price : 0;
        $product->pro_last_purchase_rate = isset($request->purchase_price) ? $request->purchase_price : 0;
        $product->pro_createdby = $user->user_id;
        $product->pro_clg_id = $user->user_clg_id;
        $product->pro_day_end_id = $day_end->de_id;
        $product->pro_day_end_date = $day_end->de_datetime;
        $product->pro_average_rate = isset($request->purchase_price) ? $request->purchase_price : 0;

        $product->pro_quantity = 0;
        $product->pro_p_code = $request->product_barcode;
        $product->pro_alternative_code = '';
        $product->pro_ISBN = '';
//        $product->pro_flag = 0;

        $product->pro_tax = 0;
        $product->pro_retailer_discount = 0;
        $product->pro_whole_seller_discount = 0;
        $product->pro_loyalty_card_discount = 0;
        $product->pro_use_cat_fields = 0;

        $product->pro_hold_qty_per = 0;

        // coding from shahzaib start
        $tbl_var_name = 'product';
        $prfx = 'pro';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        if (!empty($request->bottom_price)) {
            $product->pro_bottom_price = $request->bottom_price;
        }
        $product->pro_sale_price = isset($request->sale_price) ? $request->sale_price : 0;


        return $product;
    }

    public
    function ProductCreationStockMovementValues($product, $stock_movement)
    {
        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $product_code = $product->pro_p_code;
        $product_name = $product->pro_title;
        $product_remarks = $product->pro_remarks;
        $product_bal_qty = $product->pro_quantity;
        $product_bal_rate = $product->pro_purchase_price;
        $product_bal_total = $product_bal_qty * $product_bal_rate;
        $notes = 'OPENING_BALANCE';


        $stock_movement->sm_product_code = $product_code;
        $stock_movement->sm_product_name = $product_name;
//        $stock_movement->sm_pur_qty = 0;
//        $stock_movement->sm_pur_rate = 0;
//        $stock_movement->sm_pur_total = 0;
//        $stock_movement->sm_sale_qty = 0;
//        $stock_movement->sm_sale_rate = 0;
//        $stock_movement->sm_sale_total = 0;
        $stock_movement->sm_bal_total_qty_wo_bonus = $product_bal_qty;
        $stock_movement->sm_bal_total_qty = $product_bal_qty;
//        $stock_movement->sm_bal_qty = $product_bal_qty;
        $stock_movement->sm_bal_rate = $product_bal_rate;
        $stock_movement->sm_bal_total = $product_bal_total;
        $stock_movement->sm_type = $notes;
        $stock_movement->sm_day_end_id = 1;
        $stock_movement->sm_day_end_date = $day_end->de_datetime;
//        $stock_movement->sm_voucher_code = 0;
        $stock_movement->sm_remarks = $product_remarks;
        $stock_movement->sm_user_id = $user->user_id;
        $stock_movement->sm_clg_id = $user->user_clg_id;
        $stock_movement->sm_date_time = Carbon::now()->toDateTimeString();

        return $stock_movement;
    }
}
