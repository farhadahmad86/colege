<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Imports\ExcelDataImport;
use App\Models\AccountRegisterationModel;
use App\Models\AdvanceFeeVoucher;
use App\Models\BalancesModel;
use App\Models\College\CustomVoucherItemsModel;
use App\Models\College\CustomVoucherModel;
use App\Models\College\FeePaidVoucherItemsModel;
use App\Models\College\FeePaidVoucherModel;
use App\Models\College\FeeVoucherModel;
use App\Models\College\Student;
use App\Models\College\StudentBalances;
use App\Models\College\StudentInstallment;
use App\Models\College\StudentInstallmentItems;
use App\Models\College\TransportVoucherModel;
use App\Models\PostingReferenceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PaidFeeVoucherController extends Controller
{
    public function fee_paid_voucher()
    {
        return view('collegeViews.feePaidVoucher.fee_paid_voucher');
    }

    public function submit_fee_paid_voucher_excel(Request $request)
    {
        $rules = [
            'add_fee_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_fee_excel.max' => "Your File size too long.",
            'add_fee_excel.required' => "Please select your Area Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);
        $user = Auth::user();
        $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)->pluck('pr_id')->first();
        if ($request->hasFile('add_fee_excel')) {

            $path = $request->file('add_fee_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            $total_voucher_amount = 0;
            $account_id = $request->account;
            $account_name = $this->get_account_name($account_id);
            $accountsval = [];
            $entry_accountsval = [];
            $voucher_no_not_found = '';
            $registration_no_not_found = '';
            $voucher_paid_date = '';
            $voucherBranchId = '';
            $voucher_year_id = '';

            foreach ($data as $key => $value) {
                foreach ($excelData as $rows) {
                    foreach ($rows as $row) {
                        $rowData = (array)$row;
                        $request->merge($rowData);
                        $fine_amount = 0;
                        if (!empty($request->voucher_no)) {
                            if (substr($request->voucher_no, 0, 1) === "7" || substr($request->voucher_no, 0, 1) === "3") {
                                $fee_voc = FeeVoucherModel::where('fv_v_no', $request->voucher_no)->where('fv_std_reg_no', $request->std_id)->where('fv_clg_id', $user->user_clg_id)->where('fv_status_update', '=', 0)->first();
                                if (!empty($fee_voc)) {
                                    $voucherBranchId = $fee_voc->fv_branch_id;
                                    $voucher_year_id = $fee_voc->fv_year_id;
                                }
                            } elseif (substr($request->voucher_no, 0, 1) === "9") {
                                $fee_voc = CustomVoucherModel::where('cv_v_no', $request->voucher_no)->where('cv_reg_no', $request->std_id)->where('cv_clg_id', $user->user_clg_id)->where('cv_status', '=', 'Pending')->first();
                                if (!empty($fee_voc)) {
                                    $cv_items = CustomVoucherItemsModel::where('cvi_voucher_id', $fee_voc->cv_id)->get();
                                    $voucherBranchId = $fee_voc->cv_branch_id;
                                    $voucher_year_id = $fee_voc->cv_year_id;
                                }
                            } elseif (substr($request->voucher_no, 0, 1) === "5") {
                                $fee_voc = TransportVoucherModel::where('tv_v_no', $request->voucher_no)->where('tv_reg_no', $request->std_id)->where('tv_clg_id', $user->user_clg_id)->where('tv_status', '=', 0)->first();
                                if (!empty($fee_voc)) {
                                    $voucherBranchId = $fee_voc->tv_branch_id;
                                    $voucher_year_id = $fee_voc->tv_year_id;
                                }
                            }

                            if (!empty($fee_voc)) {
                                $student = Student::where('registration_no', $request->std_id)->where('clg_id', $user->user_clg_id)->select('id', 'full_name', 'class_id')->first();
                                if (!empty($student)) {
                                    if (substr($request->voucher_no, 0, 1) === "7" || substr($request->voucher_no, 0, 1) === "3") {
                                        if ($fee_voc->fv_total_amount < $request->amount) {
                                            $fine_amount = $request->amount - $fee_voc->fv_total_amount;
                                        }
                                    } elseif (substr($request->voucher_no, 0, 1) === "9") {
                                        if ($fee_voc->cv_total_amount < $request->amount) {
                                            $fine_amount = $request->amount - $fee_voc->cv_total_amount;
                                        }
                                    } elseif (substr($request->voucher_no, 0, 1) === "5") {
                                        if ($fee_voc->tv_total_amount < $request->amount) {
                                            $fine_amount = $request->amount - $fee_voc->tv_total_amount;
                                        }
                                    }
                                    $total_voucher_amount += $request->amount;
                                    $voucher_paid_date = date('Y-m-d', strtotime($request->date));
                                    $student_id = $student->id;
                                    $student_name = $student->full_name;
                                    if (substr($request->voucher_no, 0, 1) === "7" || substr($request->voucher_no, 0, 1) === "3") {
                                        $entry_accountsval[] = [
                                            'account_code' => '110201',
                                            'account_name' => '110201 - Tution Fee Receivable HO',
                                            'account_amount' => $fee_voc->fv_total_amount,
                                            'voucher_no' => $request->voucher_no,
                                            'std_id' => $student_id,
                                            'reg_no' => $request->std_id,
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
                                                    '4' => $request->std_id . ' - ' . $student_name,
                                                    '5' => $posting_reference,
                                                    '6' => $student_id,
                                                    '7' => $request->std_id,
                                                    '8' => $voucherBranchId,
                                                    '9' => $voucher_year_id,
                                                ];
                                            }
                                            if ($fee_voc->fv_p_fund > 0) {
                                                $accountsval[] = [
                                                    '0' => '110202',
                                                    '1' => '110202 - Paper Fund Receivable HO',
                                                    '2' => $fee_voc->fv_p_fund,
                                                    '3' => 'Cr',
                                                    '4' => $request->std_id . ' - ' . $student_name,
                                                    '5' => $posting_reference,
                                                    '6' => $student_id,
                                                    '7' => $request->std_id,
                                                    '8' => $voucherBranchId,
                                                    '9' => $voucher_year_id,
                                                ];
                                            }
                                            if ($fee_voc->fv_a_fund > 0) {
                                                $accountsval[] = [
                                                    '0' => '110203',
                                                    '1' => '110203 - Annual Fund Receivable HO',
                                                    '2' => $fee_voc->fv_a_fund,
                                                    '3' => 'Cr',
                                                    '4' => $request->std_id . ' - ' . $student_name,
                                                    '5' => $posting_reference,
                                                    '6' => $student_id,
                                                    '7' => $request->std_id,
                                                    '8' => $voucherBranchId,
                                                    '9' => $voucher_year_id,
                                                ];
                                            }
                                            if ($fee_voc->fv_z_fund > 0) {
                                                $accountsval[] = [
                                                    '0' => '110201',
                                                    '1' => '110201 - Tution Fee Receivable HO',
                                                    '2' => $fee_voc->fv_z_fund,
                                                    '3' => 'Cr',
                                                    '4' => 'Zakat ' . $request->std_id . ' - ' . $student_name,
                                                    '5' => $posting_reference,
                                                    '6' => $student_id,
                                                    '7' => $request->std_id,
                                                    '8' => $voucherBranchId,
                                                    '9' => $voucher_year_id,
                                                ];
                                            }
                                        } elseif ($fee_voc->fv_package_type == 2) {
                                            $accountsval[] = [
                                                '0' => '110211', // change account number
                                                '1' => '110211 - Arrears Receivables - HO',
                                                '2' => $fee_voc->fv_total_amount,
                                                '3' => 'Cr',
                                                '4' => $request->std_id . ' - ' . $student_name,
                                                '5' => $posting_reference,
                                                '6' => $student_id,
                                                '7' => $request->std_id,
                                                '8' => $voucherBranchId,
                                                '9' => $voucher_year_id,
                                            ];
                                        }
                                    } elseif (substr($request->voucher_no, 0, 1) === "9") {
                                        foreach ($cv_items as $account) {
                                            $entry_accountsval[] = [
                                                'account_code' => $account->cvi_dr_account_id,
                                                'account_name' => $account->cvi_dr_account_name,
                                                'account_amount' => $account->cvi_amount,
                                                'voucher_no' => $request->voucher_no,
                                                'std_id' => $student_id,
                                                'reg_no' => $request->std_id,
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
                                                    '4' => $request->std_id . ' - ' . $student_name,
                                                    '5' => $posting_reference,
                                                    '6' => $student_id,
                                                    '7' => $request->std_id,
                                                    '8' => $voucherBranchId,
                                                    '9' => $voucher_year_id,
                                                ];
                                            } else if ($fee_voc->cv_package_type == 2) {
                                                $accountsval[] = [
                                                    '0' => '110211', // change account number
                                                    '1' => '110211 - Arrears Receivables - HO',
                                                    '2' => $fee_voc->cv_total_amount,
                                                    '3' => 'Cr',
                                                    '4' => $request->std_id . ' - ' . $student_name,
                                                    '5' => $posting_reference,
                                                    '6' => $student_id,
                                                    '7' => $request->std_id,
                                                    '8' => $voucherBranchId,
                                                    '9' => $voucher_year_id,
                                                ];
                                            }
                                        }
                                    } elseif (substr($request->voucher_no, 0, 1) === "5") {
                                        $account_name = $this->get_account_name($fee_voc->tv_dr_account);
                                        $entry_accountsval[] = [
                                            'account_code' => $fee_voc->tv_dr_account,
                                            'account_name' => $account_name,
                                            'account_amount' => $fee_voc->tv_total_amount,
                                            'voucher_no' => $request->voucher_no,
                                            'std_id' => $student_id,
                                            'reg_no' => $request->std_id,
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
                                        $accountsval[] = [
                                            '0' => $fee_voc->tv_dr_account,
                                            '1' => $account_name,
                                            '2' => $fee_voc->tv_total_amount,
                                            '3' => 'Cr',
                                            '4' => $request->std_id . ' - ' . $student_name,
                                            '5' => $posting_reference,
                                            '6' => $student_id,
                                            '7' => $request->std_id,
                                            '8' => $voucherBranchId,
                                            '9' => $voucher_year_id,
                                        ];
                                    }
                                    if ($fine_amount > 0) {
                                        $accountsval[] = [
                                            '0' => '311131',
                                            '1' => '311131 - Fine Income HO',
                                            '2' => $fine_amount,
                                            '3' => 'Cr',
                                            '4' => $request->std_id . ' - ' . $student_name,
                                            '5' => $posting_reference,
                                            '6' => $student_id,
                                            '7' => $request->std_id,
                                            '8' => $voucherBranchId,
                                            '9' => $voucher_year_id,
                                        ];
                                    }
                                } else {
                                    $registration_no_not_found .= $request->std_id . ' ';
                                }
                            } else {
                                $voucher_no_not_found .= $request->voucher_no . ' ';
                            }
                        }
                    }
                }
            }
            $cr_total_amount = 0;
            foreach ($accountsval as $key) {
                $cr_total_amount += $key[2];
            }
            if ($total_voucher_amount == $cr_total_amount) {

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
                        '8' => Session::get('branch_id'),
                        '9' => $voucher_year_id,

                    ];
                }

                if (!empty($accountsval)) {
                    $rollBack = false;
                    $transaction_ids = 0;
                    $account_uid = $request->account;
                    $account_name_text = $account_uid . ' - ' . $this->get_account_name($account_uid);
                    $voucher_remarks = '';
                    $status = '';

                    $notes = 'FEE_PAID_VOUCHER';
                    $voucher_code = config('global_variables.FEE_PAID_VOUCHER_CODE');
                    $transaction_type = config('global_variables.FEE_PAID');

                    $get_day_end = new DayEndController();
                    $day_end = $get_day_end->day_end();
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
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    $detail_remarks = '';

                    $item = $this->paid_voucher_items_values($entry_accountsval, $fpv_id, $fpv_voucher_no, 'fpvi');

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
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    $fpv->fpv_detail_remarks = $detail_remarks;
                    if (!$fpv->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
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
                                    return redirect()->back()->with('fail', 'Failed');
                                }
                            } else {
                                DB::rollBack();
                                return redirect()->back()->with('fail', 'Failed');
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
                                    return redirect()->back()->with('fail', 'Failed');
                                }
                                //                        // student balance table entry start
                                if ($key[0] != 311131) {
                                    $std_balances = new StudentBalances();

                                    $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], $key[3],
                                        $notes, $account_name_text . ' to ' . $key[1] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
                                        $voucher_code . $fpv_id, $key[6], $key[7], $key[8]);
                                    if (!$std_balances->save()) {
                                        $rollBack = true;
                                        DB::rollBack();
                                        return redirect()->back()->with('fail', 'Failed');
                                    }
                                }
