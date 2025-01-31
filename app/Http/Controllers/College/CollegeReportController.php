<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Branch;
use App\Models\College\Classes;
use App\Models\College\ClassTimetableItem;
use App\Models\College\ExamModel;
use App\Models\College\GroupItems;
use App\Models\College\MarkExamModel;
use App\Models\College\NewGroupsModel;
use App\Models\College\Semester;
use App\Models\College\Student;
use App\Models\College\Subject;
use App\Models\College\TimeTableModel;
use App\Models\CreateSectionModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use \Illuminate\Support\Facades\Auth;
use Session;
use PDF;

class CollegeReportController extends Controller
{
    // code by Mustafa start
    public function fee_register(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $semesters = Semester::all();
        $classes = Classes::where('class_clg_id', '=', $user->user_clg_id)->orderby('class_id', 'DESC')->get();
        $sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id)->orderby('cs_id', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->class;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section;
        $search_type = (!isset($request->type) && empty($request->type)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->type;
        $search_status = (!isset($request->status) && empty($request->status)) ? ((!empty($ar)) ? $ar[5]->{'value'} : 3) : $request->status;
        $search_semester = (!isset($request->semester) && empty($request->semester)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->semester;

        $prnt_page_dir = 'print.college.reports.fee_register';
        $pge_title = 'Fee Register';
        $srch_fltr = [];

        array_push($srch_fltr, $search, $search_class, $search_section, $search_type, $search_status, $search_semester);


        $pagination_number = (empty($ar) || !empty($ar)) ? 1000000 : 100000000;
        $query2 = Student::where('clg_id', '=', $user->user_clg_id)->where('class_id', '=', $search_class)->where('status', '!=', 3)
            ->where('branch_id', '=', $branch_id);

        $query = DB::table('financials_fee_voucher')
            ->join('students', 'students.id', '=', 'financials_fee_voucher.fv_std_id')
            ->join('semesters', 'semesters.semester_id', '=', 'financials_fee_voucher.fv_semester_id')
            ->where('students.status', '!=', 3)
            ->where('fv_clg_id', '=', $user->user_clg_id)
            ->where('fv_class_id', '=', $search_class)
            ->where('fv_section_id', '=', $search_section)
            ->where('students.section_id', '=', $search_section)
            ->where('fv_package_type', '=', $search_type)
            ->where('fv_branch_id', '=', $branch_id);


        if (!empty($search_class)) {
            $pagination_number = 1000000;
            $query2->where('class_id', '=', $search_class);
            $query->where('fv_class_id', '=', $search_class);
        }
        if (!empty($search_section)) {
            $pagination_number = 1000000;
            $query2->where('section_id', '=', $search_section);
            $query->where('fv_section_id', '=', $search_section);
        }
        if (!empty($search_semester)) {
            $pagination_number = 1000000;
            $query->where('fv_semester_id', '=', $search_semester);
        }

        if (!empty($search)) {

            $pagination_number = 1000000;
            $query->where('fv_std_reg_no', 'like', '%' . $search . '%');
            $query2->where('registration_no', 'like', '%' . $search . '%');
        }

        if ($search_status != 3) {
            $pagination_number = 1000000;
            $query->where('fv_status_update', '=', $search_status);
        }

        $datas = $query
            ->orderBy('students.roll_no', config('global_variables.drop_sorting'))
            ->paginate($pagination_number);

        $fee_students = $query2->where('section_id', '=', $search_section)->select('id', 'full_name', 'registration_no', 'roll_no')->orderBy('roll_no', config('global_variables.drop_sorting'))
            ->paginate
            ($pagination_number);

        $students = Student::where('branch_id', $branch_id)->where('class_id', $search_class)->where('status', '!=', 3)->where('clg_id', '=', $user->user_clg_id)->
        orderBy('id', 'ASC')->pluck('registration_no')->all();


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'fee_students', 'search_type', 'search_class', 'srch_fltr', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $fee_students, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('collegeViews/Reports/fee_register', compact('datas', 'search', 'students', 'classes', 'sections', 'search_section', 'search_class', 'fee_students', 'search_type', 'semesters', 'search_status', 'search_semester'));
        }

    }

    public function custom_fee_register(Request $request, $array = null, $str = null)
    {

        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $classes = Classes::where('class_clg_id', '=', $user->user_clg_id)->orderby('class_id', 'DESC')->get();
        $sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id)->orderby('cs_id', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->class;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section;
        $search_type = (!isset($request->type) && empty($request->type)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->type;
        $search_status = !isset($request->status) && empty($request->status) ? (!empty($ar) ? $ar[5]->{'value'} : '') : $request->status;
        $prnt_page_dir = 'print.college.reports.custom_fee_register';
        $pge_title = 'Custom Fee Register';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_class, $search_section, $search_type, $search_status);


        $pagination_number = (empty($ar) || !empty($ar)) ? 1000000 : 100000000;

        $query2 = DB::table('students')
            ->where('students.status', '!=', 3)
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->selectRaw('create_section.cs_name, section_id, id, full_name, registration_no, roll_no,
        (SELECT SUM(cv_total_amount)
         FROM student_custom_voucher
         WHERE cv_std_id = students.id
           AND cv_package_type = ?
           AND cv_section_id = ?) as total_amount,
        (SELECT SUM(cv_total_amount)
         FROM student_custom_voucher AS cv_voucher
         WHERE cv_voucher.cv_std_id = students.id
           AND cv_voucher.cv_status = "Paid"
           AND cv_voucher.cv_package_type = ?
           AND cv_voucher.cv_section_id = ?) AS paid',
                array_merge(
                    [$search_type],
                    [$search_section, $search_type, $search_section]
                )
            )
            ->where('branch_id', '=', $branch_id)
            ->where('clg_id', '=', $user->user_clg_id)
            ->where('students.section_id', $search_section);


        $query = DB::table('student_custom_voucher_items')
            ->join('student_custom_voucher', 'student_custom_voucher.cv_id', '=', 'student_custom_voucher_items.cvi_voucher_id')
            ->join('students', 'students.id', '=', 'student_custom_voucher.cv_std_id')
            ->where('students.status', '!=', 3)
            ->where('cv_clg_id', '=', $user->user_clg_id)
            ->where('cv_section_id', '=', $search_section)
            ->where('students.section_id', '=', $search_section)
            ->where('cv_package_type', '=', $search_type)
            ->where('cv_branch_id', '=', $branch_id);

        if (!empty($search_status)) {
            $query->where('cv_status', $search_status);
        }
        if (!empty($search_class)) {
            $pagination_number = 1000000;
            $query2->where('class_id', '=', $search_class);
            $query->where('cv_class_id', '=', $search_class);
        }
        if (!empty($search_section)) {
            $pagination_number = 1000000;
            $query2->where('section_id', '=', $search_section);
            $query->where('cv_section_id', '=', $search_section);
        }

        if (!empty($search)) {

            $pagination_number = 1000000;
            $query->where('cv_reg_no', 'like', '%' . $search . '%');
            $query2->where('registration_no', 'like', '%' . $search . '%');
        }
        $datas = $query
            ->orderBy('students.roll_no', config('global_variables.drop_sorting'))
            ->paginate($pagination_number);

        $fee_students = $query2->orderBy('roll_no', config('global_variables.drop_sorting'))
            ->paginate($pagination_number);

        $students = Student::where('branch_id', $branch_id)->where('status', '!=', 3)->where('clg_id', '=', $user->user_clg_id)->
        orderBy('id', 'ASC')->pluck('registration_no')->all();


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'fee_students', 'search_type', 'srch_fltr', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $fee_students, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews/Reports/custom_fee_register', compact('datas', 'search', 'students', 'search_status', 'classes', 'sections', 'search_section', 'search_class', 'fee_students', 'search_type'));
        }
    }

