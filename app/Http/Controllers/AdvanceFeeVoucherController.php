<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\AdvanceFeeReverseVoucher;
use App\Models\AdvanceFeeVoucher;
use App\Models\BalancesModel;
use App\Models\College\BankAccountModel;
use App\Models\College\Classes;
use App\Models\College\Section;
use App\Models\College\Student;
use App\Models\College\StudentBalances;
use App\Models\CreateSectionModel;
use App\Models\PostingReferenceModel;
use App\Models\TransactionModel;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class AdvanceFeeVoucherController extends Controller
{
    public function submit_advance_voucher(Request $request)
    {
        $user = Auth::user();

        Session::put('student_id', $request->adv_student_id);


        $student_id = $request->adv_student_id;
        $tution_fee = $request->adv_t_fee;
        $funds = $request->adv_fund;
//        $total_fee = $request->adv_total_fee;
        $total_fee = $request->adv_t_fee + $request->adv_fund;
        $account_uid = '210131,210134';
        $student = Student::where('id', $student_id)
            ->where('status', '!=', 3)
            ->select('id', 'full_name', 'registration_no', 'class_id', 'section_id')
            ->first();
        if ($total_fee > 0) {
            $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)
                ->pluck('pr_id')
                ->first();

            $class = $student->class_id;
            $section = $student->section_id;
            $get_day_end = new DayEndController();
            $day_end = $get_day_end->day_end();

            $rollBack = false;
            $flag = false;


            $values_array = [];

            $tution_account_name = $this->get_account_name('210131');
            $fund_account_name = $this->get_account_name('210134');
            $cash_account_name = $this->get_account_name('110101');
            if ($tution_fee > 0) {
                $values_array[] = [
                    '0' => '210131',
                    '1' => '210131' . ' - ' . $tution_account_name,
                    '2' => $tution_fee,
                    '3' => 'Cr',
                    '4' => $student->registration_no . '-' . $student->full_name,
                    '5' => $posting_reference,
                ];
            }
            if ($funds > 0) {
                $values_array[] = [
                    '0' => '210134',
                    '1' => '210134' . ' - ' . $fund_account_name,
                    '2' => $funds,
                    '3' => 'Cr',
                    '4' => $student->registration_no . '-' . $student->full_name,
                    '5' => $posting_reference,
                ];
            }

            $values_array[] = [
                '0' => '110101',
                '1' => '110101' . ' - ' . $cash_account_name,
                '2' => $total_fee,
                '3' => 'Dr',
                '4' => $student->registration_no . '-' . $student->full_name,
                '5' => $posting_reference,
            ];


            $notes = 'ADVANCE_FEE_VOUCHER';
            $voucher_code = config('global_variables.ADVANCE_FEE_VOUCHER_CODE');
            $transaction_type = config('global_variables.ADVANCE_VOUCHER');

            DB::beginTransaction();

            $due_date = date('Y-m-d', strtotime($request->due_date));
            $advance_fee = new AdvanceFeeVoucher();
            $advance_fee = $this->assign_advance_fee_voucher_values(
                'afv', $advance_fee, $account_uid, $total_fee, $user, $day_end, $class, $section,
                $student_id, $tution_fee, $funds,$due_date);

            if ($advance_fee->save()) {
                $afv_id = $advance_fee->afv_id;
                $afv_voucher_no = $advance_fee->afv_v_no;
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()
                    ->back()
                    ->with('fail', 'Failed');
            }
            $detail_remarks = '';

            if (!empty($tution_fee)) {
                $detail_remarks .= $afv_voucher_no . ' - ' . $tution_account_name . ', @' . number_format($tution_fee, 2) . config('global_variables.Line_Break');
            }
            if (!empty($funds)) {
                $detail_remarks .= $afv_voucher_no . ' - ' . $fund_account_name . ', @' . number_format($funds, 2) . config('global_variables.Line_Break');
            }


            foreach ($values_array as $key) {
                $transaction = new TransactionModel();

                if ($key[3] == 'Dr') {
                    $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $afv_id);

                    if ($transaction->save()) {
                        $transaction_id = $transaction->trans_id;
                        $balances = new BalancesModel();

                        $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code . $afv_id, $key[5], $voucher_code . $afv_voucher_no,$this->getYearEndId());

                        if (!$balance->save()) {
                            $flag = true;
                            DB::rollBack();
                            return redirect()
                                ->back()
                                ->with('fail', 'Failed');
                        }

                        // student balance table entry start
                        $std_balances = new StudentBalances();

                        $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Dr', $notes, $afv_voucher_no . ' - ' . $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'), $voucher_code . $afv_id, $student->id, $student->registration_no);
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
                    $transaction = $this->AssignTransactionsValues($transaction, 0, $key[2], $key[0], 'ADVANCE FEE VOUCHER', 5, $afv_id);

                    if ($transaction->save()) {
                        $transaction_id = $transaction->trans_id;
                        $balances = new BalancesModel();

                        $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code . $afv_id, $key[5], $voucher_code . $afv_voucher_no,$this->getYearEndId());

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
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Journal Voucher With Id: ' . $advance_fee->afv_id);
                $advance_fee->afv_detail_remarks = $detail_remarks;
                $advance_fee->save();
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
            }
        } else {
            return redirect()
                ->route('create_installments')
                ->with('success', 'Total Amount of Advance Voucher is required');
        }
    }

    public function assign_advance_fee_voucher_values(
        $prfx, $voucher, $account_uid, $total_voucher_amount, $user, $day_end, $class_id, $section_id,
        $std_id, $tution_fee, $fund, $due_date
    )
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $v_no = $prfx . '_v_no';
        $class = $prfx . '_class_id';
        $section = $prfx . '_section_id';
        $student_id = $prfx . '_std_id';
        $student_reg = $prfx . '_reg_no';
        $account_id = $prfx . '_account_id';
        $col_due_date = $prfx . '_due_date';

        $tution_fees = $prfx . '_t_fee';
        $funds = $prfx . '_fund';
        $total_amount = $prfx . '_total_amount';
        $created_datetime = $prfx . '_created_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $col_status = $prfx . '_status';
        $col_year_id = $prfx . '_year_id';


