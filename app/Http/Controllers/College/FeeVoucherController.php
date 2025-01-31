<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Models\AdvanceFeeVoucher;
use App\Models\College\BankAccountModel;
use App\Models\College\CustomVoucherModel;
use App\Models\College\Section;
use App\Models\College\Student;
use App\Models\College\StudentInstallment;
use App\Models\College\TransportVoucherModel;
use Session;
use App\Models\College\Classes;
use App\Models\College\FeeVoucherModel;
use App\Models\CreateSectionModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FeeVoucherController extends Controller
{
    public function fee_voucher()
    {
        $classes = Classes::where('class_clg_id', Auth::user()->user_clg_id)->get();
        $months = StudentInstallment::where('si_clg_id', Auth::user()->user_clg_id)->where('si_status_update', 0)->groupBy('si_month_year')->orderBy('si_id')->pluck('si_month_year');
        return view('collegeViews.feeVoucher.fee_voucher', compact('classes', 'months'));
    }

    public function submit_fee_voucher(Request $request)
    {
        $student_ids = StudentInstallment::
        where('si_class_id', $request->class)->where('si_section_id', $request->section)->where('si_total_amount', '>', 0)->where('si_status_update', 0)->where('si_month_year',
            $request->month)
            ->where('si_branch_id', Session::get('branch_id'))
            ->leftJoin('students', 'students.id', '=', 'student_installments.si_std_id')
            ->where('student_disable_enable', 1)
            ->where('status', '!=', 3)
            ->groupBy('si_std_id')->pluck('si_std_id');

        $this->fee_voucher_validation($request);
        $rollBack = false;

        $user = Auth::user();

        $account_uid = '110201,110202,110203';

        $voucher_remarks = '';
        $month = $request->month;
        $issue_date = date('Y-m-d', strtotime($request->issue_date));
        $due_date = date('Y-m-d', strtotime($request->due_date));


        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        DB::beginTransaction();
        foreach ($student_ids as $student_id) {
            $installment = StudentInstallment::where('si_month_year', '=', $month)
                ->where('si_status_update', 0)
                ->where('si_total_amount', '>', 0)
                ->where('si_std_id', $student_id)
                ->first();


            $fv = new FeeVoucherModel();

            $fv = $this->assign_fee_voucher_values(
                'fv',
                $fv,
                $account_uid,
                $installment->si_total_amount,
                $voucher_remarks,
                $user,
                $day_end,
                $installment->si_class_id,
                $installment->si_section_id,
                $month,
                $due_date,
                $student_id,
                $installment->si_id,
                $installment->si_t_fee,
                $installment->si_p_fund,
                $installment->si_a_fund,
                $installment->si_z_fund,
                $installment->si_semester_id,
                $installment->si_package_type,
                $issue_date
            );

            if ($fv->save()) {
                $installment->si_fid = $fv->fv_v_no;
                $installment->si_status_update = 3;
                $installment->save();
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }
        }

        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
            //            return redirect()->back()->with(['fv_id' => $fv_id, 'success' => 'Successfully Saved']);
        }
    }

    public function fee_single_voucher_validation($request)
    {
        return $this->validate($request, [
            'month' => ['required'],
            'issue_date' => ['required'],
            'due_date' => ['required'],
        ]);
    }

    public function fee_voucher_validation($request)
    {
        return $this->validate($request, [
            'class' => ['required'],
            'month' => ['required'],
            'issue_date' => ['required'],
            'due_date' => ['required'],
        ]);
    }

    public function assign_fee_voucher_values(
        $prfx,
        $voucher,
        $account_uid,
        $total_voucher_amount,
        $voucher_remarks,
        $user,
        $day_end,
        $class_id,
        $section_id,
        $month_year,
        $due_date,
        $std_id,
        $instalment_id,
        $t_fee,
        $p_fund,
        $a_fund,
        $z_fund,
        $semester_id,
        $package_type,
        $issue_date
    )
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $v_no = $prfx . '_v_no';
        $instalment = $prfx . '_installment_id';
        $class = $prfx . '_class_id';
        $section = $prfx . '_section_id';
        $student_id = $prfx . '_std_id';
        $student_reg = $prfx . '_std_reg_no';
        $month = $prfx . '_month';
        $col_due_date = $prfx . '_due_date';
        $col_issue_date = $prfx . '_issue_date';
        $account_id = $prfx . '_account_id';

        $tution_fee = $prfx . '_t_fee';
        $paper_fund = $prfx . '_p_fund';
        $annual_fund = $prfx . '_a_fund';
        $zakat_fund = $prfx . '_z_fund';
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
        $col_semester = $prfx . '_semester_id';
        $col_package_type = $prfx . '_package_type';
        $col_year_id = $prfx . '_year_id';