    public function fee_summary_report(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $classes = Classes::where('class_clg_id', '=', $user->user_clg_id)->orderby('class_id', 'DESC')->get();
        $branch_id = Session::get('branch_id');
        $semesters = Semester::all();
        $ar = json_decode($request->array);
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->class;
        $search_type = (!isset($request->type) && empty($request->type)) ? ((!empty($ar) && isset($ar[2])) ? $ar[2]->{'value'} : '') : $request->type;
        $search_semester = (!isset($request->semester) && empty($request->semester)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->semester;

        $prnt_page_dir = 'print.college.reports.fee_summary';
        $pge_title = 'Fee Register';
        $srch_fltr = [];

        array_push($srch_fltr, $search_class, $search_type, $search_semester);
        $pagination_number = (empty($ar)) ? 30 : 100000000;
        $class_ids = '';
        $students = '';
        if (!empty($search_class)) {
            $students = Student::
            whereIn('class_id', $search_class)
                ->where('status', '!=', 3)->where('branch_id', $branch_id)
                ->pluck('id');
        }
        if (!empty($search_class) && $students->isNotEmpty()) {

            $class_ids = implode(',', $search_class);
            $query = DB::table('students_package')
                ->whereIn('sp_class_id', $search_class)
                ->whereIn('sp_sid', $students)
                ->where('sp_package_type', $search_type)
                ->where('sp_branch_id', $branch_id)
                ->where('sp_semester', $search_semester)
                ->leftJoin('classes', 'classes.class_id', '=', 'students_package.sp_class_id')
                ->leftJoin('semesters', 'semesters.semester_id', '=', 'students_package.sp_semester')
                ->leftJoin('create_section', 'create_section.cs_id', '=', 'students_package.sp_section_id')
                ->selectRaw('
                    (SELECT SUM(fv_total_amount) FROM financials_fee_voucher
                    WHERE fv_package_type = 1 AND fv_status_update = 1
                    AND fv_class_id IN (' . $class_ids . ') AND fv_std_id IN (' . $students->implode(',') . ') AND fv_branch_id = "' . $branch_id . '"
                    AND fv_package_type = "' . $search_type . '"
                    AND fv_semester_id = "' . $search_semester . '"
                    AND fv_section_id = students_package.sp_section_id) AS paid_fee,

                    (SELECT count(id) FROM students
                    WHERE class_id IN (' . $class_ids . ') AND status != 3 AND branch_id = "' . $branch_id . '" AND section_id = students_package.sp_section_id) AS total_students,
                    SUM(sp_T_package_amount) AS tution_fee,
                    SUM(sp_A_package_amount) AS annual_fund,
                    SUM(sp_P_package_amount) AS paper_fund,
                    SUM(sp_Z_package_amount) AS zakat_fund,
                    sp_package_type AS type,
                    classes.class_name,
                    create_section.cs_name,
                    semesters.semester_name
                ');
        } else {
            $query = DB::table('students_package')
                ->where('sp_class_id', $search_class)
                ->where('sp_package_type', $search_type)
                ->where('sp_branch_id', $branch_id)
                ->where('sp_semester', $search_semester)
                ->leftJoin('classes', 'classes.class_id', '=', 'students_package.sp_class_id')
                ->leftJoin('semesters', 'semesters.semester_id', '=', 'students_package.sp_semester')
                ->leftJoin('create_section', 'create_section.cs_id', '=', 'students_package.sp_section_id')
                ->selectRaw('
            (SELECT SUM(fv_total_amount) FROM financials_fee_voucher
            WHERE fv_package_type = 1 AND fv_status_update = 1
            AND fv_class_id ="' . $class_ids . '" AND fv_branch_id = "' . $branch_id . '" AND fv_package_type = "' . $search_type . '" AND fv_semester_id = "' . $search_semester . '" AND fv_section_id = students_package.sp_section_id) AS paid_fee,

            (SELECT count(id) FROM students
            WHERE class_id ="' . $class_ids . '" AND branch_id = "' . $branch_id . '" AND section_id = students_package.sp_section_id) AS total_students,
            SUM(sp_T_package_amount) AS tution_fee,
            SUM(sp_A_package_amount) AS annual_fund,
            SUM(sp_P_package_amount) AS paper_fund,
            SUM(sp_Z_package_amount) AS zakat_fund,
            sp_package_type AS type,
            classes.class_name,
            create_section.cs_name,
            semesters.semester_name
            ');
        }

        $datas = $query
            ->groupBy('sp_section_id', 'sp_class_id')
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
            $pdf->loadView($prnt_page_dir, compact('datas', 'srch_fltr', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('collegeViews/Reports/fee_summary_report', compact('datas', 'classes', 'search_class', 'class_ids', 'search_type', 'search_semester', 'semesters'));
        }
    }

    public function teacher_day_attendance(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search_date = (!isset($request->date) && empty($request->date)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->date;
        $ar = json_decode($request->array);
        $prnt_page_dir = 'print.college.reports.teacher_day_attendance';
        $pge_title = 'Teacher Day Attendance';
        $srch_fltr = [];
        array_push($srch_fltr, $search_date);
        $date = date('Y-m-d', strtotime($search_date));

        $pagination_number = (empty($ar) || !empty($ar)) ? 1000000 : 100000000;
        if (!empty($search_date)) {
            $query = DB::table('lecturer_attendance')
                ->leftJoin('financials_users', 'financials_users.user_id', '=', 'lecturer_attendance.la_emp_id')
                ->select('la_emp_id', 'financials_users.user_name',
                    DB::raw('(SELECT ab.la_attendance FROM lecturer_attendance as ab WHERE ab.la_date= "' . $date . '" and ab.la_attendance="A" and ab.la_emp_id = lecturer_attendance.la_emp_id) as absent'),
                    DB::raw('(SELECT cv_sl.la_attendance FROM lecturer_attendance AS cv_sl WHERE cv_sl.la_date= "' . $date . '" and cv_sl.la_attendance="S.L" and cv_sl.la_emp_id = lecturer_attendance.la_emp_id) AS short_leave'),
                    DB::raw('(SELECT leav.la_attendance FROM lecturer_attendance AS leav WHERE leav.la_date= "' . $date . '" and leav.la_attendance="L" and leav.la_emp_id = lecturer_attendance.la_emp_id) AS leaves')
                )
                ->where('la_attendance', '!=', 'P');


            if (!empty($search_date)) {
                $query->where('la_date', '=', $date);
            }
            $datas = $query
                ->groupBy('la_emp_id')
                ->paginate($pagination_number);

        } else {
            $datas = [];
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
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'search_date', 'srch_fltr', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('collegeViews/Reports/teacher_day_attendance', compact('datas', 'search_date'));
        }

    }
    // code by Mustafa end

    // code by Burhan start

    public function teacher_analyze_report(Request $request)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search_teacher_id = (!isset($request->teacher_id) && empty($request->teacher_id)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->teacher_id;
        $search_exam_id = (!isset($request->exam_id) && empty($request->exam_id)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->exam_id;
        $search_subject_id = (!isset($request->subject_id) && empty($request->subject_id)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->subject_id;
        $prnt_page_dir = 'print.college.reports.fee_register';
        $pge_title = 'Fee Register';
        $srch_fltr = [];
        array_push($srch_fltr, $search_teacher_id);
        $branch = Session::get('branch_id');
        $time_table = TimeTableModel::with('users')
            ->where('tm_college_id', $user->user_clg_id)
            ->where('tm_branch_id', $branch)
            ->get();

        $teachers = User::where('user_clg_id', $user->user_clg_id)->where('user_mark', '=', 1)->get();

        $exams = ExamModel::where('exam_clg_id', $user->user_clg_id)->get();

        $subjects = Subject::where('subject_clg_id', $user->user_clg_id)->get();

        // Create an array to store the formatted data for all days
        $uniqueTeachers = []; // Initialize an array to store unique teacher_ids

        // Loop through the $time_table collection and format the data
        $section_id = [];
        $subject_id = [];
        foreach ($time_table as $row) {
            if (!is_null($row->tm_timetable)) {
                $tmTimetable = json_decode($row->tm_timetable, true);

                // Loop through the $tmTimetable and format the data for the current day
                foreach ($tmTimetable as $dayData) {
                    $day = $dayData['day'];
                    $items = $dayData['items'];
                    // Loop through the items for the current day and populate the dayRow array
                    foreach ($items as $key => $item) {
                        if (isset($item['teacher_id'])) {
                            // Fetch the teacher name directly from the users table based on teacher ID
                            if (!in_array($item['teacher_id'], $uniqueTeachers)) {
                                $teacher = optional(User::find($item['teacher_id']));
                                $subject = optional(Subject::find($item['subject_id']));
                                if ($teacher->user_id == $search_teacher_id) {
                                    if ($subject->subject_id == $search_subject_id) {
                                        $section_id[$row->tm_section_id] = $item['teacher_id'];
                                    }
                                    // $section_id[$key] = $row->tm_section_id;
                                }
                            }
                            // Fetch the subject name directly from the subjects table based on subject ID

                        }
                    }
                }
            }
        }
        $section_names = [];
        $uniqueSectionIds = array_keys($section_id);
        $uniqueSubjectIds = array_unique($subject_id);
        $section_marks = [];


        foreach ($uniqueSectionIds as $sectionKey) {
            $marks = MarkExamModel::where('me_clg_id', $user->user_clg_id)
                ->where('me_branch_id', $branch)
                ->where('me_exam_id', $search_exam_id)
                ->where('me_section_id', $sectionKey)
                ->where('me_subject_id', $search_subject_id)
                ->leftJoin('create_section', 'create_section.cs_id', '=', 'marks_exam.me_section_id')
                ->get();
            $section_marks[$sectionKey] = $marks;
        }


        if (isset($request->array) && !empty($request->array)) {
            // dd($section_names,$section_id,$subject_id,$exams,$teachers,$time_table);
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
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('collegeViews.Reports.teacher_analyze_report', compact('search_teacher_id', 'teachers', 'exams', 'search_exam_id', 'section_marks', 'search_subject_id', 'subjects'));
        }

    }

    public function student_analysis_report(Request $request)
    {
        $ar = json_decode($request->array);
        $class_id = (!isset($request->class_id) && empty($request->class_id)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->class_id;
        $section_id = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->section;
        $branch_id = Session::get('branch_id');
        $user = Auth::user();
        $prnt_page_dir = 'print.college.reports.student_analysis_report';
        $pge_title = 'Student Result';

        $srch_fltr = [];
        array_push($srch_fltr, $class_id, $section_id);
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->where('class_disable_enable', 1)->get();
        $class_name = Classes::where('class_clg_id', $user->user_clg_id)->where('class_id', $class_id)->pluck('class_name')->first();
        $section_name = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_id', $section_id)->pluck('cs_name')->first();
        $exam_ids = MarkExamModel::where('me_clg_id', $user->user_clg_id)->where('me_class_id', $class_id)
            ->where('me_section_id', $section_id)
//            ->where('me_ng_id', $group_id)
            ->groupBy('me_exam_id')
            ->orderBy('me_exam_id', 'desc')
            ->take(3)
            ->pluck('me_exam_id');
        $exams_names = ExamModel::whereIn('exam_id', $exam_ids)->get();
        $branch = Branch::where('branch_clg_id', $user->user_clg_id)->where('branch_id', $branch_id)->pluck('branch_name')->first();
        $students = Student::where('clg_id', $user->user_clg_id)
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->whereIn('status', [1, 3])
            ->get();
        // $section_result = $this->section_wise_result($exam_id, $class_id, $section_id, $group_id, $user->user_clg_id);
        // $branch_result = $this->branch_wise_result($exam_id, $class_id, $group_id, $user->user_clg_id, $branch_id);
        $college_result0 = '';
        $college_result1 = '';
        $college_result2 = '';
        foreach ($exam_ids as $index => $exam_id) {
            ${'college_result' . $index} = $this->college_wise_result($exam_id, $class_id, $user->user_clg_id, $section_id);
            foreach (${'college_result' . $index} as $result) {
                $filteredData = Arr::only($result, ['branch_id']);
                $foundItem = $filteredData['branch_id'] == $branch_id ? $result : null;

                $filteredSection = Arr::only($result, ['section_id']);
                $sectionItem = $filteredSection['section_id'] == $section_id ? $result : null;

                // Check if $foundItem is set before using it
                if ($foundItem) {
                    ${'branch_result' . $index}[] = [
                        "id" => $result['id'],
                        "obtain" => $result['obtain'],
                        "total_marks" => $result['total_marks'],
                        "branch_id" => $result['branch_id'],
                        "section_id" => $result['section_id'],
                    ];
                }

                // Check if $sectionItem is set before using it
                if ($sectionItem) {
                    ${'section_result' . $index}[] = [
                        "id" => $result['id'],
                        "obtain" => $result['obtain'],
                        "total_marks" => $result['total_marks'],
                        "branch_id" => $result['branch_id'],
                        "section_id" => $result['section_id'],
                    ];
                }
            }
        }
        $clg0_positions = json_encode($college_result0);
        $clg1_positions = json_encode($college_result1);
        $clg2_positions = json_encode($college_result2);

        if (isset($request->array) && !empty($request->array)) {
            // dd($section_names,$section_id,$subject_id,$exams,$teachers,$time_table);
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
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'type', 'pge_title', 'students',
                'clg0_positions',
                'clg1_positions',
                'clg2_positions',
                'exams_names', 'class_name', 'section_name'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('collegeViews.Reports.student_analysis_report', compact(
                'classes', 'students',
                'request',
                'branch',
                'clg0_positions',
                'clg1_positions',
                'clg2_positions',
                'exams_names',
                'class_id',
                'section_id'
            ));
        }
    }


    public function teacher_subject_exam_report(Request $request)
    {
        $ar = json_decode($request->array);
        $class_id = (!isset($request->class_id) && empty($request->class_id)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->class_id;
        $section_id = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->section;
        $branch_id = Session::get('branch_id');
        $user = Auth::user();
        $prnt_page_dir = 'print.college.reports.teacher_subject_exam_report';
        $pge_title = 'Teacher Analysis Report';
        $srch_fltr = [];
        array_push($srch_fltr, $class_id, $section_id);
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->where('class_disable_enable', 1)->get();
        $class_name = Classes::where('class_clg_id', $user->user_clg_id)->where('class_id', $class_id)->pluck('class_name')->first();
        $section_name = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_id', $section_id)->pluck('cs_name')->first();
        $exam_ids = MarkExamModel::where('me_clg_id', $user->user_clg_id)->where('me_class_id', $class_id)
            ->where('me_section_id', $section_id)
            ->groupBy('me_exam_id')
            ->orderBy('me_exam_id', 'desc')
            ->take(3)
            ->pluck('me_exam_id');
        $exams_names = ExamModel::whereIn('exam_id', $exam_ids)->get();
        $branch = Branch::where('branch_clg_id', $user->user_clg_id)->where('branch_id', $branch_id)->pluck('branch_name')->first();
        $teachers = ClassTimetableItem::where('tmi_section_id', $section_id)
            ->where('tmi_branch_id', Session::get('branch_id'))
            ->leftJoin('financials_users as user', 'user.user_id', '=', 'tmi_teacher_id')
            ->leftJoin('class_timetable', 'class_timetable.tm_id', '=', 'tmi_tm_id')
            ->where('class_timetable.tm_disable_enable','=', 1)
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'tmi_subject_id')
            ->select('user.user_name', 'user.user_id', 'subjects.subject_id', 'subjects.subject_name')->groupBy('user.user_id', 'user.user_name', 'subjects.subject_id', 'subjects.subject_name')->get();

        $c_marks0 = [];
        $c_marks1 = [];
        $c_marks2 = [];
        foreach ($exam_ids as $index => $exam_id) {
            $class_marks = MarkExamModel::where('me_clg_id', $user->user_clg_id)
                ->where('me_exam_id', $exam_id)
                ->leftJoin('subjects', 'subjects.subject_id', '=', 'marks_exam.me_subject_id')
                ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'marks_exam.me_ng_id')
                ->where('me_class_id', $class_id)
                ->where('me_section_id', $section_id)
                ->orderBy('me_exam_id', 'desc')->get();
            ${'class_marks_' . $index} = [];
            // dd($class_marks);
            foreach ($class_marks as $result) {
                $red = 0;
                $purple = 0;
                $blue = 0;
                $yellow = 0;
                $green = 0;
                $studentCount = 0;

                $numericArray = json_decode($result->me_obtain_marks, true);
                $studentsArray = json_decode($result->me_students, true);

                if (is_array($numericArray) && $result->me_total_marks > 0) {
                    $numericArray = array_map('intval', $numericArray);
                    $studentsArray = array_map('intval', $studentsArray);
                    $studentCount = count($studentsArray);

                    foreach ($numericArray as $item) {
                        $percentage = $item > 0 ? number_format($item / $result->me_total_marks * 100, 2) : 0;

                        if ($percentage <= 39) {
                            $red++;
                        } elseif ($percentage >= 40 && $percentage <= 65) {
                            $purple++;
                        } elseif ($percentage > 65 && $percentage <= 75) {
                            $blue++;
                        } elseif ($percentage > 75 && $percentage <= 85) {
                            $yellow++;
                        } elseif ($percentage > 85 && $percentage <= 100) {
                            $green++;
                        }
                    }
                }
                // Calculate total students passed in various grades
                $t_passed = $green + $yellow + $blue + $purple;
                // Store the results in the class marks variable
                ${'class_marks_' . $index}[] = [
                    's_id' => $result->me_subject_id ?? null,
                    'group_name' => $result->ng_name,
                    'total_students' => $studentCount,
                    'total_passed' => $t_passed,
                    'total_failed' => $red,
                    'green' => $green,
                    'yellow' => $yellow,
                    'blue' => $blue,
                    'purple' => $purple,
                    'red' => $red,
                    'exam_id' => $result->me_exam_id ?? null
                ];
            }


            // Store the result back in corresponding variables
            ${'c_marks' . $index} = ${'class_marks_' . $index};
        }
        // dd($c_marks0, $c_marks1, $c_marks2);
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
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'type', 'pge_title', 'teachers',
                'c_marks0',
                'c_marks1',
                'c_marks2',
                'exams_names',
                'class_name', 'section_name'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('collegeViews.Reports.teacher_subject_exam_report', compact(
                'classes',
                'request',
                'teachers',
                'branch',
                'c_marks0',
                'c_marks1',
                'c_marks2',
                'exams_names',
                'class_id',
                'section_id'
            ));
        }
    }

    public function subject_wise_exam_report(Request $request)
    {
        $ar = json_decode($request->array);
        $class_id = (!isset($request->class_id) && empty($request->class_id)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->class_id;
        $section_id = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->section;
        $subject_id = (!isset($request->subject_id) && empty($request->subject_id)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->subject_id;
        $branch_id = Session::get('branch_id');
        $user = Auth::user();
        $prnt_page_dir = 'print.college.reports.subject_wise_exam_report';
        $pge_title = 'Student Result';
        $srch_fltr = [];
        array_push($srch_fltr, $class_id, $section_id);
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->where('class_disable_enable', 1)->get();
        $class_name = Classes::where('class_clg_id', $user->user_clg_id)->where('class_id', $class_id)->pluck('class_name')->first();
        $section_name = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_id', $section_id)->pluck('cs_name')->first();
        $subject_name = Subject::where('subject_clg_id', $user->user_clg_id)->where('subject_id', $subject_id)->pluck('subject_name')->first();
        $exam_ids = MarkExamModel::where('me_clg_id', $user->user_clg_id)->where('me_class_id', $class_id)
            ->where('me_section_id', $section_id)
            ->groupBy('me_exam_id')
            ->orderBy('me_exam_id', 'desc')
            ->take(5)
            ->pluck('me_exam_id');
        $exams_names = ExamModel::whereIn('exam_id', $exam_ids)->get();
        $branch = Branch::where('branch_clg_id', $user->user_clg_id)->where('branch_id', $branch_id)->pluck('branch_name')->first();
        $students = Student::where('clg_id', $user->user_clg_id)
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->where('status', '!=', 3)
            ->get();
        // $section_result = $this->section_wise_result($exam_id, $class_id, $section_id, $group_id, $user->user_clg_id);
        // $branch_result = $this->branch_wise_result($exam_id, $class_id, $group_id, $user->user_clg_id, $branch_id);
        $college_result0 = '';
        $college_result1 = '';
        $college_result2 = '';
        $college_result3 = '';
        $college_result4 = '';
        foreach ($exam_ids as $index => $exam_id) {
            ${'college_result' . $index} = $this->college_wise_result($exam_id, $class_id, $user->user_clg_id, $section_id, $subject_id);
            foreach (${'college_result' . $index} as $result) {
                $filteredData = Arr::only($result, ['branch_id']);
                $foundItem = $filteredData['branch_id'] == $branch_id ? $result : null;

                $filteredSection = Arr::only($result, ['section_id']);
                $sectionItem = $filteredSection['section_id'] == $section_id ? $result : null;

                // Check if $foundItem is set before using it
                if ($foundItem) {
                    ${'branch_result' . $index}[] = [
                        "id" => $result['id'],
                        "obtain" => $result['obtain'],
                        "total_marks" => $result['total_marks'],
                        "branch_id" => $result['branch_id'],
                        "section_id" => $result['section_id'],
                    ];
                }

                // Check if $sectionItem is set before using it
                if ($sectionItem) {
                    ${'section_result' . $index}[] = [
                        "id" => $result['id'],
                        "obtain" => $result['obtain'],
                        "total_marks" => $result['total_marks'],
                        "branch_id" => $result['branch_id'],
                        "section_id" => $result['section_id'],
                    ];
                }
            }
        }
        $clg0_positions = json_encode($college_result0);
        $clg1_positions = json_encode($college_result1);
        $clg2_positions = json_encode($college_result2);
        $clg3_positions = json_encode($college_result3);
        $clg4_positions = json_encode($college_result4);
        if (isset($request->array) && !empty($request->array)) {
            // dd($section_names,$section_id,$subject_id,$exams,$teachers,$time_table);
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
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'type', 'pge_title', 'classes', 'students',
                'request',
                'branch',
                'clg0_positions',
                'clg1_positions',
                'clg2_positions',
                'clg3_positions',
                'clg4_positions',
                'exams_names',
                'class_id',
                'section_id',
                'subject_id', 'class_name', 'section_name', 'subject_name'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('collegeViews.Reports.subject_wise_exam_report', compact(
                'classes', 'students',
                'request',
                'branch',
                'clg0_positions',
                'clg1_positions',
                'clg2_positions',
                'clg3_positions',
                'clg4_positions',
                'exams_names',
                'class_id',
                'section_id',
                'subject_id'
            ));
        }

    }

    public function college_wise_result($exam_id, $class_id, $college_id, $section_id, $subject_id = null)
    {
        $search_exam = $exam_id;
        $search_class = $class_id;
        $search_section = $section_id;
        $query = MarkExamModel::where('me_clg_id', $college_id)
            ->where('me_exam_id', $search_exam)
            ->where('me_class_id', $search_class)
            ->where('me_section_id', $search_section);
        if (!empty($subject_id)) {
            $query->where('me_subject_id', $subject_id);
        }
        $class_marks = $query->get();

        $students = Student::where('clg_id', $college_id)
            ->where('class_id', $search_class)
            ->where('section_id', $search_section)
            ->where('status', '!=', 3)
            ->orderBy('roll_no', 'ASC')->get();

        $count = 0;
        $array = [];
        foreach ($students as $student) {
            if ($student) {
                $obtained_marks = 0;
                $total_marks = 0;

                foreach ($class_marks as $class_mark) {
                    $numericArray = json_decode($class_mark->me_obtain_marks, true);
                    $studentsArray = json_decode($class_mark->me_students, true);
                    if (is_array($numericArray)) {
                        $numericArray = array_map('intval', $numericArray);
                        $studentsArray = array_map('intval', $studentsArray);
                        // Fetch student details based on student IDs
                    }


                    if ($numericArray) {
                        foreach ($studentsArray as $key => $value) {
                            if ($value == $student->id) {
                                $obtained_marks = $obtained_marks + $numericArray[$key];
                                $total_marks = $total_marks + $class_mark->me_total_marks;
                            }
                        }
                    }
                }
            }
            $count++;
            $array[$count] = array('id' => $student->id, 'obtain' => $obtained_marks, 'total_marks' => $total_marks, 'branch_id' => $student->branch_id, 'section_id' =>
                $student->section_id);
        }
        return $array;
    }

    public function issue_matricMarks(Request $request, $array = null, $str = null)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->where('class_disable_enable', 1)->get();
        $sections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_branch_id', Session::get('branch_id'))->get();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->class;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section;
        $search_status = (!isset($request->status) && empty($request->status)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->status;

        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search_class, $search_section, $search_status);

        $pagination_number = (empty($ar)) ? 100 : 100000000;


        $query = Student::leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'students.branch_id')
            ->where('students.clg_id', $user->user_clg_id)
            ->where('status', '!=', 3)
            ->where('students.branch_id', Session::get('branch_id'));

        if (!empty($search)) {
            $query->where('full_name', 'like', '%' . $search . '%')
                ->orWhere('registration_no', 'like', '%' . $search . '%')
                ->orWhere('cnic', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%');
        }
        if (!empty($search_class)) {
            $query->where('students.class_id', $search_class);
        }
        if (!empty($search_section)) {
            $query->where('students.section_id', $search_section);
        }
        if (!empty($search_status)) {
            $query->where('students.student_disable_enable', $search_status);
        }
        $datas = $query->orderBy('full_name', 'ASC')
            ->select('students.*', 'classes.class_name', 'branches.branch_name')
            ->paginate($pagination_number);


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
            return view('collegeViews.student.issue_matricMarks', compact('datas', 'search', 'search_class', 'classes', 'student_title', 'search_status', 'search_section', 'sections'));
        }
    }

    public function submit_matricMarks(Request $request)
    {
        $user = Auth::User();

        $matricMarks = $request->matricMarks;
        $student_ids = $request->student_id;

        foreach ($student_ids as $index => $id) {
            $student_id = $id;
            $matric_marks = $matricMarks[$index];
            $student = Student::where('clg_id', '=', $user->user_clg_id)->where('id', '=', $student_id)->first();
            $student->marks_10th = $matric_marks;
            $student->save();
        }
        return redirect()->back()->with('success', 'Successfully Update');
    }
}