//                        // student balance table entry end
                            } else {
                                DB::rollBack();
                                return redirect()->back()->with('fail', 'Failed');
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
                        }
                    }

                    if ($rollBack) {

                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    } else {

                        DB::commit();

                        if (!empty($voucher_no_not_found) || !empty($registration_no_not_found)) {
                            return redirect()->back()->with(['voucher_no' => $voucher_no_not_found, 'students' => $registration_no_not_found, 'success' => 'Successfully Saved']);
                        } else {
                            return redirect()->back()->with(['voucher_no' => $voucher_no_not_found, 'students' => $registration_no_not_found, 'success' => 'Successfully Saved']);
                        }
                    }
                } else {
                    return redirect()->back()->with(['voucher_no' => $voucher_no_not_found, 'fail' => 'Voucher Not Found']);
                }
            } else {
                $voucher_no_not_found = 'Check your MIS Amount! voucher Created amount ' . number_format($cr_total_amount) . ' Mis amount ' . number_format($total_voucher_amount);
                return redirect()->back()->with(['voucher_no' => $voucher_no_not_found, 'fail' => 'Check your MIS Amount! voucher Created amount ' . $cr_total_amount . ' Mis amount '
                    . $total_voucher_amount]);
            }
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }
    }

    public function excel_fee_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'voucher_no' => ['required', 'numeric'],
            'std_id' => ['required'],
            'amount' => ['required'],
            'date' => ['required'],
        ]);
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
        $year_id = $prfx . '_year_id';


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
        $voucher->$branch_id = Session::get('branch_id');
        $voucher->$brwsr_info = $brwsr_rslt;
        $voucher->$ip_adrs = $ip_rslt;
        $voucher->$v_status = $status;
        $voucher->$year_id = $this->getYearEndId();
        return $voucher;
    }

    public function AssignAccountBalancesValuess($balance, $transaction_id, $account, $amount, $type, $remarks, $transaction_type, $detail_remarks, $voucher_id, $posting_ref_id, $voucher_no, $branch_id)
    {
        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $account_head = substr($account, 0, 1);
        $debit_amount = 0;
        $credit_amount = 0;

        $previous_balance = $this->calculate_account_balance($account);

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
        $balance->bal_clg_id = $user->user_clg_id;
        $balance->bal_branch_id = $branch_id;

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

    public function paid_voucher_items_values($values_array, $voucher_number, $v_number, $prfx)
    {
        $data = [];

        $voucher_id = $prfx . '_voucher_id';
        $voucher_no = $prfx . '_v_no';
        $fee_voucher_id = $prfx . '_fee_voucher_id';

        $account_id = $prfx . '_account_id';
        $account_name = $prfx . '_account_name';
        $amount = $prfx . '_amount';

        $fine_account_id = $prfx . '_fine_account_id';
        $fine_account_name = $prfx . '_fine_account_name';
        $fine_amount = $prfx . '_fine_amount';
        $std_id = $prfx . '_std_id';
        $registration_no = $prfx . '_std_reg_no';
        $class_id = $prfx . '_class_id';
        $branch_id = $prfx . '_branch_id';
        $total_amount = $prfx . '_total_amount';
        $remarks = $prfx . '_remarks';
        $posting_reference = $prfx . '_pr_id';
        $year_id = $prfx . '_year_id';

        foreach ($values_array as $key) {
            $data[] = [
                $voucher_id => $voucher_number,
                $voucher_no => $v_number,
                $fee_voucher_id => $key['voucher_no'],
                $account_id => $key['account_code'],
                $account_name => $key['account_name'],
                $amount => $key['account_amount'],
                $fine_account_id => $key['fine_account_code'],
                $fine_account_name => $key['fine_account_name'],
                $fine_amount => $key['fine_amount'],
                $std_id => $key['std_id'],
                $registration_no => $key['reg_no'],
                $class_id => $key['class'],
                $branch_id => $key['branch_id'],
                $total_amount => $key['total_account_amount'],
                $remarks => ucfirst($key['account_remarks']),
                $posting_reference => $key['posting_reference'],
                $year_id => $this->getYearEndId(),
            ];
        }

        return $data;
    }

    // update code by Mustafa start
    public function fee_paid_voucher_list(Request $request, $array = null, $str = null)
    {
        $bank_accounts = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_bank_account = (!isset($request->from) && empty($request->bank_account)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->bank_account;
        $search_year = (!isset($request->from) && empty($request->year)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.fee_paid_voucher_list.fee_paid_voucher_list';
        $pge_title = 'Fee_Paid Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_bank_account, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
//        $query = BankPaymentVoucherModel::query();
        $query = DB::table('financials_fee_paid_voucher')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_fee_paid_voucher.fpv_account_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_fee_paid_voucher.fpv_createdby')
            ->where('fpv_clg_id', $user->user_clg_id);
        $ttl_amnt = $query->sum('fpv_total_amount');

        if (!empty($request->search)) {
            $query->where('fpv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('fpv_remarks', 'like', '%' . $search . '%')
                ->orWhere('fpv_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('fpv_createdby', $search_by_user);
        }

        if (!empty($search_bank_account)) {
            $query->where('fpv_account_id', $search_bank_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('fpv_day_end_date', [$start, $end]);
            $query->whereDate('fpv_day_end_date', '>=', $start)
                ->whereDate('fpv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('fpv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('fpv_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('fpv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('fpv_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('fpv_id', config('global_variables.query_sorting'))
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
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $search_year, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('collegeViews.feePaidVoucher.fee_paid_voucher_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'bank_accounts', 'search_bank_account'));
        }

    }

    // update code by Mustafa end

    public function fee_paid_items_view_details(Request $request)
    {
        $items = FeePaidVoucherItemsModel::where('fpvi_voucher_id', $request->id)->orderby('fpvi_account_name', 'ASC')->get();

        return response()->json($items);
    }

    public function fee_paid_items_view_details_SH(Request $request, $id)
    {
        $fee_voucher = FeePaidVoucherModel::where('fpv_id', $id)->first();
        $items = FeePaidVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_fee_paid_voucher_items.fpvi_pr_id')->where('fpvi_voucher_id',
            $id)->orderby('fpvi_account_name', 'ASC')->get();

        $fpv_acnt_nme = AccountRegisterationModel::where('account_uid', $fee_voucher->fpv_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($fee_voucher->fpv_total_amount);
        $invoice_nbr = $fee_voucher->fpv_id;
//        $invoice_date = $fee_voucher->fpv_created_datetime;
        $invoice_date = $fee_voucher->fpv_day_end_date;
        $invoice_remarks = $fee_voucher->fpv_remarks;
        $type = 'grid';
        $pge_title = 'Fee Voucher';

        return view('voucher_view.feePaidVoucher.fee_paid_voucher_list_modal', compact('items', 'fee_voucher', 'nbrOfWrds', 'fpv_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

    }

    public function fee_paid_items_view_details_pdf_SH(Request $request, $id)
    {
        $fee_voucher = FeePaidVoucherModel::where('fpv_id', $id)->first();
        $items = FeePaidVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_fee_paid_voucher_items.fpvi_pr_id')->where('fpvi_voucher_id',
            $id)->orderby('fpvi_account_name', 'ASC')->get();
        $fpv_acnt_nme = AccountRegisterationModel::where('account_uid', $fee_voucher->fpv_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($fee_voucher->fpv_total_amount);
        $invoice_nbr = $fee_voucher->fpv_id;
        $invoice_date = $fee_voucher->fpv_created_datetime;
        $invoice_date = $fee_voucher->fpv_day_end_date;
        $invoice_remarks = $fee_voucher->fpv_remarks;
        $type = 'pdf';
        $pge_title = 'Fee Voucher';


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
        $pdf->loadView('voucher_view.feePaidVoucher.fee_paid_voucher_list_modal', compact('items', 'fee_voucher', 'nbrOfWrds', 'fpv_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type',
            'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Fee-Paid-Voucher-Detail.pdf');

    }

    public function paid_single_fee_voucher(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'string'],
            'account' => ['required', 'integer'],
            'date' => ['required', 'string'],
        ]);

        $user = Auth::user();
        $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)->pluck('pr_id')->first();
        $total_voucher_amount = 0;
        $account_id = $request->account;
        $account_name = $this->get_account_name($account_id);
        $accountsval = [];
        $entry_accountsval = [];
        $voucher_no_not_found = '';
        $registration_no_not_found = '';
        $voucher_paid_date = '';
        $voucher_year_id = '';
        $voucherBranchId = '';
        $fine_amount = 0;
        if (!empty($request->voucher_no)) {
            if (substr($request->voucher_no, 0, 1) === "7" || substr($request->voucher_no, 0, 1) === "3") {
                $fee_voc = FeeVoucherModel::where('fv_v_no', $request->voucher_no)->where('fv_std_reg_no', $request->std_id)->where('fv_clg_id', $user->user_clg_id)->where('fv_status_update', '=', 0)->first();
                $voucher_year_id = $fee_voc->fv_year_id;
                $voucherBranchId = $fee_voc->fv_branch_id;
            } elseif (substr($request->voucher_no, 0, 1) === "9") {
                $fee_voc = CustomVoucherModel::where('cv_v_no', $request->voucher_no)->where('cv_reg_no', $request->std_id)->where('cv_clg_id', $user->user_clg_id)->where('cv_status', '=', 'Pending')->first();
                if (!empty($fee_voc)) {
                    $cv_items = CustomVoucherItemsModel::where('cvi_voucher_id', $fee_voc->cv_id)->get();
                    $voucher_year_id = $fee_voc->cv_year_id;
                    $voucherBranchId = $fee_voc->cv_branch_id;
                }
            } elseif (substr($request->voucher_no, 0, 1) === "5") {
                $fee_voc = TransportVoucherModel::where('tv_v_no', $request->voucher_no)->where('tv_reg_no', $request->std_id)->where('tv_clg_id', $user->user_clg_id)->where('tv_status', '=', 0)->first();
                $voucher_year_id = $fee_voc->tv_year_id;
                $voucherBranchId = $fee_voc->tv_branch_id;
            }

            if (!empty($fee_voc)) {
                $student = Student::where('registration_no', $request->std_id)->where('clg_id', $user->user_clg_id)->select('id', 'full_name', 'class_id')->first();

                if (!empty($student)) {
                    if (substr($request->voucher_no, 0, 1) === "7" || substr($request->voucher_no, 0, 1) === "3") {
                        if ($fee_voc->fv_total_amount < $request->amount) {
                            $fine_amount = $request->amount - $fee_voc->fv_total_amount;
                        }
                    } elseif (substr($request->voucher_no, 0, 1) === "9") {
                        if ($fee_voc->cv_total_amount < $request->amount) {
                            $fine_amount = $request->amount - $fee_voc->cv_total_amount;
                        }
                    } elseif (substr($request->voucher_no, 0, 1) === "5") {
                        if ($fee_voc->tv_total_amount < $request->amount) {
                            $fine_amount = $request->amount - $fee_voc->tv_total_amount;
                        }
                    }

                    $total_voucher_amount += $request->amount;
                    $voucher_paid_date = date('Y-m-d', strtotime($request->date));


                    $student_id = $student->id;

                    $student_name = $student->full_name;
                    if (substr($request->voucher_no, 0, 1) === "7" || substr($request->voucher_no, 0, 1) === "3") {
                        $entry_accountsval[] = [
                            'account_code' => '110201',
                            'account_name' => '110201 - Tution Fee Receivable HO',
                            'account_amount' => $fee_voc->fv_total_amount,
                            'voucher_no' => $request->voucher_no,
                            'std_id' => $student_id,
                            'reg_no' => $request->std_id,
                            'date' => $voucher_paid_date,
                            'fine_account_code' => '311131',
                            'fine_account_name' => '311131 - Fine Income HO',
                            'fine_amount' => $fine_amount,
                            'class' => $fee_voc->fv_class_id,
                            'branch_id' => $voucherBranchId,
                            'posting_reference' => $posting_reference,
                            'total_account_amount' => $request->amount,
                            'account_remarks' => '',
                            'fee_voucher_id' => $fee_voc->fv_id,
                            'installment_id' => $fee_voc->fv_installment_id,
                            'yearEndId' => $voucher_year_id,
                        ];
                        if ($fee_voc->fv_package_type == 1) {
                            if ($fee_voc->fv_t_fee > 0) {
                                $accountsval[] = [
                                    '0' => '110201',
                                    '1' => '110201 - Tution Fee Receivable HO',
                                    '2' => $fee_voc->fv_t_fee,
                                    '3' => 'Cr',
                                    '4' => $request->std_id . ' - ' . $student_name,
                                    '5' => $posting_reference,
                                    '6' => $student_id,
                                    '7' => $request->std_id,
                                    '8' => $voucherBranchId,
                                    '9' => $voucher_year_id,
                                ];
                            }
                            if ($fee_voc->fv_p_fund > 0) {
                                $accountsval[] = [
                                    '0' => '110202',
                                    '1' => '110202 - Paper Fund Receivable HO',
                                    '2' => $fee_voc->fv_p_fund,
                                    '3' => 'Cr',
                                    '4' => $request->std_id . ' - ' . $student_name,
                                    '5' => $posting_reference,
                                    '6' => $student_id,
                                    '7' => $request->std_id,
                                    '8' => $voucherBranchId,
                                    '9' => $voucher_year_id,
                                ];
                            }
                            if ($fee_voc->fv_a_fund > 0) {
                                $accountsval[] = [
                                    '0' => '110203',
                                    '1' => '110203 - Annual Fund Receivable HO',
                                    '2' => $fee_voc->fv_a_fund,
                                    '3' => 'Cr',
                                    '4' => $request->std_id . ' - ' . $student_name,
                                    '5' => $posting_reference,
                                    '6' => $student_id,
                                    '7' => $request->std_id,
                                    '8' => $voucherBranchId,
                                    '9' => $voucher_year_id,
                                ];
                            }
                            if ($fee_voc->fv_z_fund > 0) {
                                $accountsval[] = [
                                    '0' => '110201',
                                    '1' => '110201 - Tution Fee Receivable HO',
                                    '2' => $fee_voc->fv_z_fund,
                                    '3' => 'Cr',
                                    '4' => 'Zakat ' . $request->std_id . ' - ' . $student_name,
                                    '5' => $posting_reference,
                                    '6' => $student_id,
                                    '7' => $request->std_id,
                                    '8' => $voucherBranchId,
                                    '9' => $voucher_year_id,
                                ];
                            }
                        } elseif ($fee_voc->fv_package_type == 2) {
                            $accountsval[] = [
                                '0' => '110211', // change account number
                                '1' => '110211 - Arrears Receivables - HO',
                                '2' => $fee_voc->fv_total_amount,
                                '3' => 'Cr',
                                '4' => $request->std_id . ' - ' . $student_name,
                                '5' => $posting_reference,
                                '6' => $student_id,
                                '7' => $request->std_id,
                                '8' => $voucherBranchId,
                                '9' => $voucher_year_id,
                            ];
                        }
                    } elseif (substr($request->voucher_no, 0, 1) === "9") {
                        foreach ($cv_items as $account) {
                            $entry_accountsval[] = [
                                'account_code' => $account->cvi_dr_account_id,
                                'account_name' => $account->cvi_dr_account_name,
                                'account_amount' => $account->cvi_amount,
                                'voucher_no' => $request->voucher_no,
                                'std_id' => $student_id,
                                'reg_no' => $request->std_id,
                                'date' => $voucher_paid_date,
                                'fine_account_code' => '311131',
                                'fine_account_name' => '311131 - Fine Income HO',
                                'fine_amount' => $fine_amount,
                                'class' => $fee_voc->cv_class_id,
                                'branch_id' => $voucherBranchId,
                                'posting_reference' => $posting_reference,
                                'total_account_amount' => $request->amount,
                                'account_remarks' => '',
                                'fee_voucher_id' => $fee_voc->cv_id,
                                'yearEndId' => $voucher_year_id,
                            ];
                            if ($fee_voc->cv_package_type == 1) {
                                $accountsval[] = [
                                    '0' => $account->cvi_dr_account_id,
                                    '1' => $account->cvi_dr_account_name,
                                    '2' => $account->cvi_amount,
                                    '3' => 'Cr',
                                    '4' => $request->std_id . ' - ' . $student_name,
                                    '5' => $posting_reference,
                                    '6' => $student_id,
                                    '7' => $request->std_id,
                                    '8' => $voucherBranchId,
                                    '9' => $voucher_year_id,
                                ];
                            } else if ($fee_voc->cv_package_type == 2) {
                                $accountsval[] = [
                                    '0' => '110211', // change account number
                                    '1' => '110211 - Arrears Receivables - HO',
                                    '2' => $account->cvi_amount,
                                    '3' => 'Cr',
                                    '4' => $request->std_id . ' - ' . $student_name,
                                    '5' => $posting_reference,
                                    '6' => $student_id,
                                    '7' => $request->std_id,
                                    '8' => $voucherBranchId,
                                    '9' => $voucher_year_id,
                                ];
                            }
                        }
                    } elseif (substr($request->voucher_no, 0, 1) === "5") {
                        $account_name = $this->get_account_name($fee_voc->tv_dr_account);
                        $entry_accountsval[] = [
                            'account_code' => $fee_voc->tv_dr_account,
                            'account_name' => $account_name,
                            'account_amount' => $fee_voc->tv_total_amount,
                            'voucher_no' => $request->voucher_no,
                            'std_id' => $student_id,
                            'reg_no' => $request->std_id,
                            'date' => $voucher_paid_date,
                            'fine_account_code' => '311131',
                            'fine_account_name' => '311131 - Fine Income HO',
                            'fine_amount' => $fine_amount,
                            'class' => $student->class_id,
                            'branch_id' => $voucherBranchId,
                            'posting_reference' => $posting_reference,
                            'total_account_amount' => $request->amount,
                            'account_remarks' => '',
                            'fee_voucher_id' => $fee_voc->tv_id,
                            'yearEndId' => $voucher_year_id,
                        ];
//                                            if ($fee_voc->cv_package_type == 1) {
                        $accountsval[] = [
                            '0' => $fee_voc->tv_dr_account,
                            '1' => $account_name,
                            '2' => $fee_voc->tv_total_amount,
                            '3' => 'Cr',
                            '4' => $request->std_id . ' - ' . $student_name,
                            '5' => $posting_reference,
                            '6' => $student_id,
                            '7' => $request->std_id,
                            '8' => $voucherBranchId,
                            '9' => $voucher_year_id,
                        ];
//                                            }
                    }
                    if ($fine_amount > 0) {
                        $accountsval[] = [
                            '0' => '311131',
                            '1' => '311131 - Fine Income HO',
                            '2' => $fine_amount,
                            '3' => 'Cr',
                            '4' => $request->std_id . ' - ' . $student_name,
                            '5' => $posting_reference,
                            '6' => $student_id,
                            '7' => $request->std_id,
                            '8' => $voucherBranchId,
                            '9' => $voucher_year_id,
                        ];
                    }

//                        if ($rollBack) {
//                            DB::rollBack();
//                            return redirect()->back()->with('fail', 'Failed Try Again');
//                        }
//                        else {
//                            DB::commit();
//                        }
//                            } else {
//                                $voucher_no_not_found .= $request->voucher_no . ' ';
//                            }
                } else {
                    $registration_no_not_found .= $request->std_id . ' ';
                }
            } else {
                $voucher_no_not_found .= $request->voucher_no . ' ';
            }
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
                '8' => Session::get('branch_id'),
                '9' => $voucher_year_id,
            ];
        }

        if (!empty($accountsval)) {
            $rollBack = false;
            $transaction_ids = 0;
            $account_uid = $request->account;
            $account_name_text = $account_uid . ' - ' . $this->get_account_name($account_uid);
            $voucher_remarks = $request->remarks;
            $status = '';

            $notes = 'FEE_PAID_VOUCHER';
            $voucher_code = config('global_variables.FEE_PAID_VOUCHER_CODE');
            $transaction_type = config('global_variables.FEE_PAID');


            $get_day_end = new DayEndController();
            $day_end = $get_day_end->day_end();
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
                return redirect()->back()->with('fail', 'Failed');
            }

            $detail_remarks = '';

            $item = $this->paid_voucher_items_values($entry_accountsval, $fpv_id, $fpv_voucher_no, 'fpvi');

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
                return redirect()->back()->with('fail', 'Failed');
            }


            $fpv->fpv_detail_remarks = $detail_remarks;
            if (!$fpv->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
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
                            return redirect()->back()->with('fail', 'Failed');
                        }

//                            // student balance table entry start
//                            $std_balances = new StudentBalances();
//
//                            $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Dr',
//                                $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
//                                $voucher_code . $fpv_id, $key[6], $key[7]);
//                            if (!$std_balances->save()) {
//                                $rollBack = true;
//                                DB::rollBack();
//                                return redirect()->back()->with('fail', 'Failed');
//                            }

                        // student balance table entry end

                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
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
                            return redirect()->back()->with('fail', 'Failed');
                        }
                        //                        // student balance table entry start
                        if ($key[0] != 311131) {
                            $std_balances = new StudentBalances();

                            $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], $key[3],
                                $notes, $account_name_text . ' to ' . $key[1] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
                                $voucher_code . $fpv_id, $key[6], $key[7], $key[8]);
                            if (!$std_balances->save()) {
                                $rollBack = true;
                                DB::rollBack();
                                return redirect()->back()->with('fail', 'Failed');
                            }
                        }
//                        // student balance table entry end
                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
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
                }
            }

            if ($rollBack) {

                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            } else {

                DB::commit();

                if (!empty($voucher_no_not_found) || !empty($registration_no_not_found)) {
                    return redirect()->back()->with(['voucher_no' => $voucher_no_not_found, 'students' => $registration_no_not_found, 'success' => 'Successfully Saved']);
                } else {
                    return redirect()->back()->with(['voucher_no' => $voucher_no_not_found, 'students' => $registration_no_not_found, 'success' => 'Successfully Saved']);
                }
//            return redirect()->back()->with(['fpv_id' => $fpv_id, 'success' => 'Successfully Saved']);
            }
//            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['voucher_no' => $voucher_no_not_found, 'fail' => 'Voucher Not Found']);
        }

    }

    public function paid_single_advance_fee_voucher(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'string'],
            'account' => ['required', 'integer'],
            'date' => ['required', 'string'],
        ]);

        $user = Auth::user();
        $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)->pluck('pr_id')->first();
        $total_voucher_amount = 0;
        $account_id = $request->account;
        $account_name = $this->get_account_name($account_id);
        $cr_account_name = $this->get_account_name('110101');
        $accountsval = [];
        $entry_accountsval = [];
        $voucher_no_not_found = '';
        $registration_no_not_found = '';
        $voucher_paid_date = '';
        $voucher_year_id = '';
        $voucherBranchId = '';

        $fine_amount = 0;
        if (!empty($request->voucher_no)) {
            if (substr($request->voucher_no, 0, 1) === "4") {
                $fee_voc = AdvanceFeeVoucher::where('afv_v_no', $request->voucher_no)->where('afv_reg_no', $request->std_id)->where('afv_clg_id', $user->user_clg_id)->where('afv_status', '=', 1)
                    ->first();
                $voucher_year_id = $fee_voc->afv_year_id;
                $voucherBranchId = $fee_voc->afv_branch_id;
            }

            if (!empty($fee_voc)) {
                $student = Student::where('registration_no', $request->std_id)->where('clg_id', $user->user_clg_id)->select('id', 'full_name', 'class_id')->first();

                if (!empty($student)) {
                    if (substr($request->voucher_no, 0, 1) === "4") {
                        if ($fee_voc->afv_total_amount < $request->amount) {
                            $fine_amount = $request->amount - $fee_voc->afv_total_amount;
                        }
                    }

                    $total_voucher_amount += $request->amount;
                    $voucher_paid_date = date('Y-m-d', strtotime($request->date));


                    $student_id = $student->id;

                    $student_name = $student->full_name;
                    if (substr($request->voucher_no, 0, 1) === "4") {
                        $entry_accountsval[] = [
                            'account_code' => '110101',
                            'account_name' => '110101 - ' . $cr_account_name,
                            'account_amount' => $fee_voc->afv_total_amount,
                            'voucher_no' => $request->voucher_no,
                            'std_id' => $student_id,
                            'reg_no' => $request->std_id,
                            'date' => $voucher_paid_date,
                            'fine_account_code' => '311131',
                            'fine_account_name' => '311131 - Fine Income HO',
                            'fine_amount' => $fine_amount,
                            'class' => $fee_voc->afv_class_id,
                            'branch_id' => $voucherBranchId,
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
                            '4' => $request->std_id . ' - ' . $student_name,
                            '5' => $posting_reference,
                            '6' => $student_id,
                            '7' => $request->std_id,
                            '8' => $voucherBranchId,
                            '9' => $voucher_year_id,
                        ];

                    }
                    if ($fine_amount > 0) {
                        $accountsval[] = [
                            '0' => '311131',
                            '1' => '311131 - Fine Income HO',
                            '2' => $fine_amount,
                            '3' => 'Cr',
                            '4' => $request->std_id . ' - ' . $student_name,
                            '5' => $posting_reference,
                            '6' => $student_id,
                            '7' => $request->std_id,
                            '8' => $voucherBranchId,
                            '9' => $voucher_year_id,
                        ];
                    }
                } else {
                    $registration_no_not_found .= $request->std_id . ' ';
                }
            } else {
                $voucher_no_not_found .= $request->voucher_no . ' ';
            }
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
                '8' => Session::get('branch_id'),
                '9' => $voucher_year_id,

            ];
        }

        if (!empty($accountsval)) {
            $rollBack = false;
            $transaction_ids = 0;
            $account_uid = $request->account;
            $account_name_text = $account_uid . ' - ' . $this->get_account_name($account_uid);
            $voucher_remarks = $request->remarks;
            $status = '';

            $notes = 'ADVANCE_FEE_PAID_VOUCHER';
            $voucher_code = config('global_variables.FEE_PAID_VOUCHER_CODE');
            $transaction_type = config('global_variables.FEE_PAID');


            $get_day_end = new DayEndController();
            $day_end = $get_day_end->day_end();
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
                return redirect()->back()->with('fail', 'Failed');
            }

            $detail_remarks = '';

            $item = $this->paid_voucher_items_values($entry_accountsval, $fpv_id, $fpv_voucher_no, 'fpvi');

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
                return redirect()->back()->with('fail', 'Failed');
            }


            $fpv->fpv_detail_remarks = $detail_remarks;
            if (!$fpv->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
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
                            return redirect()->back()->with('fail', 'Failed');
                        }

