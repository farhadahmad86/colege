<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Http\Controllers\SaveImageController;
use App\Models\AccountRegisterationModel;
use App\Models\AdvanceFeeReverseVoucher;
use App\Models\AdvanceFeeVoucher;
use App\Models\BalancesModel;
use App\Models\College\Classes;
use App\Models\College\ComponentModel;
use App\Models\College\CustomVoucherModel;
use App\Models\College\DecrementIncrementModel;
use App\Models\College\ExamModel;
use App\Models\College\FeeVoucherModel;
use App\Models\College\MarkExamModel;
use App\Models\College\Semester;
use App\Models\College\Student;
use App\Models\College\StudentBalances;
use App\Models\College\StudentInstallment;
use App\Models\College\StudentPackage;
use App\Models\College\StudentPackageItems;
use App\Models\College\StudentsPackageModel;
use App\Models\College\TransportRouteModel;
use App\Models\College\TransportVoucherModel;
use App\Models\CreateSectionModel;
use App\Models\DayEndModel;
use App\Models\PostingReferenceModel;
use App\Models\StudentAttendanceModel;
use App\Models\TransactionModel;
use App\Models\Utility;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentBookedPackageController extends Controller
{
    // update code by farhad  start
    public function student_register_list(Request $request, $array = null, $str = null)
    {
        Session::forget('student_id');
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = Student::join('financials_users as user', 'user.user_id', '=', 'students.created_by')
            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'students.branch_id')
            ->where('clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('full_name', 'like', '%' . $search . '%')
                ->orWhere('registration_no', 'like', '%' . $search . '%')
                ->orWhere('cnic', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {

            $query->where('created_by', $search_by_user);
        }

        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('delete_status', '=', 1);
        // } else {
        //     $query->where('delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('id', 'DESC')
            ->select('students.*', 'user.user_id', 'user.user_name', 'classes.class_name', 'branches.branch_name')
            ->paginate($pagination_number);
        // ->get();

        $student_title = Student::where('clg_id', $user->user_clg_id)->orderBy('id', config('global_variables.query_sorting'))->pluck('full_name')->all(); //where('delete_status', '!=', 1)->
        //where('delete_status', '!=', 1)->


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
            return view('collegeViews.student.student_register_list', compact('datas', 'search', 'student_title', 'search_by_user', 'restore_list'));
        }
    }

    // update code by Farhad end

    /**
     * Show the form for editing the specified resource.
     */
    public function get_package(Request $request)
    {
        $user = Auth::user();
        $package = StudentsPackageModel::where('sp_id', $request->package_id)->first();
        $student = Student::leftJoin('classes', 'classes.class_id', '=', 'students.class_id')->where('clg_id', $user->user_clg_id)->where('id', $package->sp_sid)->select('classes.class_type')->first();

        if ($student->class_type == 'Annual') {
            $query = Semester::whereIn('semester_name', ['Annual 1st Year', 'Annual 2nd Year']);
        } else {
            $query = Semester::whereNotIN('semester_name', ['Annual 1st Year', 'Annual 2nd Year']);
        }
        $semesters = $query->where('semester_clg_id', $user->user_clg_id)->get();


        return response()->json(['package' => $package, 'semesters' => $semesters]);
    }

    public function create_installments(Request $request, $array = null, $str = null)
    {
        $std_id = Session::get('student_id');
        $branch_id = Session::get('branch_id');
        $user = Auth::user();
        $currentYear = Carbon::now()->format('Y');
        if (empty($request->student_id) && empty($std_id)) {
            return redirect()->route('student_dashboard');
        }
        if (empty($std_id)) {
            $std_id = $request->student_id;
        }
        $student = Student::leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->where('branch_id', Session::get('branch_id'))
            ->where('clg_id', $user->user_clg_id)->where('id', $std_id)->select('students.*', 'classes.class_name', 'classes.class_type', 'create_section.cs_name as section_name')
            ->first();

        if (empty($student)) {
            return redirect()->route('student_dashboard');
        } else {

            $student_packages = StudentsPackageModel::leftJoin('semesters', 'semesters.semester_id', '=', 'students_package.sp_semester')->where('sp_clg_id', $user->user_clg_id)
                ->where('sp_sid', $std_id)->select('students_package.*', 'semesters.semester_name')->get();

            $increase_discounts = DecrementIncrementModel::
            leftJoin('semesters', 'semesters.semester_id', '=', 'decrease_increase_package.di_semester_id')
                ->leftJoin('financials_users as createdBy', 'createdBy.user_id', '=', 'decrease_increase_package.di_created_by')
                ->leftJoin('financials_users as postedBy', 'postedBy.user_id', '=', 'decrease_increase_package.di_posted_by')
                ->where('di_clg_id', $user->user_clg_id)
                ->where('di_std_id', $std_id)->select('decrease_increase_package.*', 'semesters.semester_name', 'createdBy.user_name as created', 'postedBy.user_name as posted')->get();

            if ($student->class_type == 'Annual') {
                $query = Semester::whereIn('semester_name', ['Annual 1st Year', 'Annual 2nd Year']);
            } else {
                $query = Semester::whereNotIN('semester_name', ['Annual 1st Year', 'Annual 2nd Year']);
            }
            $semesters = $query->where('semester_clg_id', $user->user_clg_id)->whereNotIn('semester_id', StudentsPackageModel::where('sp_clg_id', $user->user_clg_id)->where('sp_sid', $std_id)->pluck('sp_semester'))->get();

            $components = ComponentModel::where('sfc_clg_id', $user->user_clg_id)->where('sfc_disable_enable', '=', 1)->get();
            $custom_vouchers = CustomVoucherModel::where('cv_clg_id', $user->user_clg_id)->where('cv_std_id', $std_id)->get();
            $transport_vouchers = TransportVoucherModel::where('tv_clg_id', $user->user_clg_id)->where('tv_std_id', $std_id)->where('tv_status','!=' ,2)->get();
            $student_attendance = StudentAttendanceModel::where('std_att_section_id', $student->section_id)->get();


            $monthlyCounts = []; // Initialize an array to store counts for each month
            foreach ($student_attendance as $items) {
                $att = json_decode($items->std_attendance, true);
                $monthName = date('M', strtotime($items->std_att_date));
                // Initialize count for the month if not set
                if (!isset($monthlyCounts[$monthName])) {
                    $monthlyCounts[$monthName] = 0;
                }
                foreach ($att as $attendance) {
                    if ($attendance['student_id'] == $std_id && $attendance['is_present'] == 'P') {
                        $monthlyCounts[$monthName]++;
                    }
                }
            }
            $presents[$student->id] = $monthlyCounts;

            $exams = MarkExamModel::where('me_class_id', $student->class_id)
                ->leftJoin('exam', 'exam.exam_id', '=', 'marks_exam.me_exam_id')
                ->where('me_section_id', $student->section_id)
                ->where('me_ng_id', $student->group_id)
                ->groupBy('me_exam_id')
                ->get();
//            transport
            $dr_accounts = AccountRegisterationModel::where('account_parent_code', 11020)
                ->select('account_name', 'account_uid')
                ->where('account_disabled', '!=', 1)
                ->where('account_delete_status', '!=', 1)
                ->where('account_clg_id', $user->user_clg_id)
                ->where('account_branch_id', $branch_id)
                ->get();

            $cr_accounts = AccountRegisterationModel::where('account_parent_code', 31114)
                ->select('account_name', 'account_uid')
                ->where('account_disabled', '!=', 1)
                ->where('account_delete_status', '!=', 1)
                ->where('account_clg_id', $user->user_clg_id)
                ->where('account_branch_id', $branch_id)
                ->get();

            $route_price = TransportRouteModel::where('tr_id', '=', $student->route_id)
                ->first();

            $advance_vouchers = AdvanceFeeVoucher::where('afv_std_id', $std_id)->get();
            $advance_reverse_vouchers = AdvanceFeeReverseVoucher::where('afrv_std_id', $std_id)->get();

//        Session::forget('student_id');
        }

        return view('collegeViews.installments.add_installment', compact('student', 'student_packages', 'semesters', 'components', 'currentYear', 'custom_vouchers', 'increase_discounts',
            'presents', 'exams', 'transport_vouchers', 'route_price', 'cr_accounts', 'dr_accounts', 'advance_vouchers', 'advance_reverse_vouchers'));
    }

    public function submit_student_package(Request $request)
    {
        Session::put('student_id', $request->std_id);

        $this->package_validation($request);

        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        $voucher_code = config('global_variables.STUDENT_BOOKED_VOUCHER_CODE');
        $registration_number = $this->get_registration_number($request->std_id);
        DB::beginTransaction();

        if ($request->package_id != '') {
            $sp = StudentsPackageModel::where('sp_id', $request->package_id)->first();
            $sp = $this->assign_package_values('sp', $request, $sp, $user, $day_end);
        } else {
            $sp = new StudentsPackageModel();
            $sp = $this->assign_package_values('sp', $request, $sp, $user, $day_end);
        }
        if (!$sp->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }
        if ($request->package_type == 2) {
            // student balance table entry start
            $std_balances = new StudentBalances();

            $std_balances = $this->AssignStudentBalancesValues($std_balances, '110211', $request->total_package_value, 'Dr',
                'Arrears', '110211 - Arrears Receivables - HO , @' . number_format($request->total_package_value, 2) . config('global_variables.Line_Break'),
                $voucher_code . $sp->sp_id, $sp->sp_sid, $registration_number);
            if (!$std_balances->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }

            // student balance table entry end
        }
        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create  With Id: ' . $sp->sp_id);
            DB::commit();

            return redirect()->route('create_installments')->with('success', 'Successfully Saved');
            //            return redirect()->back()->with(['sp_id' => $sp_id, 'success' => 'Successfully Saved']);
        }
    }

    public function package_validation($request)
    {
        return $this->validate($request, [
            'semester_master' => ['required', 'numeric'],
            'start_m' => ['required', 'string'],
            'start_y' => ['required', 'string'],
            'end_m' => ['required', 'string'],
            'end_y' => ['required', 'string'],
            'T_package_amount' => ['required', 'string'],
            'P_package_amount' => ['required', 'string'],
            'E_package_amount' => ['required', 'string'],
        ]);
    }

    public function assign_package_values($prfx, $request, $package, $user, $day_end)
    {
        $registration_number = $this->get_registration_number($request->std_id);
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $student = Student::where('id', $request->std_id)->first();
        $std_id = $prfx . '_sid';
        $semester = $prfx . '_semester';
        $std_reg_no = $prfx . '_std_reg';
        $start_month = $prfx . '_start_m';
        $start_year = $prfx . '_start_y';
        $end_month = $prfx . '_end_m';
        $end_year = $prfx . '_end_y';
        $tution_amount = $prfx . '_T_package_amount';
        $paper_fund = $prfx . '_P_package_amount';
        $annual_fund = $prfx . '_A_package_amount';
        $e_amount = $prfx . '_E_package_amount';
        $zakat_amout = $prfx . '_Z_package_amount';
        $package_amount = $prfx . '_package_amount';

        $tution_month_income = $prfx . '_t_month_income';
        $paper_month_income = $prfx . '_p_month_income';
        $annual_month_income = $prfx . '_a_month_income';

        $package_type = $prfx . '_package_type';
        $col_finalized = $prfx . '_finalized';

        $created_datetime = $prfx . '_created_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $class_id = $prfx . '_class_id';
        $section_id = $prfx . '_section_id';
        $group_id = $prfx . '_group_id';
        $year_id = $prfx . '_year_id';

        $first_date = '01-' . $request->start_m . '-' . $request->start_y;
        $last_date = '01-' . $request->end_m . '-' . $request->end_y;

        $end = Carbon::parse($last_date);
        $start = Carbon::parse($first_date);

        $total_month = $end->diffInMonths($start);
        $total_months = $total_month + 1;
        $package->$semester = $request->semester_master;
        $package->$std_id = $request->std_id;
        $package->$std_reg_no = $registration_number;
        $package->$start_month = $request->start_m;
        $package->$start_year = $request->start_y;
        $package->$end_month = $request->end_m;
        $package->$end_year = $request->end_y;
        $package->$tution_amount = $request->T_package_amount != '' ? $request->T_package_amount : 0;
        $package->$paper_fund = $request->P_package_amount != '' ? $request->P_package_amount : 0;
        $package->$annual_fund = $request->A_package_amount != '' ? $request->A_package_amount : 0;
        $package->$e_amount = $request->E_package_amount != '' ? $request->E_package_amount : 0;
        $package->$zakat_amout = $request->Z_package_amount != '' ? $request->Z_package_amount : 0;
        $package->$package_amount = $request->total_package_value;

        $package->$tution_month_income = $request->T_package_amount / $total_months;
        $package->$paper_month_income = $request->P_package_amount / $total_months;
        $package->$annual_month_income = $request->A_package_amount / $total_months;
        $package->$package_type = $request->package_type;
        $package->$col_finalized = $request->package_type == 1 ? 'Not Finalized' : 'Finalized';

        $package->$created_datetime = Carbon::now()->toDateTimeString();
        $package->$day_end_id = $day_end->de_id;
        $package->$day_end_date = $day_end->de_datetime;
        $package->$createdby = $user->user_id;
        $package->$clg_id = $user->user_clg_id;
        $package->$branch_id = Session::get('branch_id');
        $package->$brwsr_info = $brwsr_rslt;
        $package->$ip_adrs = $ip_rslt;
        $package->$class_id = $student->class_id;
        $package->$section_id = $student->section_id;
        $package->$group_id = $student->group_id;
        $package->$year_id = $this->getYearEndId();

        return $package;
    }

    // update code by mustafa start
    public function finalized_package_posting_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        $sections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_branch_id', $branch_id)->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->class;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;

        $prnt_page_dir = 'print.bill_of_labour_voucher_list.bill_of_labour_voucher_list';
        $pge_title = 'Bill Of Labour Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_class, $search_section, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        //        $query = CashPaymentVoucherModel::query();
        $query = DB::table('students_package')
            ->leftJoin('branches', 'branches.branch_id', 'students_package.sp_branch_id')
            ->leftJoin('students', 'students.id', 'students_package.sp_sid')
            ->where('students.clg_id', $user->user_clg_id)
            ->where('students.branch_id', Session::get('branch_id'))
            ->where('students_package.sp_clg_id', $user->user_clg_id)
            ->leftJoin('classes', 'classes.class_id', 'students.class_id')
            ->leftJoin('create_section', 'create_section.cs_id', 'students.section_id')
