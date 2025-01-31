<?php

namespace App\Http\Controllers\ExcelForm\AccountRegistrationForm;

use App\Http\Controllers\DayEndController;
use App\Http\Controllers\SaveImageController;
use App\Mail\PasswordMail;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\DayEndModel;
use App\Models\FixedAssetModel;
use App\Models\TownModel;
use App\Models\Utility;
use App\User;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AccountRegistrationsController extends Controller
{
    public function excel_form_receivables_payable($request, $head_code)
    {

        DB::beginTransaction();

        return $this->submit_account_payable_receiveable_excel($request, $head_code, 1);

//        if ($rollBack) {
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//            // return redirect()->back()->with('fail', 'Failed Try Again')->withInput($request->all());
//        } else {
//            DB::commit();
////            if ($parent_code == config('global_variables.receivable')) {
////                WizardController::updateWizardInfo(['client_registration'], []);
////            } else {
////                WizardController::updateWizardInfo(['supplier_registration'], []);
////            }
//            return redirect()->back()->with('success', 'Successfully Saved');
//        }


//        DB::beginTransaction();
//        $rollBack = false;
//
//        $town = new TownModel();
//
//        $town = $this->ExcelAssignTownValues($request, $town);
//        $user = Auth::User();
//
//        if ($town->save()) {
//
//            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Town With Id: ' . $town->town_id . ' And Name: ' . $town->town_title);
//
//            if (!$town->save()) {
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

    public function simple_form_receivables_payable($request)
    {
        $parent_code = $request->head_code;

        if ($parent_code == config('global_variables.receivable')) {
//            $area_already_exist = AccountRegisterationModel::where('account_name', '=', $request->town_name)->where('account_parent_code', '=', $parent_code)->first();
//            if ($area_already_exist != null) {
//                return response()->json(['already_exist' => 'Account Name Already exist'], 200);
//            }
            $this->receivables_payable_account_validation($request, config('global_variables.receivable'));
        } else {
            $this->receivables_payable_account_validation($request, config('global_variables.payable'));
        }
        if (isset($request->make_credentials)) {
            $this->employee_credentials_validation($request);
        }
//        $account_name=$request->account_name;
        DB::beginTransaction();
        $client_supplier = new User();

        $password = Utility::uniqidReal();

        if (isset($request->make_credentials)) {
            $client_supplier = $this->AssignEmployeeValues($request, $client_supplier, $password);
            if ($client_supplier->save()) {
                $employee_id = $client_supplier->user_id;
                $employee_name = $client_supplier->user_name;

                $client_supplier->user_employee_code = $this->generate_employee_code($employee_id, $employee_name);
                if (!$client_supplier->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }
        }

        $rollBack = $this->submit_account($request, 1, $client_supplier->user_id);

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
            // return redirect()->back()->with('fail', 'Failed Try Again')->withInput($request->all());
        } else {
            DB::commit();
            if (isset($request->make_credentials)) {
                $this->SendPasswordMail($request->email, $request->username, $password);
//                Mail::to($request->email)->send(new PasswordMail($password, $request->username));
            }
//            if ($parent_code == config('global_variables.receivable')) {
//                WizardController::updateWizardInfo(['client_registration'], []);
//            } else {
//                WizardController::updateWizardInfo(['supplier_registration'], []);
//            }
//            return response()->json(['message' => 'Successfully Saved!', 'name' => $account_name], 200);
            return redirect()->back()->with('success', 'Successfully Saved');
        }

    }

    public function employee_credentials_validation($request)
    {
        return $this->validate($request, [
//            'modular_group' => ['required', 'numeric'],
            'username' => ['required', 'string', 'unique:financials_users,user_username,NULL,user_id,user_have_credentials,1'],
            'email' => ['required', 'string', 'unique:financials_users,user_email,NULL,user_id,user_have_credentials,1'],

        ]);
    }

    protected function AssignEmployeeValues($request, $client_supplier, $password)
    {
        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

//        $employee->user_level = $request->user_type;
        $client_supplier->user_name = ucwords($request->account_name);
        $client_supplier->user_mobile = $request->mobile;


        $client_supplier->user_createdby = $user->user_id;
        $client_supplier->user_clg_id = $user->user_clg_id;
        $client_supplier->user_datetime = \Illuminate\Support\Carbon::now()->toDateTimeString();

        $client_supplier->user_day_end_id = $day_end->de_id;
        $client_supplier->user_day_end_date = $day_end->de_datetime;
        $client_supplier->user_brwsr_info = $brwsr_rslt;
        $client_supplier->user_ip_adrs = $ip_rslt;
        $client_supplier->user_update_datetime = Carbon::now()->toDateTimeString();

        if (isset($request->make_credentials)) {
            $client_supplier->user_have_credentials = 1;
//            $client_supplier->user_modular_group_id = $request->modular_group;
            $client_supplier->user_username = $request->username;
            $client_supplier->user_password = Hash::make($password);
            $client_supplier->user_email = $request->email;
            $client_supplier->user_login_status = 'ENABLE';
            $client_supplier->user_status = 'Non Employee';
//            if($request->head_code==21010){
//                $client_supplier->user_status = 'Supplier';
//            }else{
//                $client_supplier->user_status = 'Client';
//            }

        }

        return $client_supplier;
    }

    public function excel_form_other_account($request)
    {
        DB::beginTransaction();

        $rollBack = $this->submit_account_excel($request, 0);
        return $rollBack;
//        if ($rollBack) {
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        } else {
//            DB::commit();
////            if ($request->head_code == config('global_variables.bank_head')) {
////                WizardController::updateWizardInfo(['bank_account'/*, 'entry_account'*/], ['credit_card_machine']);
////            } else if ($request->first_head_code == config('global_variables.expense')) { // entry condition // first_head_code:4 expense
////                WizardController::updateWizardInfo(['expense_account'], []);
////            } else {
////                WizardController::updateWizardInfo(['entry_account', 'bank_account'], []);
////            }
//            return redirect()->back()->with('success', 'Successfully Saved');
//        }

    }

    public function simple_form_other_account($request)
    {
        $user = Auth::user();
        $already_exist = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_name', '=', $request->account_name)->where('account_parent_code', '=',
            $request->head_code)->first();
        if ($already_exist != null) {
            return response()->json(['already_exist' => 'Account Already exist'], 200);
        }

        $this->account_validation($request);

        DB::beginTransaction();

        $rollBack = $this->submit_account($request, 0);

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            DB::commit();
//            if ($request->head_code == config('global_variables.bank_head')) {
//                WizardController::updateWizardInfo(['bank_account'/*, 'entry_account'*/], ['credit_card_machine']);
//            } else if ($request->first_head_code == config('global_variables.expense')) { // entry condition // first_head_code:4 expense
//                WizardController::updateWizardInfo(['expense_account'], []);
//            } else {
//                WizardController::updateWizardInfo(['entry_account', 'bank_account'], []);
//            }
            return response()->json(['message' => 'Successfully Saved!', 'name' => $request->account_name], 200);
//            return redirect()->back()->with('success', 'Successfully Saved');
        }

    }

    public function excel_form_salary_account_registration($request)
    {
        //  DB::beginTransaction();
        $user = Auth::User();
        $check_account_name = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_name', 'Exp - ' . $request->account_name)->exists();

        if ($check_account_name) {
            return redirect()->back()->with('fail', 'Name Already Exist!');
        }

        DB::beginTransaction();


        $rollBack = false;

        $parent_code = $request->head_code;

        $account = new AccountRegisterationModel();
        $account = $this->AssignAccountValues_excel($request, $account, $parent_code, 0, 'Exp - ');

        if (!$account->save()) {
            $rollBack = true;
        }

        $account_uid = $account->account_uid;
        $account_name = $account->account_name;

        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $account_uid, $account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////// Second Account ///////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $advance_salary_account = new AccountRegisterationModel();

        $advance_salary_account = $this->AssignAccountValues_excel($request, $advance_salary_account, config('global_variables.advance_salary_head'), 0, 'Adv - ');

        if (!$advance_salary_account->save()) {
            $rollBack = true;
        }

        $account->account_link_uid = $advance_salary_account->account_uid;

        if (!$account->save()) {
            $rollBack = true;
        }

        $advance_salary_account->account_link_uid = $account->account_uid;

        if (!$advance_salary_account->save()) {
            $rollBack = true;
        }


        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $advance_salary_account->account_uid, $advance_salary_account->account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $advance_salary_account->account_uid . ' And Name: '
            . $advance_salary_account->account_name);

        return $rollBack;

    }

    public function simple_form_salary_account_registration($request)
    {
        $this->account_validation($request);
        $user = Auth::User();
        $check_account_name = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_name', 'Exp - ' . $request->account_name)->exists();

        if ($check_account_name) {
            return redirect()->back()->with('fail', 'Name Already Exist!');
        }

        DB::beginTransaction();


        $rollBack = false;

        $parent_code = $request->head_code;

        $account = new AccountRegisterationModel();
        $account = $this->AssignAccountValues($request, $account, $parent_code, 0, 'Exp - ');

        if (!$account->save()) {
            $rollBack = true;
        }

        $account_uid = $account->account_uid;
        $account_name = $account->account_name;

        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $account_uid, $account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////// Second Account ///////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $advance_salary_account = new AccountRegisterationModel();

        $advance_salary_account = $this->AssignAccountValues($request, $advance_salary_account, config('global_variables.advance_salary_head'), 0, 'Adv - ');

        if (!$advance_salary_account->save()) {
            $rollBack = true;
        }

        $account->account_link_uid = $advance_salary_account->account_uid;

        if (!$account->save()) {
            $rollBack = true;
        }

        $advance_salary_account->account_link_uid = $account->account_uid;

        if (!$advance_salary_account->save()) {
            $rollBack = true;
        }


        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $advance_salary_account->account_uid, $advance_salary_account->account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $advance_salary_account->account_uid . ' And Name: '
            . $advance_salary_account->account_name);


        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            DB::commit();

            // WizardController::updateWizardInfo(['salary_account'], ['employee']);

            return redirect()->back()->with('success', 'Successfully Saved');
        }

    }

    public function receivables_payable_account_validation($request, $parent_code)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'region' => ['required', 'numeric'],
            'area' => ['required', 'numeric'],
            'sector' => ['required', 'numeric'],
            'group' => ['required', 'numeric'],
            'account_name' => 'required | unique:financials_accounts,account_name,NULL,account_id,account_parent_code,' . $parent_code . ',account_clg_id,' . $user->user_clg_id,
            'remarks' => ['nullable', 'string'],
            'print_name' => ['nullable', 'string'],
            'cnic' => ['nullable', 'regex:/^\d{5}-\d{7}-\d$|^\d{13}$/'],
            'opening_balance' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
            'proprietor' => ['nullable', 'string'],
            'co_code' => ['nullable', 'string'],
            'mobile' => ['nullable', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'whatsapp' => ['nullable', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'phone' => ['nullable', 'regex:/^\d{3}-?\d{3}-?\d{4}$|^\d{3} ?\d{3} ?\d{4}$/'],
            'email' => ['nullable', 'email'],
            'gst' => ['nullable', 'regex:/^([0-9]{1}[0-9]{1})-?([0-9]{1}[0-9]{1})-?([0-9]{4}-?[0-9]{3}-?[0-9]{2})+$|^([0-9]{1}[0-9]{1}) ?([0-9]{1}[0-9]{1}) ?([0-9]{4} ?[0-9]{3} ?[0-9]{2})+$/'],
            'ntn' => ['nullable', 'regex:/^\d{7}-?\d$/'],
            'credit_limit' => ['nullable', 'numeric', 'min:0'],
            'unlimited' => ['nullable', 'numeric'],
            'page_no' => ['nullable', 'string'],
            'sale_person' => ['nullable', 'numeric'],
            'discountType' => ['required'],
        ]);
    }

    public function receivables_payable_account_validation_excel($request, $parent_code)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'region' => ['required', 'numeric'],
            'area' => ['required', 'numeric'],
            'sector' => ['required', 'numeric'],
            'group' => ['required', 'numeric'],
            'account_name' => 'required | unique:financials_accounts,account_name,NULL,account_id,account_parent_code,' . $parent_code . ',account_clg_id,' . $user->user_clg_id,
            'credit_limit' => ['nullable', 'numeric', 'min:0'],

        ]);
    }


    public function submit_account($request, $account_type, $client_supplier = '')
    {
        $branch_no=Session::get('branch_no');

        $parent_code = $request->head_code;

        $user = Auth::User();
        $rollBack = false;

        $prefix = '';

        $account = new AccountRegisterationModel();
        $account = $this->AssignAccountValues($request, $account, $parent_code, $account_type, $prefix, $client_supplier);

        if (!$account->save()) {
            $rollBack = true;
        }

        $account_uid = $account->account_uid;
        $account_name = $account->account_name. ' - '.$branch_no;

        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $account_uid, $account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);

        return $rollBack;


    }

    public function submit_account_payable_receiveable_excel($request, $head_code, $account_type)
    {

        $parent_code = $head_code;

        $user = Auth::User();
        $rollBack = false;

        $prefix = '';

        $account = new AccountRegisterationModel();
        $account = $this->AssignAccountValues_excel($request, $account, $parent_code, $account_type, $prefix);

        if (!$account->save()) {
            $rollBack = true;
        }

        $account_uid = $account->account_uid;
        $account_name = $account->account_name;

        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $account_uid, $account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);

        return $rollBack;


    }

    public function submit_account_excel($request, $account_type)
    {

        $parent_code = $request->head_code;

        $user = Auth::User();
        $rollBack = false;

        $prefix = '';

        $account = new AccountRegisterationModel();
        $account = $this->AssignAccountValues_excel($request, $account, $parent_code, $account_type, $prefix);

        if (!$account->save()) {
            $rollBack = true;
        }

        $account_uid = $account->account_uid;
        $account_name = $account->account_name;

        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $account_uid, $account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);

        return $rollBack;

    }

    public function account_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'head_code' => ['required', 'numeric'],
            'group' => ['required', 'numeric'],
            'account_name' => 'required | unique:financials_accounts,account_name,NULL,account_id,account_parent_code,' . $request->head_code . ',account_clg_id,' . $user->user_clg_id,
            'opening_balance' => ['nullable', 'numeric'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function account_validation_excel($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'head_code' => ['required', 'numeric'],
            'group' => ['required', 'numeric'],
            'account_name' => 'required | unique:financials_accounts,account_name,NULL,account_id,account_parent_code,' . $request->head_code . ',account_clg_id,' . $user->user_clg_id,
            'opening_balance' => ['nullable', 'numeric'],
        ]);
    }

