<?php

namespace App\Http\Controllers\ExcelForm\CreditCardMachineForm;

use App\Http\Controllers\AccountRegisterationsController;
use App\Http\Controllers\DayEndController;
use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\BalancesModel;
use App\Models\CreditCardMachineModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreditCardMachineController extends Controller
{
    public function excel_form_credit_card_machine($request)
    {
        DB::beginTransaction();


        $user = Auth::User();
        $rollBack = false;


        $request->request->add(['account_name' => $request->name]);


        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////// Bank Service Charges Account /////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $bank_service_charges_parent_code = config('global_variables.bank_service_charges');

        $account_registration_controller = new AccountRegisterationsController();

        $bank_service_charges_account = new AccountRegisterationModel();
        $bank_service_charges_account = $account_registration_controller->AssignAccountValues_excel($request, $bank_service_charges_account, $bank_service_charges_parent_code, 0, '', ' Service Charges');

        if (!$bank_service_charges_account->save()) {
            $rollBack = true;
        }

        $bank_service_charges_account_uid = $bank_service_charges_account->account_uid;
        $bank_service_charges_account_name = $bank_service_charges_account->account_name;

        $account_balance = new BalancesModel();

        $account_balance = $account_registration_controller->add_balance($account_balance, $bank_service_charges_account_uid, $bank_service_charges_account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $bank_service_charges_account_uid . ' And Name: ' . $bank_service_charges_account_name);

        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////// Credit Card Machine Account //////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $credit_card_machine_parent_code = config('global_variables.credit_card_accounts_head');

        $account_registration_controller = new AccountRegisterationsController();

        $credit_card_machine_account = new AccountRegisterationModel();
        $credit_card_machine_account = $account_registration_controller->AssignAccountValues_excel($request, $credit_card_machine_account, $credit_card_machine_parent_code, 0, '', ' Credit Card Machine');

        if (!$credit_card_machine_account->save()) {
            $rollBack = true;
        }

        $credit_card_machine_account_uid = $credit_card_machine_account->account_uid;
        $credit_card_machine_account_name = $credit_card_machine_account->account_name;

        $account_balance = new BalancesModel();

        $account_balance = $account_registration_controller->add_balance($account_balance, $credit_card_machine_account_uid, $credit_card_machine_account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $credit_card_machine_account_uid . ' And Name: ' . $credit_card_machine_account_name);

        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////// Creat Credit Card Machine ////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $credit_card_machine = new CreditCardMachineModel();

        $credit_card_machine = $this->ExcelAssignCreditCardMachineValues($request, $credit_card_machine, $credit_card_machine_account_uid, $bank_service_charges_account_uid);

        if ($credit_card_machine->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Credit Card Machine With Id: ' . $credit_card_machine->ccm_id . ' And Name: ' .
                $credit_card_machine->ccm_title);
        } else {
            $rollBack = true;
        }
        return $rollBack;
//        if ($rollBack) {
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        } else {
//            DB::commit();
//            return redirect()->back()->with('success', 'Successfully Saved');
//        }


//        DB::beginTransaction();
//        $rollBack = false;
//
//        $area = new AreaModel();
//        $user = Auth::User();
//        $area = $this->ExcelAssignAreaValues($request, $area);
//
//        if ($area->save()) {
//
//            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Area With Id: ' . $area->area_id . ' And Name: ' . $area->area_title);
//
//
//            if (!$area->save()) {
//                $rollBack = true;
//                DB::rollBack();
//                return true;
//            }
//
//        } else {
//            $rollBack = true;
//            DB::rollBack();
//            return true;
//        }

    }

    public function simple_form_credit_card_machine($request)
    {
        DB::beginTransaction();

        $this->credit_card_machine_validation($request);

        $user = Auth::User();
        $rollBack = false;


        $request->request->add(['account_name' => $request->name]);


        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////// Bank Service Charges Account /////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $bank_service_charges_parent_code = config('global_variables.bank_service_charges');

        $account_registration_controller = new AccountRegisterationsController();

        $bank_service_charges_account = new AccountRegisterationModel();
        $bank_service_charges_account = $account_registration_controller->AssignAccountValues($request, $bank_service_charges_account, $bank_service_charges_parent_code, 0, '', ' Service Charges');

        if (!$bank_service_charges_account->save()) {
            $rollBack = true;
        }

        $bank_service_charges_account_uid = $bank_service_charges_account->account_uid;
        $bank_service_charges_account_name = $bank_service_charges_account->account_name;

        $account_balance = new BalancesModel();

        $account_balance = $account_registration_controller->add_balance($account_balance, $bank_service_charges_account_uid, $bank_service_charges_account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $bank_service_charges_account_uid . ' And Name: ' . $bank_service_charges_account_name);

        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////// Credit Card Machine Account //////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $credit_card_machine_parent_code = config('global_variables.credit_card_accounts_head');

        $account_registration_controller = new AccountRegisterationsController();

        $credit_card_machine_account = new AccountRegisterationModel();
        $credit_card_machine_account = $account_registration_controller->AssignAccountValues($request, $credit_card_machine_account, $credit_card_machine_parent_code, 0, '', ' Credit Card Machine');

        if (!$credit_card_machine_account->save()) {
            $rollBack = true;
        }

        $credit_card_machine_account_uid = $credit_card_machine_account->account_uid;
        $credit_card_machine_account_name = $credit_card_machine_account->account_name;

        $account_balance = new BalancesModel();

        $account_balance = $account_registration_controller->add_balance($account_balance, $credit_card_machine_account_uid, $credit_card_machine_account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $credit_card_machine_account_uid . ' And Name: ' . $credit_card_machine_account_name);

        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////// Creat Credit Card Machine ////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $credit_card_machine = new CreditCardMachineModel();

        $credit_card_machine = $this->AssignCreditCardMachineValues($request, $credit_card_machine, $credit_card_machine_account_uid, $bank_service_charges_account_uid);

        if ($credit_card_machine->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Credit Card Machine With Id: ' . $credit_card_machine->ccm_id . ' And Name: ' .
                $credit_card_machine->ccm_title);
        } else {
            $rollBack = true;
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function credit_card_machine_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_credit_card_machine,ccm_title,null,null,ccm_clg_id,' . $user->user_clg_id],
            'bank' => ['required', 'numeric', 'unique:financials_credit_card_machine,ccm_bank_code,null,null,ccm_clg_id,' . $user->user_clg_id],
            'percentage' => ['required', 'numeric'],
            'merchant_id' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    public function excel_credit_card_machine_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_credit_card_machine,ccm_title,null,null,ccm_clg_id,' . $user->user_clg_id],
            'bank' => ['required', 'numeric', 'unique:financials_credit_card_machine,ccm_bank_code,null,null,ccm_clg_id,' . $user->user_clg_id],
            'percentage' => ['required', 'numeric'],
            'merchant_id' => ['required', 'string'],

        ]);

    }

    protected function AssignCreditCardMachineValues($request, $credit_card_machine, $credit_card_machine_account_uid, $bank_service_charges_account_uid, $edit = 0)
    {
        $user = Auth::User();

        $credit_card_machine->ccm_title = ucwords($request->name);
        $credit_card_machine->ccm_bank_code = $request->bank;

        if ($edit == 0) {
            $credit_card_machine->ccm_credit_card_account_code = $credit_card_machine_account_uid;
            $credit_card_machine->ccm_service_account_code = $bank_service_charges_account_uid;
        }

        $credit_card_machine->ccm_percentage = $request->percentage;
        $credit_card_machine->ccm_merchant_id = $request->merchant_id;
        $credit_card_machine->ccm_remarks = ucfirst($request->remarks);
        $credit_card_machine->ccm_created_by = $user->user_id;
        $credit_card_machine->ccm_clg_id = $user->user_clg_id;
        $credit_card_machine->ccm_datetime = Carbon::now()->toDateTimeString();


        // coding from shahzaib start
        $tbl_var_name = 'credit_card_machine';
        $prfx = 'ccm';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $credit_card_machine;
    }

    protected function ExcelAssignCreditCardMachineValues($request, $credit_card_machine, $credit_card_machine_account_uid, $bank_service_charges_account_uid, $edit = 0)
    {
        $user = Auth::User();

        $credit_card_machine->ccm_title = ucwords($request->name);
        $credit_card_machine->ccm_bank_code = $request->bank;

        if ($edit == 0) {
            $credit_card_machine->ccm_credit_card_account_code = $credit_card_machine_account_uid;
            $credit_card_machine->ccm_service_account_code = $bank_service_charges_account_uid;
        }

        $credit_card_machine->ccm_percentage = $request->percentage;
        $credit_card_machine->ccm_merchant_id = $request->merchant_id;
        $credit_card_machine->ccm_created_by = $user->user_id;
        $credit_card_machine->ccm_clg_id = $user->user_clg_id;
        $credit_card_machine->ccm_datetime = Carbon::now()->toDateTimeString();


        // coding from shahzaib start
        $tbl_var_name = 'credit_card_machine';
        $prfx = 'ccm';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $credit_card_machine;
    }
}
