<?php

namespace App\Http\Controllers\ExcelForm\CategoryForm;

use App\Http\Controllers\DayEndController;
use App\Models\CategoryInfoModel;
use App\Models\UnitInfoModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryFormController extends Controller
{
    public function excel_form_category($request)
    {

        DB::beginTransaction();
        $rollBack = false;

        $category = new CategoryInfoModel();

        $user = Auth::User();

        $category = $this->ExcelAssignCategoryValues($request, $category);

        if ($category->save()) {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Category With Id: ' . $category->cat_id . ' And Name: ' . $category->cat_title);


            if (!$category->save()) {
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

    public function simple_form_category($request)
    {
        $user = Auth::User();
        $area_already_exist = CategoryInfoModel::where('cat_clg_id', '=', $user->user_clg_id)->where('cat_title', '=', $request->category_name)->where('cat_group_id', '=', $request->group_name)
            ->first();
        if ($area_already_exist != null) {
            return response()->json(['already_exist' => 'Category Already exist'], 200);
        }
        $this->category_validation($request);

        $category = new CategoryInfoModel();

        $category = $this->AssignCategoryValues($request, $category);

        $category->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Category With Id: ' . $category->cat_id . ' And Name: ' . $category->cat_title);

        // WizardController::updateWizardInfo(['category'], ['main_unit', 'product']);
        return response()->json(['message' => 'Successfully Saved!', 'name' => $category->cat_title], 200);
//        return redirect('add_category')->with('success', 'Successfully Saved');
    }

    public function category_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'group_name' => ['required', 'numeric'],
            'category_name' => ['required', 'string', 'unique:financials_categories,cat_title,NULL,cat_id,cat_group_id,' . $request->group_name . ',cat_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
            'tax' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'retailer' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'wholesaler' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'loyalty_card' => ['nullable', 'regex:/^\d*\.?\d*$/'],
        ]);
    }

    public function excel_category_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'group_name' => ['required', 'numeric'],
            'category_name' => ['required', 'string', 'unique:financials_categories,cat_title,NULL,cat_id,cat_group_id,' . $request->group_name . ',cat_clg_id,' . $user->user_clg_id],
        ]);
    }

    protected function AssignCategoryValues($request, $category)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $category->cat_group_id = $request->group_name;
        $category->cat_title = ucwords($request->category_name);
        $category->cat_remarks = ucfirst($request->remarks);
        $category->cat_createdby = $user->user_id;
        $category->cat_clg_id = $user->user_clg_id;
        $category->cat_day_end_id = $day_end->de_id;
        $category->cat_day_end_date = $day_end->de_datetime;

        $category->cat_tax = (isset($request->tax) || !empty($request->tax)) ? $request->tax : 0;
        $category->cat_retailer_discount = (isset($request->retailer) || !empty($request->retailer)) ? $request->retailer : 0;
        $category->cat_whole_seller_discount = (isset($request->wholesaler) || !empty($request->wholesaler)) ? $request->wholesaler : 0;
        $category->cat_loyalty_card_discount = (isset($request->loyalty_card) || !empty($request->loyalty_card)) ? $request->loyalty_card : 0;
        $category->cat_use_group_fields = (isset($request->check_group) || !empty($request->check_group)) ? $request->check_group : 0;

        // coding from shahzaib start
        $tbl_var_name = 'category';
        $prfx = 'cat';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $category;
    }

    protected function ExcelAssignCategoryValues($request, $category)
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $category->cat_group_id = $request->group_name;
        $category->cat_title = ucwords($request->category_name);
        $category->cat_createdby = $user->user_id;
        $category->cat_clg_id = $user->user_clg_id;
        $category->cat_day_end_id = $day_end->de_id;
        $category->cat_day_end_date = $day_end->de_datetime;

        $category->cat_tax = 0;
        $category->cat_retailer_discount = 0;
        $category->cat_whole_seller_discount = 0;
        $category->cat_loyalty_card_discount = 0;
        $category->cat_use_group_fields = 0;


        // coding from shahzaib start
        $tbl_var_name = 'category';
        $prfx = 'cat';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $category;
    }
}