// make by mustafa start
    public function AssignFixedAccountValues($request, $account, $parent_code, $balance, $account_type, $prefix, $postfix = '')
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $check_uid = AccountRegisterationModel::where('account_parent_code', $parent_code)->orderBy('account_uid', 'DESC')->pluck('account_uid')->first();

        if ($check_uid) {

            $check_uid = $this->generate_account_code($parent_code, $check_uid);

            $uid = $check_uid;
        } else {
            $check_uid = $check_uid + 1;
            $uid = $parent_code . $check_uid;
        }

        $account->account_group_id = !empty($request->group) ? $request->group : 1;
        $account->account_parent_code = $parent_code;
        $account->account_uid = $uid;
        $account->account_name = $prefix . ucwords($request->account_name) . $postfix;
        $account->account_urdu_name = $prefix . ucwords($request->account_urdu_name) . $postfix;
        $account->account_remarks = ucfirst($request->remarks);
        $account->account_balance = $balance;

        if ($account_type == 1) {
            $account->account_region_id = $request->region;
            $account->account_area = $request->area;
            $account->account_sector_id = $request->sector;
            $account->account_town_id = $request->town;
            $account->account_sale_person = $request->sale_person;
            $account->account_print_name = ucwords($request->print_name);
            $account->account_cnic = $request->cnic;
            $account->account_type = $account_type;
            $account->account_address = ucfirst($request->address);
            $account->account_proprietor = $request->proprietor;
            $account->account_company_code = $request->co_code;
            $account->account_mobile_no = $request->mobile;
            $account->account_whatsapp = $request->whatsapp;
            $account->account_phone = $request->phone;
            $account->account_email = $request->email;
            $account->account_gst = $request->gst;
            $account->account_ntn = $request->ntn;
            $account->account_discount_type = $request->discountType;

            if (isset($request->unlimited)) {
                $account->account_credit_limit_status = 1;
                $account->account_credit_limit = 0;
            } else {
                $account->account_credit_limit = isset($request->credit_limit) ? $request->credit_limit : 0;
            }

            $account->account_page_no = $request->page_no;
        }

        $account->account_createdby = $user->user_id;
        $account->account_clg_id = $user->user_clg_id;
        $account->account_day_end_id = $day_end->de_id;
        $account->account_day_end_date = $day_end->de_datetime;
        $account->account_brwsr_info = $brwsr_rslt;
        $account->account_ip_adrs = $ip_rslt;
        $account->account_update_datetime = Carbon::now()->toDateTimeString();

        return $account;
    }

    public function AssignFixAccountBalancesValues($account_balance, $account_uid, $account_name, $balance, $transection_type, $type, $remarks)
    {

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $debit_amount = 0;
        $credit_amount = 0;

        $previous_balance = $this->calculate_account_balance($account_uid);


        if ($type == 'Dr') {
            $total_balance = $previous_balance + $balance;
            $debit_amount = $balance;

        } else {
            $total_balance = $previous_balance - $balance;
            $credit_amount = $balance;
        }


        $account_balance->bal_account_id = $account_uid;
        $account_balance->bal_dr = $debit_amount;
        $account_balance->bal_cr = $credit_amount;
        $account_balance->bal_total = $total_balance;
        $account_balance->bal_transaction_type = $transection_type;
        $account_balance->bal_transaction_id = 0;
        $account_balance->bal_remarks = $remarks;
        $account_balance->bal_detail_remarks = $transection_type;
        $account_balance->bal_day_end_id = $day_end->de_id;
        $account_balance->bal_day_end_date = $day_end->de_datetime;
        $account_balance->bal_user_id = $user->user_id;
        $account_balance->bal_clg_id = $user->user_clg_id;

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Opening Balance of Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);

        return $account_balance;
    }