//                            // student balance table entry start
//                            $std_balances = new StudentBalances();
//
//                            $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Dr',
//                                $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
//                                $voucher_code . $fpv_id, $key[6], $key[7]);
//                            if (!$std_balances->save()) {
//                                $rollBack = true;
//                                DB::rollBack();
//                                return redirect()->back()->with('fail', 'Failed');
//                            }

                        // student balance table entry end

                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
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
                            return redirect()->back()->with('fail', 'Failed');
                        }
                        //                        // student balance table entry start
                        if ($key[0] != 311131) {
                            $std_balances = new StudentBalances();

                            $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], $key[3],
                                $notes, $account_name_text . ' to ' . $key[1] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
                                $voucher_code . $fpv_id, $key[6], $key[7], $key[8]);
                            if (!$std_balances->save()) {
                                $rollBack = true;
                                DB::rollBack();
                                return redirect()->back()->with('fail', 'Failed');
                            }
                        }
//                        // student balance table entry end
                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }
                }
            }

            foreach ($entry_accountsval as $arry) {
                if (substr($arry['voucher_no'], 0, 1) === "4") {
                    $fee_voc = AdvanceFeeVoucher::where('afv_id', $arry['fee_voucher_id'])->where('afv_reg_no', $arry['reg_no'])->where('afv_clg_id', $user->user_clg_id)->where('afv_status', '=', 1)
                        ->first();
                    $fee_voc->afv_status = 2;
                    $fee_voc->afv_posted_by = $user->user_id;
                    $fee_voc->afv_paid_date = $voucher_paid_date;
                    $fee_voc->save();
                }
            }

            if ($rollBack) {

                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            } else {

                DB::commit();

                if (!empty($voucher_no_not_found) || !empty($registration_no_not_found)) {
                    return redirect()->back()->with(['voucher_no' => $voucher_no_not_found, 'students' => $registration_no_not_found, 'success' => 'Successfully Saved']);
                } else {
                    return redirect()->back()->with(['voucher_no' => $voucher_no_not_found, 'students' => $registration_no_not_found, 'success' => 'Successfully Saved']);
                }
//            return redirect()->back()->with(['fpv_id' => $fpv_id, 'success' => 'Successfully Saved']);
            }
//            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['voucher_no' => $voucher_no_not_found, 'fail' => 'Voucher Not Found']);
        }

    }
}
