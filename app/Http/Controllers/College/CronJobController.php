<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Models\BalancesModel;
use App\Models\College\Student;
use App\Models\College\StudentBalances;
use App\Models\College\StudentsPackageModel;
use App\Models\DayEndModel;
use App\Models\PostingReferenceModel;
use App\Models\TransactionModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CronJobController extends Controller
{
    public function every_month_auto_income_entry($college_id)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->format('Y');
        $user = User::where('user_clg_id',$college_id)->select('user_id','user_branch_id')->first();
        $packages = StudentsPackageModel:: where('sp_clg_id', $college_id)->where('sp_start_m', '>=', $currentMonth)->where('sp_start_y', '>=', $currentYear)->get();
        $posting_reference = PostingReferenceModel::where('pr_clg_id', $college_id)->pluck('pr_id')->first();

        $day_end = DayEndModel::where('de_clg_id',$college_id)->orderBy('de_id', 'DESC')->first();//where('de_datetime_status', 'OPEN')->


        $voucher_remarks = '';
        $rollBack = false;
        $flag = false;

        $total_voucher_amount = 0;
        DB::beginTransaction();

        foreach ($packages as $account) {
            $values_array = [];
            $total_voucher_amount += $account->sp_t_month_income + $account->sp_p_month_income + $account->sp_a_month_income;
            $student_name = Student::where('id', $account->sp_sid)->pluck('full_name')->first();
            if ($account->sp_t_month_income > 0) {
                $values_array[] = [
                    '0' => '210131',
                    '1' => '210131 - Unearned Tution Fee HO',
                    '2' => $account->sp_t_month_income,
                    '3' => 'Dr',
                    '4' => $account->sp_std_reg . ' - ' . $student_name,
                    '5' => $posting_reference,

                ];
                $values_array[] = [
                    '0' => '310111',
                    '1' => '310111 - Tution Fee Income HO',
                    '2' => $account->sp_t_month_income,
                    '3' => 'Cr',
                    '4' => $account->sp_std_reg . ' - ' . $student_name,
                    '5' => $posting_reference,
                ];
            }
            if ($account->sp_p_month_income > 0) {
                $values_array[] = [
                    '0' => '210132',
                    '1' => '210132 - Unearned Paper Fund HO',
                    '2' => $account->sp_p_month_income,
                    '3' => 'Dr',
                    '4' => $account->sp_std_reg . ' - ' . $student_name,
                    '5' => $posting_reference,

                ];
                $values_array[] = [
                    '0' => '310112',
                    '1' => '310112 - Paper Fee Income HO',
                    '2' => $account->sp_p_month_income,
                    '3' => 'Cr',
                    '4' => $account->sp_std_reg . ' - ' . $student_name,
                    '5' => $posting_reference,
                ];
            }
            if ($account->sp_a_month_income > 0) {
                $values_array[] = [
                    '0' => '210133',
                    '1' => '210133 - Unearned Annual Fund HO',
                    '2' => $account->sp_a_month_income,
                    '3' => 'Dr',
                    '4' => $account->sp_std_reg . ' - ' . $student_name,
                    '5' => $posting_reference,
                ];
                $values_array[] = [
                    '0' => '310113',
                    '1' => '310113 - Annual Fee Income HO',
                    '2' => $account->sp_a_month_income,
                    '3' => 'Cr',
                    '4' => $account->sp_std_reg . ' - ' . $student_name,
                    '5' => $posting_reference,
                ];
            }

            $notes = 'INCOME_VOUCHER';
            $voucher_code = 'STD';
            $transaction_type = config('global_variables.INCOME_VOUCHER');

            $cv_id = $account->sp_sid;
            $cv_voucher_no = $account->sp_std_reg;

            $detail_remarks = '';

            foreach ($values_array as $key) {

                $transaction = new TransactionModel();

                if ($key[3] == 'Dr') {

                    $transaction = $this->AssignsTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $cv_id, $college_id, $day_end, $user);

                    if ($transaction->save()) {

                        $transaction_id = $transaction->trans_id;
                        $balances = new BalancesModel();

                        $balance = $this->AssignsAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code .
                            $cv_id, $key[5], $voucher_code . $cv_voucher_no, $college_id, $day_end, $user );

                        if (!$balance->save()) {

                            $flag = true;
                            DB::rollBack();
                            return response()->json(['fail'=>'Failed']);
                        }

                        // student balance table entry start
                        $std_balances = new StudentBalances();

                        $std_balances = $this->AssignsStudentBalancesValues($std_balances, $key[0], $key[2], 'Dr',
                            $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
                            $voucher_code . $cv_id, $account->sp_sid, $account->sp_std_reg, $college_id, $day_end, $user);
                        if (!$std_balances->save()) {
                            $flag = true;
                            DB::rollBack();
                            return response()->json(['fail'=>'Failed']);
                        }

                        // student balance table entry end

                    } else {
                        DB::rollBack();
                        return response()->json(['fail'=>'Failed']);
                    }

                } else {

                    $transaction = $this->AssignsTransactionsValues($transaction, 0, $key[2], $key[0], 'INCOME VOUCHER', 5, $cv_id,$college_id, $day_end, $user);
                    if ($transaction->save()) {
                        $transaction_id = $transaction->trans_id;
                        $balances = new BalancesModel();

                        $balance = $this->AssignsAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code .
                            $cv_id, $key[5], $voucher_code . $cv_voucher_no,$college_id,$day_end, $user);

                        if (!$balance->save()) {
                            $flag = true;
                            DB::rollBack();
                            return response()->json(['fail'=>'Failed']);
                        }

                    } else {
                        DB::rollBack();
                        return response()->json(['fail'=>'Failed']);
                    }
                }
            }


            if ($flag) {
                DB::rollBack();
                return response()->json(['fail'=>'Failed']);
            } else {

            }

        }

        if ($flag) {

            DB::rollBack();
            return response()->json(['fail'=>'Failed']);
        } else {

            DB::commit();
            return response()->json(['success'=>'Successfully Saved!']);
            //            return redirect()->back()->with(['cv_id' => $cv_id, 'success' => 'Successfully Saved']);
        }
    }

    public function AssignsTransactionsValues($transaction, $dr_account, $amount, $cr_account, $notes, $type, $entry_id = 0, $college_id, $day_end, $user)
    {
        $transaction->trans_type = $type;
        $transaction->trans_dr = $dr_account;
        $transaction->trans_cr = $cr_account;
        $transaction->trans_amount = $amount;
        $transaction->trans_notes = $notes;
        $transaction->trans_datetime = Carbon::now()->toDateTimeString();
        $transaction->trans_entry_id = $entry_id;
        $transaction->trans_clg_id = $college_id;
        $transaction->trans_branch_id = $user->user_branch_id;

        // coding from shahzaib start
        $tbl_var_name = 'transaction';
        $prfx = 'trans';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end

        return $transaction;
    }

    public function AssignsAccountBalancesValues($balance, $transaction_id, $account, $amount, $type, $remarks, $transaction_type, $detail_remarks, $voucher_id, $posting_ref_id, $voucher_no,
                                                 $college_id, $day_end, $user)
    {

        $account_head = substr($account, 0, 1);
        $debit_amount = 0;
        $credit_amount = 0;

        $previous_balance = $this->calculate_accounts_balance($account,$college_id);

        // if ($account_head == config('global_variables.assets') || $account_head == config('global_variables.expense')) {

        if ($type == 'Dr') {
            $total_balance = $previous_balance + $amount;
            $debit_amount = $amount;

        } else {
            $total_balance = $previous_balance - $amount;
            $credit_amount = $amount;
        }

        // }
        // elseif ($account_head == config('global_variables.liabilities') || $account_head == config('global_variables.revenue') || $account_head == config('global_variables.equity')) {

        //     if ($type == 'Dr') {

        //         $total_balance = $previous_balance - $amount;
        //         $debit_amount = $amount;
        //     } else {
        //         $total_balance = $previous_balance + $amount;
        //         $credit_amount = $amount;
        //     }

        // }

        $balance->bal_account_id = $account;
        $balance->bal_transaction_type = $transaction_type;
        $balance->bal_remarks = ucfirst($remarks);
        $balance->bal_dr = $debit_amount;
        $balance->bal_cr = $credit_amount;
        $balance->bal_total = $total_balance;
        $balance->bal_transaction_id = $transaction_id;
        $balance->bal_datetime = Carbon::now()->toDateTimeString();
        $balance->bal_day_end_id = $day_end->de_id;
        $balance->bal_day_end_date = $day_end->de_datetime;
        $balance->bal_detail_remarks = $detail_remarks;
        $balance->bal_voucher_number = $voucher_id;
        $balance->bal_v_no = $voucher_no;
        $balance->bal_user_id = $user->user_id;
        $balance->bal_pr_id = $posting_ref_id;
        $balance->bal_clg_id = $college_id;
        $balance->bal_branch_id = $user->user_branch_id;

        // coding from shahzaib start
        $tbl_var_name = 'balance';
        $prfx = 'bal';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $balance;
    }

    public function calculate_students_balance($student_id, $college_id)
    {
        $total = StudentBalances::where('sbal_clg_id', $college_id)->where('sbal_student_id', $student_id)->orderBy('sbal_id', 'DESC')->pluck('sbal_total')->first();

        return $total;
    }
    //entry in student balance table
    public function AssignsStudentBalancesValues($balance, $account, $amount, $type, $transaction_type, $detail_remarks, $voucher_id,$student_id, $registration_number, $college_id, $day_end, $user)
    {

        $debit_amount = 0;
        $credit_amount = 0;

        $previous_balance = $this->calculate_students_balance($student_id, $college_id);

        // if ($account_head == config('global_variables.assets') || $account_head == config('global_variables.expense')) {

        if ($type == 'Dr') {
            $total_balance = $previous_balance + $amount;
            $debit_amount = $amount;

        } else {
            $total_balance = $previous_balance - $amount;
            $credit_amount = $amount;
        }

        $balance->sbal_student_id = $student_id;
        $balance->sbal_registration_no = $registration_number;
        $balance->sbal_account_id = $account;
        $balance->sbal_transaction_type = $transaction_type;
        $balance->sbal_dr = $debit_amount;
        $balance->sbal_cr = $credit_amount;
        $balance->sbal_total = $total_balance;

        $balance->sbal_datetime = Carbon::now()->toDateTimeString();

        $balance->sbal_detail_remarks = $detail_remarks;
        $balance->sbal_voucher_number = $voucher_id;

        $balance->sbal_user_id = $user->user_id;
        $balance->sbal_clg_id = $college_id;
        $balance->sbal_branch_id = $user->user_branch_id;

        // coding from shahzaib start
        $tbl_var_name = 'balance';
        $prfx = 'sbal';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();;

        // coding from shahzaib end

        return $balance;
    }


    public function calculate_accounts_balance($account_uid, $college_id)
    {

        $total = BalancesModel::where('bal_clg_id', $college_id)->where('bal_account_id', $account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();

        return $total;
    }
}
