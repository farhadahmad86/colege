<?php

namespace App\Http\Controllers\EmployeeForm;

use App\Http\Controllers\AccountRegisterationsController;
use App\Http\Controllers\DayEndController;
use App\Http\Controllers\SaveImageController;
use App\Mail\PasswordMail;
use App\Mail\UserCredentialEmail;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\Department;
use App\Models\PackagesModel;
use App\Models\SalaryInfoModel;
use App\Models\Utility;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountGroupModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Session;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function excel_form_employee($request)
    {

        $user = Auth::user();
        //            ASSIGN DEPARTMENT ID TO FINANCIAL ACCOUNT
        $department_id = $request->user_department_id;
        //            ASSIGN DEPARTMENT ID TO FINANCIAL ACCOUNT

        $account_registerations_controller = new AccountRegisterationsController();

        $group_id = AccountGroupModel::where('ag_clg_id', $user->user_clg_id)->orderBy('ag_id', 'ASC')->pluck('ag_id')->first();
        DB::beginTransaction();
        $rollBack = false;

        $employee = new User();

        $uniqueId = Utility::uniqidReal() . mt_rand();
        $password = Utility::uniqidReal();

        $user = Auth::User();

        $employee = $this->ExcelAssignEmployeeValues($request, $employee, $uniqueId, $password);

        if ($employee->save()) {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Employee With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);

            $employee_id = $employee->user_id;
            $employee_name = $employee->user_name;

            $employee->user_employee_code = $this->generate_employee_code($employee_id, $employee_name);

            if (!$employee->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }
        } else {
            $rollBack = true;
            DB::rollBack();
            return true;
        }

        $notesCus = "";

        if ($request->role == config('global_variables.teller_account_id')) {
            $notesCus = " - TELLER - CASH";
        }
        if ($request->role == config('global_variables.purchaser_role_id')) {
            $notesCus = " - PURCHASER - Cash";
        }
        if ($request->role == config('global_variables.seller_role_account_id')) {
            $notesCus = " - SALEMAN - CASH";
        }

        if ($request->role == config('global_variables.teller_account_id') || $request->role == config('global_variables.purchaser_role_id')) {

            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Cash Account /////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////


            $account = new AccountRegisterationModel();
            $account = $this->AssignAccountValues(config('global_variables.cash'), $employee_name . $notesCus, $account, $employee_id, $request, $group_id);


            if (!$account->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }

            $account_uid = $account->account_uid;
            $account_name = $account->account_name;

            if ($request->role == config('global_variables.teller_account_id')) {

                $employee->user_teller_cash_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return true;
                }
            } elseif ($request->role == config('global_variables.purchaser_role_id')) {
                $employee->user_purchaser_cash_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return true;
                }
            }


            $account_balance = new BalancesModel();

            $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Walk in customer / Purchaser Account /////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////


            if ($request->role == config('global_variables.teller_account_id')) {

                $parent_account = config('global_variables.walk_in_customer_head');
                $prefix_name = ' - WIC';
            } elseif ($request->role == config('global_variables.purchaser_role_id')) {
                $parent_account = config('global_variables.purchaser_account_head');
                $prefix_name = ' - Purchaser';
            }

            $account = new AccountRegisterationModel();
            $account = $this->AssignAccountValues($parent_account, $employee_name . $prefix_name, $account, $employee_id, $request, $group_id);

            if (!$account->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }

            $account_uid = $account->account_uid;
            $account_name = $account->account_name;


            if ($request->role == config('global_variables.teller_account_id')) {

                $employee->user_teller_wic_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return true;
                }
            } elseif ($request->role == config('global_variables.purchaser_role_id')) {
                $employee->user_purchaser_wic_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return true;
                }
            }

            $account_balance = new BalancesModel();

            $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);
        }


        if ($request->role == config('global_variables.seller_role_account_id')) {

            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Cash Account /////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////

            $account = new AccountRegisterationModel();
            $account = $this->AssignAccountValues(config('global_variables.cash'), $employee_name . $notesCus, $account, $employee_id, $request, $group_id);

            if (!$account->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }

            $account_uid = $account->account_uid;
            $account_name = $account->account_name;


            if ($request->role == config('global_variables.seller_role_account_id')) {

                $employee->user_teller_cash_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return true;
                }
            }


            $account_balance = new BalancesModel();

            $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);
        }

        if ((isset($request->basic_salary) && !empty($request->basic_salary)) && (isset($request->salary_period) && !empty($request->salary_period)) && (isset($request->hour_per_day) && !empty($request->hour_per_day)) && (isset($request->holidays_id) && !empty($request->holidays_id))) {

            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Expense Account //////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////

            $getParentHeadAcc = Department::where('dep_id', $department_id)->select('dep_account_code')->first();

            $account = new AccountRegisterationModel();
            $account = $this->AssignAccountValues(config('global_variables.new_salary_expense_account'), 'Exp - ' . $employee_name, $account, $employee_id, $request, $request->group_id);

            if (!$account->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }

            $account_uid = $account->account_uid;
            $account_name = $account->account_name;

            $account_balance = new BalancesModel();

            $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Advance Account //////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////

            $advance_salary_account = new AccountRegisterationModel();

            $advance_salary_account = $this->AssignAccountValues(config('global_variables.advance_salary_head'), 'Adv - ' . $employee_name, $advance_salary_account, $employee_id, $request, $request->group_id);

            if (!$advance_salary_account->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $advance_salary_account->account_uid . ' And Name: '
                    . $advance_salary_account->account_name);
            }

            $account->account_link_uid = $advance_salary_account->account_uid;

            if (!$account->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }

            $advance_salary_account->account_link_uid = $account->account_uid;

            if (!$advance_salary_account->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }


            $account_balance = new BalancesModel();

            $account_balance = $account_registerations_controller->add_balance($account_balance, $advance_salary_account->account_uid, $advance_salary_account->account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }


            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Salary Info //////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////

            $salary_info = new SalaryInfoModel();

            $salary_info = $this->ExcelAssignSalaryInfoValues($request, $salary_info, $account->account_uid, $advance_salary_account->account_uid, $employee_id);

            if ($salary_info->save()) {

                $salary_info_id = $salary_info->si_id;

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Employee Salary Info With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);
            } else {
                $rollBack = true;
                DB::rollBack();
                return true;
            }


            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Salary Items /////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////

            if (isset($request->accounts_array) && !empty($request->accounts_array)) {
                $salary_items = $this->AssignAllowanceDeductionValues($request->accounts_array, $salary_info_id, $employee_id);

                if (DB::table('financials_allowances_deductions')->insert($salary_items)) {
                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Employee Salary Items With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return true;
                }
            }
        }
    }

    public function simple_form_employee($request)
    {

        //        $accountsval = json_decode($request->accounts_array, true);
        //        dd($request->all(),$accountsval);
        $user = Auth::user();
        $group_id = AccountGroupModel::where('ag_clg_id', $user->user_clg_id)->orderBy('ag_id', 'ASC')->pluck('ag_id')->first();
        $total_user = PackagesModel::where('pak_clg_id', '=', $user->user_clg_id)->pluck('pak_total_user')->first();
        $count_user = User::where('user_clg_id', '=', $user->user_clg_id)->where('user_username', '!=', null)->where('user_status', '=', 'Employee')->where('user_id', '!=', 1)->where('user_type', '!=', 'Master')->count();

        if (isset($request->make_credentials)) {
            if ($count_user >= $total_user) {
                return redirect()->route('add_employee')->with('fail', 'You are not eligible to make more user for login contact Softagics ');
            }
        }
        $this->employee_validation($request);

        //            ASSIGN DEPARTMENT ID TO FINANCIAL ACCOUNT
        $department_id = $request->user_department_id;
        //            ASSIGN DEPARTMENT ID TO FINANCIAL ACCOUNT
        if (isset($request->make_salary_account)) {
            $this->employee_salary_info_validation($request);
        }

        if (isset($request->make_credentials)) {
            $this->employee_credentials_validation($request);
        }

        $account_registerations_controller = new AccountRegisterationsController();

        DB::beginTransaction();
        $rollBack = false;

        $employee = new User();

        $uniqueId = Utility::uniqidReal() . mt_rand();
        $password = Utility::uniqidReal();

        $user = Auth::User();

        $employee = $this->AssignEmployeeValues($request, $employee, $uniqueId, $password);

        if ($employee->save()) {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Employee With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);

            $employee_id = $employee->user_id;
            $employee_name = $employee->user_name;

            $employee->user_employee_code = $this->generate_employee_code($employee_id, $employee_name);

            if (!$employee->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Please Try Again!');
        }

        $notesCus = "";

        if ($request->role == config('global_variables.cashier_account_id')) {
            $notesCus = " - CASHIER - CASH";
        }
        if ($request->role == config('global_variables.teller_account_id')) {
            $notesCus = " - TELLER - CASH";
        }
        if ($request->role == config('global_variables.purchaser_role_id')) {
            $notesCus = " - PURCHASER - CASH";
        }
        if ($request->role == config('global_variables.seller_role_account_id')) {
            $notesCus = " - SALEMAN - CASH";
        }

        if ($request->role == config('global_variables.cashier_account_id')) {

            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Cash Account /////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////

            $account = new AccountRegisterationModel();
            $account = $this->AssignAccountValues(config('global_variables.cash'), $employee_name . $notesCus, $account, $employee_id, $request, $group_id);

            if (!$account->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }

            $account_uid = $account->account_uid;
            $account_name = $account->account_name;


            if ($request->role == config('global_variables.cashier_account_id')) {

                $employee->user_teller_cash_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }
            }


            $account_balance = new BalancesModel();

            $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);
        }

        if ($request->role == config('global_variables.teller_account_id') || $request->role == config('global_variables.purchaser_role_id')) {

            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Cash Account /////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////


            $account = new AccountRegisterationModel();
            $account = $this->AssignAccountValues(config('global_variables.cash'), $employee_name . $notesCus, $account, $employee_id, $request, $group_id);


            if (!$account->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }

            $account_uid = $account->account_uid;
            $account_name = $account->account_name;

            if ($request->role == config('global_variables.teller_account_id')) {

                $employee->user_teller_cash_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }
            } elseif ($request->role == config('global_variables.purchaser_role_id')) {
                $employee->user_purchaser_cash_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }
            }


            $account_balance = new BalancesModel();

            $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Walk in customer / Purchaser Account /////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////


            if ($request->role == config('global_variables.teller_account_id')) {

                $parent_account = config('global_variables.walk_in_customer_head');
                $prefix_name = ' - WIC';
            } elseif ($request->role == config('global_variables.purchaser_role_id')) {
                $parent_account = config('global_variables.purchaser_account_head');
                $prefix_name = ' - Purchaser';
            }

            $account = new AccountRegisterationModel();
            $account = $this->AssignAccountValues($parent_account, $employee_name . $prefix_name, $account, $employee_id, $request, $group_id);

            if (!$account->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }

            $account_uid = $account->account_uid;
            $account_name = $account->account_name;


            if ($request->role == config('global_variables.teller_account_id')) {

                $employee->user_teller_wic_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }
            } elseif ($request->role == config('global_variables.purchaser_role_id')) {
                $employee->user_purchaser_wic_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }
            }

            $account_balance = new BalancesModel();

            $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);
        }


        if ($request->role == config('global_variables.seller_role_account_id')) {

            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Cash Account /////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////

            $account = new AccountRegisterationModel();
            $account = $this->AssignAccountValues(config('global_variables.cash'), $employee_name . $notesCus, $account, $employee_id, $request, $group_id);

            if (!$account->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }

            $account_uid = $account->account_uid;
            $account_name = $account->account_name;


            if ($request->role == config('global_variables.seller_role_account_id')) {

                $employee->user_teller_cash_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }
            }


            $account_balance = new BalancesModel();

            $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);
        }

        if (isset($request->make_salary_account)) {

            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Expense Account //////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////

            $account = new AccountRegisterationModel();
            $account = $this->AssignAccountValues(config('global_variables.new_salary_expense_account'), 'Exp - ' . $employee_name, $account, $employee_id, $request, $request->group_id);

            if (!$account->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }

            $account_uid = $account->account_uid;
            $account_name = $account->account_name;

            $account_balance = new BalancesModel();

            $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Advance Account //////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////

            $advance_salary_account = new AccountRegisterationModel();

            $advance_salary_account = $this->AssignAccountValues(config('global_variables.advance_salary_head'), 'Adv - ' . $employee_name, $advance_salary_account, $employee_id, $request, $request->group_id);

            if (!$advance_salary_account->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $advance_salary_account->account_uid . ' And Name: '
                    . $advance_salary_account->account_name);
            }

            $account->account_link_uid = $advance_salary_account->account_uid;

            if (!$account->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }

            $advance_salary_account->account_link_uid = $account->account_uid;

            if (!$advance_salary_account->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }


            $account_balance = new BalancesModel();

            $account_balance = $account_registerations_controller->add_balance($account_balance, $advance_salary_account->account_uid, $advance_salary_account->account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }


            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Loan Account //////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////
            $loan_account = '';
            if (isset($request->make_loan_account)) {
                $loan_account = new AccountRegisterationModel();

                $loan_account = $this->AssignAccountValues(config('global_variables.loan_head'), 'Loan - ' . $employee_name, $loan_account, $employee_id, $request, $request->group_id);

                if (!$loan_account->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                } else {
                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $loan_account->account_uid . ' And Name: '
                        . $loan_account->account_name);
                }

                $account->account_link_uid = $loan_account->account_uid;

                if (!$account->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $loan_account->account_link_uid = $account->account_uid;

                if (!$loan_account->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }


                $account_balance = new BalancesModel();

                $account_balance = $account_registerations_controller->add_balance($account_balance, $loan_account->account_uid, $loan_account->account_name);

                if (!$account_balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Salary Info //////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////
            $loan_account_uid = '';
            if ($loan_account != '') {
                $loan_account_uid = $loan_account->account_uid;
            }
            $salary_info = new SalaryInfoModel();

            $salary_info = $this->AssignSalaryInfoValues($request, $salary_info, $account->account_uid, $advance_salary_account->account_uid, $loan_account_uid, $employee_id);

            if ($salary_info->save()) {

                $salary_info_id = $salary_info->si_id;

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Employee Salary Info With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Please Try Again!');
            }


            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Salary Allowances and deductions Items /////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////

            if (isset($request->accounts_array) && !empty($request->accounts_array)) {
                //                AllowanceDeductionModel::where('ad_employ')
                $salary_items = $this->AssignAllowanceDeductionValues($request->accounts_array, $salary_info_id, $employee_id);

                if (DB::table('financials_allowances_deductions')->insert($salary_items)) {
                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Employee Salary Items With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }
            }

        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            DB::commit();

            if (isset($request->make_credentials)) {
                $role = Role::findById($request->modular_group);
                $employee->assignRole($role);
//                $this->SendPasswordMail($request->email, $request->username, $password);
//                Mail::to($request->email)->send(new PasswordMail($password, $request->username));
                Mail::to($request->email)->send(new UserCredentialEmail($password, $request->username));
            }
            // WizardController::updateWizardInfo(['employee'], []);
            //            return response()->json(['message' => 'Successfully Saved!', 'name' => $request->name], 200);

            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function employee_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'user_department_id' => ['required'],
            'user_type' => ['required', 'numeric'],
            'role' => ['required', 'numeric'],
            'designation' => ['required'],
            // 'name' => ['required', 'regex:/^[^-\s][a-zA-Z\s-]+$/', 'unique:financials_users,user_name,user_clg_id,' . $user->user_clg_id],
            'name' => ['required', 'regex:/^[^-\s][a-zA-Z\s-]+$/', 'unique:financials_users,user_name,null,null,user_clg_id,' . $user->user_clg_id],
            'fname' => ['required', 'regex:/^[^-\s][a-zA-Z\s-]+$/'],
            //            'mobile' => ['required', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            //            'emergency_contact' => ['nullable', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'mobile' => ['required'],
            'emergency_contact' => ['nullable'],
            'cnic' => ['nullable', 'regex:/^\d{5}-\d{7}-\d$|^\d{13}$/'],
            'family_code' => ['nullable', 'string'],
            'marital' => ['required', 'numeric'],
            'city' => ['nullable', 'numeric'],
            'blood_group' => ['nullable', 'string'],
            'nationality' => ['nullable', 'numeric'],
            'religion' => ['required', 'numeric'],
            'doj' => ['nullable', 'string'],
            'grade' => ['nullable', 'string'],
            'commission' => ['nullable', 'numeric'],
            'target_amount' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
            'address2' => ['nullable', 'string'],
            'pimage' => 'nullable|image|mimes:jpeg,jpg,png|max:1999',
            //            'pimage' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    }

    public function excel_employee_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'user_department_id' => ['required'],
            'user_type' => ['required', 'numeric'],
            'role' => ['required', 'numeric'],
            'designation' => ['required', 'string'],
            'name' => ['required', 'regex:/^[^-\s][a-zA-Z\s-]+$/', 'unique:financials_users,user_name,user_clg_id,' . $user->user_clg_id],
            'father_name' => ['required', 'regex:/^[^-\s][a-zA-Z\s-]+$/'],
            //            'mobile' => ['required', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'mobile' => ['required'],
        ]);
    }

    public function employee_salary_info_validation($request)
    {
        return $this->validate($request, [
            //            'parent_head' => ['required', 'numeric'],
            'basic_salary' => ['required', 'numeric'],
            'salary_period' => ['required', 'numeric'],
            'hour_per_day' => ['required', 'numeric'],
            'holidays' => ['nullable', 'array'],
            'accounts_array' => ['nullable', 'string'],
        ]);
    }

    public function employee_credentials_validation($request)
    {
        return $this->validate($request, [
            'group' => ['required', 'array'],
            'product_reporting_group' => ['required', 'array'],
            'modular_group' => ['required', 'numeric'],
            //            'username' => ['required', 'regex:/^[a-zA-Z0-9]{6,40}$/', 'unique:financials_users,user_username'],
            'username' => ['required', 'string', 'unique:financials_users,user_username,NULL,user_id,user_have_credentials,1'],
            'email' => ['required', 'confirmed', 'string', 'unique:financials_users,user_email,NULL,user_id,user_have_credentials,1'],
            //            'email' => 'required|string|email|unique:financials_users,user_email',
        ]);
    }

    protected function AssignEmployeeValues($request, $employee, $uniqueid, $password)
    {
        $user = Auth::user();
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();


        $employee->user_department_id = $request->user_department_id;
        $employee->user_level = $request->user_type;
        $employee->user_designation = ucwords($request->designation);
        $employee->user_name = ucwords($request->name);
        $employee->user_father_name = ucwords($request->fname);
        $employee->user_mobile = $request->mobile;
        $employee->user_emergency_contact = $request->emergency_contact;
        $employee->user_cnic = $request->cnic;
        $employee->user_family_code = $request->family_code;
        $employee->user_marital_status = $request->marital;
        $employee->user_city = $request->city;
        $employee->user_blood_group = $request->blood_group;
        $employee->user_nationality = $request->nationality;
        $employee->user_religion = $request->religion;
        $employee->user_d_o_j = empty($request->doj) ? '0000-00-00' : date('Y-m-d', strtotime($request->doj));
        $employee->user_commission_per = empty($request->commission) ? 0 : $request->commission;
        $employee->user_target_amount = empty($request->target_amount) ? 0 : $request->target_amount;
        $employee->user_role_id = $request->role;
        $employee->user_address = ucfirst($request->address);
        $employee->user_address_2 = ucfirst($request->address2);
        $employee->user_createdby = $user->user_id;
        $employee->user_clg_id = $user->user_clg_id;
        $employee->user_branch_id = implode(",", $request->branch);
        $employee->user_datetime = Carbon::now()->toDateTimeString();

        $save_image = new SaveImageController();

        $common_path = config('global_variables.common_path');
        $employee_path = config('global_variables.employee_path');

        // Handle Image
        $fileNameToStore = $save_image->SaveImage($request, 'pimage', $uniqueid, $employee_path, 'Profile_Image');


        if ($request->hasFile('pimage')) {
            $employee->user_profilepic = $common_path . $fileNameToStore;
        } else {
            $employee->user_profilepic = $fileNameToStore;
        }

        $employee->user_folder = $uniqueid;
        $employee->user_day_end_id = $day_end->de_id;
        $employee->user_day_end_date = $day_end->de_datetime;
        $employee->user_brwsr_info = $brwsr_rslt;
        $employee->user_ip_adrs = $ip_rslt;
        $employee->user_update_datetime = Carbon::now()->toDateTimeString();

        if (isset($request->make_salary_account)) {
            $employee->user_salary_person = 1;
        }

        if (isset($request->make_loan_account)) {
            $employee->user_loan_person = 1;
        }

        if (isset($request->make_credentials)) {
            $employee->user_have_credentials = 1;
            $employee->user_account_reporting_group_ids = implode(',', $request->group);
            $employee->user_product_reporting_group_ids = implode(',', $request->product_reporting_group);
            $employee->user_modular_group_id = $request->modular_group;
            $employee->user_username = $request->username;
            $employee->user_password = Hash::make($password);
            $employee->user_email = $request->email;
            $employee->user_expiry_date = date('Y-m-d', strtotime($user->user_expiry_date));
        }

        return $employee;
    }

    protected function ExcelAssignEmployeeValues($request, $employee, $uniqueid, $password)
    {
        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();


        $employee->user_department_id = $request->user_department_id;
        $employee->user_level = $request->user_type;
        $employee->user_role_id = $request->role;
        $employee->user_designation = ucwords($request->designation);
        $employee->user_name = ucwords($request->name);
        $employee->user_father_name = ucwords($request->father_name);
        $employee->user_mobile = $request->mobile;


        $employee->user_createdby = $user->user_id;
        $employee->user_clg_id = $user->user_clg_id;
        $employee->user_datetime = Carbon::now()->toDateTimeString();


        $employee->user_day_end_id = $day_end->de_id;
        $employee->user_day_end_date = $day_end->de_datetime;
        $employee->user_brwsr_info = $brwsr_rslt;
        $employee->user_ip_adrs = $ip_rslt;
        $employee->user_update_datetime = Carbon::now()->toDateTimeString();

        if ((isset($request->basic_salary) && !empty($request->basic_salary)) && (isset($request->salary_period) && !empty($request->salary_period)) && (isset($request->hour_per_day) && !empty($request->hour_per_day)) && (isset($request->holidays_id) && !empty($request->holidays_id))) {
            $employee->user_salary_person = 1;
        }

        return $employee;
    }

    protected function AssignAccountValues($parent_code, $account_name, $account, $employee_id, $request, $group_id)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $account_reg = new AccountRegisterationsController();

        $check_uid = AccountRegisterationModel::where('account_parent_code', $parent_code)->orderBy('account_uid', 'DESC')->pluck('account_uid')->first();


        if ($check_uid) {
            $check_uid = $account_reg->generate_account_code($parent_code, $check_uid);

            $uid = $check_uid;
        } else {
            $check_uid = $check_uid + 1;
            $uid = $parent_code . $check_uid;
        }

        $account->account_parent_code = $parent_code;
        $account->account_name = ucwords($account_name);
        $account->account_balance = 0;
        $account->account_remarks = '';
        $account->account_uid = $uid;
        $account->account_group_id = $group_id;
        $account->account_createdby = $user->user_id;
        $account->account_clg_id = $user->user_clg_id;
        $account->account_branch_id = Session::get('branch_id');
        $account->account_day_end_id = $day_end->de_id;
        $account->account_day_end_date = $day_end->de_datetime;
        $account->account_employee_id = $employee_id;
        $account->account_brwsr_info = $brwsr_rslt;
        $account->account_ip_adrs = $ip_rslt;
        $account->account_update_datetime = Carbon::now();
        $account->account_department_id = $request->user_department_id;

        return $account;
    }

    public function AssignSalaryInfoValues($request, $salary_info, $salary_account_uid, $advance_account_uid, $loan_account_uid, $employee_id)
    {
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $user = Auth::user();

        $salary_info->si_basic_salary = empty($request->basic_salary) ? 0 : $request->basic_salary;
        $salary_info->si_basic_salary_period = $request->salary_period;
        $salary_info->si_working_hours_per_day = empty($request->hour_per_day) ? 0 : $request->hour_per_day;
        $salary_info->si_off_days = empty($request->holidays) ? '' : implode(',', $request->holidays);
        $salary_info->si_user_id = $employee_id;
        $salary_info->si_advance_salary_account_uid = $advance_account_uid;
        $salary_info->si_expense_salary_account_uid = $salary_account_uid;
        $salary_info->si_loan_account_uid = $loan_account_uid;
        $salary_info->si_day_end_id = $day_end->de_id;
        $salary_info->si_day_end_date = $day_end->de_datetime;
        $salary_info->si_clg_id = $user->user_clg_id;
        $salary_info->si_branch_id = Session::get('branch_id');
        $salary_info->si_datetime = Carbon::now()->toDateTimeString();
        $salary_info->si_update_datetime = Carbon::now()->toDateTimeString();
        $salary_info->si_payment_type = $request->payment_type;
        $salary_info->si_branch_code = $request->branch_code;
        $salary_info->si_account_number = $request->account_no;

        return $salary_info;
    }

    public function ExcelAssignSalaryInfoValues($request, $salary_info, $salary_account_uid, $advance_account_uid, $employee_id)
    {
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        $user = Auth::user();

        $salary_info->si_basic_salary = empty($request->basic_salary) ? 0 : $request->basic_salary;
        $salary_info->si_basic_salary_period = $request->salary_period;
        $salary_info->si_working_hours_per_day = empty($request->hour_per_day) ? 0 : $request->hour_per_day;
        $salary_info->si_off_days = empty($request->holidays_id) ? '' : $request->holidays_id;
        $salary_info->si_user_id = $employee_id;
        $salary_info->si_advance_salary_account_uid = $advance_account_uid;
        $salary_info->si_expense_salary_account_uid = $salary_account_uid;
        $salary_info->si_day_end_id = $day_end->de_id;
        $salary_info->si_day_end_date = $day_end->de_datetime;
        $salary_info->si_clg_id = $user->user_clg_id;
        $salary_info->si_branch_id = Session::get('branch_id');
        $salary_info->si_datetime = Carbon::now()->toDateTimeString();
        $salary_info->si_update_datetime = Carbon::now()->toDateTimeString();

        return $salary_info;
    }

    public function AssignAllowanceDeductionValues($values_array, $salary_info_id, $employee_id)
    {
        $data = [];

        $values_array = json_decode($values_array, true);
        $user = Auth::user();
        foreach ($values_array as $value) {

            $data[] = [
                'ad_account_id' => $value['account_code'],
                'ad_account_name' => $value['account_name'],
                'ad_allowance_deduction' => $value['allowance_deduction'],
                'ad_start_month' => date("Y-m-d", strtotime($value['start_month'])),
                'ad_end_month' => date("Y-m-d", strtotime($value['end_month'])),
                'ad_allowance_amount' => $value['allowance_deduction'] == 1 ? $value['account_amount'] : 0,
                'ad_deduction_amount' => $value['allowance_deduction'] == 2 ? $value['account_amount'] : 0,
                'ad_salary_info_id' => $salary_info_id,
                'ad_employee_id' => $employee_id,
                'ad_remarks' => $value['account_remarks'],
                'ad_clg_id' => $user->user_clg_id,
                'ad_created_by' => $user->user_id,
            ];
        }

        return $data;
    }
}
