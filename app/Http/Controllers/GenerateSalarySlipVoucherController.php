<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\AllowanceDeductionModel;
use App\Models\AttendanceModel;
use App\Models\BalancesModel;
use App\Models\Department;
use App\Models\GenerateSalarySlipItemsModel;
use App\Models\GenerateSalarySlipModel;
use App\Models\LoanModel;
use App\Models\SalaryInfoModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use App\User;
use PDF;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class GenerateSalarySlipVoucherController extends Controller
{
    public function generate_salary_slip_voucher()
    {
        $user = Auth::user();
        $heads = explode(',', config('global_variables.payable_receivable_cash_bank'));

        $pay_accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)
            ->select('account_name', 'account_uid')->get();
        $accounts_array = $this->get_account_query('advance_salary');
//        $pay_accounts = $accounts_array[0];
        $advance_salary_accounts = $accounts_array[1];
        $departments = Department::where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)->where('dep_clg_id', $user->user_clg_id)->get();

        return view('generate_salary_slip_voucher', compact('departments', 'pay_accounts', 'advance_salary_accounts'));
    }

    public function generate_salary_slip_voucher_with_load()
    {
        $user = Auth::user();
        $heads = explode(',', config('global_variables.payable_receivable_cash_bank'));

        $pay_accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)
            ->select('account_name', 'account_uid')->get();
        $accounts_array = $this->get_account_query('advance_salary');