//            ->where('students_package.sp_branch_id',Session::get('branch_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'students_package.sp_createdby')
            ->where('sp_finalized', '=', 'Not Finalized');
        $ttl_amnt = $query->sum('sp_package_amount');

        if (!empty($request->search)) {
            $query->where('students.full_name', 'like', '%' . $search . '%')
                ->orWhere('sp_package_amount', 'like', '%' . $search . '%')
                ->orWhere('sp_id', 'like', '%' . $search . '%')
                ->orWhere('sp_std_reg', 'like', '%' . $search . '%');
        }

        if (!empty($search_class)) {
            $query->where('students.class_id', $search_class);
        }
        if (!empty($search_section)) {
            $query->where('students.section_id', $search_section);
        }
        if (!empty($search_year)) {
            $query->where('sp_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('sp_year_id', '=', $search_year);
        }

        $datas = $query->select('students.full_name', 'students.registration_no', 'students_package.*', 'financials_users.user_id', 'financials_users.user_name', 'financials_users.user_id', 'branches.branch_name')
            ->orderBy('sp_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);
        $student_title = Student::where('student_disable_enable', 1)->where('branch_id', $branch_id)->pluck('full_name');

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
            //            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $search_year), $pge_title . '_x.xlsx');
            }

        } else {
            return view('collegeViews.student.student_finalize_list', compact('datas', 'search', 'search_year', 'student_title', 'search_class', 'search_section', 'classes', 'sections', 'ttl_amnt'));
        }
    }

    // update code by mustafa end

    public function post_finalized_student_package($id, Request $request)
    {
        $sp_id = $id;
        $user = Auth::user();
        $student_package = StudentsPackageModel::where('sp_id', '=', $sp_id)->where('sp_finalized', '=', 'Not Finalized')->leftJoin('students', 'students.id', '=', 'students_package.sp_sid')->first();
        if ($student_package) {
            $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)->first();
            $values_array = [];
            $detail_remarks = '';
            if ($student_package->sp_T_package_amount > 0) {
                $detail_remarks .= '110201 - Tution Fee Receivable HO' . ', ' . 'Dr' . '@' . number_format($student_package->sp_T_package_amount, 2) . config('global_variables.Line_Break');

                $values_array[] = [
                    '0' => '110201',
                    '1' => '110201 - Tution Fee Receivable HO',
                    '2' => $student_package->sp_T_package_amount,
                    '3' => 'Dr',
                    '4' => $student_package->registration_no . ' - ' . $student_package->full_name,
                    '5' => $posting_reference,

                ];
                $detail_remarks .= '310111 - Tution Fee Income HO' . ', ' . 'Cr' . '@' . number_format($student_package->sp_T_package_amount, 2) . config('global_variables.Line_Break');
                $values_array[] = [
                    '0' => '310111',
                    '1' => '310111 - Tution Fee Income HO',
                    '2' => $student_package->sp_T_package_amount,
                    '3' => 'Cr',
                    '4' => $student_package->registration_no . ' - ' . $student_package->full_name,
                    '5' => $posting_reference,
                ];
            }
            if ($student_package->sp_P_package_amount > 0) {
                $detail_remarks .= '110202 - Paper Fund Receivable HO' . ', ' . 'Dr' . '@' . number_format($student_package->sp_P_package_amount, 2) . config('global_variables.Line_Break');
                $values_array[] = [
                    '0' => '110202',
                    '1' => '110202 - Paper Fund Receivable HO',
                    '2' => $student_package->sp_P_package_amount,
                    '3' => 'Dr',
                    '4' => $student_package->registration_no . ' - ' . $student_package->full_name,
                    '5' => $posting_reference,
                ];
                $detail_remarks .= '310112 - Paper Fund Income HO' . ', ' . 'Cr' . '@' . number_format($student_package->sp_P_package_amount, 2) . config('global_variables.Line_Break');
                $values_array[] = [
                    '0' => '310112',
                    '1' => '310112 - Paper Fund Income HO',
                    '2' => $student_package->sp_P_package_amount,
                    '3' => 'Cr',
                    '4' => $student_package->registration_no . ' - ' . $student_package->full_name,
                    '5' => $posting_reference,
                ];
            }
            if ($student_package->sp_A_package_amount > 0) {
                $detail_remarks .= '110203 - Annual Fund Receivable HO' . ', ' . 'Dr' . '@' . number_format($student_package->sp_A_package_amount, 2) . config('global_variables.Line_Break');
                $values_array[] = [
                    '0' => '110203',
                    '1' => '110203 - Annual Fund Receivable HO',
                    '2' => $student_package->sp_A_package_amount,
                    '3' => 'Dr',
                    '4' => $student_package->registration_no . ' - ' . $student_package->full_name,
                    '5' => $posting_reference,
                ];
                $detail_remarks .= '310113 - Annual Fund Income HO' . ', ' . 'Cr' . '@' . number_format($student_package->sp_A_package_amount, 2) . config('global_variables.Line_Break');
                $values_array[] = [
                    '0' => '310113',
                    '1' => '310113 - Annual Fund Income HO',
                    '2' => $student_package->sp_A_package_amount,
                    '3' => 'Cr',
                    '4' => $student_package->registration_no . ' - ' . $student_package->full_name,
                    '5' => $posting_reference,
                ];
            }
            if ($student_package->sp_Z_package_amount > 0) {
                $detail_remarks .= '110201 - Tution Fee Receivable HO as a zakat' . ', ' . 'Dr' . '@' . number_format($student_package->sp_Z_package_amount, 2) . config('global_variables.Line_Break');
                $values_array[] = [
                    '0' => '110201',
                    '1' => '110201 - Tution Fee Receivable HO',
                    '2' => $student_package->sp_Z_package_amount,
                    '3' => 'Dr',
                    '4' => $student_package->registration_no . ' - ' . $student_package->full_name . ' - Zakat',
                    '5' => $posting_reference,
                ];
                $detail_remarks .= '310111 - Tution Fee Income HO As a Zakat' . ', ' . 'Cr' . '@' . number_format($student_package->sp_Z_package_amount, 2) . config('global_variables.Line_Break');
                $values_array[] = [
                    '0' => '310111',
                    '1' => '310111 - Tution Fee Income HO',
                    '2' => $student_package->sp_Z_package_amount,
                    '3' => 'Cr',
                    '4' => $student_package->registration_no . ' - ' . $student_package->full_name . ' - Zakat',
                    '5' => $posting_reference,
                ];
            }


            $flag = false;

            $user = Auth::user();

            $get_day_end = new DayEndController();
            $day_end = $get_day_end->day_end();

            $notes = 'STUDENT_BOOKED_VOUCHER';
            $voucher_code = config('global_variables.STUDENT_BOOKED_VOUCHER_CODE');
            $transaction_type = config('global_variables.STUDENT_BOOKED');

            DB::beginTransaction();

            foreach ($values_array as $key) {

                $transaction = new TransactionModel();

                if ($key[3] == 'Dr') {

                    $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $sp_id);

                    if ($transaction->save()) {

                        $transaction_id = $transaction->trans_id;
                        $balances = new BalancesModel();
                        $detail_remarks_std = $key[1] . ', ' . 'Dr' . '@' . number_format($key[2], 2) . config('global_variables.Line_Break');

                        $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks_std, $voucher_code .
                            $sp_id, $key[5], $voucher_code . $sp_id, $this->getYearEndId());

                        if (!$balance->save()) {

                            $flag = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }

                        // student balance table entry start
                        $std_balances = new StudentBalances();

                        $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Dr',
                            $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
                            $voucher_code . $sp_id, $student_package->sp_sid, $student_package->sp_std_reg);
                        if (!$std_balances->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }

                        // student balance table entry end

                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                } else {

                    $transaction = $this->AssignTransactionsValues($transaction, 0, $key[2], $key[0], $notes, 5, $sp_id);
                    if ($transaction->save()) {
                        $transaction_id = $transaction->trans_id;
                        $balances = new BalancesModel();
                        $detail_remarks_std = $key[1] . ', ' . 'Cr' . '@' . number_format($key[2], 2) . config('global_variables.Line_Break');
                        $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code .
                            $sp_id, $key[5], $voucher_code . $sp_id, $this->getYearEndId());

                        if (!$balance->save()) {
                            $flag = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }
                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }
                }
            }

            if ($flag) {
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            } else {
                $student_package = StudentsPackageModel::where('sp_id', '=', $sp_id)->first();
                $student_package->sp_finalized = 'Finalized';
                $student_package->sp_finalization_date = Carbon::now()->toDateTimeString();
                $student_package->sp_posted_by = $user->user_id;
                $student_package->save();

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Journal Voucher With Id: ' . $sp_id);

                DB::commit();
                return redirect()->back()->with('success', 'Student Finalized Successfully!');
            }
        } else {
            return redirect()->back()->with('fail', 'Student already Finalized!');
        }
    }

    public function submit_student_installment(Request $request)
    {
        Session::put('student_id', $request->student_id);
        $branch_id = Session::get('branch_id');
        $user = Auth::user();

        DB::transaction(function () use ($request, $user, $branch_id) {

            // coding from shahzaib start
            $brwsr_rslt = $this->getBrwsrInfo();
            $ip_rslt = $this->getIp();
            // coding from shahzaib end

            $requested_arrays = $request->ins_total_amount;
            $student_info = Student::where('id', $request->student_id)->select('class_id', 'registration_no', 'section_id')->first();
            $array = ['Jan' => "01", 'Feb' => "02", 'Mar' => "03", 'Apr' => "04", 'May' => "05", 'Jun' => "06", 'Jul' => "07", 'Aug' => "08", 'Sep' => "09", 'Oct' => "10", 'Nov' => "11", 'Dec' => "12"];
            foreach ($requested_arrays as $index => $requested_array) {


                $item_total_amount = isset($request->ins_total_amount[$index]) ? $request->ins_total_amount[$index] : 0;
                if ($request->Z_amount[$index] != null || $request->T_amount[$index] != null || $request->P_amount[$index] != null || $request->A_amount[$index] != null) {

                    $item_ins_id = $request->ins_id[$index];

                    $item_T_amount = isset($request->T_amount[$index]) ? $request->T_amount[$index] : 0;
                    $item_P_amount = isset($request->P_amount[$index]) ? $request->P_amount[$index] : 0;
                    $item_A_amount = isset($request->A_amount[$index]) ? $request->A_amount[$index] : 0;
                    $item_Z_amount = isset($request->Z_amount[$index]) ? $request->Z_amount[$index] : 0;
                    $item_semester = isset($request->semester[$index]) ? $request->semester[$index] : 0;
                    $item_package_type = $request->ins_package_type[$index];


                    if ($item_ins_id != null) {
                        $std_instalment = StudentInstallment::where('si_id', $item_ins_id)->first();
                        if (!empty($std_instalment->si_fid)) {
                            FeeVoucherModel::where('fv_v_no', $std_instalment->si_fid)->where('fv_status_update', 0)->where('fv_clg_id', $user->user_clg_id)->update(['fv_t_fee' => $item_T_amount,
                                'fv_p_fund' => $item_P_amount,
                                'fv_a_fund' => $item_A_amount, 'fv_z_fund' => $item_Z_amount, 'fv_total_amount' => $item_total_amount]);
                        }
                    } else {
                        $item_month = $request->ins_mm[$index];
                        $item_year = $request->ins_yy[$index];
                        $std_instalment = new StudentInstallment();
                        $month = array_search($request->ins_mm[$index], $array);
                        $std_instalment->si_year = $item_year;
                        $std_instalment->si_month = $item_month;
                        $std_instalment->si_month_year = $month . '-' . $item_year;
                        $std_instalment->si_status_update = 0;
                    }

                    $std_instalment->si_semester_id = $item_semester;
                    $std_instalment->si_std_id = $request->student_id;
                    $std_instalment->si_std_reg = $student_info->registration_no;

                    $std_instalment->si_instalment_no = $index + 1;
                    $std_instalment->si_t_fee = $item_T_amount;
                    $std_instalment->si_p_fund = $item_P_amount;
                    $std_instalment->si_a_fund = $item_A_amount;
                    $std_instalment->si_z_fund = $item_Z_amount;
                    $std_instalment->si_class_id = $student_info->class_id;
                    $std_instalment->si_section_id = $student_info->section_id;
                    $std_instalment->si_sp_id = $request->package_id;
                    $std_instalment->si_created_by = $user->user_id;
                    $std_instalment->si_created_datetime = Carbon::now();
                    $std_instalment->si_brwsr_info = $brwsr_rslt;
                    $std_instalment->si_ip_adrs = $ip_rslt;
                    $std_instalment->si_clg_id = $user->user_clg_id;
                    $std_instalment->si_branch_id = $branch_id;
                    $std_instalment->si_total_amount = $item_total_amount;
                    $std_instalment->si_package_type = $item_package_type;
                    $std_instalment->si_year_id = $this->getYearEndId();
                    $std_instalment->save();
                }
            }
            $request->package_id;
            StudentsPackageModel::where('sp_id', $request->package_id)->update(['sp_installment_status' => 1]);
        });

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Product Rate of Code:  And Name: ');
        return redirect()->route('create_installments')->with('success', 'Successfully Saved');
    }

    public function submit_discount_increase_package(Request $request)
    {

        $user = Auth::user();
        $rand_number = Utility::uniqidReal();
        $uniqueId = Utility::uniqidReal() . mt_rand();
        $amount = $request->amount;
        $student_id = $request->disc_std_id;
        Session::put('student_id', $student_id);
        $package = StudentsPackageModel::where('sp_sid', $student_id)->where('sp_package_type', 1)->orderBy('sp_id', 'DESC')->first();
        $discount_increment = new DecrementIncrementModel();
        $discount_increment->di_std_id = $student_id;
        $discount_increment->di_sp_id = $package->sp_id;
        $discount_increment->di_semester_id = $package->sp_semester;
        $discount_increment->di_entry_type = $request->entry_type;
        $discount_increment->di_amount = $amount;
        $discount_increment->di_created_datetime = Carbon::now();
        $discount_increment->di_created_by = $user->user_id;
        $discount_increment->di_clg_id = $user->user_clg_id;
        $discount_increment->di_branch_id = Session::get('branch_id');

        $save_image = new SaveImageController();

        $common_path = config('global_variables.common_path');
        $product_path = config('global_variables.reasons_path');

        // Handle Image
        $fileNameToStore = $save_image->SaveImage($request, 'pimage', $uniqueId, $product_path, $rand_number . 'Reasons');


        if ($request->hasFile('pimage')) {
            $discount_increment->di_image = $common_path . $fileNameToStore;
        } else {
            $discount_increment->di_image = $fileNameToStore;
        }

        $discount_increment->save();
        return redirect()->route('create_installments')->with('success', 'Successfully Saved');
    }

    // update code by mustafa start
    public function discount_increase_package_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        $sections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_branch_id', $branch_id)->get();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->class;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section;

        $prnt_page_dir = 'print.bill_of_labour_voucher_list.bill_of_labour_voucher_list';
        $pge_title = 'Bill Of Labour Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_class, $search_section);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        //        $query = CashPaymentVoucherModel::query();
        $query = DB::table('decrease_increase_package')
            ->leftJoin('branches', 'branches.branch_id', 'decrease_increase_package.di_branch_id')
            ->leftJoin('students', 'students.id', 'decrease_increase_package.di_std_id')
            ->where('students.clg_id', $user->user_clg_id)
            ->leftJoin('classes', 'classes.class_id', 'students.class_id')
            ->leftJoin('create_section', 'create_section.cs_id', 'students.section_id')
            ->where('students.branch_id', Session::get('branch_id'))
            ->where('decrease_increase_package.di_branch_id', Session::get('branch_id'))
            ->where('decrease_increase_package.di_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users', 'financials_users.user_id', 'decrease_increase_package.di_created_by')
            ->where('di_status_update', '=', 0);
        $ttl_amnt = $query->sum('di_amount');

        if (!empty($request->search)) {
            $query->where('students.full_name', 'like', '%' . $search . '%')
                ->orWhere('students.registration_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_class)) {
            $query->where('students.class_id', $search_class);
        }
        if (!empty($search_section)) {
            $query->where('students.section_id', $search_section);
        }


        $datas = $query->select('students.full_name', 'students.registration_no', 'decrease_increase_package.*', 'financials_users.user_id', 'financials_users.user_name', 'create_section.cs_name', 'classes.class_name', 'branches.branch_name', 'financials_users.user_id')
            ->orderBy('di_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $student_title = Student::where('student_disable_enable', 1)->where('branch_id', $branch_id)->pluck('full_name');

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
            //            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('collegeViews.student.discount_increase_package_list', compact('datas', 'search', 'student_title', 'search_class', 'search_section', 'classes', 'sections', 'ttl_amnt'));
        }
    }

    // update code by mustafa end

    // start posting package discounts and increase
    public function post_discount_increment_package($id, Request $request)
    {
        $sp_id = $id;
        $amount = $request->amount;
        $user = Auth::user();
        $student_package = StudentsPackageModel::where('sp_id', '=', $request->package_id)->leftJoin('students', 'students.id', '=', 'students_package.sp_sid')->first();

        $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)->first();
        $values_array = [];
        $detail_remarks = '';


        if ($request->entry_type == 2) {
            $notes = 'STUDENT_INCREASE_PACKAGE_VOUCHER';
            $detail_remarks .= '110201 - Tution Fee Receivable HO' . ', ' . 'Dr' . '@' . number_format($student_package->sp_T_package_amount, 2) . config('global_variables.Line_Break');

            $values_array[] = [
                '0' => '110201',
                '1' => '110201 - Tution Fee Receivable HO',
                '2' => $amount,
                '3' => 'Dr',
                '4' => $student_package->registration_no . ' - ' . $student_package->full_name,
                '5' => $posting_reference,

            ];
            $detail_remarks .= '310111 - Tution Fee Income HO' . ', ' . 'Cr' . '@' . number_format($student_package->sp_T_package_amount, 2) . config('global_variables.Line_Break');
            $values_array[] = [
                '0' => '310111',
                '1' => '310111 - Tution Fee Income HO',
                '2' => $amount,
                '3' => 'Cr',
                '4' => $student_package->registration_no . ' - ' . $student_package->full_name,
                '5' => $posting_reference,
            ];
        } else {
            $notes = 'STUDENT_DISCOUNT_VOUCHER';
            $detail_remarks .= '110201 - Tution Fee Receivable HO' . ', ' . 'Cr' . '@' . number_format($student_package->sp_T_package_amount, 2) . config('global_variables.Line_Break');

            $values_array[] = [
                '0' => '110201',
                '1' => '110201 - Tution Fee Receivable HO',
                '2' => $amount,
                '3' => 'Cr',
                '4' => $student_package->registration_no . ' - ' . $student_package->full_name,
                '5' => $posting_reference,

            ];
            $detail_remarks .= '310111 - Tution Fee Income HO' . ', ' . 'Dr' . '@' . number_format($student_package->sp_T_package_amount, 2) . config('global_variables.Line_Break');
            $values_array[] = [
                '0' => '310111',
                '1' => '310111 - Tution Fee Income HO',
                '2' => $amount,
                '3' => 'Dr',
                '4' => $student_package->registration_no . ' - ' . $student_package->full_name,
                '5' => $posting_reference,
            ];
        }


        $flag = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $voucher_code = config('global_variables.STUDENT_DISCOUNT_INCREASE_CODE');
        $transaction_type = config('global_variables.DISCOUNT_INCREASE_VOUCHER');

        DB::beginTransaction();

        foreach ($values_array as $key) {

            $transaction = new TransactionModel();

            if ($key[3] == 'Dr') {

                $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $sp_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code .
                        $sp_id, $key[5], $voucher_code . $sp_id, $this->getYearEndId());

                    if (!$balance->save()) {

                        $flag = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    // student balance table entry start
                    if ($request->entry_type == 2) {
                        $std_balances = new StudentBalances();

                        $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Dr',
                            $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
                            $voucher_code . $sp_id, $student_package->sp_sid, $student_package->sp_std_reg);
                        if (!$std_balances->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }
                    }
                    // student balance table entry end

                } else {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

            } else {

                $transaction = $this->AssignTransactionsValues($transaction, 0, $key[2], $key[0], $notes, 5, $sp_id);
                if ($transaction->save()) {
                    $transaction_id = $transaction->trans_id;
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code .
                        $sp_id, $key[5], $voucher_code . $sp_id, $this->getYearEndId());

                    if (!$balance->save()) {
                        $flag = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }
                    // student balance table entry start
                    if ($request->entry_type == 1) {
                        $std_balances = new StudentBalances();

                        $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Cr',
                            $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
                            $voucher_code . $sp_id, $student_package->sp_sid, $student_package->sp_std_reg);
                        if (!$std_balances->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }
                    }
                    // student balance table entry end
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }
            }
        }

        if ($flag) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {
            $student_package = StudentsPackageModel::where('sp_id', '=', $request->package_id)->first();
            $student_di = DecrementIncrementModel::where('di_id', '=', $id)->first();
            if ($request->entry_type == 2) {

                $student_package->sp_increase = $student_package->sp_increase + $amount;
                $student_package->sp_T_package_amount = $student_package->sp_T_package_amount + $amount;
                $student_package->sp_package_amount = $student_package->sp_package_amount + $amount;
                $student_package->save();

                $student_di->di_status_update = 1;
                $student_di->di_posted_by = $user->user_id;
                $student_di->di_update_datetime = Carbon::now()->toDateTimeString();
                $student_di->save();
            } else {
                $student_package->sp_T_package_amount = $student_package->sp_T_package_amount - $amount;
                $student_package->sp_discount = $student_package->sp_discount - $amount;
                $student_package->sp_package_amount = $student_package->sp_package_amount - $amount;
                $student_package->save();

                $student_di->di_status_update = 1;
                $student_di->di_posted_by = $user->user_id;
                $student_di->di_update_datetime = Carbon::now()->toDateTimeString();
                $student_di->save();
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Journal Voucher With Id: ' . $sp_id);

            DB::commit();
            return redirect()->back()->with('success', 'Posted Successfully!');
        }
    }

    // end posting package discounts and increase


}