//        $maxId = FeeVoucherModel::where('fv_clg_id', $user->user_clg_id)->orderBy('fv_id', 'DESC')->pluck('fv_v_no')->first();
        $maxId = FeeVoucherModel::lockForUpdate()->selectRaw('MAX(CAST(fv_v_no AS UNSIGNED)) as max_fv_v_no')
            ->where('fv_clg_id', $user->user_clg_id)
            ->where('fv_v_no', 'like', '7%')
            ->value('max_fv_v_no');
        $new_value = $maxId ? (int)substr($maxId, 1) : null;
        if ($maxId == null) {
            $voucher_number = $new_value + 1;
            $voucher_number = 100 + $voucher_number;
            $voucher->$v_no = '7' . $voucher_number;
        } else {
            $voucher->$v_no = '7' . $new_value + 1;
        }

        $voucher->$instalment = $instalment_id;
        $voucher->$class = $class_id;
        $voucher->$section = $section_id;
        $voucher->$student_id = $std_id;
        $voucher->$student_reg = $this->get_registration_number($std_id);
        $voucher->$month = $month_year;
        $voucher->$col_due_date = $due_date;
        $voucher->$col_issue_date = $issue_date;
        $voucher->$account_id = $account_uid;

        $voucher->$tution_fee = $t_fee;
        $voucher->$paper_fund = $p_fund;
        $voucher->$annual_fund = $a_fund;
        $voucher->$zakat_fund = $z_fund;

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
        $voucher->$col_semester = $semester_id;
        $voucher->$col_package_type = $package_type;
        $voucher->$col_year_id = $this->getYearEndId();
        return $voucher;
    }

    function get_students_for_fee(Request $request)
    {
        $student_ids = StudentInstallment::where('si_month_year', $request->month)
            ->where('si_class_id', $request->class_id)
            ->where('si_section_id', $request->section_id)
            ->where('si_total_amount', '>', 0)
            ->where('si_status_update', 0)
            ->where('si_branch_id', Session::get('branch_id'))
            ->leftJoin('students', 'students.id', '=', 'student_installments.si_std_id')
            ->where('student_disable_enable', 1)
            ->where('status', '!=', 3)
            ->groupBy('si_std_id')->pluck('si_std_id')->count();
        return response()->json(['students' => $student_ids]);
    }

    // update code by Mustafa start
    public function fee_voucher_list(Request $request, $array = null, $str = null)
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
        $search_type = (!isset($request->type) && empty($request->type)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->type;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[8]->{'value'} : '') : $request->year;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.fee_voucher_list.fee_voucher_list';
        $pge_title = 'Fee Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_class, $search_section, $search_status, $search_type, $search_year);

        $pagination_number = (empty($ar)) ? 100 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_fee_voucher')
            ->leftJoin('students', 'students.id', 'financials_fee_voucher.fv_std_id')
            ->where('students.status', '!=', 3)
            ->leftJoin('classes', 'classes.class_id', 'financials_fee_voucher.fv_class_id')
            ->leftJoin('create_section', 'create_section.cs_id', 'financials_fee_voucher.fv_section_id')
            ->leftJoin('branches', 'branches.branch_id', 'financials_fee_voucher.fv_branch_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_fee_voucher.fv_createdby')
            ->where('fv_clg_id', $user->user_clg_id)
            ->where('fv_branch_id', Session::get('branch_id'));
        $ttl_amnt = $query->sum('fv_total_amount');

        if (!empty($request->search)) {
            $query->where('fv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('fv_remarks', 'like', '%' . $search . '%')
                ->orWhere('fv_id', 'like', '%' . $search . '%')
                ->orWhere('fv_v_no', 'like', '%' . $search . '%')
                ->orWhere('fv_std_reg_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)->pluck('section_name');
            $query->where('fv_class_id', $search_class);
            $query_sections->whereIn('cs_id', $section);
        }

        if (!empty($search_section)) {
            $query->where('fv_section_id', $search_section);
        }

        if (!empty($search_type)) {
            $query->where('fv_package_type', $search_type);
        }
        if ($search_status != '') {
            $query->where('fv_status_update', '=', $search_status);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('fv_day_end_date', '>=', $start)
                ->whereDate('fv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('fv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('fv_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('fv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('fv_year_id', '=', $search_year);
        }
        $sections = $query_sections->get();
        $datas = $query->orderBy('fv_id', config('global_variables.query_sorting'))
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
            return view('collegeViews.feeVoucher.fee_voucher_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'search_class', 'search_status', 'sections', 'search_section', 'search_type'));
        }
    }

    public function month_wise_fee_voucher_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $query_sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_class = (isset($request->class) && !empty($request->class)) ? $request->class : '';
        $search_section = (isset($request->section) && !empty($request->section)) ? $request->section : '';
        $search_status = (isset($request->status) && !empty($request->status)) ? $request->status : '';
        $prnt_page_dir = 'print.college.month_wise_fee_voucher_list.month_wise_fee_voucher_list';
        $pge_title = 'Month Wise Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_class, $search_section, $search_status);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_fee_voucher')
            ->leftJoin('classes', 'classes.class_id', 'financials_fee_voucher.fv_class_id')
            ->leftJoin('create_section', 'create_section.cs_id', 'financials_fee_voucher.fv_section_id')
            ->where('fv_clg_id', $user->user_clg_id)
            ->where('fv_status_update', '=', 0)
            ->where('fv_branch_id', '=', Session::get('branch_id'))
            ->selectRaw('count(fv_std_id) as total_students, sum(fv_total_amount) as total_amount, fv_month, classes.class_name,fv_class_id,create_section.cs_name,fv_section_id,fv_issue_date,fv_due_date');
        $ttl_amnt = $query->sum('fv_total_amount');

        //        $query = DB::table('financials_fee_voucher')
        //            ->leftJoin('students', 'students.id', 'financials_fee_voucher.fv_std_id')
        //            ->leftJoin('classes', 'classes.class_id', 'financials_fee_voucher.fv_class_id')
        //            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_fee_voucher.fv_createdby')
        //            ->where('fv_clg_id', $user->user_clg_id);
        //        $ttl_amnt = $query->sum('fv_total_amount');

        if (!empty($request->search)) {
            $query->where('fv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('fv_remarks', 'like', '%' . $search . '%')
                ->orWhere('fv_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('fv_createdby', $search_by_user);
        }

        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)->pluck('section_name');
            $query->where('fv_class_id', $search_class);
            $query_sections->whereIn('cs_id', $section);
        }
        if (!empty($search_section)) {
            $query->where('fv_section_id', $search_section);
        }
        if (!empty($search_status)) {
            $query->where('fv_status_update', $search_status);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('fv_day_end_date', '>=', $start)
                ->whereDate('fv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('fv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('fv_day_end_date', $end);
        }
        $sections = $query_sections->get();
        $datas = $query->groupBy('fv_class_id', 'fv_section_id', 'fv_month', 'fv_issue_date')->orderBy('fv_id', config('global_variables.query_sorting'))
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
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'datas', 'type', 'ttl_amnt', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $ttl_amnt, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.feeVoucher.month_wise_fee_voucher_list', compact('datas', 'search', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'search_status', 'search_class', 'search_section', 'sections'));
        }
    }

    // update code by Mustafa end


    public function fee_items_view_details(Request $request)
    {
        $user = Auth::user();

        $items = FeeVoucherModel::where('fv_v_no', $request->id)->where('fv_clg_id', $user->user_clg_id)
            //->where('fv_status_update', 0)
            ->orderby('fv_id', 'ASC')->get();
        return response()->json($items);
    }

    public function fee_items_view_details_SH(Request $request, $id)
    {

        $user = Auth::user();
        $fee_voucher = FeeVoucherModel::leftJoin('students', 'students.id', '=', 'financials_fee_voucher.fv_std_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'financials_fee_voucher.fv_branch_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'financials_fee_voucher.fv_class_id')
            ->where('fv_v_no', $request->id)->where('fv_std_reg_no', $request->reg_no)->where('fv_clg_id', $user->user_clg_id)
            //->where('fv_status_update', 0)
            ->first();
        $college_bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();
        $items = FeeVoucherModel::where('fv_v_no', $request->id)->where('fv_std_reg_no', $request->reg_no)->where('fv_clg_id', $user->user_clg_id)->first();
        $type = 'grid';
        $pge_title = 'Fee Voucher';

        return view('voucher_view.feeVoucher.view_fee_voucher_all', compact('items', 'fee_voucher', 'college_bank_info', 'type', 'pge_title'));
    }

    public function fee_items_view_details_pdf_SH(Request $request, $id)
    {
        $user = Auth::user();
        $fee_vouchers = FeeVoucherModel::leftJoin('students', 'students.id', '=', 'financials_fee_voucher.fv_std_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'financials_fee_voucher.fv_branch_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'financials_fee_voucher.fv_class_id')
            ->where('fv_v_no', $request->id)->where('fv_std_reg_no', $request->reg_no)->where('fv_clg_id', $user->user_clg_id)
            //->where('fv_status_update', 0)
            ->get();
        $college_bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();
        $type = 'pdf';
        $pge_title = 'Fee Voucher';

        $options = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ]);

        $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($options);
        $pdf->loadView('voucher_view.feeVoucher.print_fee_voucher_all', compact('college_bank_info', 'fee_vouchers', 'type', 'pge_title'));

        return $pdf->stream('Fee-Voucher-Detail.pdf');
    }

    public function month_fee_items_view_details(Request $request)
    {
        $user = Auth::user();
        $items = FeeVoucherModel::where('fv_section_id', $request->id)->where('fv_status_update', 0)->where('fv_clg_id', $user->user_clg_id)->orderby('fv_id', 'ASC')->get();

        return response()->json($items);
    }

    public function month_fee_items_view_details_SH(Request $request, $id)
    {
        $user = Auth::user();
        $section_id = $request->id;
        $class_id = $request->class_id;
        $month = $request->month;
        $issue_date = $request->issue_date;
        $fee_vouchers = FeeVoucherModel::leftJoin('students', 'students.id', '=', 'financials_fee_voucher.fv_std_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'financials_fee_voucher.fv_branch_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'financials_fee_voucher.fv_class_id')
            ->where('fv_class_id', $class_id)
            ->where('fv_section_id', $section_id)
            ->where('fv_month', $month)
            ->where('fv_status_update', 0)
            ->where('fv_clg_id', $user->user_clg_id)
            ->where('fv_issue_date', $issue_date)
            ->where('fv_branch_id', Session::get('branch_id'))
            ->get();
        $college_bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();

        $type = 'grid';
        $pge_title = 'Fee Voucher';

        return view('voucher_view.feeVoucher.view_fee_voucher_monthly', compact('fee_vouchers', 'section_id', 'class_id', 'month', 'issue_date', 'college_bank_info', 'type', 'pge_title'));
    }

    public function month_fee_items_view_details_pdf_SH(Request $request, $id)
    {
        $user = Auth::user();
        $section_id = $request->id;
        $class_id = $request->class_id;
        $month = $request->month;
        $issue_date = $request->issue_date;
        $fee_vouchers = FeeVoucherModel::leftJoin('students', 'students.id', '=', 'financials_fee_voucher.fv_std_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'financials_fee_voucher.fv_branch_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'financials_fee_voucher.fv_class_id')
            ->where('fv_class_id', $class_id)
            ->where('fv_section_id', $section_id)
            ->where('fv_month', $month)
            ->where('fv_status_update', 0)
            ->where('fv_clg_id', $user->user_clg_id)
            ->where('fv_issue_date', $issue_date)
            ->where('fv_branch_id', Session::get('branch_id'))
            ->get();
        $college_bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();
        $type = 'pdf';
        $pge_title = 'Fee Voucher';

        $options = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ]);

        $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($options);
        $pdf->loadView('voucher_view.feeVoucher.print_fee_voucher_monthly', compact('college_bank_info', 'fee_vouchers', 'class_id', 'type', 'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Fee-Voucher-Detail.pdf');
    }

    public function update_fee_voucher_no(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        $sections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_branch_id', Session::get('branch_id'))->get();
        $months = FeeVoucherModel::where('fv_clg_id', $user->user_clg_id)->groupBy('fv_month')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->class;
        $search_month = (!isset($request->month) && empty($request->month)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->month;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->section;

        $prnt_page_dir = 'print.bank_payment_voucher_list.bank_payment_voucher_list';
        $pge_title = 'Bank Payment Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_class, $search_month, $search_section);

        $pagination_number = (empty($ar)) ? 100000000 : 100000000;

        //        $query = BankPaymentVoucherModel::query();
        $query = DB::table('financials_fee_voucher')
            ->leftJoin('students', 'students.id', 'financials_fee_voucher.fv_std_id')
            ->leftJoin('classes', 'classes.class_id', 'financials_fee_voucher.fv_class_id')
            ->leftJoin('create_section', 'create_section.cs_id', 'financials_fee_voucher.fv_section_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_fee_voucher.fv_createdby')
            ->where('fv_status_update', '=', 0)
            ->where('fv_branch_id', '=', Session::get('branch_id'))
            ->where('fv_clg_id', '=', $user->user_clg_id);
        $ttl_amnt = $query->sum('fv_total_amount');

        if (!empty($search)) {
            $query->where('fv_std_reg_no', 'like', '%' . $search . '%')
                ->orWhere('students.full_name', 'like', '%' . $search . '%')
                ->orWhere('fv_v_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_class)) {
            $query->where('financials_fee_voucher.fv_class_id', $search_class);
        }
        if (!empty($search_section)) {
            $query->where('financials_fee_voucher.fv_section_id', $search_section);
        }
        if (!empty($search_month)) {
            $query->where('financials_fee_voucher.fv_month', $search_month);
        }

        if (!empty($search_section) || !empty($search_month) || !empty($search_class) || !empty($search)) {

            $datas = $query->orderBy('fv_id', config('global_variables.query_sorting'))
                ->paginate($pagination_number);
        } else {

            $datas = $query->orderBy('fv_id', config('global_variables.query_sorting'))
                ->take(50)
                ->get();
        }


        $students = Student::orderBy('registration_no', 'ASC')->pluck('registration_no')->all();
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
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.feeVoucher.update_fee_voucher_no', compact('datas', 'search_class', 'search_month', 'search_section', 'months', 'ttl_amnt', 'classes', 'sections', 'students'));
        }
    }

    public function submit_fee_voucher_no(Request $request)
    {
        $requested_arrays = $request->v_id;

        foreach ($requested_arrays as $index => $requested_array) {

            $item_voucher_no = $request->voucher_no[$index];
            $item_v_no = $request->v_no[$index];
            $item_v_id = $request->v_id[$index];

            if ($item_voucher_no != null) {
                StudentInstallment::where('si_fid', $item_v_no)->update(['si_fid' => $item_voucher_no]);
                FeeVoucherModel::where('fv_id', $item_v_id)->where('fv_v_no', $item_v_no)->update(['fv_v_no' => $item_voucher_no]);
            }
        }

        return redirect()->back()->with('success', 'Saved successfully!');
    }


    public function submit_single_fee_voucher(Request $request)
    {
        Session::put('student_id', $request->gen_ins_std_id);
        $this->fee_single_voucher_validation($request);
        $rollBack = false;

        $user = Auth::user();

        $account_uid = '110201,110202,110203';

        $voucher_remarks = '';
        $month = $request->month;
        $issue_date = date('Y-m-d', strtotime($request->issue_date));
        $due_date = date('Y-m-d', strtotime($request->due_date));
        $student_id = $request->gen_ins_std_id;

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        DB::beginTransaction();
        if (!empty($student_id)) {
            $installment = StudentInstallment::where('si_status_update', 0)
                ->where('si_id', $request->gen_ins_id)
                ->first();

            $fv = new FeeVoucherModel();
//            $fv_v_no = FeeVoucherModel::where('fv_clg_id', $user->user_clg_id)->count();

            $fv = $this->assign_fee_voucher_values(
                'fv',
                $fv,
                $account_uid,
                $installment->si_total_amount,
                $voucher_remarks,
                $user,
                $day_end,
                $installment->si_class_id,
                $installment->si_section_id,
                $month,
                $due_date,
                $student_id,
                $installment->si_id,
                $installment->si_t_fee,
                $installment->si_p_fund,
                $installment->si_a_fund,
                $installment->si_z_fund,
                $installment->si_semester_id,
                $installment->si_package_type,
                $issue_date
            );

            if ($fv->save()) {
                $installment->si_fid = $fv->fv_v_no;
                $installment->si_status_update = 3;
                $installment->save();
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }
        }
        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            DB::commit();
            return redirect()->route('create_installments')->with('success', 'Successfully Saved');
        }
    }

    public function update_due_date($id, Request $request)
    {
        Session::put('student_id', $request->student_id);
        $due_date = date('Y-m-d', strtotime($request->due_date));
        $voucher_type = $request->type;

        if ($voucher_type == 'tv') {
            TransportVoucherModel::where('tv_id', $id)->update(['tv_due_date' => $due_date]);
        } elseif ($voucher_type == 'fv') {
            FeeVoucherModel::where('fv_id', $id)->update(['fv_due_date' => $due_date]);
        } elseif ($voucher_type == 'cv') {
            CustomVoucherModel::where('cv_id', $id)->update(['cv_due_date' => $due_date]);
        }
        return redirect()->back()->with('success', 'Date Changed Successfully!');
    }