// make by mustafa end
    public
    function AssignAccountValues($request, $account, $parent_code, $account_type, $prefix, $client_supplier = '', $postfix = '')
    {
        $branch_id = Session::get('branch_id');
        $branch_no=Session::get('branch_no');
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $check_uid = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_parent_code', $parent_code)->orderBy('account_uid', 'DESC')->pluck('account_uid')->first();

        if ($check_uid) {

            $check_uid = $this->generate_account_code($parent_code, $check_uid);
            $uid = $check_uid;
        } else {
            $check_uid = $check_uid + 1;
            $uid = $parent_code . $check_uid;
        }

        $account->account_group_id = !empty($request->group) ? $request->group : 1;
        $account->account_parent_code = $parent_code;
        $account->account_uid = $uid;
        $account->account_name = $prefix . ucwords($request->account_name) . $postfix.' - '.$branch_no;
        $account->account_urdu_name = $prefix . ucwords($request->account_urdu_name) . $postfix.' - '.$branch_no;
        $account->account_remarks = ucfirst($request->remarks);
        $account->account_balance = 0;

        if ($account_type == 1) {
            $account->account_region_id = $request->region;
            $account->account_area = $request->area;
            $account->account_sector_id = $request->sector;
            $account->account_town_id = $request->town;
            $account->account_sale_person = $request->head_code == 21010 ? $request->purchaser : $request->sale_person;
            $account->account_print_name = ucwords($request->print_name);
            $account->account_cnic = $request->cnic;
            $account->account_type = $account_type;
            $account->account_address = ucfirst($request->address);
            $account->account_proprietor = $request->proprietor;
            $account->account_company_code = $request->co_code;
            $account->account_mobile_no = $request->mobile;
            $account->account_whatsapp = $request->whatsapp;
            $account->account_phone = $request->phone;
            $account->account_email = $request->email;
            $account->account_gst = $request->gst;
            $account->account_ntn = $request->ntn;
            $account->account_discount_type = $request->discountType;
            $account->account_employee_id = $client_supplier;

            if (isset($request->unlimited)) {
                $account->account_credit_limit_status = 1;
                $account->account_credit_limit = 0;
            } else {
                $account->account_credit_limit = isset($request->credit_limit) ? $request->credit_limit : 0;
            }

            $account->account_page_no = $request->page_no;
        }

        $account->account_createdby = $user->user_id;
        $account->account_clg_id = $user->user_clg_id;
        $account->account_branch_id = $branch_id;
        $account->account_day_end_id = $day_end->de_id;
        $account->account_day_end_date = $day_end->de_datetime;
        $account->account_brwsr_info = $brwsr_rslt;
        $account->account_ip_adrs = $ip_rslt;
        $account->account_year_id = $this->getYearEndId();
        $account->account_update_datetime = Carbon::now()->toDateTimeString();

        return $account;
    }

    public
    function AssignAccountValues_excel($request, $account, $parent_code, $account_type, $prefix, $postfix = '')
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $check_uid = AccountRegisterationModel::where('account_parent_code', $parent_code)->orderBy('account_uid', 'DESC')->pluck('account_uid')->first();

        if ($check_uid) {

            $check_uid = $this->generate_account_code($parent_code, $check_uid);

            $uid = $check_uid;
        } else {
            $check_uid = $check_uid + 1;
            $uid = $parent_code . $check_uid;
        }

        $account->account_group_id = !empty($request->group) ? $request->group : 1;
        $account->account_parent_code = $parent_code;
        $account->account_uid = $uid;
        $account->account_name = $prefix . ucwords($request->account_name) . $postfix;

        $account->account_balance = 0;

        if ($account_type == 1) {
            $account->account_region_id = $request->region;
            $account->account_area = $request->area;
            $account->account_sector_id = $request->sector;
            $account->account_town_id = $request->town;
            $account->account_type = $account_type;
            $account->account_discount_type = 1;
            if (isset($request->unlimited)) {
                $account->account_credit_limit_status = 1;
                $account->account_credit_limit = 0;
            } else {
                $account->account_credit_limit = isset($request->credit_limit) ? $request->credit_limit : 0;
            }

        }

        $account->account_createdby = $user->user_id;
        $account->account_clg_id = $user->user_clg_id;
        $account->account_day_end_id = $day_end->de_id;
        $account->account_day_end_date = $day_end->de_datetime;
        $account->account_brwsr_info = $brwsr_rslt;
        $account->account_ip_adrs = $ip_rslt;
        $account->account_update_datetime = Carbon::now()->toDateTimeString();
        $account->account_year_id = $this->getYearEndId();

        return $account;
    }

    public
    function add_balance($account_balance, $account_uid, $account_name)
    {
        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $account_balance->bal_account_id = $account_uid;
        $account_balance->bal_dr = 0;
        $account_balance->bal_cr = 0;
        $account_balance->bal_total = 0;
        $account_balance->bal_transaction_type = 'OPENING_BALANCE';
        $account_balance->bal_transaction_id = 0;
        $account_balance->bal_remarks = '';
        $account_balance->bal_detail_remarks = 'OPENING_BALANCE';
        $account_balance->bal_day_end_id = $day_end->de_id;
        $account_balance->bal_day_end_date = $day_end->de_datetime;
        $account_balance->bal_user_id = $user->user_id;
        $account_balance->bal_clg_id = $user->user_clg_id;
        $account_balance->bal_branch_id = Session::get('branch_id');
        $account_balance->bal_year_id = $this->getYearEndId();
        $account_balance->bal_v_year_id = $this->getYearEndId();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Opening Balance of Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);

        return $account_balance;
    }

    public
    function generate_account_code($parent_head, $pre_account_id)
    {
        $id = str_replace_first(trim($parent_head, ""), "", $pre_account_id);

        $id = $id + 1;

        $newId = $parent_head . $id;

        return $newId;
    }

    public
    function excel_form_fixed_asset($request)
    {
//        if ($request->account_type == 1) {
//            $this->validate($request, [
//                'expense_group_account' => ['required', 'numeric'],
//                'expense_parent_account' => ['required', 'numeric'],
//            ]);
//        }

        $user = Auth::User();
        $rollBack = false;

        DB::beginTransaction();

        /////////////////////////////////////////////////// 1st Account //////////////////////////////////////////////////////

        $parent_code = $request->head_code;

        $account = new AccountRegisterationModel();
        $account = $this->AssignAccountValues_excel($request, $account, $parent_code, 0, '');

        if (!$account->save()) {
            $rollBack = true;
        }

        $account_uid = $account->account_uid;
        $account_name = $account->account_name;

        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $account_uid, $account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


        if ($request->account_type == 2) {

            $pre_account_name = 'Amo. ';
            $account_type_parent_code = config('global_variables.amortization');
        } else {
            $pre_account_name = 'Dep. ';

            if (isset($request->expense_parent_account) && !empty($request->expense_parent_account)) {
                $account_type_parent_code = $request->expense_parent_account;
            } else {

                $account_type_parent_code = config('global_variables.depreciation');
            }

        }

        /////////////////////////////////////////////////// 2nd Account //////////////////////////////////////////////////////

        $accumulated_account = new AccountRegisterationModel();

        $accumulated_account = $this->AssignAccountValues_excel($request, $accumulated_account, $parent_code, 0, 'Acc. ' . $pre_account_name);

        if (!$accumulated_account->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $accumulated_account->account_uid . ' And Name: '
            . $accumulated_account->account_name);


        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $accumulated_account->account_uid, $accumulated_account->account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        /////////////////////////////////////////////////// 3rd Account //////////////////////////////////////////////////////


        $expense_or_revenue_account = new AccountRegisterationModel();

        $expense_or_revenue_account = $this->AssignAccountValues_excel($request, $expense_or_revenue_account, $account_type_parent_code, 0, $pre_account_name);

        if (!$expense_or_revenue_account->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $expense_or_revenue_account->account_uid . ' And Name: '
            . $expense_or_revenue_account->account_name);

        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $expense_or_revenue_account->account_uid, $expense_or_revenue_account->account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->parent_account_uid = $account->account_uid;
        $this->link_account_uids .= $account->account_uid . ',' . $accumulated_account->account_uid . ',' . $expense_or_revenue_account->account_uid;


        $fixed_asset = new FixedAssetModel();

        $fixed_asset = $this->AssignFixedAssetValues_excel($request, $fixed_asset);

        if (!$fixed_asset->save()) {
            $rollBack = true;
            DB::rollBack();
        }
        return $rollBack;
//        if ($rollBack) {
//            DB::rollBack();
//            return true;
//        } else {
//            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Fixed Asset With Unique Id: ' . $fixed_asset->fa_id . ' And Name: '
//                . $fixed_asset->fa_account_name);
//
//            DB::commit();
//            // WizardController::updateWizardInfo(['asset_registration'], []);
//            return redirect()->back()->with('success', 'Successfully Saved');
//        }

    }

    public
    function simple_form_fixed_asset($request)
    {
        $user = Auth::User();
        $count = DayEndModel::where('de_clg_id',$user->user_clg_id)->count();
        $this->fixed_asset_validation($request);

        if ($request->account_type == 1) {
            $this->validate($request, [
                'expense_group_account' => ['required', 'numeric'],
                'expense_parent_account' => ['required', 'numeric'],
            ]);
        }


        $rollBack = false;

        DB::beginTransaction();

        /////////////////////////////////////////////////// 1st Account //////////////////////////////////////////////////////

        $parent_code = $request->head_code;
//        $balance = $request->asset_purchase_price - $request->residual_value;
        $account = new AccountRegisterationModel();
//        $account = $this->AssignFixedAccountValues($request, $account, $parent_code, $balance, 0, '');
        $account = $this->AssignAccountValues($request, $account, $parent_code, 0, '');

        if (!$account->save()) {
            $rollBack = true;
        }

        $account_uid = $account->account_uid;
        $account_name = $account->account_name;

        $account_balance = new BalancesModel();

////        make by mustafa
//        $account_balance = $this->AssignFixAccountBalancesValues($account_balance, $account_uid, $account_name, $balance, 'OPENING_BALANCE', 'Dr', $request->remarks);
////       code  end
        $account_balance = $this->add_balance($account_balance, $account_uid, $account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


        if ($request->account_type == 2) {

            $pre_account_name = 'Amo. ';
            $account_type_parent_code = config('global_variables.amortization');
        } else {
            $pre_account_name = 'Dep. ';

            if (isset($request->expense_parent_account) && !empty($request->expense_parent_account)) {
                $account_type_parent_code = $request->expense_parent_account;
            } else {

                $account_type_parent_code = config('global_variables.depreciation');
            }

        }

        /////////////////////////////////////////////////// 2nd Account //////////////////////////////////////////////////////

        $accumulated_account = new AccountRegisterationModel();

        $accumulated_account = $this->AssignAccountValues($request, $accumulated_account, $parent_code, 0, 'Acc. ' . $pre_account_name);

        if (!$accumulated_account->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $accumulated_account->account_uid . ' And Name: '
            . $accumulated_account->account_name);


        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $accumulated_account->account_uid, $accumulated_account->account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        /////////////////////////////////////////////////// 3rd Account //////////////////////////////////////////////////////


        $expense_or_revenue_account = new AccountRegisterationModel();

        $expense_or_revenue_account = $this->AssignAccountValues($request, $expense_or_revenue_account, $account_type_parent_code, 0, $pre_account_name);

        if (!$expense_or_revenue_account->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $expense_or_revenue_account->account_uid . ' And Name: '
            . $expense_or_revenue_account->account_name);

        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $expense_or_revenue_account->account_uid, $expense_or_revenue_account->account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->parent_account_uid = $account->account_uid;
        $this->link_account_uids .= $account->account_uid . ',' . $accumulated_account->account_uid . ',' . $expense_or_revenue_account->account_uid;

        /////////////////////////////////////////////////// 4th Account entry  //////////////////////////////////////////////////////

//        if ($count > 0) {
//            $account_name = AccountRegisterationModel::where('account_uid', '=', $request->account)->pluck('account_name')->first();
////        make by mustafa
//            $account_balance = $this->AssignFixAccountBalancesValues($account_balance, $request->account, $account_name, $balance, 'FAV', 'Cr', $request->remarks);
////       code  end
////        $account_balance = $this->add_balance($account_balance, $account_uid, $account_name);
//
//            if (!$account_balance->save()) {
//                $rollBack = true;
//            }
//        }


        $fixed_asset = new FixedAssetModel();

        $fixed_asset = $this->AssignFixedAssetValues($request, $fixed_asset);

        if (!$fixed_asset->save()) {
            $rollBack = true;
            DB::rollBack();
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Fixed Asset With Unique Id: ' . $fixed_asset->fa_id . ' And Name: '
                . $fixed_asset->fa_account_name);

            DB::commit();
            // WizardController::updateWizardInfo(['asset_registration'], []);
            return redirect()->back()->with('success', 'Successfully Saved');
        }

    }

    public
    function fixed_asset_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'head_code' => ['required', 'numeric'],
            'group' => ['required', 'numeric'],
            'account_name' => 'required | unique:financials_accounts,account_name,NULL,account_id,account_parent_code,' . $request->head_code . ',account_clg_id,' . $user->user_clg_id,
            'asset_registration_no' => ['nullable', 'string'],
            'importer_supplier_detail' => ['nullable', 'string'],
            'asset_guarantee_period' => ['nullable', 'string'],
            'asset_specification' => ['nullable', 'string'],
            'asset_capacity' => ['nullable', 'string'],
            'asset_size' => ['nullable', 'string'],
            'method' => ['required', 'numeric'],
            'account_type' => ['required', 'numeric'],
            'asset_purchase_price' => ['required', 'numeric'],
            'residual_value' => ['required', 'string'],
            'useful_life' => ['required', 'string'],
            'depreciation_percentage_radio' => ['required', 'numeric'],
            'depreciation_percentage' => ['required', 'numeric'],
            'posting_method' => ['required', 'string'],
            'acquisition_date' => ['required', 'date'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public
    function fixed_asset_validation_excel($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'head_code' => ['required', 'numeric'],
            'group' => ['required', 'numeric'],
            'account_name' => 'required | unique:financials_accounts,account_name,NULL,account_id,account_parent_code,' . $request->head_code . ',account_clg_id,' . $user->user_clg_id,
            'opening_balance' => ['nullable', 'numeric'],
        ]);
    }

    protected
    function AssignFixedAssetValues($request, $fixed_asset)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $fixed_asset->fa_parent_account_uid = $request->head_code;
        $fixed_asset->fa_group_id = $request->group;
        $fixed_asset->fa_link_account_uids = $this->link_account_uids;
        $fixed_asset->fa_account_name = ucwords($request->account_name);
        $fixed_asset->fa_register_number = $request->asset_registration_no;
        $fixed_asset->fa_supplier_details = $request->importer_supplier_detail;
        $fixed_asset->fa_guarantee_period = $request->asset_guarantee_period;
        $fixed_asset->fa_specification = $request->asset_specification;
        $fixed_asset->fa_capacity = $request->asset_capacity;
        $fixed_asset->fa_size = $request->asset_size;
        $fixed_asset->fa_method = $request->method;
        $fixed_asset->fa_dep_amo = $request->account_type;
        $fixed_asset->fa_price = $request->asset_purchase_price;
        $fixed_asset->fa_book_value = $request->asset_purchase_price;
        $fixed_asset->fa_residual_value = $request->residual_value;
        $fixed_asset->fa_useful_life_year = $request->useful_life;
        $fixed_asset->fa_useful_life_month = $request->useful_life * 12;
        $fixed_asset->fa_useful_life_day = $request->useful_life * 365;
        $fixed_asset->fa_dep_period = $request->depreciation_percentage_radio;
        $fixed_asset->fa_dep_percentage_year = $request->depreciation_percentage;
        $fixed_asset->fa_dep_percentage_month = $request->depreciation_percentage / 12;
        $fixed_asset->fa_dep_percentage_day = $request->depreciation_percentage / 365;
        $fixed_asset->fa_posting = $request->posting_method;
        $fixed_asset->fa_acquisition_date = date('Y-m-d', strtotime($request->acquisition_date));
        $fixed_asset->fa_remarks = ucfirst($request->remarks);
        $fixed_asset->fa_user_id = $user->user_id;
        $fixed_asset->fa_clg_id = $user->user_clg_id;
        $fixed_asset->fa_date_time = Carbon::now()->toDateTimeString();
        $fixed_asset->fa_day_end_id = $day_end->de_id;
        $fixed_asset->fa_day_end_date = $day_end->de_datetime;
        $fixed_asset->fa_temp_residual_value = $request->asset_purchase_price;
        $fixed_asset->fa_year_id = $this->getYearEndId();

        // coding from shahzaib start
        $tbl_var_name = 'fixed_asset';
        $prfx = 'fa';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        // coding from shahzaib end


        return $fixed_asset;
    }

    public
    function AssignFixedAssetValues_excel($request, $fixed_asset)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $fixed_asset->fa_parent_account_uid = $request->head_code;
        $fixed_asset->fa_group_id = $request->group;
        $fixed_asset->fa_account_id = $request->account;
        $fixed_asset->fa_link_account_uids = $this->link_account_uids;
        $fixed_asset->fa_account_name = ucwords($request->account_name);
        $fixed_asset->fa_method = $request->method;
        $fixed_asset->fa_dep_amo = $request->account_type;
        $fixed_asset->fa_price = $request->asset_purchase_price;
        $fixed_asset->fa_book_value = $request->asset_purchase_price;
        $fixed_asset->fa_residual_value = $request->residual_value;
        $fixed_asset->fa_useful_life_year = $request->useful_life;
        $fixed_asset->fa_useful_life_month = $request->useful_life * 12;
        $fixed_asset->fa_useful_life_day = $request->useful_life * 365;
        $fixed_asset->fa_dep_period = $request->depreciation_percentage_radio;
        $fixed_asset->fa_dep_percentage_year = $request->depreciation_percentage;
        $fixed_asset->fa_dep_percentage_month = $request->depreciation_percentage / 12;
        $fixed_asset->fa_dep_percentage_day = $request->depreciation_percentage / 365;
        $fixed_asset->fa_posting = $request->posting_method;
        $fixed_asset->fa_acquisition_date = date('Y-m-d', strtotime($request->acquisition_date));

        $fixed_asset->fa_user_id = $user->user_id;
        $fixed_asset->fa_clg_id = $user->user_clg_id;
        $fixed_asset->fa_date_time = Carbon::now()->toDateTimeString();
        $fixed_asset->fa_day_end_id = $day_end->de_id;
        $fixed_asset->fa_day_end_date = $day_end->de_datetime;
        $fixed_asset->fa_year_id = $this->getYearEndId();

        // coding from shahzaib start
        $tbl_var_name = 'fixed_asset';
        $prfx = 'fa';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        // coding from shahzaib end


        return $fixed_asset;
    }
}
