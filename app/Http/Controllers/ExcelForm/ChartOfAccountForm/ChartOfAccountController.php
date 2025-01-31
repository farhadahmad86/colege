<?php

namespace App\Http\Controllers\ExcelForm\ChartOfAccountForm;

use App\Http\Controllers\AccountRegisterationsController;
use App\Http\Controllers\DayEndController;
use App\Models\AccountHeadsModel;
use App\Models\AreaModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartOfAccountController extends Controller
{
    public function excel_form_second_level_chart_of_account($request)
    {
        DB::beginTransaction();
        $rollBack = false;

        $account = new AccountHeadsModel();
        $user = Auth::User();
        $account = $this->ExcelAssignSecondLevelChartOfAccountValues($request->head_code, $request->account_name, $account, 2);

        if ($account->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Group Account With Unique Id: ' . $account->coa_code . ' And Name: ' . $account->coa_head_name);


            if (!$account->save()) {
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

    public function simple_form_second_level_chart_of_account($request)
    {
        $user = Auth::user();
        $already_exist = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_head_name', '=', $request->account_name)->where('coa_parent', '=', $request->head_code)->first();
        if ($already_exist != null) {
            return response()->json(['already_exist' => 'Account Already exist'], 200);
        }

        $this->second_level_chart_of_account_validation($request);

        $account = new AccountHeadsModel();

        $account = $this->AssignSecondLevelChartOfAccountValues($request->head_code, $request->account_name, $request->remarks, $account, 2);

        $account->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Group Account With Unique Id: ' . $account->coa_code . ' And Name: ' . $account->coa_head_name);

//        if ($request->head_code == config('global_variables.expense'))
//        {
//            WizardController::updateWizardInfo(['expense_group_account'], ['asset_registration']);
//        } else {
//            WizardController::updateWizardInfo(['group_account'], ['parent_account']);
//            WizardController::updateWizardInfo(['second_head'], ['capital_registration']);
//        }
        return response()->json(['message' => 'Successfully Saved!', 'name' => $request->account_name], 200);

//        return redirect('add_second_level_chart_of_account')->with('success', 'Successfully Saved');

    }

    public function excel_form_third_level_chart_of_account($request)
    {
        DB::beginTransaction();
        $rollBack = false;

        $account = new AccountHeadsModel();
        $user = Auth::User();
        $account = $this->ExcelAssignSecondLevelChartOfAccountValues($request->head_code, $request->account_name, $account, 3);

        if ($account->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Parent Account With Unique Id: ' . $account->coa_code . ' And Name: ' . $account->coa_head_name);

            if (!$account->save()) {
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

    public function simple_form_third_level_chart_of_account($request)
    {
        $user = Auth::user();
        $already_exist = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_head_name', '=', $request->account_name)->where('coa_parent', '=', $request->head_code)->first();
        if ($already_exist != null) {
            return response()->json(['already_exist' => 'Account Already exist'], 200);
        }

        $this->third_level_chart_of_account_validation($request);

        $account = new AccountHeadsModel();

        $account = $this->AssignSecondLevelChartOfAccountValues($request->head_code, $request->account_name, $request->remarks, $account, 3);

        $account->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Parent Account With Unique Id: ' . $account->coa_code . ' And Name: ' . $account->coa_head_name);

//        if ($request->head_code == config('global_variables.fixed_asset_second_head'))
//        {
//            WizardController::updateWizardInfo(['asset_parent_account'], []);
//        } elseif ($request->head_code == config('global_variables.salary_expense_second_head')) {
//            WizardController::updateWizardInfo(['parent_account_1'], ['salary_account']);
//        }
        return response()->json(['message' => 'Successfully Saved!', 'name' => $request->account_name], 200);

//        return redirect('add_third_level_chart_of_account')->with('success', 'Successfully Saved');

    }

    public function second_level_chart_of_account_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
//            'account_name' => ['required', 'string', 'unique:financials_coa_heads,coa_head_name'],
            'head_code' => ['required', 'numeric'],
            'account_name' => 'required | unique:financials_coa_heads,coa_head_name,NULL,coa_id,coa_parent,' . $request->head_code . ',coa_clg_id,' . $user->user_clg_id,
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function excel_second_level_chart_of_account_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
//            'account_name' => ['required', 'string', 'unique:financials_coa_heads,coa_head_name'],
            'head_code' => ['required', 'numeric'],
            'account_name' => 'required | unique:financials_coa_heads,coa_head_name,NULL,coa_id,coa_parent,' . $request->head_code . ',coa_clg_id,' . $user->user_clg_id,
        ]);
    }

    public function third_level_chart_of_account_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'first_head_code' => ['required', 'numeric'],
            'head_code' => ['required', 'numeric'],
            'account_name' => 'required | unique:financials_coa_heads,coa_head_name,NULL,coa_id,coa_parent,' . $request->head_code . ',coa_clg_id,' . $user->user_clg_id,
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function excel_third_level_chart_of_account_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'first_head_code' => ['required', 'numeric'],
            'head_code' => ['required', 'numeric'],
            'account_name' => 'required | unique:financials_coa_heads,coa_head_name,NULL,coa_id,coa_parent,' . $request->head_code . ',coa_clg_id,' . $user->user_clg_id,
        ]);
    }

    public function AssignSecondLevelChartOfAccountValues($parent_code, $account_name, $remarks, $account, $level)
    {
        $user = Auth::user();
        $account_registration_controller = new AccountRegisterationsController();

        if ($level == 2) {

            $check_uid = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $parent_code)->orderBy('coa_code', 'DESC')->pluck('coa_code')->first();

//            $account_code = $check_uid + 1;

            if ($check_uid) {
//                $account_code = $parent_code . '10';
                $account_code = $check_uid = $account_registration_controller->generate_account_code($parent_code, $check_uid);
            } else {
                $uid = 10;
                $account_code = $parent_code . $uid;
            }

        } elseif ($level == 3) {

            $check_uid = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $parent_code)->orderBy('coa_code', 'DESC')->pluck('coa_code')->first();

            if ($check_uid) {
//                $account_code = $parent_code . '10';
                $account_code = $check_uid = $account_registration_controller->generate_account_code($parent_code, $check_uid);
            } else {
                $uid = 10;
                $account_code = $parent_code . $uid;
            }
        }


        $account->coa_head_name = ucwords($account_name);
        $account->coa_remarks = ucfirst($remarks);
        $account->coa_code = $account_code;
        $account->coa_parent = $parent_code;
        $account->coa_level = $level;
        $account->coa_clg_id = $user->user_clg_id;
        $account->coa_datetime = Carbon::now()->toDateTimeString();


        // coding from shahzaib start
        $tbl_var_name = 'account';
        $prfx = 'coa';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $account;
    }

    protected function ExcelAssignSecondLevelChartOfAccountValues($parent_code, $account_name, $account, $level)
    {
        $user = Auth::user();
        $account_registration_controller = new AccountRegisterationsController();

        if ($level == 2) {

            $check_uid = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $parent_code)->orderBy('coa_code', 'DESC')->pluck('coa_code')->first();

//            $account_code = $check_uid + 1;

            if ($check_uid) {
//                $account_code = $parent_code . '10';
                $account_code = $check_uid = $account_registration_controller->generate_account_code($parent_code, $check_uid);
            } else {
                $uid = 10;
                $account_code = $parent_code . $uid;
            }

        } elseif ($level == 3) {

            $check_uid = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $parent_code)->orderBy('coa_code', 'DESC')->pluck('coa_code')->first();

            if ($check_uid) {
//                $account_code = $parent_code . '10';
                $account_code = $check_uid = $account_registration_controller->generate_account_code($parent_code, $check_uid);
            } else {
                $uid = 10;
                $account_code = $parent_code . $uid;
            }
        }


        $account->coa_head_name = ucwords($account_name);
        $account->coa_code = $account_code;
        $account->coa_parent = $parent_code;
        $account->coa_level = $level;
        $account->coa_clg_id = $user->user_clg_id;
        $account->coa_datetime = Carbon::now()->toDateTimeString();


        // coding from shahzaib start
        $tbl_var_name = 'account';
        $prfx = 'coa';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $account;
    }
}
