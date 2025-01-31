<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Models\BalancesModel;
use App\Models\College\BankAccountModel;
use App\Models\College\Classes;
use App\Models\College\ComponentModel;
use App\Models\College\CustomVoucherItemsModel;
use App\Models\College\CustomVoucherModel;
use App\Models\College\FeeVoucherModel;
use App\Models\College\Section;
use App\Models\College\Student;
use App\Models\College\StudentBalances;
use App\Models\CreateSectionModel;
use App\Models\PostingReferenceModel;
use App\Models\TransactionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use PDF;

class CustomVoucherController extends Controller
{
    public function custom_voucher()
    {
        $user = Auth::user();
        $components = ComponentModel::where('sfc_clg_id', $user->user_clg_id)
            ->where('sfc_disable_enable', '=', 1)
            ->get();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)
            ->where('class_disable_enable', '=', 1)
            ->get();
        return view('collegeViews.custom_voucher.custom_voucher', compact('components', 'classes'));
    }

    public function submit_custom_voucher(Request $request)
    {
        $user = Auth::user();
        $already_generated = '';
        $components = ComponentModel::whereIn('sfc_id', $request->component)
            ->select('sfc_id', 'sfc_name', 'sfc_dr_account', 'sfc_cr_account', 'sfc_amount')
            ->get();
        $selected_components = $request->component;
        $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)
            ->pluck('pr_id')
            ->first();
        $class = $request->class;
        $section = $request->section;
        $students = Student::
        whereIn('id', $request->students)