//        $pay_accounts = $accounts_array[0];
        $advance_salary_accounts = $accounts_array[1];
        $departments = Department::where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)->where('dep_clg_id', $user->user_clg_id)->get();

        return view('collegeViews.salary_slip.generate_salary_slip_with_load', compact('departments', 'pay_accounts', 'advance_salary_accounts'));
    }

    public function submit_generate_salary_slip_voucher(Request $request)
    {
        $this->generate_salary_validation($request);

        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        $month = $request->month;

        // Use Carbon to parse the date string
        $date = \Carbon\Carbon::createFromFormat('F Y', $month);

        // Get the month as a number (1-12)
        $month = $date->month;

        // Get the year as a four-digit number (e.g., 2023)
        $year = $date->year;
        $dayMonthYear = $year . '-' . $month . '-01';

        $generate_salary_array = json_decode($request->accountsval, true);


        $total_payable_amount = 0;
        $total_voucher_amount = (float)$request->total_salary_amount;
        foreach ($generate_salary_array as $item) {
            $total_payable_amount += $item['payable_amount'];
        }

//            dd($total_payable_amount , $total_voucher_amount);
        $department_id = $request->department;

        $voucher_remarks = $request->remarks;
        $month = $request->month;

        $notes = 'GENERATE_SALARY_SLIP_VOUCHER';
        $voucher_code = config('global_variables.GENERATE_SALARY_SLIP_VOUCHER_CODE');

        $transaction_type = config('global_variables.GENERATE_SALARY_SLIP');


        DB::beginTransaction();

        $generate_salary = new GenerateSalarySlipModel();
        $gss_v_no = GenerateSalarySlipModel::where('gss_clg_id', $user->user_clg_id)->count();


        $generate_salary = $this->assign_salary_values('gss', $gss_v_no + 1, $generate_salary, $department_id, $total_voucher_amount, $voucher_remarks, $month, $user, $day_end);

        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_salary_slip_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = GenerateSalarySlipModel::where('gss_clg_id', $user->user_clg_id)->get();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $generate_salary->gss_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;


        if ($generate_salary->save()) {
            $generate_salary_id = $generate_salary->gss_id;
            $gss_voucher_no = $generate_salary->gss_v_no;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->voucher_salary_items_values($generate_salary_array, $generate_salary_id, $month, $gss_voucher_no, 'gssi');

        foreach ($item as $value) {

            $generate_salary_amount = (float)$value['gssi_net_salary'];

            $detail_remarks .= $value['gssi_account_name'] . ', ' . $month . ', @' . number_format($generate_salary_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_generate_salary_slip_voucher_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $generate_salary->gss_detail_remarks = $detail_remarks;
        if (!$generate_salary->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        // for gross salary
        foreach ($generate_salary_array as $key) {

//            ->where('si_expense_salary_account_uid',$key['account_code'])
            $adv_account = SalaryInfoModel::where('si_user_id', $key['employee_id'])->pluck('si_advance_salary_account_uid')->first();

            $account_name = AccountRegisterationModel::where('account_uid', $adv_account)->pluck('account_name')->first();

            $transaction = new TransactionModel();

            $transaction = $this->AssignTransactionsValues($transaction, $key['account_code'], $key['gross_salary'], $adv_account, $notes, $transaction_type, $generate_salary_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                // Selected Accounts

                $balances = new BalancesModel();

                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['account_code'], $key['gross_salary'], 'Dr', $voucher_remarks, $notes, $account_name . ' to ' . $key['account_name'] . ', ' . $month . ', @'
                    . number_format($key['gross_salary'], 2), $voucher_code . $generate_salary_id, '', $voucher_code . $gss_voucher_no, $this->getYearEndId());
//                $account_name_text . ' to ' . $key['to_text'] .
                if (!$balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                // Bank Account

                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $adv_account, $key['gross_salary'], 'Cr', $voucher_remarks,
                    $notes, $account_name . ' to ' . $key['account_name'] . ', ' . $month . ', @' . number_format($key['gross_salary'], 2), $voucher_code . $generate_salary_id, '', $voucher_code . $gss_voucher_no, $this->getYearEndId());
//                $account_name_text . ' to ' . $key['to_text'] .
                if (!$balance2->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }
        }

//        for allownance and deduction
        foreach ($generate_salary_array as $key) {
            $adv_account = SalaryInfoModel::where('si_user_id', $key['employee_id'])->pluck('si_advance_salary_account_uid')->first();
            $account_name = AccountRegisterationModel::where('account_uid', $adv_account)->pluck('account_name')->first();

//            deduction cut in salary
            if ($key['deductions'] > 0) {
                $deduction_accounts = AllowanceDeductionModel::where('ad_employee_id', $key['employee_id'])->where('ad_allowance_deduction', '=', 2)
                    ->whereRaw('? BETWEEN ad_start_month AND ad_end_month', [$dayMonthYear])
                    ->get();

                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $key['account_code'], $key['deductions'], $adv_account, $notes, $transaction_type, $generate_salary_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    foreach ($deduction_accounts as $deduction_account) {
                        // Selected Accounts

                        $balances = new BalancesModel();

                        $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $deduction_account->ad_account_id, $deduction_account->ad_deduction_amount, 'Cr', $voucher_remarks, $notes,
                            $account_name . ' to ' .
                            $deduction_account->ad_account_name . ', ' . $month . ', @'
                            . $deduction_account->ad_deduction_amount, $voucher_code . $generate_salary_id, '', $voucher_code . $gss_voucher_no, $this->getYearEndId());

                        if (!$balance->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }

                        // Advance Account
                        $balances2 = new BalancesModel();


                        $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $adv_account, $deduction_account->ad_deduction_amount, 'Dr', $voucher_remarks,
                            $notes, $account_name . ' to ' . $deduction_account->ad_account_name . ', ' . $month . ', @' . $deduction_account->ad_deduction_amount, $voucher_code . $generate_salary_id, '', $voucher_code . $gss_voucher_no, $this->getYearEndId());

                        if (!$balance2->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }

                    }

                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }
            }
            // allowances add in salary
            if ($key['allowances'] > 0) {
                $allowance_accounts = AllowanceDeductionModel::where('ad_employee_id', $key['employee_id'])->where('ad_allowance_deduction', '=', 1)
                    ->whereRaw('? BETWEEN ad_start_month AND ad_end_month', [$dayMonthYear])
                    ->get();

                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $key['account_code'], $key['allowances'], $adv_account, $notes, $transaction_type, $generate_salary_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    foreach ($allowance_accounts as $allowance_account) {
                        // Selected Accounts

                        $balances = new BalancesModel();

                        $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $allowance_account->ad_account_id, $allowance_account->ad_deduction_amount, 'Dr', $voucher_remarks,
                            $notes,
                            $account_name . ' to ' .
                            $allowance_account->ad_account_name . ', ' . $month . ', @'
                            . $allowance_account->ad_deduction_amount, $voucher_code . $generate_salary_id, '', $voucher_code . $gss_voucher_no, $this->getYearEndId());

                        if (!$balance->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }

                        // Advance Account
                        $balances2 = new BalancesModel();


                        $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $adv_account, $allowance_account->ad_deduction_amount, 'Cr', $voucher_remarks,
                            $notes, $account_name . ' to ' . $allowance_account->ad_account_name . ', ' . $month . ', @' . $allowance_account->ad_deduction_amount, $voucher_code . $generate_salary_id, '', $voucher_code . $gss_voucher_no, $this->getYearEndId());

                        if (!$balance2->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }
                    }

                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }
            }

            // over time amount in salary
            if ($key['over_time_amount'] > 0) {
                $over_time_account_id = 416101;
                $over_time_account_name = AccountRegisterationModel::where('account_uid', 416101)->pluck('account_name')->first();

                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $key['account_code'], $key['over_time_amount'], $adv_account, $notes, $transaction_type, $generate_salary_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    // Selected Accounts

                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $over_time_account_id, $key['over_time_amount'], 'Dr', $voucher_remarks,
                        $notes,
                        $account_name . ' to ' .
                        $over_time_account_name . ', ' . $month . ', @'
                        . number_format($key['over_time_amount'], 2), $voucher_code . $generate_salary_id, '', $voucher_code . $gss_voucher_no, $this->getYearEndId());

                    if (!$balance->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    // Advance Account
                    $balances2 = new BalancesModel();


                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $adv_account, $key['over_time_amount'], 'Cr', $voucher_remarks,
                        $notes, $account_name . ' to ' . $over_time_account_name . ', ' . $month . ', @' . number_format($key['over_time_amount'], 2), $voucher_code . $generate_salary_id, '', $voucher_code . $gss_voucher_no, $this->getYearEndId());

                    if (!$balance2->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }


                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }
            }

        }
        // for loan deduction
        foreach ($generate_salary_array as $key) {

            if ($key['loan_installment'] > 0) {
                $adv_account = SalaryInfoModel::where('si_user_id', $key['employee_id'])->pluck('si_advance_salary_account_uid')->first();
                $account_name = AccountRegisterationModel::where('account_uid', $adv_account)->pluck('account_name')->first();

                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $key['account_code'], $key['loan_installment'], $adv_account, $notes, $transaction_type, $generate_salary_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    // Selected Accounts
                    $loan_account_name = AccountRegisterationModel::where('account_uid', $key['loan_account_id'])->pluck('account_name')->first();
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['loan_account_id'], $key['loan_installment'], 'Cr', $voucher_remarks, $notes, $account_name . ' to ' .
                        $loan_account_name . ', ' . $month . ', @'
                        . number_format($key['loan_installment'], 2), $voucher_code . $generate_salary_id, '', $voucher_code . $gss_voucher_no, $this->getYearEndId());
//                $account_name_text . ' to ' . $key['to_text'] .
                    if (!$balance->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    // Bank Account

                    $balances2 = new BalancesModel();


                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $adv_account, $key['loan_installment'], 'Dr', $voucher_remarks,
                        $notes, $account_name . ' to ' . $loan_account_name . ', ' . $month . ', @' . number_format($key['loan_installment'], 2), $voucher_code . $generate_salary_id, '', $voucher_code . $gss_voucher_no, $this->getYearEndId());
//                $account_name_text . ' to ' . $key['to_text'] .
                    if (!$balance2->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    $loans_amount = LoanModel::where('loan_account_id', $key['loan_account_id'])
                        ->where('loan_status', 'Approved')
                        ->where('loan_paid_status', 1)
                        ->whereDate('loan_last_payment_month', '>=', $dayMonthYear)->get();

                    foreach ($loans_amount as $item) {
                        $loansss = LoanModel::where('loan_id', '=', $item->loan_id)->where('loan_status', '=', 'Approved')->where('loan_paid_status', '=', 1)->first();
                        $loansss->loan_remaining_amount = $item->loan_remaining_amount - $item->loan_instalment_amount;
                        $loansss->loan_remaining_installment = $item->loan_remaining_installment - 1;
                        $loansss->loan_update_datetime = Carbon::now();
                        $loansss->save();
                    }

                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }
            }
        }

        if ($rollBack == false) {
            $loans = LoanModel::where('loan_department_id', '=', $department_id)->where('loan_status', '=', 'Approved')->where('loan_paid_status', '=', 1)->whereDate('loan_last_payment_month', '=', $dayMonthYear)
                //->whereYear('loan_last_payment_month', '=', $year)
                ->get();
            foreach ($loans as $loan) {
                $loan->loan_paid_status = 2;
                $loan->loan_update_datetime = Carbon::now();
                $loan->save();
            }
        }


        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $generate_salary->gss_id);
            DB::commit();
            return redirect()->back()->with(['gss_id' => $generate_salary_id, 'success' => 'Successfully Saved']);
        }
