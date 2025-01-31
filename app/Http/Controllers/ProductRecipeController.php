<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Models\ProductModel;
use App\Models\ProductRecipeItemsModel;
use App\Models\ProductRecipeModel;
use App\Models\SystemConfigModel;
use Auth;
use PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductRecipeController extends Controller
{

    public function getProducts(Request $request){

        $search = (isset($request->searchTerm) && !empty($request->searchTerm)) ? $request->searchTerm : '';

        $user = Auth::user();

        $query = DB::table('financials_products')
            ->leftJoin('financials_units', 'financials_units.unit_id', 'financials_products.pro_unit_id');
        if ($user->user_level != 100) {
            $query->whereIn('pro_reporting_group_id', explode(',', $user->user_product_reporting_group_ids));
        }

        if (!empty($search)) {
            $query->where('pro_p_code', 'like', '%' . $search . '%')
                ->orWhere('pro_code', 'like', '%' . $search . '%')
                ->orWhere('pro_average_rate', 'like', '%' . $search . '%')
                ->orWhere('pro_title', 'like', '%' . $search . '%');
        }

        $products = $query->select('pro_code as id', 'pro_title as text')
            ->where('pro_status', config('global_variables.product_active_status'))
            ->where('pro_delete_status', '!=', 1)
            ->where('pro_disabled', '!=', 1)
            ->orderby('pro_title', 'ASC')
            ->limit(50)
            ->get();

        return response()->json(['products'=>$products], 200);
    }

    public function getRecipe(Request $request){

        $recipe_id = $request->id;

        $checkJsn = self::RECIPE_WITH_ALL_PRODUCTS($recipe_id, "Raw-Product");

        $getRaw = self::RECIPE_WITH_ALL_PRODUCTS($recipe_id, "Raw-Product");

        $getPrimary = self::RECIPE_WITH_ALL_PRODUCTS($recipe_id, "Primary-Finish-Goods");

        $getSecondary = self::RECIPE_WITH_ALL_PRODUCTS($recipe_id, "Secondary-Finish-Goods");


        return response()->json(["checkJsn"=>$checkJsn, "get_raw"=>$getRaw, "get_primary"=>$getPrimary, "get_secondary"=>$getSecondary], 200);

    }

    public function RECIPE_WITH_ALL_PRODUCTS($id, $pri_status){

        $query = DB::table("financials_product_recipe as recipe")
            ->leftJoin("financials_product_recipe_items as items", "items.pri_product_recipe_id", "recipe.pr_id")
            ->leftJoin("financials_products as pro", "items.pri_product_code", "pro.pro_p_code")
            ->select("items.pri_product_code as pro_code", "items.pri_product_name as pro_name", "items.pri_remarks as pro_remarks", "items.pri_qty as quantity", "items.pri_uom as pro_uom", "pro.pro_qty_for_sale as pro_available_quantity", "pro.pro_last_purchase_rate as pro_last_purchase_rate", "pro.pro_average_rate as pro_average_rate")
            ->where("recipe.pr_id", $id)
            ->where("items.pri_status", $pri_status)
            ->get();
        return $query;



//
//        $query = DB::table("financials_product_recipe_items")->where("pri_product_recipe_id", $id)->get();
//        $query = $query->map(function($recip) {
//            $recip->products = DB::table("financials_products")->where('pro_code', '=', $recip->pri_product_code)->get();
//            return $recip;


//            ->leftJoin("financials_units as unit", "unit.unit_id", "pro.pro_unit_id")
//        "unit.unit_title as pro_uom"
    }

    public function product_recipe()
    {
        $products = $this->get_all_products();

        $parent_products = $this->get_products_by_type(config('global_variables.parent_product_type'));

        $pro_code = '';
        $pro_name = '';

        $manufacture_pro_code = '';
        $manufacture_pro_name = '';

        foreach ($products as $key=>$product) {
            $pro_title = $this->RemoveSpecialChar($product->pro_title);

            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate' data-uom='$product->unit_title' data-code='$product->pro_p_code'> $product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_title' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate' data-uom='$product->unit_title' data-code='$product->pro_p_code'>$pro_title</option>";
        }

        foreach ($parent_products as $parent_product) {
            $pro_title = $this->RemoveSpecialChar($parent_product->pro_title);

            $manufacture_pro_code .= "<option value='$parent_product->pro_p_code'> $parent_product->pro_p_code</option>";
            $manufacture_pro_name .= "<option value='$parent_product->pro_p_code'>$pro_title</option>";
        }

        $expense_accounts = $this->get_fourth_level_account(config('global_variables.expense'), 2, 0);

        return view('product_recipe', compact('pro_code', 'pro_name', 'manufacture_pro_code', 'manufacture_pro_name', 'expense_accounts'));
    }

    public function submit_product_recipe(Request $request)
    {
//        dd($request->all());

        $this->validation($request);

        $rollBack = false;
        DB::beginTransaction();

        $product_recipe = new ProductRecipeModel();

        $user_id = Auth::user()->user_id;
        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();
        $current_date_time = Carbon::now()->toDateTimeString();

        $product_recipe = $this->AssignValues($request, $product_recipe, $user_id, $ip, $browser, $current_date_time);

        if ($product_recipe->save()) {
            $product_recipe_id = $product_recipe->pr_id;

            $items = [];

            /*
             * This array add Recipe Raw Products in Product Recipe Items Table
             */
            $cartDataForProductRecipes = json_decode($request->cartDataForProductRecipe, true);
            $item = $this->AssignItemsValuesForQuantity($cartDataForProductRecipes, $items, $product_recipe_id, 'Raw-Product');
            if (!DB::table('financials_product_recipe_items')->insert($item)) {
                $rollBack = true;
                DB::rollBack();
            }


            /*
             * This array add Recipe Expens in Product Recipe Items Table
             */
//            $cartDataForProductRecipes = json_decode($request->cartDataForExpense, true);
//            $item = $this->AssignItemsValuesForAmount($cartDataForProductRecipes, $items, $product_recipe_id, 'Recipe-Expense');
//            if (!DB::table('financials_product_recipe_items')->insert($item)) {
//                $rollBack = true;
//                DB::rollBack();
//            }

            /*
             * This array add Finished Primay Goods in Product Recipe Items Table
             */
            $cartDataForPrimaryGoods[] = ['pri_product_recipe_id' => $product_recipe_id, 'pri_product_code' => $request->primary_limited_product_code, 'pri_product_name' => ucwords($request->primary_limited_product_title), 'pri_qty' => $request->primary_limited_product_quantity, 'pri_uom' => $request->pro_uom_primary, 'pri_status' => 'Primary-Finish-Goods'];
            if (!DB::table('financials_product_recipe_items')->insert($cartDataForPrimaryGoods)) {
                $rollBack = true;
                DB::rollBack();
            }


            /*
             * This array add Finished Secondary Goods in Product Recipe Items Table
             */
            $cartDataForFinishedGoods = json_decode($request->cartDataForFinishedGoods, true);
            $item = $this->AssignItemsValuesForQuantity($cartDataForFinishedGoods, $items, $product_recipe_id, 'Secondary-Finish-Goods');
            if (!DB::table('financials_product_recipe_items')->insert($item)) {
                $rollBack = true;
                DB::rollBack();
            }
        }
        else {
            $rollBack = true;
            DB::rollBack();
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }
        else {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Pack With Id: ' . $product_recipe->pp_id . ' And Name: ' . $product_recipe->pp_name);

            DB::commit();

            // WizardController::updateWizardInfo(['product_recipe'], []);

            return redirect()->back()->with('success', 'Successfully Saved');
        }


    }

    public function validation($request)
    {
        return $this->validate($request, [
            'recipe_name' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
            'primary_limited_product_code' => ['nullable', 'string'],
            'primary_limited_product_title' => ['nullable', 'string'],
            'primary_limited_product_quantity' => ['nullable', 'string'],
//            'manufacture_product_code' => ['required', 'string'],
//            'manufacture_product_name' => ['required', 'string'],
//            'manufacture_qty' => ['required', 'numeric', 'min:1'],
//            'total_items' => ['required', 'numeric', 'min:1'],
//            'total_price' => ['required', 'numeric'],
//            'salesval' => ['required', 'string'],
            'cartDataForProductRecipe' => ['required', 'string'],
//            'cartDataForExpense' => ['required', 'string'],
//            'cartDataForFinishedGoods' => ['required', 'string'],
        ]);
    }

    public function AssignValues($request, $product_recipe, $user_id, $ip, $browser, $current_date_time)
    {
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $product_recipe->pr_name = ucwords($request->recipe_name);
        $product_recipe->pr_remarks = ucfirst($request->recipe_remarks);
        $product_recipe->pr_datetime = $current_date_time;
        $product_recipe->pr_day_end_id = $day_end->de_id;
        $product_recipe->pr_day_end_date = $day_end->de_datetime;
        $product_recipe->pr_createdby = $user_id;
        $product_recipe->pr_brwsr_info = $browser;
        $product_recipe->pr_ip_adrs = $ip;
        $product_recipe->pr_update_datetime = $current_date_time;
//        $product_recipe->pr_pro_code = $request->manufacture_product_code;
//        $product_recipe->pr_pro_name = $request->manufacture_product_name;
//        $product_recipe->pr_qty = $request->manufacture_qty;

        return $product_recipe;
    }

    public function AssignItemsValuesForQuantity($items, $data, $product_recipe_id, $status)
    {
//        $cartDataForProductRecipes = json_decode($request->cartDataForProductRecipe, true);
        foreach ($items as $key=>$item) {
            $data[] = [
                'pri_product_recipe_id' => $product_recipe_id,
                'pri_product_code' => $item['code'],
                'pri_product_name' => ucwords($item['title']),
                'pri_remarks' => $item['remarks'],
                'pri_uom' => $item['uom'],
                'pri_qty' => $item['quantity'],
                'pri_status' => $status
            ];
        }
        return $data;
    }

    public function AssignItemsValuesForAmount($items, $data, $product_recipe_id, $status)
    {
        foreach ($items as $key=>$item) {
            $data[] = ['pri_product_recipe_id' => $product_recipe_id, 'pri_product_code' => $item['code'], 'pri_product_name' => ucwords($item['title']), 'pri_remarks' => $item['remarks'], 'pri_amount' => $item['amount'], 'pri_status' => $status];
        }
        return $data;
    }

//
//    public function AssignItemsValues($request, $data, $product_recipe_id)
//    {
//        $salesval = json_decode($request->salesval, true);
//
//        foreach ($salesval as $key) {
//
//            $data[] = ['pri_product_recipe_id' => $product_recipe_id, 'pri_product_code' => $key[0], 'pri_product_name' => ucwords($key[1]), 'pri_qty' => $key[3], 'pri_rate'
//            => $key[4], 'pri_amount' => $key[5]];
//        }
//
//        return $data;
//    }

    // update code by shahzaib start
    public function product_recipe_list(Request $request, $array = null, $str = null)
    {


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
//        $search_product = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product_code;
//        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
//        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_recipe_list.product_recipe_list';
        $pge_title = 'Product Recipe List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


//        $start = date('Y-m-d', strtotime($search_to));
//        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_product_recipe as pr')
            ->leftJoin('financials_product_recipe_items as pri', 'pr.pr_id', 'pri.pri_product_recipe_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'pr.pr_createdby');

        if (!empty($search)) {
            $query->where('pr.pr_id', 'like', '%' . $search . '%')
                ->orWhere('pr.pr_name', 'like', '%' . $search . '%')
                ->orWhere('pr.pr_remarks', 'like', '%' . $search . '%')
                ->orWhere('pri.pri_product_code', 'like', '%' . $search . '%')
                ->orWhere('pri.pri_product_name', 'like', '%' . $search . '%')
                ->orWhere('pri.pri_uom', 'like', '%' . $search . '%')
                ->orWhere('pri.pri_status', 'like', '%' . $search . '%')
                ->orWhere('financials_users.user_designation', 'like', '%' . $search . '%')
                ->orWhere('financials_users.user_name', 'like', '%' . $search . '%')
                ->orWhere('financials_users.user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_product)) {
            $query->where('pri.pri_product_code', $search_product);
        }

        if (!empty($search_by_user)) {
            $query->where('pr.pr_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('pr.pr_delete_status', '=', 1);
        } else {
            $query->where('pr.pr_delete_status', '!=', 1);
        }



        $datas = $query->where('pri.pri_status', 'Primary-Finish-Goods')
            ->select("pr.pr_id", "pr.pr_name", "pr.pr_remarks", "pr.pr_brwsr_info", "pr.pr_ip_adrs", "pr.pr_delete_status", "pr.pr_disabled", "pri.pri_product_name", "pri.pri_qty", "financials_users.user_id", "financials_users.user_name" )
//            ->where('pr_delete_status', '!=', 1)
            ->orderBy('pr.pr_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $product_recipe_name = ProductRecipeModel::
        where('pr_delete_status', '!=', 1)->
        orderBy('pr_name', 'ASC')->pluck('pr_name')->all();


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
            return view('product_recipe_list', compact('datas', 'search', 'product_recipe_name', 'search_by_user', 'restore_list'));//'pro_code', 'pro_name',
//            return view('product_recipe_list', compact('datas', 'search', 'product_recipe_name', 'search_by_user', 'search_to', 'search_from', 'search_product', 'pro_code', 'pro_name','restore_list'));
        }

    }
    // update code by shahzaib end


    public function edit_product_recipe(Request $request)
    {
        $this->validate($request, [
            'recipe_id' => ['required', 'numeric', 'min:1'],
        ]);


        $recipe_id = $request->recipe_id;

        $product_recipe = ProductRecipeModel::where('pr_id', $recipe_id)->first();

        $products = $this->get_all_products();
        $pro_code = '';
        $pro_name = '';
        foreach ($products as $key=>$product) {
            $pro_title = $this->RemoveSpecialChar($product->pro_title);
            $selected = $product_recipe->pr_pro_code == $product->pro_p_code ? 'selected' : '';

            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate' data-uom='$product->unit_title' data-code='$product->pro_p_code' $selected> $product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_title' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate' data-uom='$product->unit_title' data-code='$product->pro_p_code' $selected>$pro_title</option>";
        }

        $getRaw = self::RECIPE_WITH_ALL_PRODUCTS($recipe_id, "Raw-Product");

        $getPrimary = self::RECIPE_WITH_ALL_PRODUCTS($recipe_id, "Primary-Finish-Goods");

        $getSecondary = self::RECIPE_WITH_ALL_PRODUCTS($recipe_id, "Secondary-Finish-Goods");


        return view('product_recipe_edit', compact('pro_code', 'pro_name', 'product_recipe', 'getRaw', 'getPrimary', 'getSecondary', "products"));
    }

    public function update_product_recipe(Request $request)
    {
        $this->validation($request);

        $this->validate($request, [
            'recipe_id' => ['required', 'numeric', 'min:1'],
        ]);

        $rollBack = false;
        DB::beginTransaction();

        $product_recipe = ProductRecipeModel::where('pr_id', $request->recipe_id)->first();

        $user_id = Auth::user()->user_id;
        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();
        $current_date_time = Carbon::now()->toDateTimeString();

        $product_recipe = $this->AssignValues($request, $product_recipe, $user_id, $ip, $browser, $current_date_time);

        if ($product_recipe->save()) {


            $product_recipe_id = $product_recipe->pr_id;

            $delete = ProductRecipeItemsModel::where('pri_product_recipe_id', $product_recipe_id)->delete();

            if ($delete) {
                $items = [];

                /*
                 * This array add Recipe Raw Products in Product Recipe Items Table
                 */
                $cartDataForProductRecipes = json_decode($request->cartDataForProductRecipe, true);
                $item = $this->AssignItemsValuesForQuantity($cartDataForProductRecipes, $items, $product_recipe_id, 'Raw-Product');
                if (!DB::table('financials_product_recipe_items')->insert($item)) {
                    $rollBack = true;
                    DB::rollBack();
                }

                /*
                 * This array add Finished Primay Goods in Product Recipe Items Table
                 */
                $cartDataForPrimaryGoods[] = ['pri_product_recipe_id' => $product_recipe_id, 'pri_product_code' => $request->primary_limited_product_code, 'pri_product_name' => ucwords($request->primary_limited_product_title), 'pri_qty' => $request->primary_limited_product_quantity, 'pri_uom' => $request->pro_uom_primary, 'pri_status' => 'Primary-Finish-Goods'];
                if (!DB::table('financials_product_recipe_items')->insert($cartDataForPrimaryGoods)) {
                    $rollBack = true;
                    DB::rollBack();
                }


                /*
                 * This array add Finished Secondary Goods in Product Recipe Items Table
                 */
                $cartDataForFinishedGoods = json_decode($request->cartDataForFinishedGoods, true);
                $item = $this->AssignItemsValuesForQuantity($cartDataForFinishedGoods, $items, $product_recipe_id, 'Secondary-Finish-Goods');
                if (!DB::table('financials_product_recipe_items')->insert($item)) {
                    $rollBack = true;
                    DB::rollBack();
                }
            }
            else {
                $rollBack = true;
                DB::rollBack();
            }
        }
        else {
            $rollBack = true;
            DB::rollBack();
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Product Recipe With Id: ' . $product_recipe->pr_id . ' And Name: ' . $product_recipe->pr_name);

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }

    }

    public function delete_product_recipe(Request $request)
    {
        $this->validate($request, [
            'del_recipe_id' => ['required', 'numeric', 'min:1'],
        ]);

        $user = Auth::User();

        $delete = ProductRecipeModel::where('pr_id', $request->del_recipe_id)->first();

//        $delete->pr_delete_status = 1;
        if ($delete->pr_delete_status == 1) {
            $delete->pr_delete_status = 0;
        } else {
            $delete->pr_delete_status = 1;
        }
        $delete->pr_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->pr_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Product Recipe With Id: ' . $delete->pr_id . ' And Name: ' . $delete->pr_name);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Product Recipe With Id: ' . $delete->pr_id . ' And Name: ' . $delete->pr_name);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }

    public function get_product_recipe_details(Request $request)
    {
        $items = ProductRecipeItemsModel::where('pri_product_recipe_id', $request->id)->get();

        return response()->json($items);
    }


}
