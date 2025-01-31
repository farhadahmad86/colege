<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\College\PaidFeeVoucherController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Http\Requests\LoginRequest;
use App\Models\AccountRegisterationModel;
use App\Models\AdvanceFeeVoucher;
use App\Models\BalancesModel;
use App\Models\BankIntegration;
use App\Models\College\Branch;
use App\Models\College\CustomVoucherItemsModel;
use App\Models\College\CustomVoucherModel;
use App\Models\College\FeePaidVoucherModel;
use App\Models\College\FeeVoucherModel;
use App\Models\College\Student;
use App\Models\College\StudentBalances;
use App\Models\College\StudentInstallment;
use App\Models\College\TransportVoucherModel;
use App\Models\DayEndModel;
use App\Models\PostingReferenceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FeeApiController extends Controller
{
    public function post_voucher(Request $request)
    {

        try {
            $username = $request->input('username');

            $user = Auth::attempt([
                'user_username' => $username,
                'password' => $request->input('password')], false);
            if ($user) {
                // Validate the request data
                $validated = $request->validate([
                    'VoucherNo' => ['required', 'string'],
                    'amount' => ['required', 'string'],
                ]);

                $account = BankIntegration::pluck('bi_account_no')->first();
                $booking_amount = 0;
                $branch_id = Branch::pluck('branch_id')->first();
                $user = Auth::user();

                $date = Carbon::now();
                $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)->pluck('pr_id')->first();

                $total_voucher_amount = 0;
                $account_id = $account;
                $account_name = $this->account_name($account_id, $user);
                $accountsval = [];
                $entry_accountsval = [];
                $voucher_no_not_found = '';
                $registration_no_not_found = '';
                $voucher_paid_date = $date;
                $voucher_year_id = '';
                $fine_amount = 0;
                if (!empty($request->VoucherNo)) {
                    $query = Student::where('clg_id', $user->user_clg_id);
                    if (substr($request->VoucherNo, 0, 1) === "7" || substr($request->VoucherNo, 0, 1) === "3") {
                        $fee_voc = FeeVoucherModel::where('fv_v_no', $request->VoucherNo)->where('fv_clg_id', $user->user_clg_id)->where('fv_status_update', '=', 0)
                            ->first();
                        if (!empty($fee_voc)) {
                            $voucher_year_id = $fee_voc->fv_year_id;
                            $due_date = $fee_voc->fv_due_date;
                            $booking_amount = $fee_voc->fv_t_fee + $fee_voc->fv_p_fund + $fee_voc->fv_a_fund + $fee_voc->fv_z_fund;
                            $query->where('registration_no', $fee_voc->fv_std_reg_no);
                        }
                    } elseif (substr($request->VoucherNo, 0, 1) === "9") {
                        $fee_voc = CustomVoucherModel::where('cv_v_no', $request->VoucherNo)->where('cv_clg_id', $user->user_clg_id)->where('cv_status', '=', 'Pending')->first();
                        if (!empty($fee_voc)) {
                            $voucher_year_id = $fee_voc->cv_year_id;
                            $due_date = $fee_voc->cv_due_date;
                            $booking_amount = $fee_voc->cv_total_amount;
                            $query->where('registration_no', $fee_voc->cv_reg_no);
                        }
                        if (!empty($fee_voc)) {
                            $cv_items = CustomVoucherItemsModel::where('cvi_voucher_id', $fee_voc->cv_id)->get();
                        }
                    } elseif (substr($request->VoucherNo, 0, 1) === "5") {
                        $fee_voc = TransportVoucherModel::where('tv_v_no', $request->VoucherNo)->where('tv_clg_id', $user->user_clg_id)->where('tv_status', '=', 0)->first();
                        if (!empty($fee_voc)) {
                            $voucher_year_id = $fee_voc->tv_year_id;
                            $due_date = $fee_voc->tv_due_date;
                            $booking_amount = $fee_voc->tv_total_amount;
                            $query->where('registration_no', $fee_voc->tv_reg_no);
                        }
                    } elseif (substr($request->VoucherNo, 0, 1) === "4") {
                        $fee_voc = AdvanceFeeVoucher::where('afv_v_no', $request->VoucherNo)->where('afv_clg_id', $user->user_clg_id)->where('afv_status', '=', 1)->first();
                        if (!empty($fee_voc)) {
                            $voucher_year_id = $fee_voc->afv_year_id;
                            $due_date = $fee_voc->afv_due_date;
                            $booking_amount = $fee_voc->afv_t_fee + $fee_voc->afv_fund;
                            $query->where('registration_no', $fee_voc->afv_reg_no);
                        }
                    }
                    if (!empty($fee_voc)) {
                        $student = $query->select('id', 'full_name', 'registration_no', 'class_id')->first();
                        if (!empty($student)) {

                            if (substr($request->VoucherNo, 0, 1) === "7" || substr($request->VoucherNo, 0, 1) === "3") {
                                if ($fee_voc->fv_total_amount < $request->amount) {
                                    $fine_amount = $request->amount - $fee_voc->fv_total_amount;
                                }
                            } elseif (substr($request->VoucherNo, 0, 1) === "9") {
                                if ($fee_voc->cv_total_amount < $request->amount) {
                                    $fine_amount = $request->amount - $fee_voc->cv_total_amount;
                                }
                            } elseif (substr($request->VoucherNo, 0, 1) === "5") {
                                if ($fee_voc->tv_total_amount < $request->amount) {
                                    $fine_amount = $request->amount - $fee_voc->tv_total_amount;
                                }
                            } elseif (substr($request->VoucherNo, 0, 1) === "4") {
                                if ($fee_voc->afv_total_amount < $request->amount) {
                                    $fine_amount = $request->amount - $fee_voc->afv_total_amount;
                                }
                            }

                            $total_voucher_amount += $request->amount;

                            $student_id = $student->id;

                            $student_name = $student->full_name;
                            if (substr($request->VoucherNo, 0, 1) === "7" || substr($request->VoucherNo, 0, 1) === "3") {
                                $entry_accountsval[] = [
                                    'account_code' => '110201',
                                    'account_name' => '110201 - Tution Fee Receivable HO',
                                    'account_amount' => $fee_voc->fv_total_amount,
                                    'voucher_no' => $request->VoucherNo,
                                    'std_id' => $student_id,
                                    'reg_no' => $student->registration_no,
                                    'date' => $voucher_paid_date,
                                    'fine_account_code' => '311131',
                                    'fine_account_name' => '311131 - Fine Income HO',
                                    'fine_amount' => $fine_amount,
                                    'class' => $fee_voc->fv_class_id,
                                    'branch_id' => $fee_voc->fv_branch_id,
                                    'posting_reference' => $posting_reference,
                                    'total_account_amount' => $request->amount,
                                    'account_remarks' => '',
                                    'fee_voucher_id' => $fee_voc->fv_id,
                                    'installment_id' => $fee_voc->fv_installment_id,
                                ];
                                if ($fee_voc->fv_package_type == 1) {
                                    if ($fee_voc->fv_t_fee > 0) {
                                        $accountsval[] = [
                                            '0' => '110201',
                                            '1' => '110201 - Tution Fee Receivable HO',
                                            '2' => $fee_voc->fv_t_fee,
                                            '3' => 'Cr',
                                            '4' => $student->registration_no . ' - ' . $student_name,
                                            '5' => $posting_reference,
                                            '6' => $student_id,
                                            '7' => $student->registration_no,
                                            '8' => $fee_voc->fv_branch_id,
                                            '9' => $voucher_year_id,
                                        ];
                                    }
                                    if ($fee_voc->fv_p_fund > 0) {
                                        $accountsval[] = [
                                            '0' => '110202',
                                            '1' => '110202 - Paper Fund Receivable HO',
                                            '2' => $fee_voc->fv_p_fund,
                                            '3' => 'Cr',
                                            '4' => $student->registration_no . ' - ' . $student_name,
                                            '5' => $posting_reference,
                                            '6' => $student_id,
                                            '7' => $student->registration_no,
                                            '8' => $fee_voc->fv_branch_id,
                                            '9' => $voucher_year_id,
                                        ];
                                    }
                                    if ($fee_voc->fv_a_fund > 0) {
                                        $accountsval[] = [
                                            '0' => '110203',
                                            '1' => '110203 - Annual Fund Receivable HO',
                                            '2' => $fee_voc->fv_a_fund,
                                            '3' => 'Cr',
                                            '4' => $student->registration_no . ' - ' . $student_name,
                                            '5' => $posting_reference,
                                            '6' => $student_id,
                                            '7' => $student->registration_no,
                                            '8' => $fee_voc->fv_branch_id,
                                            '9' => $voucher_year_id,
                                        ];
                                    }
                                    if ($fee_voc->fv_z_fund > 0) {
                                        $accountsval[] = [
                                            '0' => '110201',
                                            '1' => '110201 - Tution Fee Receivable HO',
                                            '2' => $fee_voc->fv_z_fund,
                                            '3' => 'Cr',
                                            '4' => 'Zakat ' . $student->registration_no . ' - ' . $student_name,
                                            '5' => $posting_reference,
                                            '6' => $student_id,
                                            '7' => $student->registration_no,
                                            '8' => $fee_voc->fv_branch_id,
                                            '9' => $voucher_year_id,
                                        ];
                                    }
                                } elseif ($fee_voc->fv_package_type == 2) {
                                    $accountsval[] = [
                                        '0' => '110211', // change account number
                                        '1' => '110211 - Arrears Receivables - HO',
                                        '2' => $fee_voc->fv_total_amount,
                                        '3' => 'Cr',
                                        '4' => $student->registration_no . ' - ' . $student_name,
                                        '5' => $posting_reference,
                                        '6' => $student_id,
                                        '7' => $student->registration_no,
                                        '8' => $fee_voc->fv_branch_id,
                                        '9' => $voucher_year_id,
                                    ];
                                }
                            } elseif (substr($request->VoucherNo, 0, 1) === "9") {
                                foreach ($cv_items as $account) {
                                    $entry_accountsval[] = [
                                        'account_code' => $account->cvi_dr_account_id,
                                        'account_name' => $account->cvi_dr_account_name,
                                        'account_amount' => $account->cvi_amount,
                                        'voucher_no' => $request->VoucherNo,
                                        'std_id' => $student_id,
                                        'reg_no' => $student->registration_no,
                                        'date' => $voucher_paid_date,
                                        'fine_account_code' => '311131',
                                        'fine_account_name' => '311131 - Fine Income HO',
                                        'fine_amount' => $fine_amount,
                                        'class' => $fee_voc->cv_class_id,
                                        'branch_id' => $fee_voc->cv_branch_id,
                                        'posting_reference' => $posting_reference,
                                        'total_account_amount' => $request->amount,
                                        'account_remarks' => '',
                                        'fee_voucher_id' => $fee_voc->cv_id,
                                    ];
                                    if ($fee_voc->cv_package_type == 1) {
                                        $accountsval[] = [
                                            '0' => $account->cvi_dr_account_id,
                                            '1' => $account->cvi_dr_account_name,
                                            '2' => $account->cvi_amount,
                                            '3' => 'Cr',
                                            '4' => $student->registration_no . ' - ' . $student_name,
                                            '5' => $posting_reference,
                                            '6' => $student_id,
                                            '7' => $student->registration_no,
                                            '8' => $fee_voc->cv_branch_id,
                                            '9' => $voucher_year_id,
                                        ];
                                    } else if ($fee_voc->cv_package_type == 2) {
                                        $accountsval[] = [
                                            '0' => '110211', // change account number
                                            '1' => '110211 - Arrears Receivables - HO',
                                            '2' => $account->cvi_amount,
                                            '3' => 'Cr',
                                            '4' => $student->registration_no . ' - ' . $student_name,
                                            '5' => $posting_reference,
                                            '6' => $student_id,
                                            '7' => $student->registration_no,
                                            '8' => $fee_voc->cv_branch_id,
                                            '9' => $voucher_year_id,
                                        ];
                                    }
                                }
                            } elseif (substr($request->VoucherNo, 0, 1) === "5") {
                                $account_name = $this->get_account_name($fee_voc->tv_dr_account);
                                $entry_accountsval[] = [
                                    'account_code' => $fee_voc->tv_dr_account,
                                    'account_name' => $account_name,
                                    'account_amount' => $fee_voc->tv_total_amount,
                                    'voucher_no' => $request->VoucherNo,
                                    'std_id' => $student_id,
                                    'reg_no' => $student->registration_no,
                                    'date' => $voucher_paid_date,
                                    'fine_account_code' => '311131',
                                    'fine_account_name' => '311131 - Fine Income HO',
                                    'fine_amount' => $fine_amount,
                                    'class' => $student->class_id,
                                    'branch_id' => $fee_voc->tv_branch_id,
                                    'posting_reference' => $posting_reference,
                                    'total_account_amount' => $request->amount,
                                    'account_remarks' => '',
                                    'fee_voucher_id' => $fee_voc->tv_id,
                                ];
//                                            if ($fee_voc->cv_package_type == 1) {
                                $accountsval[] = [
                                    '0' => $fee_voc->tv_dr_account,
                                    '1' => $account_name,
                                    '2' => $fee_voc->tv_total_amount,
                                    '3' => 'Cr',
                                    '4' => $student->registration_no . ' - ' . $student_name,
                                    '5' => $posting_reference,
                                    '6' => $student_id,
                                    '7' => $student->registration_no,
                                    '8' => $fee_voc->tv_branch_id,
                                    '9' => $voucher_year_id,
                                ];
//                                            }
                            } elseif (substr($request->VoucherNo, 0, 1) === "4") {
                                $cr_account_name = $this->account_name('110101', $user);
                                $entry_accountsval[] = [
                                    'account_code' => '110101',
                                    'account_name' => '110101 - ' . $cr_account_name,
                                    'account_amount' => $fee_voc->afv_total_amount,
                                    'voucher_no' => $request->VoucherNo,
                                    'std_id' => $student_id,
                                    'reg_no' => $student->registration_no,
                                    'date' => $voucher_paid_date,
                                    'fine_account_code' => '311131',
                                    'fine_account_name' => '311131 - Fine Income HO',
                                    'fine_amount' => $fine_amount,
                                    'class' => $fee_voc->afv_class_id,
                                    'branch_id' => $fee_voc->afv_branch_id,
                                    'posting_reference' => $posting_reference,
                                    'total_account_amount' => $request->amount,
                                    'account_remarks' => '',
                                    'fee_voucher_id' => $fee_voc->afv_id,
                                ];

                                $accountsval[] = [
                                    '0' => '110101',
                                    '1' => '110101 - ' . $cr_account_name,
                                    '2' => $fee_voc->afv_total_amount,
                                    '3' => 'Cr',
                                    '4' => $student->registration_no . ' - ' . $student_name,
                                    '5' => $posting_reference,
                                    '6' => $student_id,
                                    '7' => $student->registration_no,
                                    '8' => $fee_voc->afv_branch_id,
                                    '9' => $voucher_year_id,
                                ];

                            }
                            if ($fine_amount > 0) {
                                $accountsval[] = [
                                    '0' => '311131',
                                    '1' => '311131 - Fine Income HO',
                                    '2' => $fine_amount,
                                    '3' => 'Cr',
                                    '4' => $student->registration_no . ' - ' . $student_name,
                                    '5' => $posting_reference,
                                    '6' => $student_id,
                                    '7' => $student->registration_no,
                                    '8' => $fee_voc->fv_branch_id,
                                    '9' => $voucher_year_id,
                                ];
                            }
                        } else {
                            return response()->json(['code' => 610, 'message' => 'The student was not found'], 401);
                        }
                    } else {
                        return response()->json(['message' => 'The challan was not found', 'code' => 620], 404);
                    }
                    $currentDate = Carbon::now();
                    $ddueDate = Carbon::parse($due_date);
                    $AmountAfterDueDate=$booking_amount;
                    if ($ddueDate < $currentDate) {
                        $daysAfterDueDate = $currentDate->diffInDays($ddueDate, false);
                        $daysAfterDueDate = abs($daysAfterDueDate);
                        $AmountAfterDueDate = $booking_amount + ($daysAfterDueDate * 20);
                    }
                }

                if ($AmountAfterDueDate != $request->amount) {
                    return response()->json(['message' => 'The received amount did not match with the fee slip balance', 'code' => 632], 404);
                }

                if (!empty($entry_accountsval)) {
                    $accountsval[] = [
                        '0' => $account_id,
                        '1' => $account_id . ' - ' . $account_name,
                        '2' => $total_voucher_amount,
                        '3' => 'Dr',
                        '4' => '',
                        '5' => $posting_reference,
                        '6' => '',
                        '7' => '',
                        '8' => $branch_id,
                        '9' => $voucher_year_id,
                    ];
                }

                if (!empty($accountsval)) {
                    $rollBack = false;
                    $transaction_ids = 0;
                    $account_uid = $account;
                    $account_name_text = $account_uid . ' - ' . $this->account_name($account_uid, $user);
                    $voucher_remarks = '';
                    $status = '';

                    $notes = 'FEE_PAID_VOUCHER';
                    $voucher_code = config('global_variables.FEE_PAID_VOUCHER_CODE');
                    $transaction_type = config('global_variables.FEE_PAID');


                    $get_day_end = new DayEndController();
                    $day_end = $get_day_end->day_end($user);
                    DB::beginTransaction();

                    $fpv = new FeePaidVoucherModel();
                    $fpv_v_no = FeePaidVoucherModel::where('fpv_clg_id', $user->user_clg_id)->count();

                    $fpv = $this->assign_fee_voucher_values('fpv', $fpv_v_no + 1, $fpv, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status, $voucher_paid_date
                    );

                    // system config set increment default id according to user giving start coding$status
                    $sstm_cnfg_clm = 'sc_fee_voucher_number';
                    $sstm_cnfg_fpv_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
                    $chk_fee_pymnt = FeePaidVoucherModel::where('fpv_clg_id', '=', $user->user_clg_id)->get();
                    if ($chk_fee_pymnt->isEmpty()):
                        if (isset($sstm_cnfg_fpv_id_chk) && !empty($sstm_cnfg_fpv_id_chk)):
                            $fpv->fpv_id = $sstm_cnfg_fpv_id_chk->$sstm_cnfg_clm;
                        endif;
                    endif;
                    // system config set increment default id according to user giving end coding

                    if ($fpv->save()) {
                        $fpv_id = $fpv->fpv_id;
                        $fpv_voucher_no = $fpv->fpv_v_no;
                    } else {
                        $rollBack = true;
                        DB::rollBack();
                        return response()->json('fail', 'Failed');
                    }

                    $detail_remarks = '';

                    $paid_voucher = new PaidFeeVoucherController();

                    $item = $paid_voucher->paid_voucher_items_values($entry_accountsval, $fpv_id, $fpv_voucher_no, 'fpvi');

                    foreach ($item as $value) {
                        $fpvi_amount = (float)$value['fpvi_amount'];
                        $fpvi_fine_amount = (float)$value['fpvi_fine_amount'];
                        $fpvi_total_amount = (float)$value['fpvi_total_amount'];
                        if ($fpvi_fine_amount > 0) {
                            $detail_remarks .= $value['fpvi_account_name'] . ', @' . number_format($fpvi_amount, 2) . ' - ' . $value['fpvi_fine_account_name'] . ',' . number_format($fpvi_fine_amount, 2) . '= @'
                                . $fpvi_total_amount . config('global_variables.Line_Break');
                        } else {
                            $detail_remarks .= $value['fpvi_account_name'] . ', @' . number_format($fpvi_amount, 2) . config('global_variables.Line_Break');
                        }
                    }


                    if (!DB::table('financials_fee_paid_voucher_items')->insert($item)) {
                        $rollBack = true;
                        DB::rollBack();
                        return response()->json('fail', 'Failed');
                    }

                    $fpv->fpv_detail_remarks = $detail_remarks;
                    if (!$fpv->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return response()->json('fail', 'Failed');
                    }

                    foreach ($accountsval as $key) {

                        $transaction = new TransactionModel();

                        if ($key[3] == 'Dr') {

                            $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $fpv_id);

                            if ($transaction->save()) {

                                $transaction_id = $transaction->trans_id;
                                $balances = new BalancesModel();

                                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code .
                                    $fpv_id, $key[5], $voucher_code . $fpv->fpv_v_no, $key[9], $key[8]);

                                if (!$balance->save()) {

                                    $flag = true;
                                    DB::rollBack();
                                    return response()->json('fail', 'Failed');
                                }

                            } else {
                                DB::rollBack();
                                return response()->json('fail', 'Failed');
                            }

                        } else {

                            $transaction = $this->AssignTransactionsValues($transaction, 0, $key[2], $key[0], $notes, 5, $fpv_id);
                            if ($transaction->save()) {
                                $transaction_id = $transaction->trans_id;
                                $balances = new BalancesModel();
                                $detail_entry_remarks = $key[1] . ' to ' . $account_id . ' - ' . $account_name . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break');
                                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_entry_remarks, $voucher_code .
                                    $fpv_id, $key[5], $voucher_code . $fpv->fpv_v_no, $key[9], $key[8]);

                                if (!$balance->save()) {
                                    $flag = true;
                                    DB::rollBack();
                                    return response()->json('fail', 'Failed');
                                }
                                // student balance table entry start
                                if ($key[0] != 311131) {
                                    $std_balances = new StudentBalances();

                                    $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], $key[3],
                                        $notes, $account_name_text . ' to ' . $key[1] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
                                        $voucher_code . $fpv_id, $key[6], $key[7], $key[8]);
                                    if (!$std_balances->save()) {
                                        $rollBack = true;
                                        DB::rollBack();
                                        return response()->json('fail', 'Failed');
                                    }
                                }
                                // student balance table entry end
                            } else {
                                DB::rollBack();
                                return response()->json('fail', 'Failed');
                            }
                        }
                    }

                    foreach ($entry_accountsval as $arry) {
                        if (substr($arry['voucher_no'], 0, 1) === "9") {

                            $fee_voc = CustomVoucherModel::where('cv_id', $arry['fee_voucher_id'])->where('cv_clg_id', $user->user_clg_id)->where('cv_status', '=', 'Pending')->first();
                            if (!empty($fee_voc)) {
                                $fee_voc->cv_status = 'Paid';
                                $fee_voc->cv_fine = $arry['fine_amount'];
                                $fee_voc->cv_paid_date = $voucher_paid_date;
                                $fee_voc->cv_posted_by = $user->user_id;
                                $fee_voc->save();
                            }
                        } elseif (substr($arry['voucher_no'], 0, 1) === "7" || substr($arry['voucher_no'], 0, 1) === "3") {
                            $fee_voc = FeeVoucherModel::where('fv_id', $arry['fee_voucher_id'])->where('fv_std_reg_no', $arry['reg_no'])->where('fv_clg_id', $user->user_clg_id)->where('fv_status_update', '=', 0)->first();

                            $fee_voc->fv_status_update = 1;
                            $fee_voc->fv_fine = $arry['fine_amount'];
                            $fee_voc->fv_paid_date = $voucher_paid_date;
                            $fee_voc->save();
                            $fee_installment = StudentInstallment::where('si_id', $arry['installment_id'])->where('si_clg_id', $user->user_clg_id)->first();
                            $fee_installment->si_status_update = 1;
                            $fee_installment->save();
                        } elseif (substr($arry['voucher_no'], 0, 1) === "5") {
                            $fee_voc = TransportVoucherModel::where('tv_id', $arry['fee_voucher_id'])->where('tv_clg_id', $user->user_clg_id)->where('tv_status', '=', 0)->first();
                            if (!empty($fee_voc)) {
                                $fee_voc->tv_status = 1;
                                $fee_voc->tv_fine = $arry['fine_amount'];
                                $fee_voc->tv_paid_date = $voucher_paid_date;
                                $fee_voc->tv_posted_by = $user->user_id;
                                $fee_voc->save();
                            }
                        } elseif (substr($arry['voucher_no'], 0, 1) === "4") {
                            $fee_voc = AdvanceFeeVoucher::where('afv_id', $arry['fee_voucher_id'])->where('afv_clg_id', $user->user_clg_id)->where('afv_status', '=', 1)->first();
                            if (!empty($fee_voc)) {
                                $fee_voc->afv_status = 2;
                                $fee_voc->afv_fine = $arry['fine_amount'];
                                $fee_voc->afv_paid_date = $voucher_paid_date;
                                $fee_voc->afv_posted_by = $user->user_id;
                                $fee_voc->save();
                            }
                        }
                    }

                    if ($rollBack) {

                        DB::rollBack();
                        return response()->json('fail', 'Failed');
                    } else {

                        DB::commit();

                        return response()->json(['message' => 'The requested operation was completed successfully.', 'code' => 200]);
                    }

                } else {
                    return response()->json(['message' => 'The challan was not found', 'code' => 620], 404);
                }

                // Return a JSON response
                return response()->json([
                    'success' => true,
                    'message' => 'The requested operation  was completed successfully', 'code' => 200
                ], 201); // 201 status code for created resource

            } else {
                return response()->json(['code' => 605, 'message' => 'The intended operation is not Authorized to the API'], 401);
            }
        } catch (ValidationException $e) {
            // Return a JSON response with validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $e->errors(),
            ], 422); // 422 status code for validation errors
        }
    }


    public function account_name($account_id, $user)
    {
        $account_name = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_uid', $account_id)->pluck('account_name')->first();

        return $account_name;
    }

    public function assign_fee_voucher_values($prfx, $voucher_number, $voucher, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status, $voucher_paid_date)
    {

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $v_no = $prfx . '_v_no';
        $account_id = $prfx . '_account_id';
        $paid_date = $prfx . '_voucher_paid_date';
        $total_amount = $prfx . '_total_amount';
        $remarks = $prfx . '_remarks';
        $created_datetime = $prfx . '_created_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $v_status = $prfx . '_status';
        $posted_by = $prfx . '_posted_by';


        $voucher->$v_no = $voucher_number;
        $voucher->$account_id = $account_uid;
        $voucher->$paid_date = $voucher_paid_date;
        $voucher->$total_amount = $total_voucher_amount;
        $voucher->$remarks = $voucher_remarks;
        $voucher->$created_datetime = Carbon::now()->toDateTimeString();
        $voucher->$day_end_id = $day_end->de_id;
        $voucher->$day_end_date = $day_end->de_datetime;
        $voucher->$createdby = $user->user_id;
        $voucher->$clg_id = $user->user_clg_id;
        $voucher->$branch_id = Branch::pluck('branch_id')->first();
        $voucher->$brwsr_info = $brwsr_rslt;
        $voucher->$ip_adrs = $ip_rslt;
        $voucher->$v_status = $status;
        return $voucher;
    }

    public function day_end($user)
    {

        $date = DayEndModel::where('de_clg_id', $user->user_clg_id)->orderBy('de_id', 'DESC')->first();//where('de_datetime_status', 'OPEN')->

        if ($date === null) {
            $date = (object)array(
                "de_id" => "0",
                "de_datetime" => date("Y-m-d"),
            );
        }
        return $date;
    }

    public function bill_inquiry(Request $request)
    {
        $username = $request->input('username');

        $user = Auth::attempt([

            'user_username' => $username,
            'password' => $request->input('password')], false);
        if ($user) {

            $fee_voc = '';
            $total_amount = 0;
            $status = 0;
            $month = 0;
            $AmountAfterDueDate = 0;

            if (substr($request->VoucherNo, 0, 1) === "7" || substr($request->VoucherNo, 0, 1) === "3") {
                $fee_voc = FeeVoucherModel::where('fv_v_no', $request->VoucherNo)
                    ->select('fv_due_date as due_date', 'fv_month as month', 'fv_t_fee as t_fee', 'fv_p_fund as p_fund', 'fv_a_fund as a_fund', 'fv_status_update as status', 'fv_std_reg_no as reg_no')
                    ->first();
                if ($fee_voc) {
                    $total_amount = $fee_voc->t_fee + $fee_voc->p_fund + $fee_voc->a_fund;
                    $status = $fee_voc->status == 0 ? 'U' : 'P';
                    $month = $fee_voc->month;
                }

            } elseif (substr($request->VoucherNo, 0, 1) === "9") {
                $fee_voc = CustomVoucherModel::where('cv_v_no', $request->VoucherNo)
                    ->select('cv_due_date as due_date', 'cv_created_datetime as month', 'cv_total_amount', 'cv_status as status', 'cv_reg_no as reg_no')
                    ->first();
                if ($fee_voc) {
                    $total_amount = $fee_voc->cv_total_amount;
                    $status = $fee_voc->status == 'Pending' ? 'U' : 'P';
                    $eventDate = Carbon::parse($fee_voc->month);
                    $mah = $eventDate->format('m');
                    $year = $eventDate->format('Y');
                    $month = $year . $mah;
                }
            } elseif (substr($request->VoucherNo, 0, 1) === "5") {
                $fee_voc = TransportVoucherModel::where('tv_v_no', $request->VoucherNo)
                    //->where('tv_status', '=', 0)
                    ->select('tv_due_date as due_date', 'tv_month as month', 'tv_total_amount as amount', 'tv_status as status', 'tv_reg_no as reg_no')
                    ->first();
                if ($fee_voc) {
                    $total_amount = $fee_voc->amount;
                    $status = $fee_voc->status == 0 ? 'U' : 'P';
                    $month = $fee_voc->month;
                }

            } elseif (substr($request->VoucherNo, 0, 1) === "4") {
                $fee_voc = AdvanceFeeVoucher::where('afv_v_no', $request->VoucherNo)
                    //->where('afv_status', '!=', 3)
                    ->select('afv_due_date as due_date', 'afv_created_datetime as month', 'afv_t_fee', 'afv_fund', 'afv_status as status', 'afv_reg_no as reg_no')
                    ->first();
                if ($fee_voc) {
                    $total_amount = $fee_voc->afv_t_fee + $fee_voc->afv_fund;
                    $status = $fee_voc->status == 1 ? 'U' : ($fee_voc->status == 2 ? 'P':'R');
                    $eventDate = Carbon::parse($fee_voc->month);
                    $mah = $eventDate->format('m');
                    $year = $eventDate->format('Y');
                    $month = $year . $mah;
                }
            }
            if ($fee_voc) {
                $student = Student::where('registration_no', '=', $fee_voc->reg_no)->where('status', '!=', 3)->first();
                if ($student) {
                    if ($status == 'U') {
                        $data = [];
                        $MessageCode = "00";
                        $currentDate = Carbon::now();
                        $dueDate = Carbon::parse($fee_voc->due_date);
                        $AmountAfterDueDate = $total_amount;
                        if ($dueDate < $currentDate) {
                            $daysAfterDueDate = $currentDate->diffInDays($dueDate, false);
                            $daysAfterDueDate = abs($daysAfterDueDate);
                            $AmountAfterDueDate = $total_amount + ($daysAfterDueDate * 20);
                        }


                        $student = Student::where('registration_no', $fee_voc->reg_no)->pluck('full_name')->first();
                        $data[] = [
                            'MessageCode' => $MessageCode,
                            'StudentName' => $student,
                            'VoucherNo' => $request->VoucherNo,
                            'Amount' => $total_amount,
                            'DueDate' => $fee_voc->due_date,
                            'BillingMonth' => $month,
                            'AmountAfterDueDate' => $AmountAfterDueDate,
                            'BillStatus' => $status,
                        ];
                        return response()->json(['code' => 200, 'message' => 'The requested operation was completed successfully', 'data' => $data], 200);
//                        } else {
//                            $data[] = [
//                                'MessageCode' => "01",
//                                'StudentName' => '',
//                                'VoucherNo' => $request->VoucherNo,
//                                'Amount' => '',
//                                'DueDate' => '',
//                                'BillingMonth' => '',
//                                'AmountAfterDueDate' => '',
//                                'BillStatus' => '',
//                            ];
//                        }
                    } else {
                        return response()->json(['code' => 621, 'message' => 'The challan is already paid'], 404);
                    }
                } else {
                    return response()->json(['code' => 611, 'message' => 'The student is disabled by the institute'], 404);
                }
            } else {
                return response()->json(['code' => 620, 'message' => 'The challan was not found'], 404);
            }
//
        } else {
            return response()->json(['code' => 605, 'message' => 'The intended operation is not Authorized to the API'], 401);

        }
    }

}
