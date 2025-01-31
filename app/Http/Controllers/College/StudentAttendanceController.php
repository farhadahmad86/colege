<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\AssignCoordinatorModel;
use App\Models\College\Classes;
use App\Models\College\Branch;
use App\Models\College\Student;
use App\Models\CreateSectionModel;
use App\Models\StudentAttendanceModel;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use App\Models\College\Student as StudentModel;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_date = (!isset($request->date) && empty($request->date)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->date;
        $search_by_section = (!isset($request->section_id) && empty($request->section_id)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section_id;
        // $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'collegeViews.student_attendance.attendance_report';

        $pge_title = 'Attendance Report';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_by_date, $search_by_section,$search_year);

        $pagination_number = (empty($ar)) ? 100 : 100000000;
        $start = date('Y-m-d', strtotime($search_by_date));
        $year = date('Y', strtotime($search_by_date));
        $month = date('m', strtotime($search_by_date));
        $date = Carbon::createFromDate($year, $month, 1); // Create a Carbon instance for August 2023
        $numDays = $date->daysInMonth;

        $query = DB::table('student_attendance')->where('std_att_clg_id', $user->user_clg_id)
            ->leftJoin('classes', 'classes.class_id', '=', 'student_attendance.std_att_class_id')
            ->leftJoin('financials_users as users', 'users.user_id', '=', 'student_attendance.std_att_createdby')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'student_attendance.std_att_section_id');

        $students = StudentModel::where('class_id', $search)
            ->where('branch_id', Session::get('branch_id'))
            ->where('section_id', $search_by_section)
            ->where('status', '!=', 3)
            ->get();
        $restore_list = $request->restore_list;
        $datas = $query->where('std_att_class_id', 'like', '%' . $search . '%')
            ->where('std_att_section_id', 'like', '%' . $search_by_section . '%')
            ->whereDate('std_att_date', $start)
            ->select('student_attendance.*',
                'classes.class_name', 'classes.class_id',
                'create_section.cs_id', 'create_section.cs_name',
                'users.user_id', 'users.user_name')
            ->orderBy('std_att_id', 'ASC')->get();
        $class_title = Classes::where('class_clg_id', $user->user_clg_id)->where('class_disable_enable', '=', 1)->orderBy('class_id', config('global_variables.query_sorting'))->get(); //where('class_delete_status', '!=', 1)->
        $class_name = Classes::where('class_clg_id', $user->user_clg_id)->where('class_id', $search)->pluck('class_name')->first();
        $section = CreateSectionModel::where('cs_id', $search_by_section)->pluck('cs_name')->first(); //where('class_delete_status', '!=', 1)->
        $sections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_branch_id', Session::get('branch_id'))->orderBy('cs_id', config('global_variables.query_sorting'))->get(); //where('class_delete_status', '!=', 1)->
        $attndance_report = StudentAttendanceModel::where('std_att_clg_id', $user->user_clg_id)
            ->where('std_att_branch_id', $branch_id)
            ->where('std_att_class_id', $search)
            ->where('std_att_section_id', $search_by_section)
            ->whereYear('std_att_created_at', $year)
            ->whereMonth('std_att_created_at', $month)
            ->get();
        if (!empty($search_year)) {
            $query->where('std_att_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('std_att_year_id', '=', $search_year);
        }
        if (isset($request->array) && !empty($request->array)) {
            // dd($attndance_report,$students);
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
            $pdf->loadView($prnt_page_dir, compact('students', 'numDays','search_year', 'month', 'year', 'class_name', 'section', 'type', 'pge_title', 'attndance_report'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.student_attendance.student_attendance_list', compact('datas','search_year', 'sections', 'class_title', 'search', 'search_by_section', 'search_by_date', 'restore_list', 'class_name'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        if ($user->user_designation == 14) {
            $classId = AssignCoordinatorModel::where('ac_coordinator_id', $user->user_id)
                ->where('ac_disable_enable', 1)
                ->get();
            $classIds = $classId->pluck('ac_class_id')->implode(','); // Extract section IDs and create a comma-separated string
            $classIdsArray = explode(',', $classIds); // Convert the string to an array

            $classes = Classes::where('class_clg_id', $user->user_clg_id)
                // ->where('class_branch_id', $branch_id)
                ->whereIn('class_id', $classIdsArray) // Use class_id to match sections
                ->get();

        }else{
            $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        }


        $branch_id = Session::get('branch_id');
        $sections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_branch_id', Session::get('branch_id'))->get();
        $ar = json_decode($request->array);
        $search_class = (!isset($request->class_id) && empty($request->class_id)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->class_id;
        $search_section = (!isset($request->section_id) && empty($request->section_id)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->section_id;
        $search_month = (!isset($request->month) && empty($request->month)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->month;
        // $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.attendance_sheet.attendance_sheet';
        $pge_title = 'Student Attendance Sheet';
        $srch_fltr = [];
        array_push($srch_fltr, $search_class, $search_section, $search_month);

        $pagination_number = (empty($ar)) ? 100000000 : 100000000;

        $date = Carbon::parse(date("Y-m-d", strtotime($search_month)));
        $month = $date->format('m'); // Full month name (e.g., August)
        $year = $date->format('Y'); // Four-digit year (e.g., 2023)
        $date = Carbon::createFromDate($year, $month, 1); // Create a Carbon instance for August 2023
        $numDays = $date->daysInMonth; // Get the number of days in the month
        $class = Classes::where('class_id', $search_class)->pluck('class_name')->first();
        $section = CreateSectionModel::where('cs_id', $search_section)->pluck('cs_name')->first();
        $query = DB::table('students')->where('clg_id', $user->user_clg_id)
            ->where('students.class_id', $search_class)
            ->where('students.section_id', $search_section)
            ->where('branch_id', $branch_id)
            ->where('student_disable_enable', 1)
            ->whereNotIn('status', [4, 3])
            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id');
        $datas = $query->select('students.*', 'classes.class_name', 'create_section.cs_name')->orderBy('roll_no', 'ASC')
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
            $pdf->loadView($prnt_page_dir, compact('datas', 'numDays', 'month', 'year', 'type', 'pge_title', 'srch_fltr', 'class', 'section', 'search_month'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($data, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.student_attendance.mark_student_attendance', compact('datas', 'classes', 'search_month', 'search_class', 'search_section', 'sections'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentDate = date('Y-m-d', strtotime($request->attendance_date));
        $count = StudentAttendanceModel::where('std_att_class_id', $request->class_id)->where('std_att_section_id', $request->section_id)->whereDate('std_att_date', $currentDate)->count();
        // dd($count);
        // $att_date = date('Y-m-d', strtotime($request->attendance_date));

        if ($count == 0) {
            $user = Auth::user();
            $attendanceData = $request->input('attendance');
            $leave_remarks = $request->leave_details;

            $attendanceRecords = [];
            foreach ($attendanceData as $studentId => $isPresent) {
                if ($isPresent) {
                    $attendanceRecords[] = [
                        'student_id' => $studentId,
                        'is_present' => $isPresent,
                    ];
                }
            }

            $attendance = new StudentAttendanceModel();
            $attendance->std_att_class_id = $request->class_id;
            $attendance->std_att_section_id = $request->section_id;
            $attendance->std_att_branch_id = Session::get('branch_id');
            $attendance->std_att_clg_id = $user->user_clg_id;
            $attendance->std_att_browser_info = $this->getBrwsrInfo();
            $attendance->std_att_ip_address = $this->getIp();
            $attendance->std_attendance = json_encode($attendanceRecords);
            $attendance->std_att_leave_remarks = json_encode($leave_remarks);
            $attendance->std_att_date = $currentDate;
            $attendance->std_att_createdby = $user->user_id;
            $attendance->std_att_year_id = $this->getYearEndId();
            $attendance->save();

            return redirect()->back()->with('success', 'Attendance marked successfully.');
        } else {
            return redirect()->back()->with('fail', 'Attendance already marked');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();

        return view('collegeViews.student_attendance.edit_student_attendance', compact('request', 'classes'));
    }

    public function class_attendance_view_detail(Request $request, $class_id, $cs_id, $date)
    {
        $attendances = StudentAttendanceModel::where('std_att_class_id', $class_id)->where('std_att_section_id', $cs_id)->whereDate('std_att_created_at', $date)->first();

        return response()->json($attendances);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $user = Auth::user();
        $attendanceData = $request->input('attendance');
        $attendanceRecords = [];
        foreach ($attendanceData as $studentId => $isPresent) {
            if ($isPresent) {
                $attendanceRecords[] = [
                    'student_id' => $studentId,
                    'is_present' => $isPresent,
                ];
            }
        }

        DB::transaction(function () use ($request, $user, $attendanceRecords) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            // $validated = $request->validate([
            //     'cs_name' => ['required', 'string', 'unique:create_section,cs_name,' . $request->cs_id . ',cs_id' . ',cs_clg_id,' . $user->user_clg_id],
            // ]);
            $currentDate = date('Y-m-d', strtotime($request->attendance_date));

            $attendance = StudentAttendanceModel::where('std_att_id', $request->std_att_id)->first();
            $attendance->std_attendance = json_encode($attendanceRecords);
            $attendance->std_att_leave_remarks = $request->leave_remarks;
            $attendance->std_att_branch_id = Session::get('branch_id');
            $attendance->save();
        });
        return redirect()->route('student_attendance_list')->with('success', 'Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function monthly_report(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_section = (!isset($request->section_id) && empty($request->section_id)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->section_id;
        $search_student = (!isset($request->student_id) && empty($request->student_id)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->student_id;
        $search_month = (!isset($request->month) && empty($request->month)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->month;
        $prnt_page_dir = 'print/college/attendance_sheet/monthly_attendance_report';

        $pge_title = 'Month Attendance';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_student, $search_month, $search_by_section);

        $start = '';
        $end = '';
        $numDays = 0;
        $month = 0;
        $year = 0;

        if (!empty($search_month)) {
            // Use Carbon to parse the date string
            $date = \Carbon\Carbon::createFromFormat('F Y', $search_month);
            // Get the month as a number (1-12)
            $month = $date->month;
            // Get the year as a four-digit number (e.g., 2023)
            $year = $date->year;
            $date = Carbon::createFromDate($year, $month, 1); // Create a Carbon instance for August 2023
            $numDays = $date->daysInMonth;
            $start = $year . '-' . $month . '-01';
            $end = $year . '-' . $month . '-' . $numDays;
        }

        $pagination_number = (empty($ar)) ? 100 : 100000000;

        $results = DB::table('student_attendance')->where('std_att_clg_id', $user->user_clg_id)
            ->where('std_att_branch_id', $branch_id)
            ->leftJoin('financials_users as users', 'users.user_id', '=', 'student_attendance.std_att_createdby')
            ->whereDate('std_att_date', '>=', $start)
            ->whereDate('std_att_date', '<=', $end);
        if (!empty($search)) {
            $results->where('std_att_class_id', '=', $search);
        }
        if (!empty($search_by_section)) {
            $results->where('std_att_section_id', '=', $search_by_section);
        }

        if ($search == '' && $search_by_section == '' && $search_student == '' && $search_month == '') {
            $results->where('std_att_class_id', '=', $search);
        }
        $datas = $results->orderBy('std_att_date', 'ASC')->select('student_attendance.*', 'users.user_name')->get();

        $std_query = Student::where('clg_id', $user->user_clg_id)->where('branch_id', $branch_id)->where('class_id', $search)->where('section_id', $search_by_section)->where('status', '!=', 3);
        if (!empty($search_student)) {
            $std_query->where('id', $search_student);
        }
        $students = $std_query->orderBy('roll_no', 'ASC')->get();

        $class_title = Classes::where('class_clg_id', $user->user_clg_id)->where('class_disable_enable', '=', 1)->orderBy('class_id', config('global_variables.query_sorting'))->get(); //where('class_delete_status', '!=', 1)->
        $class_name = Classes::where('class_clg_id', $user->user_clg_id)->where('class_id', $search)->pluck('class_name')->first();
        $section = CreateSectionModel::where('cs_id', $search_by_section)->pluck('cs_name')->first(); //where('class_delete_status', '!=', 1)->
        $sections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_branch_id', Session::get('branch_id'))->orderBy('cs_id', config('global_variables.query_sorting'))->get(); //where('class_delete_status', '!=', 1)->

        if (isset($request->array) && !empty($request->array)) {
            // dd($attndance_report,$students);
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
            $pdf->loadView($prnt_page_dir, compact('datas', 'month', 'year', 'numDays', 'year', 'month', 'section', 'class_name', 'search', 'search_by_section' ,'search_student', 'class_name', 'students', 'start'
                ,'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {

            return view('collegeViews.student_attendance.monthly_attendance_report', compact('datas', 'month', 'year', 'numDays', 'sections', 'class_title', 'search', 'search_by_section', 'search_month', 'search_student', 'class_name', 'students'));
        }
    }

    public function branch_wise_report(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $ar = json_decode($request->array);
        $search_date = (!isset($request->date) && empty($request->date)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->date;
        $prnt_page_dir = 'collegeViews.student_attendance.attendance_report';

        $pge_title = 'Month Attendance';
        $srch_fltr = [];
        array_push($srch_fltr, $search_date);
        if ($search_date == '') {
            $currentDate = '';
        } else {
            $currentDate = date('Y-m-d', strtotime($search_date));
        }

//        $currentDate = date('Y-m-d', strtotime($search_date));

        $branches = Branch::where('branch_clg_id', $user->user_clg_id)->where('branch_id', '!=', 1)->select('branch_id', 'branch_name')->get();

        $results = DB::table('student_attendance')->where('std_att_clg_id', $user->user_clg_id)
            ->orderBy('std_att_branch_id', 'ASC');
//            ->groupBy('std_att_branch_id');
//            ->whereIn('std_att_branch_id', explode(',', $branches));
        $datas = $results->where('std_att_date', $currentDate)->get();

// foreach($branches as $key => $branch){


//        $students = Student::
//        where('clg_id', $user->user_clg_id)
////            ->whereIn('branch_id', explode(',', $branches))
//            ->whereDate('created_at', '<=', $currentDate)
//            ->where('status', '!=', 3)
//            ->orWhere('status', '!=', 2)
//            ->groupBy('branch_id')->count();

        $students = Student::select('branch_id', \DB::raw('count(*) as total, branch_id'))
            ->whereNotIn('status', [2, 3])
//            ->whereDate('created_at', '<=', $currentDate)
            ->groupBy('branch_id')
            ->get();

// }

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
            $pdf->loadView($prnt_page_dir, compact('type', 'datas', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {

            return view('collegeViews.student_attendance.branch_wise_report', compact('datas', 'search_date', 'datas', 'students', 'branches', 'currentDate'));
        }
    }

    public function college_wise_report(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $ar = json_decode($request->array);
        $search_date = (!isset($request->date) && empty($request->date)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->date;
        $prnt_page_dir = 'collegeViews.student_attendance.attendance_report';

        $pge_title = 'Month Attendance';
        $srch_fltr = [];
        array_push($srch_fltr, $search_date);
        $currentDate = date('Y-m-d', strtotime($search_date));
        $results = DB::table('student_attendance')->where('std_att_clg_id', $user->user_clg_id);
        $datas = $results->where('std_att_date', $currentDate)->get();


        $students = Student::
        where('clg_id', $user->user_clg_id)
            ->whereDate('created_at', '<=', $currentDate)
            ->where('status', '!=', 3)
            ->orWhere('status', '!=', 2)
            ->count();
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
            $pdf->loadView($prnt_page_dir, compact('type', 'datas', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {

            return view('collegeViews.student_attendance.college_wise_report', compact('datas', 'search_date', 'students', 'datas'));
        }
    }

}
