<?php

namespace App\Http\Controllers\ExcelForm\ProductReportingGroupForm;

use App\Http\Controllers\DayEndController;
use App\Models\MainUnitModel;
use App\Models\ProductGroupModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class ProductReportingGroupController extends Controller
{

    public function excel_form_product_group($request)
    {

        DB::beginTransaction();
        $rollBack = false;

        $product_group = new ProductGroupModel();

        $user = Auth::User();

        $product_group = $this->ExcelAssignProductGroupValues($request, $product_group);

        if ($product_group->save()) {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Product Group With Id: ' . $product_group->pg_id . ' And Name: ' . $product_group->pg_title);


            if (!$product_group->save()) {
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

    public function simple_form_product_group($request)
    {

        $this->product_group_validation($request);

        $product_group = new ProductGroupModel();

        $product_group = $this->AssignProductGroupValues($request, $product_group);

        $product_group->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Product Group With Id: ' . $product_group->pg_id . ' And Name: ' . $product_group->pg_title);

        // WizardController::updateWizardInfo(['product_reporting_group'], ['add_modular_group']);

        return redirect()->back()->with('success', 'Successfully Saved');

    }

    public function product_group_validation($request)
    {dd(78);
        $user = Auth::user();
        return $this->validate($request, [
            'group_name' => ['required', 'string', 'unique:financials_product_group,pg_title,null,pg_id,pg_clg_id,' . $user->user_clg_id],

            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function excel_product_group_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'group_name' => ['required', 'string', 'unique:financials_product_group,pg_title,null,null,pg_clg_id,' . $user->user_clg_id],
        ]);
    }

    protected function AssignProductGroupValues($request, $product_group)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $product_group->pg_title = ucwords($request->group_name);
        $product_group->pg_remarks = ucfirst($request->remarks);
        $product_group->pg_created_by = $user->user_id;
        $product_group->pg_clg_id = $user->user_clg_id;
        $product_group->pg_branch_id = Session::get('branch_id');
        $product_group->pg_day_end_id = $day_end->de_id;
        $product_group->pg_day_end_date = $day_end->de_datetime;
        $product_group->pg_brwsr_info = $brwsr_rslt;
        $product_group->pg_ip_adrs = $ip_rslt;
        $product_group->pg_update_datetime = Carbon::now()->toDateTimeString();

        return $product_group;
    }

    protected function ExcelAssignProductGroupValues($request, $product_group)
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $product_group->pg_title = ucwords($request->group_name);
        $product_group->pg_created_by = $user->user_id;
        $product_group->pg_clg_id = $user->user_clg_id;
        $product_group->pg_branch_id = Session::get('branch_id');
        $product_group->pg_day_end_id = $day_end->de_id;
        $product_group->pg_day_end_date = $day_end->de_datetime;
        $product_group->pg_brwsr_info = $brwsr_rslt;
        $product_group->pg_ip_adrs = $ip_rslt;
        $product_group->pg_update_datetime = Carbon::now()->toDateTimeString();

        return $product_group;
    }


}