//        where('section_id', $section)
//            ->where('class_id', $class)
//            ->where('student_disable_enable', 1)
//            ->where('status', '!=', 3)
            ->select('id', 'full_name', 'registration_no', 'class_id', 'section_id')
            ->get();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $voucher_remarks = '';
        $rollBack = false;
        $flag = false;
        $status = 'Pending';
        $issue_date = date('Y-m-d', strtotime($request->issue_date));
        $due_date = date('Y-m-d', strtotime($request->due_date));

        $total_voucher_amount = 0;
        $values_array = [];

        $componentsval = [];

        foreach ($components as $account) {
            $total_voucher_amount += $account->sfc_amount;
            $dr_account_name = $this->get_account_name($account->sfc_dr_account);
            $cr_account_name = $this->get_account_name($account->sfc_cr_account);
            $componentsval[] = [
                'cr_account_code' => $account->sfc_cr_account,
                'dr_account_code' => $account->sfc_dr_account,
                'cr_account_name' => $account->sfc_cr_account . ' - ' . $cr_account_name,
                'dr_account_name' => $account->sfc_dr_account . ' - ' . $dr_account_name,
                'component_id' => $account->sfc_id,
                'component_name' => $account->sfc_name,
                'account_amount' => $account->sfc_amount,
                'account_remarks' => '',
                'posting_reference' => $posting_reference,
                'class_id' => $class,
                'section_id' => $section,
            ];
            $values_array[] = [
                '0' => $account->sfc_dr_account,
                '1' => $account->sfc_dr_account . ' - ' . $dr_account_name,
                '2' => $account->sfc_amount,
                '3' => 'Dr',
                '4' => $account->sfc_name,
                '5' => $posting_reference,
            ];
            $values_array[] = [
                '0' => $account->sfc_cr_account,
                '1' => $account->sfc_cr_account . ' - ' . $cr_account_name,
                '2' => $account->sfc_amount,
                '3' => 'Cr',
                '4' => $account->sfc_name,
                '5' => $posting_reference,
            ];
        }

        $notes = 'CUSTOM_VOUCHER';
        $voucher_code = config('global_variables.CUSTOM_VOUCHER_CODE');
        $transaction_type = config('global_variables.CUSTOM_VOUCHER');

        DB::beginTransaction();
        foreach ($students as $student_id) {

            $result = CustomVoucherModel::where('cv_std_id', $student_id->id)
                ->whereIn('cv_id', function ($query) use ($selected_components) {
                    $query->select('cvi_voucher_id')
                        ->from('student_custom_voucher_items')
                        ->whereIn('cvi_component_id', $selected_components);
                })
                ->pluck('cv_v_no');
            if ($result->isEmpty()) {
                $cv = new CustomVoucherModel();

                $cv = $this->assign_custom_voucher_values('cv', $cv, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status, $class, $section, $issue_date, $due_date,
                    $student_id, 1, 'Bulk');

                //                // system config set increment default id according to user giving start coding$status
                //                $sstm_cnfg_clm = 'sc_fee_voucher_number';
                //                $sstm_cnfg_cv_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
                //                $chk_bnk_pymnt = FeeVoucherModel::where('cv_clg_id', '=', $user->user_clg_id)->get();
                //                if ($chk_bnk_pymnt->isEmpty()) :
                //                    if (isset($sstm_cnfg_cv_id_chk) && !empty($sstm_cnfg_cv_id_chk)) :
                //                        $cv->cv_id = $sstm_cnfg_cv_id_chk->$sstm_cnfg_clm;
                //                    endif;
                //                endif;
                // system config set increment default id according to user giving end coding

                if ($cv->save()) {
                    $cv_id = $cv->cv_id;
                    $cv_voucher_no = $cv->cv_v_no;
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()
                        ->back()
                        ->with('fail', 'Failed');
                }
                $detail_remarks = '';

                $item = $this->custom_voucher_items_values($componentsval, $cv_id, $cv_voucher_no, 'cvi');

                foreach ($item as $value) {
                    $cvi_amount = (float)$value['cvi_amount'];

                    $detail_remarks .= $value['cvi_component_name'] . ', @' . number_format($cvi_amount, 2) . config('global_variables.Line_Break');
                }

                if (DB::table('student_custom_voucher_items')->insert($item)) {
                    foreach ($values_array as $key) {
                        $transaction = new TransactionModel();

                        if ($key[3] == 'Dr') {
                            $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $cv_id);

                            if ($transaction->save()) {
                                $transaction_id = $transaction->trans_id;
                                $balances = new BalancesModel();

                                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code . $cv_id, $key[5], $voucher_code . $cv_voucher_no, $this->getYearEndId());

                                if (!$balance->save()) {
                                    $flag = true;
                                    DB::rollBack();
                                    return redirect()
                                        ->back()
                                        ->with('fail', 'Failed');
                                }

                                // student balance table entry start
                                $std_balances = new StudentBalances();

                                $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Dr', $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'), $voucher_code . $cv_id, $student_id->id, $student_id->registration_no);
                                if (!$std_balances->save()) {
                                    $rollBack = true;
                                    DB::rollBack();
                                    return redirect()
                                        ->back()
                                        ->with('fail', 'Failed');
                                }

                                // student balance table entry end
                            } else {
                                DB::rollBack();
                                return redirect()
                                    ->back()
                                    ->with('fail', 'Failed');
                            }
                        } else {
                            $transaction = $this->AssignTransactionsValues($transaction, 0, $key[2], $key[0], 'JOURNAL VOUCHER', 5, $cv_id);
                            if ($transaction->save()) {
                                $transaction_id = $transaction->trans_id;
                                $balances = new BalancesModel();

                                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code . $cv_id, $key[5], $voucher_code . $cv_voucher_no, $this->getYearEndId());

                                if (!$balance->save()) {
                                    $flag = true;
                                    DB::rollBack();
                                    return redirect()
                                        ->back()
                                        ->with('fail', 'Failed');
                                }
                            } else {
                                DB::rollBack();
                                return redirect()
                                    ->back()
                                    ->with('fail', 'Failed');
                            }
                        }
                    }

                    if ($flag) {
                        DB::rollBack();
                        return redirect()
                            ->back()
                            ->with('fail', 'Failed');
                    } else {
                        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Journal Voucher With Id: ' . $cv->cv_id);

                        $cv->cv_detail_remarks = $detail_remarks;
                        $cv->save();
                        //                    DB::commit();
                        //                    return redirect()->back()->with(['cv_id' => $cv_id, 'success' => 'Successfully Saved']);
                    }
                } else {
                    DB::rollBack();
                    return redirect()
                        ->back()
                        ->with('fail', 'Failed');
                }
            } else {
                $already_generated = $student_id->registration_no . ',  ' . $already_generated;
            }
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('fail', 'Failed');
        } else {
            DB::commit();
            return redirect()
                ->back()
                ->with(['already_generated' => $already_generated, 'success' => 'Saved Successfully!']);
            //            return redirect()->back()->with(['cv_id' => $cv_id, 'success' => 'Successfully Saved']);
        }
    }

    public function assign_custom_voucher_values($prfx, $voucher, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status, $class_id, $section_id, $issue_date, $due_date,
                                                 $student_id, $package_type, $voucher_type)
    {
        // Start a database transaction to ensure atomic operations
        DB::beginTransaction();

        try {
            $brwsr_rslt = $this->getBrwsrInfo();
            $ip_rslt = $this->getIp();

            $v_no = $prfx . '_v_no';
            $total_amount = $prfx . '_total_amount';
            $class = $prfx . '_class_id';
            $section = $prfx . '_section_id';
            $std_id = $prfx . '_std_id';
            $student_reg = $prfx . '_reg_no';
            $col_due_date = $prfx . '_due_date';
            $col_issue_date = $prfx . '_issue_date';
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
            $col_voucher_type = $prfx . '_voucher_type';
            $col_package_type = $prfx . '_package_type';
            $col_year_id = $prfx . '_year_id';

            // Generate a unique voucher number
            $maxId = CustomVoucherModel::lockForUpdate()->selectRaw('MAX(CAST(cv_v_no AS UNSIGNED)) as max_cv_v_no')
                ->where('cv_clg_id', $user->user_clg_id)
                ->where('cv_v_no', 'like', '9%')
                ->value('max_cv_v_no');

//            $newNumber = $lastNumber ? $lastNumber + 1 : 1;
//            $maxId = CustomVoucherModel::selectRaw('MAX(CAST(cv_v_no AS UNSIGNED)) as max_cv_v_no')
//                ->where('cv_clg_id', $user->user_clg_id)
//                ->where('cv_v_no', 'like', '9%')
//                ->value('max_cv_v_no');

            // Safely calculate the new voucher number
            $new_value = $maxId ? substr($maxId, 1) : 0;
            $voucher_number = '9' . str_pad($new_value + 1, 3, '0', STR_PAD_LEFT);
            $voucher->$v_no = $voucher_number;

            // Set other voucher attributes
            $voucher->$class = $class_id;
            $voucher->$section = $section_id;
            $voucher->$std_id = $student_id->id;
            $voucher->$student_reg = $student_id->registration_no;
            $voucher->$col_due_date = $due_date;
            $voucher->$col_issue_date = $issue_date;
            $voucher->$total_amount = $total_voucher_amount;
            $voucher->$remarks = $voucher_remarks;
            $voucher->$col_voucher_type = $voucher_type;
            $voucher->$created_datetime = Carbon::now()->toDateTimeString();
            $voucher->$day_end_id = $day_end->de_id;
            $voucher->$day_end_date = $day_end->de_datetime;
            $voucher->$createdby = $user->user_id;
            $voucher->$clg_id = $user->user_clg_id;
            $voucher->$branch_id = Session::get('branch_id');
            $voucher->$brwsr_info = $brwsr_rslt;
            $voucher->$ip_adrs = $ip_rslt;
            $voucher->$v_status = $status;
            $voucher->$col_package_type = $package_type;
            $voucher->$col_year_id = $this->getYearEndId();

            // Commit the transaction
            DB::commit();

            return $voucher;
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
            // Handle the exception or rethrow it
            throw $e;
        }
    }


    public function custom_voucher_items_values($values_array, $voucher_number, $v_number, $prfx)
    {
        $data = [];

        $voucher_id = $prfx . '_voucher_id';
        $v_no = $prfx . '_v_no';
        $cr_account_id = $prfx . '_cr_account_id';
        $dr_account_id = $prfx . '_dr_account_id';
        $cr_account_name = $prfx . '_cr_account_name';
        $dr_account_name = $prfx . '_dr_account_name';
        $component_id = $prfx . '_component_id';
        $component_name = $prfx . '_component_name';
        $amount = $prfx . '_amount';
        $remarks = $prfx . '_remarks';
        $posting_reference = $prfx . '_pr_id';
        $class_id = $prfx . '_class_id';
        $section_id = $prfx . '_section_id';
        $year_id = $prfx . '_year_id';

        foreach ($values_array as $key) {
            $data[] = [
                $voucher_id => $voucher_number,
                $v_no => $v_number,
                $cr_account_id => $key['cr_account_code'],
                $cr_account_name => $key['cr_account_name'],
                $dr_account_id => $key['dr_account_code'],
                $dr_account_name => $key['dr_account_name'],

                $component_id => $key['component_id'],
                $component_name => $key['component_name'],
                $amount => $key['account_amount'],
                $remarks => ucfirst($key['account_remarks']),
                $posting_reference => $key['posting_reference'],
                $class_id => $key['class_id'],
                $section_id => $key['section_id'],
                $year_id => $this->getYearEndId(),
            ];
        }

        return $data;
    }

    public function custom_voucher_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $query_sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id);
        $ar = json_decode($request->array);
        $search = !isset($request->search) && empty($request->search) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = !isset($request->to) && empty($request->to) ? (!empty($ar) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = !isset($request->from) && empty($request->from) ? (!empty($ar) ? $ar[3]->{'value'} : '') : $request->from;
        $search_class = !isset($request->class_id) && empty($request->class_id) ? (!empty($ar) ? $ar[4]->{'value'} : '') : $request->class_id;
        $search_section = !isset($request->section) && empty($request->section) ? (!empty($ar) ? $ar[5]->{'value'} : '') : $request->section;
        $search_status = !isset($request->status) && empty($request->status) ? (!empty($ar) ? $ar[6]->{'value'} : '') : $request->status;
        $search_type = !isset($request->type) && empty($request->type) ? (!empty($ar) ? $ar[7]->{'value'} : '') : $request->type;
        $search_year = !isset($request->year) && empty($request->year) ? (!empty($ar) ? $ar[8]->{'value'} : '') : $request->year;

        $search_by_user = isset($request->search_by_user) && !empty($request->search_by_user) ? $request->search_by_user : '';
        $prnt_page_dir = 'print/college/custom_voucher_list/custom_voucher_list';
        $pge_title = 'Custom Fee Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_class, $search_section, $search_status, $search_type, $search_year);

        $pagination_number = empty($ar) ? 100 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        //        $query = BankPaymentVoucherModel::query();
        $query = DB::table('student_custom_voucher as custom_voucher')
            ->leftJoin('students', 'students.id', 'custom_voucher.cv_std_id')
            ->where('students.status', '!=', 3)
            ->leftJoin('classes', 'classes.class_id', 'custom_voucher.cv_class_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'custom_voucher.cv_createdby')
            ->where('cv_clg_id', $user->user_clg_id)
            ->where('cv_branch_id', $branch_id);
        $ttl_amnt = $query->sum('cv_total_amount');

        if (!empty($search)) {
            $query
                ->where('cv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('cv_remarks', 'like', '%' . $search . '%')
                ->orWhere('students.full_name', 'like', '%' . $search . '%')
                ->orWhere('cv_reg_no', 'like', '%' . $search . '%')
                ->orWhere('cv_id', 'like', '%' . $search . '%')
                ->orWhere('cv_v_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('cv_createdby', $search_by_user);
        }

        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)
                ->pluck('section_name');
            $query->where('cv_class_id', $search_class);
            $query_sections->whereIn('cs_id', $section);
        }
        if (!empty($search_section)) {
            $query->where('cv_section_id', $search_section);
        }
        if (!empty($search_status)) {
            $query->where('cv_status', $search_status);
        }
        if (!empty($search_type)) {
            $query->where('cv_package_type', $search_type);
        }

        if (!empty($search_to) && !empty($search_from)) {
            $query->whereDate('cv_day_end_date', '>=', $start)->whereDate('cv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('cv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('cv_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('cv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('cv_year_id', '=', $search_year);
        }
        $sections = $query_sections->get();
        $datas = $query->orderBy('cv_id', config('global_variables.query_sorting'))->paginate($pagination_number);
        if (isset($request->array) && !empty($request->array)) {
            $type = isset($request->str) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'datas', 'type', 'ttl_amnt', 'pge_title'));
            // $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } elseif ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } elseif ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $search_year, $ttl_amnt, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.custom_voucher.custom_voucher_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'search_class', 'search_status', 'sections', 'search_section', 'search_type'));
        }
    }

    public function custom_voucher_items_view_details(Request $request)
    {
        $user = Auth::user();
        $current_voucher = CustomVoucherModel::where('cv_v_no', $request->id)
            ->where('cv_clg_id', $user->user_clg_id)
            ->first();

        $fee_vouchers = CustomVoucherModel::leftJoin('colleges', 'colleges.clg_id', '=', 'student_custom_voucher.cv_clg_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'student_custom_voucher.cv_branch_id')
            ->leftJoin('students', 'students.id', 'student_custom_voucher.cv_std_id')
            ->where('students.status', '!=', 3)
            ->leftJoin('classes', 'classes.class_id', 'student_custom_voucher.cv_class_id')
            ->where('cv_issue_date', $current_voucher->cv_issue_date)
            //->where('cv_status', 'Pending')
            ->where('cv_clg_id', $user->user_clg_id)
            ->where('cv_class_id', $current_voucher->cv_class_id)
            ->get();
        $items = CustomVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'student_custom_voucher_items.cvi_pr_id')
            ->whereIn('student_custom_voucher_items.cvi_voucher_id', $fee_vouchers->pluck('cv_id'))
            ->orderby('cvi_component_name', 'ASC')
            ->get();

        return response()->json($items);
    }

    public function custom_voucher_items_view_details_SH(Request $request, $id)
    {
        $user = Auth::user();
        //        $current_voucher = CustomVoucherModel::where('cv_v_no', $request->id)->where('cv_clg_id', $user->user_clg_id)->first();
        $bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();
        $fee_voucher = CustomVoucherModel::leftJoin('colleges', 'colleges.clg_id', '=', 'student_custom_voucher.cv_clg_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'student_custom_voucher.cv_branch_id')
            ->leftJoin('students', 'students.id', 'student_custom_voucher.cv_std_id')
            ->leftJoin('classes', 'classes.class_id', 'student_custom_voucher.cv_class_id')
            ->leftJoin('create_section', 'create_section.cs_id', 'student_custom_voucher.cv_section_id')
//            ->where('cv_status', 'Pending')
            ->where('cv_v_no', $request->id)
            ->where('cv_reg_no', $request->reg_no)
            ->where('cv_clg_id', $user->user_clg_id)
            ->first();
        $items = CustomVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'student_custom_voucher_items.cvi_pr_id')
            ->where('student_custom_voucher_items.cvi_voucher_id', $fee_voucher->cv_id)
            ->orderby('cvi_component_name', 'ASC')
            ->get();
        $type = 'grid';
        $pge_title = 'Custom Voucher';

        return view('voucher_view.customVoucher.view_custom_voucher_all', compact('items', 'fee_voucher', 'bank_info', 'type', 'pge_title'));
    }

    public function custom_voucher_items_view_details_pdf_SH(Request $request, $id)
    {
        $user = Auth::user();
        //        $current_voucher = CustomVoucherModel::where('cv_v_no', $request->id)->where('cv_clg_id', $user->user_clg_id)->first();
        $bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();

        $fee_voucher = CustomVoucherModel::leftJoin('colleges', 'colleges.clg_id', '=', 'student_custom_voucher.cv_clg_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'student_custom_voucher.cv_branch_id')
            ->leftJoin('students', 'students.id', 'student_custom_voucher.cv_std_id')
            ->leftJoin('classes', 'classes.class_id', 'student_custom_voucher.cv_class_id')
            ->leftJoin('create_section', 'create_section.cs_id', 'student_custom_voucher.cv_section_id')
            ->where('cv_status', 'Pending')
            ->where('cv_v_no', $request->id)
            ->where('cv_reg_no', $request->reg_no)
            ->where('cv_clg_id', $user->user_clg_id)
            ->first();
        $items = CustomVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'student_custom_voucher_items.cvi_pr_id')
            ->where('student_custom_voucher_items.cvi_voucher_id', $fee_voucher->cv_id)
            ->orderby('cvi_component_name', 'ASC')
            ->get();
        $type = 'pdf';
        $pge_title = 'Custom Voucher';

        //        $footer = view('voucher_view._partials.pdf_footer')->render();
        //        $header = view('voucher_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type', 'invoice_remarks'))->render();
        $options = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ]);

        $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($options);
        $pdf->loadView('voucher_view.customVoucher.print_custom_voucher_all', compact('items', 'fee_voucher', 'bank_info', 'type', 'pge_title'));
        // $pdf->setOptions($options);

        return $pdf->stream('Custom-Voucher-Detail.pdf');
    }

    //    month wise voucher

    public function month_custom_voucher_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $query_sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id);

        $ar = json_decode($request->array);
        $search = !isset($request->search) && empty($request->search) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = !isset($request->to) && empty($request->to) ? (!empty($ar) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = !isset($request->from) && empty($request->from) ? (!empty($ar) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = isset($request->search_by_user) && !empty($request->search_by_user) ? $request->search_by_user : '';
        $search_class = isset($request->class_id) && !empty($request->class_id) ? $request->class_id : '';
        $search_section = isset($request->section) && !empty($request->section) ? $request->section : '';

        $prnt_page_dir = 'print.college.custom_voucher_list.month_wise_custom_voucher_list';
        $pge_title = 'Month Wise Custom Fee Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_class);

        $pagination_number = empty($ar) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('student_custom_voucher')
            ->leftJoin('classes', 'classes.class_id', '=', 'student_custom_voucher.cv_class_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'student_custom_voucher.cv_section_id')
            ->where('cv_clg_id', '=', $user->user_clg_id)
            ->where('cv_branch_id', '=', $branch_id)
            ->where('cv_status', '=', 'Pending')
            ->selectRaw('MONTH(cv_created_datetime) AS month, YEAR(cv_created_datetime) AS year, count(cv_std_id) as total_students, sum(cv_total_amount) as total_amount, create_section.cs_name,classes.class_name,cv_class_id,cv_section_id,cv_issue_date,cv_due_date');
        $ttl_amnt = $query->sum('cv_total_amount');

        if (!empty($request->search)) {
            $query
                ->where('cv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('cv_remarks', 'like', '%' . $search . '%')
                ->orWhere('cv_id', 'like', '%' . $search . '%');
            //                ->orWhere('user_designation', 'like', '%' . $search . '%')
            //                ->orWhere('user_name', 'like', '%' . $search . '%')
            //                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('cv_createdby', $search_by_user);
        }

        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)
                ->pluck('section_name');
            $query->where('cv_class_id', $search_class);
            $query_sections->whereIn('cs_id', $section);
        }
        if (!empty($search_section)) {
            $query->where('cv_section_id', $search_section);
        }

        if (!empty($search_to) && !empty($search_from)) {
            $query->whereDate('cv_day_end_date', '>=', $start)->whereDate('cv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('cv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('cv_day_end_date', $end);
        }
        $sections = $query_sections->get();
        $datas = $query
            ->groupByRaw('YEAR(cv_created_datetime), MONTH(cv_created_datetime),cv_issue_date,cv_section_id')
            ->orderBy('cv_id', 'DESC')
            //            ->get();
            ->paginate($pagination_number);

        if (isset($request->array) && !empty($request->array)) {
            $type = isset($request->str) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'datas', 'type', 'ttl_amnt', 'pge_title'));
            // $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } elseif ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } elseif ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $ttl_amnt, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.custom_voucher.month_custom_voucher_list', compact('datas', 'search', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'search_class', 'search_section', 'sections'));
        }
    }

    public function month_custom_voucher_items_view_details(Request $request)
    {
        $user = Auth::user();
        $current_voucher = CustomVoucherModel::where('cv_section_id', $request->id)
            ->where('cv_clg_id', $user->user_clg_id)
            ->where('cv_branch_id', Session::get('branch_id'))
            ->first();

        $fee_vouchers = CustomVoucherModel::leftJoin('colleges', 'colleges.clg_id', '=', 'student_custom_voucher.cv_clg_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'student_custom_voucher.cv_branch_id')
            ->leftJoin('students', 'students.id', 'student_custom_voucher.cv_std_id')
            ->leftJoin('classes', 'classes.class_id', 'student_custom_voucher.cv_class_id')
            ->where('cv_status', 'Pending')
            ->where('cv_clg_id', $user->user_clg_id)
            ->where('cv_section_id', $request->id)
            ->where('cv_branch_id', Session::get('branch_id'))
            ->get();

        $items = CustomVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'student_custom_voucher_items.cvi_pr_id')
            ->whereIn('student_custom_voucher_items.cvi_voucher_id', $fee_vouchers->pluck('cv_id'))
            ->orderby('cvi_component_name', 'ASC')
            ->get();

        return response()->json($items);
    }

    public function month_custom_voucher_items_view_details_SH(Request $request, $id)
    {
        $user = Auth::user();
        $class_id = $request->class_id;
        $section_id = $request->id;
        $month = $request->month;
        $year = $request->year;
        $issue_date = $request->issue_date;
        $bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();
        $fee_vouchers = CustomVoucherModel::leftJoin('colleges', 'colleges.clg_id', '=', 'student_custom_voucher.cv_clg_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'student_custom_voucher.cv_branch_id')
            ->leftJoin('students', 'students.id', 'student_custom_voucher.cv_std_id')
            ->leftJoin('classes', 'classes.class_id', 'student_custom_voucher.cv_class_id')
            ->leftJoin('create_section', 'create_section.cs_id', 'student_custom_voucher.cv_section_id')
            ->where('cv_status', 'Pending')
            ->where('cv_clg_id', $user->user_clg_id)
            ->where('cv_branch_id', '=', Session::get('branch_id'))
            ->where('cv_class_id', $class_id)
            ->where('cv_section_id', $section_id)
            ->whereYear('cv_created_datetime', $year)
            ->whereMonth('cv_created_datetime', $month)
            ->where('cv_issue_date', $issue_date)
            ->get();

        $items = CustomVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'student_custom_voucher_items.cvi_pr_id')
            ->whereIn('student_custom_voucher_items.cvi_voucher_id', $fee_vouchers->pluck('cv_id'))
            ->orderby('cvi_component_name', 'ASC')
            ->get();
        $type = 'grid';
        $pge_title = 'Custom Voucher';

        return view('voucher_view.customVoucher.view_custom_voucher', compact('items', 'class_id', 'section_id', 'month', 'year', 'issue_date', 'fee_vouchers', 'bank_info', 'type', 'pge_title'));
    }

    public function month_custom_voucher_items_view_details_pdf_SH(Request $request, $id)
    {
        $user = Auth::user();
        $class_id = $request->class_id;
        $section_id = $request->id;
        $month = $request->month;
        $year = $request->year;
        $issue_date = $request->issue_date;
        $bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();
        $fee_vouchers = CustomVoucherModel::leftJoin('colleges', 'colleges.clg_id', '=', 'student_custom_voucher.cv_clg_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'student_custom_voucher.cv_branch_id')
            ->leftJoin('students', 'students.id', 'student_custom_voucher.cv_std_id')
            ->leftJoin('classes', 'classes.class_id', 'student_custom_voucher.cv_class_id')
            ->leftJoin('create_section', 'create_section.cs_id', 'student_custom_voucher.cv_section_id')
            ->where('cv_status', 'Pending')
            ->where('cv_clg_id', $user->user_clg_id)
            ->where('cv_branch_id', '=', Session::get('branch_id'))
            ->where('cv_class_id', $class_id)
            ->where('cv_section_id', $section_id)
            ->whereYear('cv_created_datetime', $year)
            ->whereMonth('cv_created_datetime', $month)
            ->where('cv_issue_date', $issue_date)
            ->get();

        $items = CustomVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'student_custom_voucher_items.cvi_pr_id')
            ->whereIn('student_custom_voucher_items.cvi_voucher_id', $fee_vouchers->pluck('cv_id'))
            ->orderby('cvi_component_name', 'ASC')
            ->get();
        $type = 'pdf';
        $pge_title = 'Custom Voucher';

        $options = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ]);

        $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($options);
        $pdf->loadView('voucher_view.customVoucher.print_custom_voucher', compact('items', 'fee_vouchers', 'bank_info', 'class_id', 'type', 'pge_title'));

        return $pdf->stream('Custom-Voucher-Detail.pdf');
    }

    public function submit_student_wise_custom_voucher(Request $request)
    {
        Session::put('student_id', $request->c_student_id);
        $user = Auth::user();
        $components = $request->component;
        $package_type = $request->package_type_cv;
        $result = CustomVoucherModel::where('cv_std_id', $request->c_student_id)
            ->whereIn('cv_id', function ($query) use ($components) {
                $query->select('cvi_voucher_id')
                    ->from('student_custom_voucher_items')
                    ->whereIn('cvi_component_id', $components);
            })
            ->pluck('cv_v_no');

        if ($result->isEmpty()) {
            $components = ComponentModel::whereIn('sfc_id', $request->component)
                ->select('sfc_id', 'sfc_name', 'sfc_dr_account', 'sfc_cr_account', 'sfc_amount')
                ->get();
            $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)
                ->pluck('pr_id')
                ->first();
            $class = $request->c_class_id;
            $section = $request->c_section_id;
            $students = Student::where('id', $request->c_student_id)
                ->where('status', '!=', 3)
                ->select('id', 'full_name', 'registration_no', 'class_id', 'section_id')
                ->get();
            $get_day_end = new DayEndController();
            $day_end = $get_day_end->day_end();

            $voucher_remarks = '';
            $rollBack = false;
            $flag = false;
            $status = 'Pending';
            $issue_date = date('Y-m-d', strtotime($request->issue_date));
            $due_date = date('Y-m-d', strtotime($request->due_date));

            $total_voucher_amount = 0;
            $values_array = [];

            $componentsval = [];

            foreach ($components as $account) {
                $total_voucher_amount += $account->sfc_amount;
                $dr_account_name = $this->get_account_name($account->sfc_dr_account);
                $cr_account_name = $this->get_account_name($account->sfc_cr_account);
                $componentsval[] = [
                    'cr_account_code' => $account->sfc_cr_account,
                    'dr_account_code' => $account->sfc_dr_account,
                    'cr_account_name' => $account->sfc_cr_account . ' - ' . $cr_account_name,
                    'dr_account_name' => $account->sfc_dr_account . ' - ' . $dr_account_name,
                    'component_id' => $account->sfc_id,
                    'component_name' => $account->sfc_name,
                    'account_amount' => $account->sfc_amount,
                    'account_remarks' => '',
                    'posting_reference' => $posting_reference,
                    'class_id' => $class,
                    'section_id' => $section,
                ];
                $values_array[] = [
                    '0' => $account->sfc_dr_account,
                    '1' => $account->sfc_dr_account . ' - ' . $dr_account_name,
                    '2' => $account->sfc_amount,
                    '3' => 'Dr',
                    '4' => $account->sfc_name,
                    '5' => $posting_reference,
                ];
                $values_array[] = [
                    '0' => $account->sfc_cr_account,
                    '1' => $account->sfc_cr_account . ' - ' . $cr_account_name,
                    '2' => $account->sfc_amount,
                    '3' => 'Cr',
                    '4' => $account->sfc_name,
                    '5' => $posting_reference,
                ];
            }

            $notes = 'CUSTOM_VOUCHER';
            $voucher_code = config('global_variables.CUSTOM_VOUCHER_CODE');
            $transaction_type = config('global_variables.CUSTOM_VOUCHER');

            DB::beginTransaction();
            foreach ($students as $student_id) {
                $cv = new CustomVoucherModel();

                $cv = $this->assign_custom_voucher_values('cv', $cv, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status, $class, $section, $issue_date, $due_date,
                    $student_id, $package_type, 'Single');

                //                // system config set increment default id according to user giving start coding$status
                //                $sstm_cnfg_clm = 'sc_fee_voucher_number';
                //                $sstm_cnfg_cv_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
                //                $chk_bnk_pymnt = FeeVoucherModel::where('cv_clg_id', '=', $user->user_clg_id)->get();
                //                if ($chk_bnk_pymnt->isEmpty()) :
                //                    if (isset($sstm_cnfg_cv_id_chk) && !empty($sstm_cnfg_cv_id_chk)) :
                //                        $cv->cv_id = $sstm_cnfg_cv_id_chk->$sstm_cnfg_clm;
                //                    endif;
                //                endif;
                // system config set increment default id according to user giving end coding

                if ($cv->save()) {
                    $cv_id = $cv->cv_id;
                    $cv_voucher_no = $cv->cv_v_no;
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()
                        ->back()
                        ->with('fail', 'Failed');
                }
                $detail_remarks = '';

                $item = $this->custom_voucher_items_values($componentsval, $cv_id, $cv_voucher_no, 'cvi');

                foreach ($item as $value) {
                    $cvi_amount = (float)$value['cvi_amount'];

                    $detail_remarks .= $value['cvi_component_name'] . ', @' . number_format($cvi_amount, 2) . config('global_variables.Line_Break');
                }

                if (DB::table('student_custom_voucher_items')->insert($item)) {
                    if ($package_type == 1) {
                        foreach ($values_array as $key) {
                            $transaction = new TransactionModel();

                            if ($key[3] == 'Dr') {
                                $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $cv_id);

                                if ($transaction->save()) {
                                    $transaction_id = $transaction->trans_id;
                                    $balances = new BalancesModel();

                                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code . $cv_id, $key[5], $voucher_code . $cv_voucher_no, $this->getYearEndId());

                                    if (!$balance->save()) {
                                        $flag = true;
                                        DB::rollBack();
                                        return redirect()
                                            ->back()
                                            ->with('fail', 'Failed');
                                    }

                                    // student balance table entry start
                                    $std_balances = new StudentBalances();

                                    $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Dr', $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'), $voucher_code . $cv_id, $student_id->id, $student_id->registration_no);
                                    if (!$std_balances->save()) {
                                        $rollBack = true;
                                        DB::rollBack();
                                        return redirect()
                                            ->back()
                                            ->with('fail', 'Failed');
                                    }

                                    // student balance table entry end
                                } else {
                                    DB::rollBack();
                                    return redirect()
                                        ->back()
                                        ->with('fail', 'Failed');
                                }
                            } else {
                                $transaction = $this->AssignTransactionsValues($transaction, 0, $key[2], $key[0], 'JOURNAL VOUCHER', 5, $cv_id);
                                if ($transaction->save()) {
                                    $transaction_id = $transaction->trans_id;
                                    $balances = new BalancesModel();

                                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code . $cv_id, $key[5], $voucher_code . $cv_voucher_no, $this->getYearEndId());

                                    if (!$balance->save()) {
                                        $flag = true;
                                        DB::rollBack();
                                        return redirect()
                                            ->back()
                                            ->with('fail', 'Failed');
                                    }
                                } else {
                                    DB::rollBack();
                                    return redirect()
                                        ->back()
                                        ->with('fail', 'Failed');
                                }
                            }
                        }
                    } elseif ($package_type == 2) {
                        foreach ($values_array as $key) {
                            if ($key[3] == 'Dr') {
                                // student balance table entry start
                                $std_balances = new StudentBalances();

                                $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Dr', $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'), $voucher_code . $cv_id, $student_id->id, $student_id->registration_no);
                                if (!$std_balances->save()) {
                                    $rollBack = true;
                                    DB::rollBack();
                                    return redirect()
                                        ->back()
                                        ->with('fail', 'Failed');
                                }
                                // student balance table entry end
                            }
                        }
                    }

                    if ($flag) {
                        DB::rollBack();
                        return redirect()
                            ->back()
                            ->with('fail', 'Failed');
                    } else {
                        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Journal Voucher With Id: ' . $cv->cv_id);

                        $cv->cv_detail_remarks = $detail_remarks;
                        $cv->save();
                        //                    DB::commit();
                        //                    return redirect()->back()->with(['cv_id' => $cv_id, 'success' => 'Successfully Saved']);
                    }
                } else {
                    DB::rollBack();
                    return redirect()
                        ->back()
                        ->with('fail', 'Failed');
                }
            }

            if ($rollBack) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->with('fail', 'Failed');
            } else {
                DB::commit();
                return redirect()
                    ->route('create_installments')
                    ->with('success', 'Successfully Saved');
                //            return redirect()->back()->with(['cv_id' => $cv_id, 'success' => 'Successfully Saved']);
            }
        } else {
            return redirect()
                ->route('create_installments')
                ->with('success', 'Already Created this component Voucher');
        }
    }

    function get_students_for_custom(Request $request)
    {
        $query = Student::where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('student_disable_enable', 1)
            ->where('status', '!=', 3);
//            ->pluck('id');
        $student_ids = $query->get();
//        $students=$query->get();
        return response()->json(['students' => $student_ids]);
    }

    public function custom_voucher_pending_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $query_sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id);
        $ar = json_decode($request->array);
        $search = !isset($request->search) && empty($request->search) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = !isset($request->to) && empty($request->to) ? (!empty($ar) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = !isset($request->from) && empty($request->from) ? (!empty($ar) ? $ar[3]->{'value'} : '') : $request->from;
        $search_class = !isset($request->class_id) && empty($request->class_id) ? (!empty($ar) ? $ar[4]->{'value'} : '') : $request->class_id;
        $search_section = !isset($request->section) && empty($request->section) ? (!empty($ar) ? $ar[5]->{'value'} : '') : $request->section;
        $search_type = !isset($request->type) && empty($request->type) ? (!empty($ar) ? $ar[7]->{'value'} : '') : $request->type;

        $search_by_user = isset($request->search_by_user) && !empty($request->search_by_user) ? $request->search_by_user : '';
        $prnt_page_dir = 'print/college/custom_voucher_list/custom_voucher_list';
        $pge_title = 'Custom Fee Voucher Pending List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_class, $search_section, $search_type);

        $pagination_number = empty($ar) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        //        $query = BankPaymentVoucherModel::query();
        $query = DB::table('student_custom_voucher as custom_voucher')
            ->leftJoin('students', 'students.id', 'custom_voucher.cv_std_id')
            ->where('students.status', '!=', 3)
            ->leftJoin('classes', 'classes.class_id', 'custom_voucher.cv_class_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'custom_voucher.cv_createdby')
            ->where('cv_clg_id', $user->user_clg_id)
            ->where('cv_branch_id', $branch_id)
            ->where('cv_status', 'Pending');
        $ttl_amnt = $query->sum('cv_total_amount');

        if (!empty($search)) {
            $query
                ->where('cv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('cv_remarks', 'like', '%' . $search . '%')
                ->orWhere('students.full_name', 'like', '%' . $search . '%')
                ->orWhere('cv_reg_no', 'like', '%' . $search . '%')
                ->orWhere('cv_id', 'like', '%' . $search . '%')
                ->orWhere('cv_v_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('cv_createdby', $search_by_user);
        }

        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)
                ->pluck('section_name');
            $query->where('cv_class_id', $search_class);
            $query_sections->whereIn('cs_id', $section);
        }
        if (!empty($search_section)) {
            $query->where('cv_section_id', $search_section);
        }

        if (!empty($search_type)) {
            $query->where('cv_package_type', $search_type);
        }

        if (!empty($search_to) && !empty($search_from)) {
            $query->whereDate('cv_day_end_date', '>=', $start)->whereDate('cv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('cv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('cv_day_end_date', $end);
        }
        $sections = $query_sections->get();
        $datas = $query->orderBy('cv_id', config('global_variables.query_sorting'))->paginate($pagination_number);
        if (isset($request->array) && !empty($request->array)) {
            $type = isset($request->str) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'datas', 'type', 'ttl_amnt', 'pge_title'));
            // $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } elseif ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } elseif ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $ttl_amnt, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.custom_voucher.custom_voucher_pending_list', compact('datas', 'search', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'search_class', 'sections', 'search_section', 'search_type'));
        }
    }

    public function custom_voucher_reverse_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $query_sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id);
        $ar = json_decode($request->array);
        $search = !isset($request->search) && empty($request->search) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = !isset($request->to) && empty($request->to) ? (!empty($ar) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = !isset($request->from) && empty($request->from) ? (!empty($ar) ? $ar[3]->{'value'} : '') : $request->from;
        $search_class = !isset($request->class_id) && empty($request->class_id) ? (!empty($ar) ? $ar[4]->{'value'} : '') : $request->class_id;
        $search_section = !isset($request->section) && empty($request->section) ? (!empty($ar) ? $ar[5]->{'value'} : '') : $request->section;

        $search_by_user = isset($request->search_by_user) && !empty($request->search_by_user) ? $request->search_by_user : '';
        $prnt_page_dir = 'print/college/custom_voucher_list/custom_voucher_list';
        $pge_title = 'Custom Fee Voucher Reverse List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_class, $search_section);

        $pagination_number = empty($ar) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        //        $query = BankPaymentVoucherModel::query();
        $query = DB::table('student_custom_voucher as custom_voucher')
            ->leftJoin('students', 'students.id', 'custom_voucher.cv_std_id')
            ->where('students.status', '!=', 3)
            ->leftJoin('classes', 'classes.class_id', 'custom_voucher.cv_class_id')
            ->leftJoin('financials_users as createdUser', 'createdUser.user_id', 'custom_voucher.cv_createdby')
            ->leftJoin('financials_users as deletedUser', 'deletedUser.user_id', 'custom_voucher.cv_posted_by')
            ->where('cv_clg_id', $user->user_clg_id)
            ->where('cv_branch_id', $branch_id)
            ->where('cv_status', 'Deleted');
        $ttl_amnt = $query->sum('cv_total_amount');

        if (!empty($search)) {
            $query
                ->where('cv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('cv_remarks', 'like', '%' . $search . '%')
                ->orWhere('students.full_name', 'like', '%' . $search . '%')
                ->orWhere('cv_reg_no', 'like', '%' . $search . '%')
                ->orWhere('cv_id', 'like', '%' . $search . '%')
                ->orWhere('cv_v_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)
                ->pluck('section_name');
            $query->where('cv_class_id', $search_class);
            $query_sections->whereIn('cs_id', $section);
        }
        if (!empty($search_section)) {
            $query->where('cv_section_id', $search_section);
        }

        if (!empty($search_to) && !empty($search_from)) {
            $query->whereDate('cv_day_end_date', '>=', $start)->whereDate('cv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('cv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('cv_day_end_date', $end);
        }
        $sections = $query_sections->get();
        $datas = $query->orderBy('cv_id', config('global_variables.query_sorting'))->select('custom_voucher.*','classes.class_name','students.full_name','students.registration_no','createdUser.user_name as createdBy','deletedUser.user_name as deletedBy')->paginate($pagination_number);
        if (isset($request->array) && !empty($request->array)) {
            $type = isset($request->str) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'datas', 'type', 'ttl_amnt', 'pge_title'));
            // $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } elseif ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } elseif ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $ttl_amnt, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.custom_voucher.custom_voucher_reverse_list', compact('datas', 'search', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'search_class', 'sections', 'search_section'));
        }
    }

    public function reverse_custom_voucher(Request $request)
    {
        $user = Auth::user();
        $values_array = [];
        $rollBack = false;
        $flag = false;
        $cv_id = $request->cv_id;
        $cv_voucher_no = $request->cv_v_no;
        $fee_voc = CustomVoucherModel::where('cv_id', '=', $request->cv_id)->where('cv_v_no', $request->cv_v_no)->where('cv_clg_id', $user->user_clg_id)->where('cv_status', '=', 'Pending')->first();
        $detail_remarks = '';
        if (!empty($fee_voc)) {
            $cv_items = CustomVoucherItemsModel::where('cvi_voucher_id', $fee_voc->cv_id)->get();
            $voucher_year_id = $fee_voc->cv_year_id;
            $voucherBranchId = $fee_voc->cv_branch_id;

            foreach ($cv_items as $account) {

                $values_array[] = [
                    '0' => $account->cvi_cr_account_id,
                    '1' => $account->cvi_cr_account_id . ' - ' . $account->cvi_cr_account_name,
                    '2' => $account->cvi_amount,
                    '3' => 'Dr',
                    '4' => $account->cvi_component_name,
                    '5' => $account->cvi_pr_id,
                ];
                $values_array[] = [
                    '0' => $account->cvi_dr_account_id,
                    '1' => $account->cvi_dr_account_id . ' - ' . $account->cvi_dr_account_name,
                    '2' => $account->cvi_amount,
                    '3' => 'Cr',
                    '4' => $account->cvi_component_name,
                    '5' => $account->cvi_pr_id,
                ];
                $cvi_amount = (float)$account->cvi_amount;

                $detail_remarks .= $account['cvi_component_name'] . ', @' . number_format($cvi_amount, 2) . config('global_variables.Line_Break');

            }
            $notes = 'REVERSAL_CUSTOM_VOUCHER';
            $voucher_code = config('global_variables.CUSTOM_VOUCHER_CODE');
            $transaction_type = config('global_variables.CUSTOM_VOUCHER');


            foreach ($values_array as $key) {
                $transaction = new TransactionModel();

                if ($key[3] == 'Dr') {
                    $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $cv_id);

                    if ($transaction->save()) {
                        $transaction_id = $transaction->trans_id;
                        $balances = new BalancesModel();

                        $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code . $cv_id, $key[5], $voucher_code . $cv_voucher_no, $this->getYearEndId());

                        if (!$balance->save()) {
                            $flag = true;
                            DB::rollBack();
                            return redirect()
                                ->back()
                                ->with('fail', 'Failed');
                        }

                        // student balance table entry end
                    } else {
                        DB::rollBack();
                        return redirect()
                            ->back()
                            ->with('fail', 'Failed');
                    }
                } else {
                    $transaction = $this->AssignTransactionsValues($transaction, 0, $key[2], $key[0], 'REVERSAL CUSTOM VOUCHER', 5, $cv_id);
                    if ($transaction->save()) {
                        $transaction_id = $transaction->trans_id;
                        $balances = new BalancesModel();

                        $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code . $cv_id, $key[5], $voucher_code . $cv_voucher_no, $this->getYearEndId());

                        if (!$balance->save()) {
                            $flag = true;
                            DB::rollBack();
                            return redirect()
                                ->back()
                                ->with('fail', 'Failed');
                        }
                        // student balance table entry start
                        $std_balances = new StudentBalances();

                        $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Cr', $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'), $voucher_code . $cv_id, $fee_voc->cv_std_id, $fee_voc->cv_reg_no);
                        if (!$std_balances->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()
                                ->back()
                                ->with('fail', 'Failed');
                        }
                    } else {
                        DB::rollBack();
                        return redirect()
                            ->back()
                            ->with('fail', 'Failed');
                    }
                }
            }

            if ($flag) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->with('fail', 'Failed');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Reverse Custom Voucher With Id: ' . $fee_voc->cv_id);

                $fee_voc->cv_status = 'Deleted';
                $fee_voc->cv_posted_by = $user->user_id;
                $fee_voc->cv_paid_date = Carbon::now();
                $fee_voc->save();
            }
        }

        return redirect()->back()->with('success', 'Voucher Deleted Successfully');
    }
}