//    paid single fee voucher list without Bank MIS

    public function fee_voucher_pending_list(Request $request, $array = null, $str = null)
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
        $search_status = (!isset($request->status) && empty($request->status)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->status;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.fee_voucher_list.fee_voucher_pending_list';
        $pge_title = 'Fee Voucher Pending List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_class, $search_status, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        if (empty($search_status)) {
            $search_status = 'fee_voucher';
        }

        if ($search_status == 'custom_voucher') {

            $query = DB::table('student_custom_voucher as custom_voucher')
                ->leftJoin('students', 'students.id', 'custom_voucher.cv_std_id')
                ->leftJoin('classes', 'classes.class_id', 'custom_voucher.cv_class_id')
                ->leftJoin('financials_users', 'financials_users.user_id', 'custom_voucher.cv_createdby')
                ->where('cv_clg_id', $user->user_clg_id);
            $ttl_amnt = $query->sum('cv_total_amount');

            if (!empty($request->search)) {
                $query->where('cv_total_amount', 'like', '%' . $search . '%')
                    ->orWhere('cv_remarks', 'like', '%' . $search . '%')
                    ->orWhere('cv_id', 'like', '%' . $search . '%')
                    ->orWhere('cv_v_no', 'like', '%' . $search . '%');
            }

            if (!empty($search_by_user)) {
                $query->where('cv_createdby', $search_by_user);
            }

            if (!empty($search_class)) {
                $query->where('cv_class_id', $search_class);
            }

            if ((!empty($search_to)) && (!empty($search_from))) {
                $query->whereDate('cv_day_end_date', '>=', $start)
                    ->whereDate('cv_day_end_date', '<=', $end);
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
            $datas = $query
                ->where('cv_status', '=', 'Pending')->select('custom_voucher.cv_id as id', 'custom_voucher.cv_total_amount as total_amount', 'custom_voucher.cv_v_no as v_no', 'custom_voucher.cv_reg_no as registration_no', 'custom_voucher.cv_std_id as student_id', 'students.full_name', 'classes.class_name')
                ->orderBy('cv_id', config('global_variables.query_sorting'))
                ->paginate($pagination_number);

        } elseif ($search_status == 'transport_voucher') {
            $query = DB::table('transport_voucher')
                ->leftJoin('students', 'students.id', 'transport_voucher.tv_std_id')
                ->leftJoin('classes', 'classes.class_id', 'students.class_id')
                ->leftJoin('branches', 'branches.branch_id', 'transport_voucher.tv_branch_id')
                ->leftJoin('financials_users', 'financials_users.user_id', 'transport_voucher.tv_createdby')
                ->where('tv_clg_id', $user->user_clg_id)
                ->where('tv_status', '=', 0);
            $ttl_amnt = $query->sum('tv_total_amount');

            if (!empty($request->search)) {
                $query->where('tv_v_no', 'like', '%' . $search . '%')
                    ->orWhere('tv_reg_no', 'like', '%' . $search . '%');
            }

            if (!empty($search_class)) {
                $query->where('class_id', $search_class);
            }

            if ((!empty($search_to)) && (!empty($search_from))) {
                $query->whereDate('tv_day_end_date', '>=', $start)
                    ->whereDate('tv_day_end_date', '<=', $end);
            } elseif (!empty($search_to)) {
                $query->where('tv_day_end_date', $start);
            } elseif (!empty($search_from)) {
                $query->where('tv_day_end_date', $end);
            }
            if (!empty($search_year)) {
                $query->where('tv_year_id', '=', $search_year);
            } else {
                $search_year = $this->getYearEndId();
                $query->where('tv_year_id', '=', $search_year);
            }
            $datas = $query
                ->where('tv_status', '=', 0)->select('transport_voucher.tv_id as id', 'transport_voucher.tv_status as status', 'transport_voucher.tv_total_amount as total_amount', 'transport_voucher.tv_v_no as v_no', 'transport_voucher.tv_reg_no as registration_no', 'transport_voucher.tv_std_id as student_id', 'students.full_name', 'classes.class_name')->orderBy('tv_id', config('global_variables.query_sorting'))
                ->paginate($pagination_number);
        } else {
            $query = DB::table('financials_fee_voucher')
                ->leftJoin('students', 'students.id', 'financials_fee_voucher.fv_std_id')
                ->leftJoin('classes', 'classes.class_id', 'financials_fee_voucher.fv_class_id')
                ->leftJoin('branches', 'branches.branch_id', 'financials_fee_voucher.fv_branch_id')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_fee_voucher.fv_createdby')
                ->where('fv_clg_id', $user->user_clg_id)
                ->where('fv_status_update', '=', 0);
            $ttl_amnt = $query->sum('fv_total_amount');

            if (!empty($request->search)) {
                $query->where('fv_v_no', 'like', '%' . $search . '%')
                    ->orWhere('fv_std_reg_no', 'like', '%' . $search . '%');
            }

            if (!empty($search_class)) {
                $query->where('fv_class_id', $search_class);
            }

            if ((!empty($search_to)) && (!empty($search_from))) {
                $query->whereDate('fv_day_end_date', '>=', $start)
                    ->whereDate('fv_day_end_date', '<=', $end);
            } elseif (!empty($search_to)) {
                $query->where('fv_day_end_date', $start);
            } elseif (!empty($search_from)) {
                $query->where('fv_day_end_date', $end);
            }
            if (!empty($search_year)) {
                $query->where('fv_year_id', '=', $search_year);
            } else {
                $search_year = $this->getYearEndId();
                $query->where('fv_year_id', '=', $search_year);
            }
            $datas = $query
                ->where('fv_status_update', '=', 0)->select('financials_fee_voucher.fv_id as id', 'financials_fee_voucher.fv_status_update as status', 'financials_fee_voucher.fv_total_amount as total_amount', 'financials_fee_voucher.fv_v_no as v_no', 'financials_fee_voucher.fv_std_reg_no as registration_no', 'financials_fee_voucher.fv_std_id as student_id', 'students.full_name', 'classes.class_name')->orderBy('fv_id', config('global_variables.query_sorting'))
                ->paginate($pagination_number);
        }


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
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.feeVoucher.fee_voucher_pending_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'classes', 'search_class', 'search_status', 'accounts'));
        }
    }

    public function get_paid_voucher(Request $request)
    {
        $fee_paid_vouchers = FeeVoucherModel::where('fv_std_id', $request->user_id)->where('fv_status_update', 1)->get();
        $fee_unpaid_vouchers = FeeVoucherModel::where('fv_std_id', $request->user_id)->where('fv_status_update', 0)->get();

        $custom_unpaid_vouchers = CustomVoucherModel::where('cv_std_id', $request->user_id)->where('cv_status', 'Pending')
            ->leftJoin('student_custom_voucher_items', 'student_custom_voucher_items.cvi_voucher_id', '=', 'student_custom_voucher.cv_id')
            ->get();
        $custom_paid_vouchers = CustomVoucherModel::where('cv_std_id', $request->user_id)->where('cv_status', 'Paid')
            ->leftJoin('student_custom_voucher_items', 'student_custom_voucher_items.cvi_voucher_id', '=', 'student_custom_voucher.cv_id')
            ->get();

        $advance_unpaid_fee_voucher = AdvanceFeeVoucher::where('afv_std_id', $request->user_id)->where('afv_status', 1)
            ->select('afv_v_no', 'afv_t_fee', 'afv_fund', 'afv_total_amount', 'afv_created_datetime', 'afv_status', 'afv_paid_date', 'afv_due_date')
            ->get();
        $advance_paid_fee_voucher = AdvanceFeeVoucher::where('afv_std_id', $request->user_id)->where('afv_status', 2)
            ->select('afv_v_no', 'afv_t_fee', 'afv_fund', 'afv_total_amount', 'afv_created_datetime', 'afv_status', 'afv_paid_date', 'afv_due_date')
            ->get();

        $unpaid_transport_voucher = TransportVoucherModel::where('tv_std_id', $request->user_id)->whereNotIN('tv_status', [1,2])
            ->select('tv_v_no', 'tv_reg_no', 'tv_month', 'tv_total_amount', 'tv_issue_date', 'tv_due_date', 'tv_paid_date', 'tv_status')
            ->get();
        $paid_transport_voucher = TransportVoucherModel::where('tv_std_id', $request->user_id)->whereNotIN('tv_status', [0,2])
            ->select('tv_v_no', 'tv_reg_no', 'tv_month', 'tv_total_amount', 'tv_issue_date', 'tv_due_date', 'tv_paid_date', 'tv_status')
            ->get();
        return response()->json(['advance_paid_fee_voucher' => $advance_paid_fee_voucher, 'advance_unpaid_fee_voucher' => $advance_unpaid_fee_voucher, 'fee_paid_vouchers' => $fee_paid_vouchers, 'fee_unpaid_vouchers' => $fee_unpaid_vouchers, 'custom_unpaid_vouchers' => $custom_unpaid_vouchers, 'custom_paid_vouchers' => $custom_paid_vouchers, 'paid_transport_voucher' => $paid_transport_voucher, 'unpaid_transport_voucher' => $unpaid_transport_voucher], 200);
    }

    public function push_voucher()
    {
        return view('collegeViews.pushVoucher.push_voucher');
    }

}
