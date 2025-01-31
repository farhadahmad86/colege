<?php

namespace App\Http\Controllers\ExcelForm\GroupAccountForm;

use App\Http\Controllers\DayEndController;
use App\Models\AccountGroupModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class AccountGroupController extends Controller
{
    public function excel_form_account_group($request)
    {
        DB::beginTransaction();
        $rollBack = false;

        $group = new AccountGroupModel();
        $user = Auth::User();
        $group = $this->ExcelAssignAccountGroupValues($request, $group);

        if ($group->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Reporting Group With Id: ' . $group->ag_id . ' And Name: ' . $group->ag_title);


            if (!$group->save()) {
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

    public function simple_form_account_group($request)
    {
        $this->account_group_validation($request);

        $group = new AccountGroupModel();

        $group = $this->AssignAccountGroupValues($request, $group);

        $group->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Reporting Group With Id: ' . $group->ag_id . ' And Name: ' . $group->ag_title);

//        WizardController::updateWizardInfo(['reporting_group'], ['product_reporting_group']);

        return redirect('add_account_group')->with('success', 'Successfully Saved');

    }

    public function account_group_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'group_name' => ['required', 'string', 'unique:financials_account_group,ag_title,null,null,ag_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function excel_account_group_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'group_name' => ['required', 'string', 'unique:financials_account_group,ag_title,null,null,ag_clg_id,' . $user->user_clg_id],
        ]);
    }

    protected function AssignAccountGroupValues($request, $group)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $group->ag_title = ucwords($request->group_name);
        $group->ag_remarks = ucfirst($request->remarks);
        $group->ag_created_by = $user->user_id;
        $group->ag_clg_id = $user->user_clg_id;
        $group->ag_branch_id = Session::get('branch_id');
        $group->ag_day_end_id = $day_end->de_id;
        $group->ag_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'group';
        $prfx = 'ag';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $group;
    }

    protected function ExcelAssignAccountGroupValues($request, $group)
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $group->ag_title = ucwords($request->group_name);
        $group->ag_created_by = $user->user_id;
        $group->ag_clg_id = $user->user_clg_id;
        $group->ag_branch_id = Session::get('branch_id');
        $group->ag_day_end_id = $day_end->de_id;
        $group->ag_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'group';
        $prfx = 'ag';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $group;
    }
}
