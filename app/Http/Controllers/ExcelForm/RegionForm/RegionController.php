<?php

namespace App\Http\Controllers\ExcelForm\RegionForm;

use App\Http\Controllers\DayEndController;
use App\Models\AreaModel;
use App\Models\RegionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;

class RegionController extends Controller
{
    public function excel_form_region($request)
    {

        DB::beginTransaction();
        $rollBack = false;

        $region = new RegionModel();

        $user = Auth::User();

        $region = $this->ExcelAssignRegionValues($request, $region);

        if ($region->save()) {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Region With Id: ' . $region->reg_id . ' And Name: ' . $region->reg_title);


            if (!$region->save()) {
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

    public function simple_form_region($request)
    {

        $this->region_validation($request);

        $region = new RegionModel();

        $region = $this->AssignRegionValues($request, $region);

        $region->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Region With Id: ' . $region->reg_id . ' And Name: ' . $region->reg_title);

        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('add_region')->with('success', 'Successfully Saved');

    }

    public function region_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'region_name' => ['required', 'string', 'unique:financials_region,reg_title,null,null,reg_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function excel_region_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'region_name' => ['required', 'string', 'unique:financials_region,reg_title,null,null,reg_clg_id,' . $user->user_clg_id],
        ]);
    }

    protected function AssignRegionValues($request, $region)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $region->reg_title = ucwords($request->region_name);
        $region->reg_remarks = ucfirst($request->remarks);
        $region->reg_createdby = $user->user_id;
        $region->reg_day_end_id = $day_end->de_id;
        $region->reg_day_end_date = $day_end->de_datetime;
        $region->reg_clg_id = $user->user_clg_id;
        $region->reg_branch_id = Session::get('branch_id');;

        // coding from shahzaib start
        $tbl_var_name = 'region';
        $prfx = 'reg';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $region;
    }

    protected function ExcelAssignRegionValues($request, $region)
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $region->reg_title = ucwords($request->region_name);
        $region->reg_createdby = $user->user_id;
        $region->reg_day_end_id = $day_end->de_id;
        $region->reg_day_end_date = $day_end->de_datetime;
        $region->reg_clg_id = $user->user_clg_id;
        $region->reg_branch_id = Session::get('branch_id');

        // coding from shahzaib start
        $tbl_var_name = 'region';
        $prfx = 'reg';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $region;
    }

}