//        $maxId = AdvanceFeeVoucher::where('afv_clg_id', $user->user_clg_id)->orderBy('afv_id','DESC')->pluck('afv_v_no')->first();

        $maxId = AdvanceFeeVoucher::lockForUpdate()->selectRaw('MAX(CAST(afv_v_no AS UNSIGNED)) as max_afv_v_no')
            ->where('afv_clg_id', $user->user_clg_id)
            ->where('afv_v_no', 'like', '4%')
            ->value('max_afv_v_no');
//        $new_value = substr($maxId, 1);
        $new_value = $maxId ? (int)substr($maxId, 1) : null;

        if ($maxId == null) {
            $voucher_number = $new_value + 1;
            $voucher_number = 100 + $voucher_number;
            $voucher->$v_no = '4' . $voucher_number;
        } else {
            $voucher->$v_no = '4' .  $new_value + 1;
        }


        $voucher->$class = $class_id;
        $voucher->$section = $section_id;
        $voucher->$student_id = $std_id;
        $voucher->$student_reg = $this->get_registration_number($std_id);
        $voucher->$account_id = $account_uid;
        $voucher->$tution_fees = $tution_fee;
        $voucher->$funds = $fund;
        $voucher->$col_due_date = $due_date;

        $voucher->$total_amount = $total_voucher_amount;
        $voucher->$created_datetime = Carbon::now()->toDateTimeString();
        $voucher->$day_end_id = $day_end->de_id;
        $voucher->$day_end_date = $day_end->de_datetime;
        $voucher->$createdby = $user->user_id;
        $voucher->$clg_id = $user->user_clg_id;
        $voucher->$branch_id = Session::get('branch_id');
        $voucher->$brwsr_info = $brwsr_rslt;
        $voucher->$ip_adrs = $ip_rslt;
        $voucher->$col_status = 1;
        $voucher->$col_year_id = $this->getYearEndId();
        return $voucher;
    }

    // update code by Mustafa start
    public function advance_fee_voucher_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $query_sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_class = (!isset($request->class_id) && empty($request->class_id)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->class_id;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->section;
        $search_status = (!isset($request->status) && empty($request->status)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->status;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->year;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.fee_voucher_list.fee_voucher_list';
        $pge_title = 'Fee Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_class, $search_section, $search_status,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('advance_fee_vouchers')
            ->leftJoin('students', 'students.id', 'advance_fee_vouchers.afv_std_id')
            ->where('students.status', '!=', 3)
            ->leftJoin('classes', 'classes.class_id', 'advance_fee_vouchers.afv_class_id')
            ->leftJoin('branches', 'branches.branch_id', 'advance_fee_vouchers.afv_branch_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'advance_fee_vouchers.afv_createdby')
            ->where('afv_clg_id', $user->user_clg_id)
            ->where('afv_branch_id', Session::get('branch_id'));


        if (!empty($request->search)) {
            $query->where('afv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('afv_id', 'like', '%' . $search . '%')
                ->orWhere('afv_v_no', 'like', '%' . $search . '%')
                ->orWhere('afv_reg_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)->pluck('section_name');
            $query->where('afv_class_id', $search_class);
            $query_sections->whereIn('cs_id', $section);
        }

        if (!empty($search_section)) {
            $query->where('afv_section_id', $search_section);
        }
        if ($search_status != '') {
            $query->where('afv_status', '=', $search_status);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('afv_day_end_date', '>=', $start)
                ->whereDate('afv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('afv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('afv_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('afv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('afv_year_id', '=', $search_year);
        }
        $ttl_amnt = $query->sum('afv_total_amount');
        $sections = $query_sections->get();
        $datas = $query->orderBy('afv_id', config('global_variables.query_sorting'))
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
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type,$search_year, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.feeVoucher.advance_fee_voucher_list', compact('datas', 'search', 'search_year','search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'search_class', 'search_status',
                'sections', 'search_section'));
        }
    }

    public function advance_fee_reverse_voucher_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $query_sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_class = (!isset($request->class_id) && empty($request->class_id)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->class_id;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->section;
        $search_status = (!isset($request->status) && empty($request->status)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->status;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->year;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.fee_voucher_list.fee_voucher_list';
        $pge_title = 'Fee Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_class, $search_section, $search_status,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('advance_fee_reverse_vouchers')
            ->leftJoin('students', 'students.id', 'advance_fee_reverse_vouchers.afrv_std_id')
            ->where('students.status', '!=', 3)
            ->leftJoin('classes', 'classes.class_id', 'advance_fee_reverse_vouchers.afrv_class_id')
            ->leftJoin('branches', 'branches.branch_id', 'advance_fee_reverse_vouchers.afrv_branch_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'advance_fee_reverse_vouchers.afrv_createdby')
            ->where('afrv_clg_id', $user->user_clg_id)
            ->where('afrv_branch_id', Session::get('branch_id'));


        if (!empty($request->search)) {
            $query->where('afrv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('afrv_id', 'like', '%' . $search . '%')
                ->orWhere('afrv_v_no', 'like', '%' . $search . '%')
                ->orWhere('afrv_reg_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)->pluck('section_name');
            $query->where('afrv_class_id', $search_class);
            $query_sections->whereIn('cs_id', $section);
        }

        if (!empty($search_section)) {
            $query->where('afrv_section_id', $search_section);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('afrv_day_end_date', '>=', $start)
                ->whereDate('afrv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('afrv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('afrv_day_end_date', $end);
        }if (!empty($search_year)) {
        $query->where('afrv_year_id', '=', $search_year);
    } else {
        $search_year = $this->getYearEndId();
        $query->where('afrv_year_id', '=', $search_year);
    }
        $ttl_amnt = $query->sum('afrv_total_amount');
        $sections = $query_sections->get();
        $datas = $query->orderBy('afrv_id', config('global_variables.query_sorting'))
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
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type,$search_year, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.feeVoucher.advance_fee_reverse_voucher_list', compact('datas', 'search','search_year', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'search_class', 'search_status',
                'sections', 'search_section'));
        }
    }

    // update code by Mustafa start

    public function adv_fee_items_view_details(Request $request)
    {
        $user = Auth::user();

        $items = AdvanceFeeVoucher::where('afv_v_no', $request->id)->where('afv_clg_id', $user->user_clg_id)
//            ->where('afv_status', 1)
            ->orderby('afv_id', 'ASC')->get();
        return response()->json($items);
    }

    public function adv_fee_items_view_details_SH(Request $request, $id)
    {

        $user = Auth::user();
        $fee_voucher = AdvanceFeeVoucher::leftJoin('students', 'students.id', '=', 'advance_fee_vouchers.afv_std_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'advance_fee_vouchers.afv_branch_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'advance_fee_vouchers.afv_class_id')
            ->where('afv_v_no', $request->id)->where('afv_reg_no', $request->reg_no)->where('afv_clg_id', $user->user_clg_id)
//            ->where('afv_status', 1)
            ->first();
        $college_bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();
        $items = AdvanceFeeVoucher::where('afv_v_no', $request->id)->where('afv_reg_no', $request->reg_no)->where('afv_clg_id', $user->user_clg_id)->first();
        $type = 'grid';
        $pge_title = 'Advance Fee Voucher';

        return view('voucher_view.advance_fee_voucher.advance_fee_voucher', compact('items', 'fee_voucher', 'college_bank_info', 'type', 'pge_title'));
    }

    public function adv_fee_items_view_details_pdf_SH(Request $request, $id)
    {
        $user = Auth::user();
        $fee_vouchers = AdvanceFeeVoucher::leftJoin('students', 'students.id', '=', 'advance_fee_vouchers.afv_std_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'advance_fee_vouchers.afv_branch_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'advance_fee_vouchers.afv_class_id')
            ->where('afv_v_no', $request->id)->where('afv_reg_no', $request->reg_no)->where('afv_clg_id', $user->user_clg_id)->where('afv_status', 1)->get();
        $college_bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();
        $type = 'pdf';
        $pge_title = 'Advance Fee Voucher';

        $options = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ]);

        $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($options);
        $pdf->loadView('voucher_view.advance_fee_voucher.print_advance_fee_voucher', compact('college_bank_info', 'fee_vouchers', 'type', 'pge_title'));

        return $pdf->stream('Advance-Fee-Voucher-Detail.pdf');
    }

    //paid single fee voucher list without Bank MIS

    public function advance_fee_voucher_pending_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $classes = Classes::where('class_clg_id', '=', $user->user_clg_id)->where('class_disable_enable', '=', 1)->get();

        $accounts_array = $this->get_account_query('bank_voucher');
        $accounts = $accounts_array[1];


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_class = (!isset($request->class_id) && empty($request->class_id)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->class_id;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->year;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.fee_voucher_list.fee_voucher_pending_list';
        $pge_title = 'Advance Fee Voucher Pending List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_class,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('advance_fee_vouchers')
            ->leftJoin('students', 'students.id', 'advance_fee_vouchers.afv_std_id')
            ->leftJoin('classes', 'classes.class_id', 'advance_fee_vouchers.afv_class_id')
            ->leftJoin('branches', 'branches.branch_id', 'advance_fee_vouchers.afv_branch_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'advance_fee_vouchers.afv_createdby')
            ->where('afv_clg_id', $user->user_clg_id)
            ->where('afv_status', '=', 1);
        $ttl_amnt = $query->sum('afv_total_amount');

        if (!empty($request->search)) {
            $query->where('afv_v_no', 'like', '%' . $search . '%')
                ->orWhere('afv_reg_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_class)) {
            $query->where('afv_class_id', $search_class);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('afv_day_end_date', '>=', $start)
                ->whereDate('afv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('afv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('afv_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('afv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('afv_year_id', '=', $search_year);
        }
        $datas = $query
            ->where('afv_status', '=', 1)->select('advance_fee_vouchers.afv_id as id', 'advance_fee_vouchers.afv_status as status', 'advance_fee_vouchers.afv_total_amount as total_amount',  'advance_fee_vouchers.afv_t_fee as t_fee',  'advance_fee_vouchers.afv_fund as fund', 'advance_fee_vouchers.afv_v_no as v_no', 'advance_fee_vouchers.afv_reg_no as registration_no', 'advance_fee_vouchers.afv_std_id as student_id', 'students.full_name', 'classes.class_name')->orderBy('afv_id', config('global_variables.query_sorting'))
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
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $search_year,$prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.feeVoucher.advance_fee_voucher_pending_list', compact('datas', 'search','search_year', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'classes', 'search_class', 'accounts'));
        }
    }


    public function reverse_advance_fee_voucher(Request $request)
    {
        $voucher_number = $request->adv_id;
        $reg_no = $request->reg_no;
        $user = Auth::user();
        $advance_voucher = AdvanceFeeVoucher::where('afv_v_no', $voucher_number)->where('afv_reg_no', $reg_no)->first();
        $student_id = $advance_voucher->afv_std_id;
        Session::put('student_id', $student_id);

        $year_end_id = $advance_voucher->afv_year_id;
        $tution_fee = $advance_voucher->afv_t_fee;
        $funds = $advance_voucher->afv_fund;
        $total_fee = $advance_voucher->afv_total_amount;
        $account_uid = '210131,210134';

        $student = Student::where('id', $advance_voucher->afv_std_id)
            ->where('status', '!=', 3)
            ->select('id', 'full_name', 'registration_no', 'class_id', 'section_id')
            ->first();

        if ($total_fee > 0) {

            $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)
                ->pluck('pr_id')
                ->first();

            $class = $student->class_id;
            $section = $student->section_id;
            $get_day_end = new DayEndController();
            $day_end = $get_day_end->day_end();

            $rollBack = false;
            $flag = false;


            $values_array = [];

            $tution_account_name = $this->get_account_name('210131');
            $fund_account_name = $this->get_account_name('210134');
            $cash_account_name = $this->get_account_name('110101');
            if ($tution_fee > 0) {
                $values_array[] = [
                    '0' => '210131',
                    '1' => '210131' . ' - ' . $tution_account_name,
                    '2' => $tution_fee,
                    '3' => 'Dr',
                    '4' => $student->registration_no . '-' . $student->full_name,
                    '5' => $posting_reference,
                    '6' => $year_end_id,
                ];
            }
            if ($funds > 0) {
                $values_array[] = [
                    '0' => '210134',
                    '1' => '210134' . ' - ' . $fund_account_name,
                    '2' => $funds,
                    '3' => 'Dr',
                    '4' => $student->registration_no . '-' . $student->full_name,
                    '5' => $posting_reference,
                    '6' => $year_end_id,
                ];
            }

            $values_array[] = [
                '0' => '110101',
                '1' => '110101' . ' - ' . $cash_account_name,
                '2' => $total_fee,
                '3' => 'Cr',
                '4' => $student->registration_no . '-' . $student->full_name,
                '5' => $posting_reference,
                '6' => $year_end_id,
            ];


            $notes = 'ADVANCE_FEE_REVERSE_VOUCHER';
            $voucher_code = config('global_variables.ADVANCE_FEE_REVERSE_VOUCHER_CODE');
            $transaction_type = config('global_variables.ADVANCE_REVERSE_VOUCHER');

            DB::beginTransaction();

            $advance_fee = new AdvanceFeeReverseVoucher();
            $advance_fee = $this->assign_advance_fee_reverse_voucher_values(
                'afrv', $advance_fee, $voucher_number, $account_uid, $total_fee, $user, $day_end, $class, $section,
                $student_id, $tution_fee, $funds
            );

            if ($advance_fee->save()) {
                $afv_id = $advance_fee->afrv_id;
                $afv_voucher_no = $voucher_number;
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()
                    ->back()
                    ->with('fail', 'Failed');
            }
            $detail_remarks = '';

            if (!empty($tution_fee)) {
                $detail_remarks .= $afv_voucher_no . ' - ' . $tution_account_name . ', @' . number_format($tution_fee, 2) . config('global_variables.Line_Break');
            }
            if (!empty($funds)) {
                $detail_remarks .= $afv_voucher_no . ' - ' . $fund_account_name . ', @' . number_format($funds, 2) . config('global_variables.Line_Break');
            }


            foreach ($values_array as $key) {
                $transaction = new TransactionModel();

                if ($key[3] == 'Dr') {
                    $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $afv_id);

                    if ($transaction->save()) {
                        $transaction_id = $transaction->trans_id;
                        $balances = new BalancesModel();

                        $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code . $afv_id, $key[5], $voucher_code . $afv_voucher_no,$key[6]);

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
                } else {
                    $transaction = $this->AssignTransactionsValues($transaction, 0, $key[2], $key[0], 'ADVANCE FEE VOUCHER', 5, $afv_id);

                    if ($transaction->save()) {
                        $transaction_id = $transaction->trans_id;
                        $balances = new BalancesModel();

                        $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code . $afv_id, $key[5], $voucher_code . $afv_voucher_no,$key[6]);

                        if (!$balance->save()) {
                            $flag = true;
                            DB::rollBack();
                            return redirect()
                                ->back()
                                ->with('fail', 'Failed');
                        }

                        // student balance table entry start
                        $std_balances = new StudentBalances();

                        $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Cr', $notes, $afv_voucher_no . ' - ' . $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'), $voucher_code . $afv_id, $student->id, $student->registration_no);
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
                }
            }

            if ($flag) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->with('fail', 'Failed');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Advance Voucher With Id: ' . $advance_fee->afrv_id);
                $advance_fee->afrv_detail_remarks = $detail_remarks;
                $advance_fee->save();
                $advance_voucher->afv_status = 3;
                $advance_voucher->save();
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
            }
        }
    }

    public function assign_advance_fee_reverse_voucher_values(
        $prfx, $voucher, $voucher_number, $account_uid, $total_voucher_amount, $user, $day_end, $class_id, $section_id,
        $std_id, $tution_fee, $fund
    )
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $v_no = $prfx . '_v_no';
        $class = $prfx . '_class_id';
        $section = $prfx . '_section_id';
        $student_id = $prfx . '_std_id';
        $student_reg = $prfx . '_reg_no';
        $account_id = $prfx . '_account_id';

        $tution_fees = $prfx . '_t_fee';
        $funds = $prfx . '_fund';
        $total_amount = $prfx . '_total_amount';
        $created_datetime = $prfx . '_created_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $year_id = $prfx . '_year_id';

        $voucher->$v_no = $voucher_number;

        $voucher->$class = $class_id;
        $voucher->$section = $section_id;
        $voucher->$student_id = $std_id;
        $voucher->$student_reg = $this->get_registration_number($std_id);
        $voucher->$account_id = $account_uid;
        $voucher->$tution_fees = $tution_fee;
        $voucher->$funds = $fund;

        $voucher->$total_amount = $total_voucher_amount;
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

}