//        } else {
//            dd($total_payable_amount , $total_voucher_amount,'else');
//            return redirect()->back()->with('fail', 'Something went wrong!');
//        }
    }

    public function generate_salary_validation($request)
    {
        return $this->validate($request, [
//            'account' => ['required', 'numeric'],
//            'to' => ['required', 'numeric'],
            'department' => ['required', 'numeric'],
            'remarks' => ['nullable', 'string'],
            'month' => ['required', 'string'],
            'total_salary_amount' => ['required', 'string'],
            'accountsval' => ['required', 'string'],
        ]);
    }

    public function assign_salary_values($prfx, $v_number, $voucher, $department_id, $total_voucher_amount, $voucher_remarks, $month_year, $user, $day_end, $voucher_type = 0)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $department = $prfx . '_department_id';
        $v_no = $prfx . '_v_no';
        $total_amount = $prfx . '_total_amount';
        $remarks = $prfx . '_remarks';
        $month = $prfx . '_month';
        $created_datetime = $prfx . '_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_created_by';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';
        $year_id = $prfx . '_year_id';


        $voucher->$department = $department_id;
        $voucher->$v_no = $v_number;
        $voucher->$total_amount = $total_voucher_amount;
        $voucher->$remarks = $voucher_remarks;
        $voucher->$month = $month_year;//date("Y-m-d", strtotime($month_year));
        $voucher->$created_datetime = Carbon::now()->toDateTimeString();
        $voucher->$day_end_id = $day_end->de_id;
        $voucher->$day_end_date = $day_end->de_datetime;
        $voucher->$createdby = $user->user_id;
        $voucher->$clg_id = $user->user_clg_id;
        $voucher->$branch_id = Session::get('branch_id');
        $voucher->$brwsr_info = $brwsr_rslt;
        $voucher->$ip_adrs = $ip_rslt;
        $voucher->$year_id = $this->getYearEndId();

        return $voucher;
    }

    public function voucher_salary_items_values($values_array, $voucher_number, $month_year, $gss_voucher_no, $prfx)
    {
        $user = Auth::user();
        $data = [];
//dd($values_array);
        $voucher_id = $prfx . '_gss_id';
        $voucher_no = $prfx . '_v_no';
        $employee_id = $prfx . '_employee_id';
        $department_id = $prfx . '_department_id';
        $department_name = $prfx . '_department_name';
        $account_id = $prfx . '_account_id';
        $account_name = $prfx . '_account_name';
        $advance_account_id = $prfx . '_advance_account_id';
        $month_days = $prfx . '_month_days';
        $attend_days = $prfx . '_attend_days';
        $salary_period = $prfx . '_salary_period_type';
        $basic_salary = $prfx . '_basic_salary';
        $gross_salary = $prfx . '_gross_salary';
        $allowances = $prfx . '_allowances';
        $deductions = $prfx . '_deductions';
        $over_time_days = $prfx . '_over_time_days';
        $over_time_amount = $prfx . '_over_time_amount';
        $net_salary = $prfx . '_net_salary';
        $month = $prfx . '_month_year';
        $advance_salary = $prfx . '_advance_salary';
        $loan_installment = $prfx . '_loan_installment_amount';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';
        $year_id = $prfx . '_year_id';

        foreach ($values_array as $key) {
            $data[] = [
                $voucher_id => $voucher_number,
                $voucher_no => $gss_voucher_no,
                $employee_id => $key['employee_id'],
                $department_id => $key['department'],
                $department_name => $key['department_name'],
                $account_id => $key['account_code'],
                $account_name => $key['account_name'],
                $advance_account_id => $key['advance_account'],
                $month_days => $key['month_days'],
                $attend_days => $key['attend_days'],
                $salary_period => $key['salary_period'],
                $basic_salary => $key['basic_salary'],
                $gross_salary => $key['gross_salary'],
                $allowances => $key['allowances'],
                $deductions => $key['deductions'],
                $over_time_days => $key['over_time_days'],
                $over_time_amount => $key['over_time_amount'],
                $advance_salary => $key['advance_salary'],
                $loan_installment => $key['loan_installment'],
                $net_salary => $key['net_salary'],
                $month => $month_year,
                $clg_id => $user->user_clg_id,
                $branch_id => Session::get('branch_id'),
                $year_id => $this->getYearEndId()
            ];
        }

        return $data;
    }

    public function get_salary_accounts(Request $request)
    {
        $user = Auth::user();
        $department_id = $request->department_id;
        $month_year = $request->month_year;
        $month = $request->month;
        $year = $request->year;
        $get_month = $request->get_month;

        $check_attendance = AttendanceModel:: where('atten_month', $month)->where('atten_department_id', $department_id)->where('atten_clg_id', $user->user_clg_id)->count();
        if ($check_attendance == 0) {
            return response()->json(compact('check_attendance'), 200);
        }
        $generated = GenerateSalarySlipModel::where('gss_month', '=', $month)->where('gss_department_id', '=', $department_id)->where('gss_clg_id', $user->user_clg_id)->count();
        if ($generated > 0) {
            return response()->json(compact('generated'), 200);
        } else {

            $heads = explode(',', config('global_variables.new_salary_expense_account'));

            $query = DB::table('financials_accounts')
                ->leftJoin('financials_salary_info', 'financials_salary_info.si_user_id', '=', 'financials_accounts.account_employee_id')
                ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_employee_id')
                ->leftJoin('financials_attendance', 'financials_salary_info.si_user_id', '=', 'financials_attendance.atten_emp_id')
                ->leftJoin(DB::raw('(SELECT bal_id, bal_total, bal_account_id FROM financials_balances WHERE bal_id IN (SELECT MAX(bal_id) AS bal_id FROM financials_balances GROUP BY bal_account_id DESC) ) AS fin_bal'), 'fin_bal.bal_account_id', '=', 'financials_salary_info.si_loan_account_uid')
                ->leftJoin(DB::raw('(SELECT bal_id as ad_bal_id, bal_total as advance_salary, bal_account_id as ad_account_id FROM financials_balances WHERE bal_id IN (SELECT MAX(bal_id) AS bal_id FROM financials_balances GROUP BY bal_account_id DESC) ) AS fin_bal1'), 'fin_bal1.ad_account_id', '=', 'financials_salary_info.si_advance_salary_account_uid')
                ->leftJoin(DB::raw('(SELECT ad_employee_id, SUM(ad_allowance_amount) as allowance, SUM(ad_deduction_amount) as deduction FROM financials_allowances_deductions WHERE "' . $month_year . '" BETWEEN ad_start_month AND ad_end_month and ad_employee_id IN (SELECT user_id FROM financials_users) GROUP BY ad_employee_id ) AS allowances_deductions'), 'allowances_deductions.ad_employee_id', '=', 'financials_users.user_id')
                ->leftJoin(DB::raw('(SELECT SUM(loan_instalment_amount) AS loan_instalment_amount, loan_account_id FROM financials_loan WHERE loan_status="Approved" AND loan_paid_status="1" AND "'
                    . $month_year . '" BETWEEN loan_first_payment_month AND loan_last_payment_month GROUP BY loan_account_id) AS financials_loan'), 'financials_loan.loan_account_id', '=', 'financials_salary_info.si_loan_account_uid')
                ->leftJoin(DB::raw('(SELECT COUNT(la_attendance) AS total_present,la_emp_id FROM lecturer_attendance WHERE la_attendance="P" AND MONTH(la_date) = "' . $get_month . '" AND YEAR(la_date) = "'
                    . $year . '" AND la_department_id="' . $department_id . '" GROUP BY la_emp_id) AS lect'), 'lect.la_emp_id', '=', 'financials_salary_info.si_user_id')
                ->where('account_department_id', '=', $department_id)
                ->whereIn('account_parent_code', [41412])
                ->where('account_delete_status', '<>', 1)
                ->where('account_disabled', '<>', 1)
                ->where('financials_users.user_disabled', '=', 0)
                ->groupBy('financials_users.user_name')
                ->select('account_name', 'account_uid', 'atten_month_days', 'atten_attend_days', 'bal_total as total_loan_amount', 'loan_instalment_amount', 'advance_salary', 'allowance', 'deduction', 'financials_salary_info.*', 'total_present');

            $pay_accounts = $query->get();


            return response()->json(compact('pay_accounts', 'generated', 'check_attendance'), 200);
        }
    }

    public function get_salary_accounts_with_load(Request $request)
    {
        $user = Auth::user();
        $department_id = $request->department_id;
        $month_year = $request->month_year;
        $month = $request->month;
        $year = $request->year;
        $get_month = $request->get_month;

        $generated = GenerateSalarySlipModel::where('gss_month', '=', $month)->where('gss_department_id', '=', $department_id)->where('gss_clg_id', $user->user_clg_id)->count();
        if ($generated > 0) {
            return response()->json(compact('generated'), 200);
        } else {

            $heads = explode(',', config('global_variables.new_salary_expense_account'));


            $pay_accounts = AccountRegisterationModel::
            leftJoin('financials_salary_info', 'financials_salary_info.si_user_id', '=', 'financials_accounts.account_employee_id')
                ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_employee_id')
                ->leftJoin('teacher_load', 'teacher_load.tl_teacher_id', '=', 'financials_salary_info.si_user_id')
                ->leftJoinSub(function ($query) {
                    $query->select('bal_id', 'bal_total', 'bal_account_id')
                        ->from('financials_balances')
                        ->whereIn('bal_id', function ($query) {
                            $query->selectRaw('MAX(bal_id)')
                                ->from('financials_balances')
                                ->groupBy('bal_account_id');
                        });
                }, 'fin_bal', 'fin_bal.bal_account_id', '=', 'financials_salary_info.si_loan_account_uid')
                ->leftJoinSub(function ($query) {
                    $query->select('bal_id', 'bal_total AS advance_salary', 'bal_account_id AS ad_account_id')
                        ->from('financials_balances')
                        ->whereIn('bal_id', function ($query) {
                            $query->selectRaw('MAX(bal_id)')
                                ->from('financials_balances')
                                ->groupBy('bal_account_id');
                        });
                }, 'fin_bal1', 'fin_bal1.ad_account_id', '=', 'financials_salary_info.si_advance_salary_account_uid')
                ->leftJoinSub(function ($query) use ($month_year) {
                    $query->select('ad_employee_id', DB::raw('SUM(ad_allowance_amount) AS allowance'), DB::raw('SUM(ad_deduction_amount) AS deduction'))
                        ->from('financials_allowances_deductions')
                        ->whereRaw("'{$month_year}' BETWEEN ad_start_month AND ad_end_month")
                        ->whereIn('ad_employee_id', function ($query) {
                            $query->select('user_id')->from('financials_users');
                        })
                        ->groupBy('ad_employee_id');
                }, 'allowances_deductions', 'allowances_deductions.ad_employee_id', '=', 'financials_users.user_id')
                ->leftJoinSub(function ($query) use ($month_year) {
                    $query->select(DB::raw('SUM(loan_instalment_amount) AS loan_instalment_amount'), 'loan_account_id')
                        ->from('financials_loan')
                        ->where('loan_status', 'Approved')
                        ->where('loan_paid_status', 1)
                        ->whereRaw("'{$month_year}' BETWEEN loan_first_payment_month AND loan_last_payment_month")
                        ->groupBy('loan_account_id');
                }, 'financials_loan', 'financials_loan.loan_account_id', '=', 'financials_salary_info.si_loan_account_uid')
                ->leftJoinSub(function ($query) use ($get_month, $year, $department_id) {
                    $query->select(DB::raw('COUNT(la_attendance) AS total_present'), 'la_emp_id')
                        ->from('lecturer_attendance')
                        ->whereIn('la_attendance', ['P', 'L'])
                        ->whereMonth('la_date', $get_month)
                        ->whereYear('la_date', $year)
                        ->where('la_department_id', $department_id)
                        ->where('la_type', '1')
                        ->where('la_year_id', $this->getYearEndId())
                        ->groupBy('la_emp_id');
                }, 'lect', 'lect.la_emp_id', '=', 'financials_salary_info.si_user_id')
                ->leftJoinSub(function ($query) use ($get_month, $year, $department_id) {
                    $query->select(DB::raw('COUNT(la_attendance) AS total_extra_lecture'), 'la_emp_id')
                        ->from('lecturer_attendance')
                        ->where('la_attendance', 'P')
                        ->whereMonth('la_date', $get_month)
                        ->whereYear('la_date', $year)
                        ->where('la_department_id', $department_id)
                        ->where('la_type', '2')
                        ->where('la_year_id', $this->getYearEndId())
                        ->groupBy('la_emp_id');
                }, 'extra_lect', 'extra_lect.la_emp_id', '=', 'financials_salary_info.si_user_id')
                ->leftJoinSub(function ($query) use ($get_month, $year, $department_id) {
                    $query->select(DB::raw('COUNT(la_attendance) AS total_absent'), 'la_emp_id')
                        ->from('lecturer_attendance')
                        ->where('la_attendance', 'A')
                        ->whereMonth('la_date', $get_month)
                        ->whereYear('la_date', $year)
                        ->where('la_department_id', $department_id)
                        ->where('la_type', '1')
                        ->where('la_year_id', $this->getYearEndId())
                        ->groupBy('la_emp_id');
                }, 'absent', 'absent.la_emp_id', '=', 'financials_salary_info.si_user_id')
                ->leftJoinSub(function ($query) use ($department_id) {
                    $query->select(DB::raw('COUNT(la_attendance) AS total_year_absent'), 'la_emp_id')
                        ->from('lecturer_attendance')
                        ->where('la_attendance', 'A')
                        ->where('la_department_id', $department_id)
                        ->where('la_type', '1')
                        ->where('la_year_id', $this->getYearEndId())
                        ->groupBy('la_emp_id');
                }, 'year_absent', 'year_absent.la_emp_id', '=', 'financials_salary_info.si_user_id')
                ->leftJoinSub(function ($query) use ($department_id) {
                    $query->select(DB::raw('COUNT(la_attendance) AS total_year_short_leave'), 'la_emp_id')
                        ->from('lecturer_attendance')
                        ->where('la_attendance', 'S.L')
                        ->where('la_department_id', $department_id)
                        ->where('la_type', '1')
                        ->where('la_year_id', $this->getYearEndId())
                        ->groupBy('la_emp_id');
                }, 'year_short_leave', 'year_short_leave.la_emp_id', '=', 'financials_salary_info.si_user_id')
                ->leftJoinSub(function ($query) use ($get_month, $year, $department_id) {
                    $query->select(DB::raw('COUNT(la_attendance) AS total_short_leave'), 'la_emp_id')
                        ->from('lecturer_attendance')
                        ->where('la_attendance', 'S.L')
                        ->whereMonth('la_date', $get_month)
                        ->whereYear('la_date', $year)
                        ->where('la_department_id', $department_id)
                        ->where('la_type', '1')
                        ->where('la_year_id', $this->getYearEndId())
                        ->groupBy('la_emp_id');
                }, 'short_leave', 'short_leave.la_emp_id', '=', 'financials_salary_info.si_user_id')
                ->where('account_department_id', $department_id)
                ->whereIn('account_parent_code', [41412])
                ->where('account_delete_status', '<>', 1)
                ->where('account_disabled', '<>', 1)
                ->where('financials_users.user_disabled', 0)
                ->groupBy('financials_users.user_name')
                ->select('account_name', 'account_uid', 'bal_total AS total_loan_amount', 'loan_instalment_amount', 'advance_salary', 'allowance', 'deduction', 'financials_salary_info.*', 'total_present', 'total_absent', 'total_extra_lecture', 'total_short_leave', 'total_year_absent', 'teacher_load.tl_extra_load_amount as extra_load_amount')
                ->get();

            return response()->json(compact('pay_accounts', 'generated'), 200);
        }
    }

    public function getAllowanceDeduction($userId)
    {
        $result = AllowanceDeductionModel::where('ad_employee_id', '=', $userId)->get();
        return response()->json($result);
    }

    // update code by shahzaib start
    public function generate_salary_slip_voucher_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $departments = Department::orderby('dep_title', 'ASC')->where('dep_clg_id', $user->user_clg_id)->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_month = (!isset($request->month) && empty($request->month)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->month;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_department = (isset($request->department) && !empty($request->department)) ? $request->department : '';
        $prnt_page_dir = 'print.grnerate_salary_slip_voucher.grnerate_salary_slip_voucher_list';
        $pge_title = 'Generate Salary Slip Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_month, $search_to, $search_from,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


//        $query = SalarySlipVoucherModel::query();
        $query = DB::table('financials_generate_salary_slip_voucher')
            ->where('gss_clg_id', $user->user_clg_id)
            ->leftJoin('financials_departments', 'financials_departments.dep_id', 'financials_generate_salary_slip_voucher.gss_department_id')
            ->where('dep_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_generate_salary_slip_voucher.gss_created_by');

        if (!empty($request->search)) {
            $query->where('gss_total_amount', 'like', ' % ' . $search . ' % ')
                ->orWhere('gss_month', 'like', ' % ' . $search . ' % ')
                ->orWhere('gss_remarks', 'like', ' % ' . $search . ' % ')
                ->orWhere('gss_id', 'like', ' % ' . $search . ' % ')
                ->orWhere('user_designation', 'like', ' % ' . $search . ' % ')
                ->orWhere('user_name', 'like', ' % ' . $search . ' % ')
                ->orWhere('user_username', 'like', ' % ' . $search . ' % ');
        }

        if (!empty($search_by_user)) {
            $query->where('gss_created_by', $search_by_user);
        }

        if (!empty($search_department)) {
            $query->where('gss_department_id', $search_department);
        }
        if (!empty($search_month)) {
            $query->where('gss_month', $search_month);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('ss_day_end_date', [$start, $end]);
            $query->whereDate('gss_day_end_date', ' >= ', $start)
                ->whereDate('gss_day_end_date', ' <= ', $end);
        } elseif (!empty($search_to)) {
            $query->where('gss_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('gss_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('gss_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('gss_year_id', '=', $search_year);
        }

        $datas = $query->orderBy('gss_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $search_year,$prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('generate_salary_slip_list', compact('datas', 'search', 'search_year','search_to', 'search_from', 'search_by_user', 'departments', 'search_department', 'search_month'));
        }

    }

    // update code by shahzaib end


    public function generate_salary_slip_items_view_details(Request $request)
    {
        $items = GenerateSalarySlipItemsModel::where('gssi_gss_id', $request->id)->get();

        return response()->json($items);
    }

    public function generate_salary_slip_items_view_details_SH(Request $request)
    {

        $slry_slp = GenerateSalarySlipModel::with('user')->where('gss_id', $request->id)->first();
        $emply = User::where('user_id', '=', $slry_slp->gss_created_by)->first();
        $items = DB::table('financials_generate_salary_slip_voucher_items')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_generate_salary_slip_voucher_items.gssi_employee_id')
            ->where('gssi_gss_id', $request->id)->select('financials_generate_salary_slip_voucher_items.*', 'financials_users.user_name')->orderBy('financials_users.user_name')->get();
        //  $items = GenerateSalarySlipItemsModel::where('gssi_gss_id', $request->id)->get();
        $nbrOfWrds = $this->myCnvrtNbr($slry_slp->gss_total_amount);
        $invoice_nbr = $slry_slp->gss_id;
//        $invoice_date = $slry_slp->ss_current_datetime;
        $invoice_date = $slry_slp->gss_day_end_date;
        $invoice_remarks = $slry_slp->gss_remarks;
        $type = 'grid';
        $pge_title = 'Generate Salary Slip Voucher';

        return view('voucher_view.generate_salary_slip_voucher.generate_salary_slip_voucher_list_modal', compact('items', 'slry_slp', 'emply', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'invoice_remarks'));

    }

    public function generate_salary_slip_items_view_details_pdf_SH(Request $request)
    {

        $slry_slp = GenerateSalarySlipModel::with('user')->where('gss_id', $request->id)->first();
        $emply = User::where('user_id', $slry_slp->gss_user_id)->first();
        $items = DB::table('financials_generate_salary_slip_voucher_items')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_generate_salary_slip_voucher_items.gssi_employee_id')
            ->where('gssi_gss_id', $request->id)->select('financials_generate_salary_slip_voucher_items.*', 'financials_users.user_name')->orderBy('financials_users.user_name')->get();
        $nbrOfWrds = $this->myCnvrtNbr($slry_slp->gss_total_amount);
        $invoice_nbr = $slry_slp->gss_id;
//        $invoice_date = $slry_slp->ss_current_datetime;
        $invoice_date = $slry_slp->gss_day_end_date;
        $invoice_remarks = $slry_slp->gss_remarks;
        $type = 'pdf';
        $pge_title = 'Generate Salary Slip Voucher';


        $footer = view('voucher_view._partials.pdf_footer')->render();
        $header = view('voucher_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type', 'invoice_remarks'))->render();
        $options = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ]);
        $optionss = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 24,
        ];
        $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($options, $optionss);
        $pdf->loadView('voucher_view.generate_salary_slip_voucher.generate_salary_slip_voucher_list_modal', compact('items', 'slry_slp', 'emply', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Generate-Salary-Slip-Voucher-Detail.pdf');

    }

    // update code by Mustafa start
    public function month_wise_salary_detail_list(Request $request, $array = null, $str = null)
    {

        $ar = json_decode($request->array);
        $search_month = (!isset($request->month) && empty($request->month)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->month;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.month_wise_salary_details_list.month_wise_salary_details_list';
        $pge_title = 'Salary Detail For The Month Of ' . $search_month;
        $srch_fltr = [];
        array_push($srch_fltr, $search_month);

        $pagination_number = (empty($ar)) ? 50 : 100000000;


        $query = DB::table('financials_generate_salary_slip_voucher_items as item')
            ->leftJoin('financials_departments', 'financials_departments.dep_id', 'item.gssi_department_id')
            ->select('item.gssi_id', 'financials_departments.dep_title', DB::raw('sum(item.gssi_gross_salary) as gross  ,sum(item.gssi_advance_salary) as advance,sum(item.gssi_net_salary) as net,sum(item.gssi_loan_installment_amount) as loan ,count(item.gssi_department_id) as employee'))
            ->groupBy('item.gssi_department_id')
            ->where('gssi_month_year', $search_month);


        if (!empty($search_by_user)) {
            $query->where('gssi_created_by', $search_by_user);
        }

        if (!empty($search_month)) {
            $query->where('gssi_month_year', $search_month);
        }


        $datas = $query->orderBy('financials_departments.dep_title', config('global_variables.drop_sorting'))
            ->paginate($pagination_number);

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
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
            return view('month_wise_salary_details_list', compact('datas', 'search_by_user', 'search_month'));
        }

    }

    // update code by Mustafa end

    public function allowance_deduction_items_view_details(Request $request)
    {
        $items = AllowanceDeductionModel::where('ad_employee_id', $request->id)->get();
        return response()->json($items);
    }

    public function allowance_deduction_items_view_details_SH(Request $request, $id, $month)
    {
        $items = AllowanceDeductionModel::leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_allowances_deductions.ad_employee_id')
            ->where('ad_employee_id', $id)
            ->whereRaw('? BETWEEN ad_start_month AND ad_end_month', [$month])
            ->select('financials_users.user_name', 'financials_allowances_deductions.*')
            ->get();
        $invoice_remarks = '';
        $type = 'grid';
        $pge_title = 'Allowance & Deduction Voucher';
        return view('voucher_view.generate_salary_slip_voucher.allowance_deduction_modal', compact('items', 'type', 'pge_title', 'invoice_remarks'));
    }
}
