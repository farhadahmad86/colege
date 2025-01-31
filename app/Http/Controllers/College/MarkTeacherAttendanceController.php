<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\AssignCoordinatorModel;
use App\Models\College\Classes;
use App\Models\College\MarkTeacherAttendanceItemsModel;
use App\Models\College\MarkTeacherAttendanceModel;
use App\Models\College\Section;
use App\Models\College\Subject;
use App\Models\College\TeacherLoadModel;
use App\Models\CreateSectionModel;
use App\Models\Department;
use App\User;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class MarkTeacherAttendanceController extends Controller
{
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        // dd($request->expectsJson());
        if ($request->is('api/*')) {
            $branchId = $request->branchId;
        }else{
            $branchId = Session::get('branch_id');
        }
        $currentDate = Carbon::now()->format('Y-m-d');
        $departments = Department::where('dep_clg_id', '=', $user->user_clg_id)
            ->orderBy('dep_title', 'ASC')
            ->get();
        $employees = User::where('user_clg_id', '=', $user->user_clg_id)
            ->where('user_delete_status', '!=', 1)
            ->orderBy('user_name', 'ASC')
            ->get();

        $search_department = !isset($request->department) && empty($request->department) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->department;
        $search_employee = !isset($request->employee) && empty($request->employee) ? (!empty($ar) ? $ar[2]->{'value'} : '') : $request->employee;

        $search_to = !isset($request->to) && empty($request->to) ? (!empty($ar) ? $ar[3]->{'value'} : '') : $request->to;
        $search_from = !isset($request->from) && empty($request->from) ? (!empty($ar) ? $ar[4]->{'value'} : '') : $request->from;
        if (!$request->expectsJson()) {
            $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->year;
            // return response()->json(['query' => $request->expectsJson()]);
        }

        $check_desktop = $request->check_desktop;
        $prnt_page_dir = 'print.sale_invoice_list.sale_invoice_list';
        $pge_title = 'Attendance List';
        $srch_fltr = [];
        array_push($srch_fltr, $search_department, $search_employee, $search_to, $search_from,$search_year);

        $pagination_number = empty($ar) ? 30 : 100000000;

        if (empty($search_to)) {
            $search_to = $currentDate;
            $start = $search_to;
        } else {
            $start = date('Y-m-d', strtotime($search_to));
        }
        $end = date('Y-m-d', strtotime($search_from));

        $query = MarkTeacherAttendanceModel::where('la_clg_id', $user->user_clg_id)
            ->where('la_branch_id',$branchId)
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'lecturer_attendance.la_createdby')
            ->leftJoin('financials_users as user', 'user.user_id', '=', 'lecturer_attendance.la_emp_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'lecturer_attendance.la_section_id')
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'lecturer_attendance.la_subject_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'lecturer_attendance.la_class_id')
            ->leftJoin('semesters', 'semesters.semester_id', '=', 'lecturer_attendance.la_semester_id')
            ->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'lecturer_attendance.la_department_id')
            ->leftJoin('lecturer_attendance_items', 'lecturer_attendance_items.lai_la_id', '=', 'lecturer_attendance.la_id')
            ->leftJoin('teacher_load', 'teacher_load.tl_teacher_id', '=', 'lecturer_attendance.la_emp_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'lecturer_attendance.la_branch_id')
            ->where('la_list_status', 0)
            ->select('lecturer_attendance.*', 'create_section.cs_name', 'subjects.subject_name', 'financials_departments.dep_title', 'user.user_name as employee', 'financials_users.user_name', 'branches.branch_name', 'teacher_load.tl_attendance_load', 'semesters.semester_name', 'classes.class_name');
        // ->selectRaw('count(lai_emp_id) as total_load,  lecturer_attendance.*,financials_departments.dep_title,user.user_name as employee, financials_users.user_name, branches.branch_name');
        // $query = $query->get();
        // return response()->json(['query' => $query]);
        // dd($result);
        if ($user->user_designation == 14) {
            $query->where('la_createdby', $user->user_id);
        }
        if ($request->expectsJson() && $user->user_designation != 14) {
            $query->where('la_emp_id', $user->user_id);
        }
        if (!empty($search_department)) {
            $query->where('la_department_id', $search_department);
        }

        if (!empty($search_employee)) {
            $query->where('la_emp_id', $search_employee);
        }

        if (!empty($search_to) && !empty($search_from)) {
            $query->whereDate('la_date', '>=', $start)->whereDate('la_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('la_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('la_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('la_year_id', '=', $search_year);
        } elseif ($request->is('api/*')) {

            $search_year = $this->getYearEndId();
            $query->where('la_year_id', '=', $search_year);
        }
        if ($request->is('api/*')) {
            $datas = $query->get();
            // return response()->json(['query' => $datas,'sc'=>$search_year]);
        }else{

            $datas = $query
                // ->select('financials_users.user_name', 'lecturer_attendance.*', 'financials_departments.dep_title', 'user.user_name as teacher')
                ->groupBy('lai_emp_id', 'la_id')
                ->orderBy('la_id', 'DESC')
                ->paginate($pagination_number);
        }
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
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } elseif ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } elseif ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            if ($request->is('api/*')) {
                return response()->json(['data' => $datas]);
//                return response()->json(['query' => $query]);
            } else {
//                return redirect()->back()->with('success', 'Successfully Saved');
                return view('collegeViews.MarkTeacherAttendance.teacher_attendance_list', compact('datas','search_year', 'search_employee', 'search_department', 'search_from', 'search_to', 'employees', 'departments'));
            }
//            return view('collegeViews.MarkTeacherAttendance.teacher_attendance_list', compact('datas','search_year', 'employee_title', 'search_by_user', 'search_employee', 'search_department', 'search_from', 'search_to', 'employees', 'departments'));
        }
    }
    public function create()
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        // dd($user->user_designation == 14);

        if ($user->user_designation == 14) {
            $classId = AssignCoordinatorModel::where('ac_coordinator_id', $user->user_id)
                ->where('ac_disable_enable', 1)
                ->get();
            $classIds = $classId->pluck('ac_class_id')->implode(','); // Extract section IDs and create a comma-separated string
            $classIdsArray = explode(',', $classIds); // Convert the string to an array

            $allclasses = Classes::where('class_clg_id', $user->user_clg_id)
                // ->where('class_branch_id', $branch_id)
                ->whereIn('class_id', $classIdsArray) // Use class_id to match sections
                ->get();

            // dd($allclasses);
        } else {
            $allclasses = Classes::where('class_clg_id', $user->user_clg_id)
                // ->where('class_branch_id', $branch_id) // Use class_id to match sections
                ->get();
            // dd($allclasses);
        }
        $allteachers = User::where('user_clg_id', $user->user_clg_id)
            ->where('user_branch_id', $branch_id) // Use class_id to match sections
            ->get();
        // dd($allteachers);
        // if ($user->user_designation == 14) {
        //     $sectionId = AssignCoordinatorModel::where('ac_coordinator_id', $user->user_id)->get();
        //     $sectionIds = $sectionId->pluck('ac_section_id')->implode(','); // Extract section IDs and create a comma-separated string
        //     $sectionIdsArray = explode(',', $sectionIds); // Convert the string to an array

        //     $allsections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)
        //         ->where('cs_branch_id', $branch_id)
        //         ->whereIn('cs_id', $sectionIdsArray) // Use cs_id to match sections
        //         ->get();

        //     // dd($allsections);
        // } else {
        //     $allsections = Section::where('section_clg_id', $user->user_clg_id)
        //         ->where('section_branch_id', $branch_id)
        //         ->leftJoin('create_section', 'create_section.cs_id', '=', 'sections.section_name')
        //         ->select('sections.*', 'create_section.cs_name', 'create_section.cs_id')
        //         ->get();
        // }

        // dd($allsections);

        // $allsections = Section::where('section_clg_id', $user->user_clg_id)
        //     ->where('section_branch_id', $branch_id)
        //     ->leftJoin('create_section', 'create_section.cs_id', '=', 'sections.section_name')
        //     ->select('sections.*', 'create_section.cs_name', 'create_section.cs_id')
        //     ->get();
        return view('collegeViews.MarkTeacherAttendance.mark_teacher_attendance', compact('allclasses', 'branch_id', 'allteachers'));
    }
    public function store(Request $request)
    {
//         dd($request->all(),1);

        $user = Auth::user();
        $dateString = $request->la_date;

        // Convert the date string to a UNIX timestamp
        $timestamp = strtotime($dateString);

        $currentDate = date('Y-m-d', $timestamp);
        // dd($currentDate);
        $teacherId = $request->input('teacher_id');
        $dep_id = User::where('user_id', $teacherId)->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'financials_users.user_department_id')->select('financials_users.user_id', 'financials_departments.dep_title', 'financials_departments.dep_id')->first();
        // dd($dep_id);

        // Retrieve teacher load information for the given teacher
        $load = TeacherLoadModel::where('tl_teacher_id', $teacherId)
            ->where('tl_branch_id', Session::get('branch_id'))
            ->where('tl_clg_id', $user->user_clg_id)
            ->first();
        // dd($load);
        if ($load == null) {
            // Redirect back with a message
            return redirect()->back()->with('success', 'Please Enter Teacher Load First');
        }

        // Process attendance-related data for the single teacher entry in the request
        $count = MarkTeacherAttendanceModel::where('la_emp_id', $teacherId)
            ->where('la_clg_id', $user->user_clg_id)
            ->where('la_date', $currentDate)
            ->count();

        $count_present = MarkTeacherAttendanceItemsModel::where('lai_emp_id', $teacherId)
            ->where('lai_clg_id', $user->user_clg_id)
            ->where('lai_date', $currentDate)
            ->where('lai_attendance', 'P')
            ->count();

        $total_count = MarkTeacherAttendanceItemsModel::where('lai_emp_id', $teacherId)
            ->where('lai_clg_id', $user->user_clg_id)
            ->where('lai_date', $currentDate)
            ->count();

        $attendanceTypes = ['P', 'L', 'A'];
        $mix_count = MarkTeacherAttendanceItemsModel::where('lai_emp_id', $teacherId)
            ->where('lai_clg_id', $user->user_clg_id)
            ->where('lai_date', $currentDate)
            ->whereIn('lai_attendance', $attendanceTypes)
            ->count();
        // dd($mix_count);

        $count_absent = MarkTeacherAttendanceItemsModel::where('lai_emp_id', $teacherId)
            ->where('lai_clg_id', $user->user_clg_id)
            ->where('lai_date', $currentDate)
            ->where('lai_attendance', 'A')
            ->count();

        $count_leave = MarkTeacherAttendanceItemsModel::where('lai_emp_id', $teacherId)
            ->where('lai_clg_id', $user->user_clg_id)
            ->where('lai_date', $currentDate)
            ->where('lai_attendance', 'L')
            ->count();

        // Create an array to store the data for the single teacher
        $checkedTeachers = [
            'teacher_id' => $teacherId,
            'load' => $load, // Access the property on the model instance
            'check_entry' => $count,
            'count_present' => $count_present,
            'count_absent' => $count_absent,
            'count_leave' => $count_leave,
            'subject_id' => $request->subject_id,
            'semester_id' => $request->semester_id,
            'class_id' => $request->class_id,
            'attendance' => $request->lec_attendance,
            'dep_id' => $dep_id,
            'total_count' => $total_count,
            'mix_count' => $mix_count,
        ];
        $teacherData = $checkedTeachers;
        // dd($checkedTeachers);

        // Your existing code for retrieving data

        DB::transaction(function () use ($request, $user, $currentDate, $load, $dep_id, $teacherData) {
            if ($teacherData['check_entry'] == 0 && $load->tl_attendance_load !== 0) {
                // dd(1);
                // Save data in MarkTeacherAttendanceModel
                $lecturer_attendance = new MarkTeacherAttendanceModel();
                $lecturer_attendance->la_clg_id = $user->user_clg_id;
                $lecturer_attendance->la_branch_id = Session::get('branch_id');
                $lecturer_attendance->la_department_id = $dep_id->dep_id;
                $lecturer_attendance->la_emp_id = $teacherData['teacher_id'];
                $lecturer_attendance->la_subject_id = $teacherData['subject_id'];
                $lecturer_attendance->la_semester_id = $teacherData['semester_id'];
                $lecturer_attendance->la_class_id = $teacherData['class_id'];
                $lecturer_attendance->la_attendance = 'S.L'; // Or your desired default value
                $lecturer_attendance->la_start_time = $request->start_time; // Or your desired default value
                $lecturer_attendance->la_createdby = $user->user_id;
                $lecturer_attendance->la_section_id = $request->section_id;
                $lecturer_attendance->la_brwsr_info = $this->getBrwsrInfo();
                $lecturer_attendance->la_ip_adrs = $this->getIp();
                $lecturer_attendance->la_year_id = $this->getYearEndId();
                $lecturer_attendance->la_created_datetime = Carbon::now();
                $lecturer_attendance->la_date = $currentDate;
                $lecturer_attendance->save();

                // Save entry in MarkTeacherAttendanceItemsModel
                $lecturer_attendance_items = new MarkTeacherAttendanceItemsModel();
                $lecturer_attendance_items->lai_la_id = $lecturer_attendance->la_id;
                $lecturer_attendance_items->lai_section_id = $request->section_id;
                $lecturer_attendance_items->lai_year_id = $this->getYearEndId();
                $lecturer_attendance_items->lai_clg_id = $user->user_clg_id;
                $lecturer_attendance_items->lai_branch_id = Session::get('branch_id');
                if ($request->lec_attendance == 'L') {
                    $lecturer_attendance_items->lai_leave_remarks = $request->leave_remarks;
                }
                $lecturer_attendance_items->lai_emp_id = $teacherData['teacher_id'];
                $lecturer_attendance_items->lai_department_id = $dep_id->dep_id;
                $lecturer_attendance_items->lai_subject_id = $teacherData['subject_id'];
                $lecturer_attendance_items->lai_semester_id = $teacherData['semester_id'];
                $lecturer_attendance_items->lai_class_id = $teacherData['class_id'];
                $lecturer_attendance_items->lai_date = $currentDate;
                $lecturer_attendance_items->lai_start_time = $request->start_time;
                $lecturer_attendance_items->lai_attendance = $teacherData['attendance'];
                $lecturer_attendance_items->lai_createdby = $user->user_id;
                $lecturer_attendance_items->lai_created_datetime = Carbon::now();
                $lecturer_attendance_items->save();
            } elseif ($teacherData['check_entry'] > 0 && $teacherData['total_count'] < $load->tl_attendance_load) {
                if ($teacherData['attendance'] == 'P' && $teacherData['count_present'] < $load->tl_attendance_load) {
                    // dd(2, $teacherData['total_count'], $teacherData['check_entry'], $teacherData['count_present'], $teacherData['count_absent'], $teacherData['count_leave']);

                    $lecturer_attendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                        ->where('la_clg_id', $user->user_clg_id)
                        ->where('la_date', $currentDate)
                        ->first();

                    if ($teacherData['count_present'] == $load->tl_attendance_load - 1) {
                        $lastLecturerAttendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                            ->where('la_clg_id', $user->user_clg_id)
                            ->where('la_date', $currentDate)
                            ->orderBy('la_id', 'desc')
                            ->first();

                        if ($lastLecturerAttendance && $lastLecturerAttendance->la_attendance == 'S.L') {
                            $lastLecturerAttendance->la_attendance = 'P';
                            $lastLecturerAttendance->save();
                        }
                    }
                    // Save entry in MarkTeacherAttendanceItemsModel
                    $lecturer_attendance_items = new MarkTeacherAttendanceItemsModel();
                    $lecturer_attendance_items->lai_la_id = $lecturer_attendance->la_id;
                    $lecturer_attendance_items->lai_section_id = $request->section_id;
                    $lecturer_attendance_items->lai_year_id = $this->getYearEndId();
                    $lecturer_attendance_items->lai_clg_id = $user->user_clg_id;
                    $lecturer_attendance_items->lai_branch_id = Session::get('branch_id');
                    if ($request->lec_attendance == 'L') {
                        $lecturer_attendance_items->lai_leave_remarks = $request->leave_remarks;
                    }
                    $lecturer_attendance_items->lai_emp_id = $teacherData['teacher_id'];
                    $lecturer_attendance_items->lai_department_id = $dep_id->dep_id;
                    $lecturer_attendance_items->lai_subject_id = $teacherData['subject_id'];
                    $lecturer_attendance_items->lai_semester_id = $teacherData['semester_id'];
                    $lecturer_attendance_items->lai_class_id = $teacherData['class_id'];
                    $lecturer_attendance_items->lai_date = $currentDate;
                    $lecturer_attendance_items->lai_start_time = $request->start_time;
                    $lecturer_attendance_items->lai_attendance = $teacherData['attendance'];
                    $lecturer_attendance_items->lai_createdby = $user->user_id;
                    $lecturer_attendance->lai_created_datetime = Carbon::now();
                    $lecturer_attendance_items->save();
                } elseif ($teacherData['attendance'] == 'A' && $teacherData['count_absent'] < $load->tl_attendance_load) {
                    // dd(2.1,$teacherData['total_count'], $teacherData['check_entry'], $teacherData['count_present'], $teacherData['count_absent'], $teacherData['count_leave']);

                    $lecturer_attendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                        ->where('la_clg_id', $user->user_clg_id)
                        ->where('la_date', $currentDate)
                        ->first();

                    if ($teacherData['count_absent'] == $load->tl_attendance_load - 1) {
                        // dd(1);
                        $absentLecturerAttendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                            ->where('la_clg_id', $user->user_clg_id)
                            ->where('la_date', $currentDate)
                            ->orderBy('la_id', 'desc') // Order by la_id in descending order
                            ->first();
                        // dd($absentLecturerAttendance);

                        if ($absentLecturerAttendance && $absentLecturerAttendance->la_attendance == 'S.L') {
                            // Update the attendance to 'P' for the last entry
                            $absentLecturerAttendance->la_attendance = 'A';
                            $absentLecturerAttendance->save();
                        }
                    }
                    // Save entry in MarkTeacherAttendanceItemsModel
                    $lecturer_attendance_items = new MarkTeacherAttendanceItemsModel();
                    $lecturer_attendance_items->lai_la_id = $lecturer_attendance->la_id;
                    $lecturer_attendance_items->lai_section_id = $request->section_id;
                    $lecturer_attendance_items->lai_year_id = $this->getYearEndId();
                    $lecturer_attendance_items->lai_clg_id = $user->user_clg_id;
                    $lecturer_attendance_items->lai_branch_id = Session::get('branch_id');
                    if ($request->lec_attendance == 'L') {
                        $lecturer_attendance_items->lai_leave_remarks = $request->leave_remarks;
                    }
                    $lecturer_attendance_items->lai_emp_id = $teacherData['teacher_id'];
                    $lecturer_attendance_items->lai_department_id = $dep_id->dep_id;
                    $lecturer_attendance_items->lai_subject_id = $teacherData['subject_id'];
                    $lecturer_attendance_items->lai_semester_id = $teacherData['semester_id'];
                    $lecturer_attendance_items->lai_class_id = $teacherData['class_id'];
                    $lecturer_attendance_items->lai_date = $currentDate;
                    $lecturer_attendance_items->lai_start_time = $request->start_time;
                    $lecturer_attendance_items->lai_attendance = $teacherData['attendance'];
                    $lecturer_attendance_items->lai_createdby = $user->user_id;
                    $lecturer_attendance->lai_created_datetime = Carbon::now();
                    $lecturer_attendance_items->save();
                } elseif ($teacherData['attendance'] == 'L' && $teacherData['count_leave'] < $load->tl_attendance_load) {
                    // dd(2.2, $teacherData['total_count'], $teacherData['check_entry'], $teacherData['count_present'], $teacherData['count_absent'], $teacherData['count_leave']);

                    $lecturer_attendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                        ->where('la_clg_id', $user->user_clg_id)
                        ->where('la_date', $currentDate)
                        ->first();

                    if ($teacherData['count_leave'] == $load->tl_attendance_load - 1) {
                        // dd(1);
                        $leaveLecturerAttendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                            ->where('la_clg_id', $user->user_clg_id)
                            ->where('la_date', $currentDate)
                            ->orderBy('la_id', 'desc') // Order by la_id in descending order
                            ->first();
                        // dd($leaveLecturerAttendance);

                        if ($leaveLecturerAttendance && $leaveLecturerAttendance->la_attendance == 'S.L') {
                            // Update the attendance to 'P' for the last entry
                            $leaveLecturerAttendance->la_attendance = 'L';
                            $leaveLecturerAttendance->save();
                        }
                    }

                    // Save entry in MarkTeacherAttendanceItemsModel
                    $lecturer_attendance_items = new MarkTeacherAttendanceItemsModel();
                    $lecturer_attendance_items->lai_la_id = $lecturer_attendance->la_id;
                    $lecturer_attendance_items->lai_section_id = $request->section_id;
                    $lecturer_attendance_items->lai_year_id = $this->getYearEndId();
                    $lecturer_attendance_items->lai_clg_id = $user->user_clg_id;
                    $lecturer_attendance_items->lai_branch_id = Session::get('branch_id');
                    if ($request->lec_attendance == 'L') {
                        $lecturer_attendance_items->lai_leave_remarks = $request->leave_remarks;
                    }
                    $lecturer_attendance_items->lai_emp_id = $teacherData['teacher_id'];
                    $lecturer_attendance_items->lai_department_id = $dep_id->dep_id;
                    $lecturer_attendance_items->lai_subject_id = $teacherData['subject_id'];
                    $lecturer_attendance_items->lai_semester_id = $teacherData['semester_id'];
                    $lecturer_attendance_items->lai_class_id = $teacherData['class_id'];
                    $lecturer_attendance_items->lai_date = $currentDate;
                    $lecturer_attendance_items->lai_start_time = $request->start_time;
                    $lecturer_attendance_items->lai_attendance = $teacherData['attendance'];
                    $lecturer_attendance_items->lai_createdby = $user->user_id;
                    $lecturer_attendance->lai_created_datetime = Carbon::now();
                    $lecturer_attendance_items->save();
                }
            } elseif ($teacherData['count_present'] >= $load->tl_attendance_load) {
                // dd(3);

                // Save data in MarkTeacherAttendanceModel
                $lecturer_attendance = new MarkTeacherAttendanceModel();
                $lecturer_attendance->la_clg_id = $user->user_clg_id;
                $lecturer_attendance->la_branch_id = Session::get('branch_id');
                $lecturer_attendance->la_department_id = $dep_id->dep_id;
                $lecturer_attendance->la_type = 2;
                $lecturer_attendance->la_emp_id = $teacherData['teacher_id'];
                $lecturer_attendance->la_subject_id = $teacherData['subject_id'];
                $lecturer_attendance->la_semester_id = $teacherData['semester_id'];
                $lecturer_attendance->la_class_id = $teacherData['class_id'];
                $lecturer_attendance->la_attendance = $teacherData['attendance']; // Or your desired default value
                $lecturer_attendance->la_start_time = $request->start_time; // Or your desired default value
                $lecturer_attendance->la_createdby = $user->user_id;
                $lecturer_attendance->la_section_id = $request->section_id;
                $lecturer_attendance->la_brwsr_info = $this->getBrwsrInfo();
                $lecturer_attendance->la_ip_adrs = $this->getIp();
                $lecturer_attendance->la_year_id = $this->getYearEndId();
                $lecturer_attendance->la_created_datetime = Carbon::now();
                if ($request->lec_attendance == 'L') {
                    $lecturer_attendance->la_leave_remarks = $request->leave_remarks;
                }
                $lecturer_attendance->la_date = $currentDate;
                $lecturer_attendance->save();
            } elseif ($teacherData['mix_count'] >= $load->tl_attendance_load) {
                // dd(4,$teacherData['mix_count']);
                $lecturer_attendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                    ->where('la_clg_id', $user->user_clg_id)
                    ->where('la_date', $currentDate)
                    ->first();
                if ($lecturer_attendance->la_attendance == 'S.L') {
                    // dd(4.1, $lecturer_attendance);
                    // Save data in MarkTeacherAttendanceModel
                    $lecturer_attendance = new MarkTeacherAttendanceModel();
                    $lecturer_attendance->la_clg_id = $user->user_clg_id;
                    $lecturer_attendance->la_branch_id = Session::get('branch_id');
                    $lecturer_attendance->la_department_id = $dep_id->dep_id;
                    $lecturer_attendance->la_type = 2;
                    $lecturer_attendance->la_emp_id = $teacherData['teacher_id'];
                    $lecturer_attendance->la_subject_id = $teacherData['subject_id'];
                    $lecturer_attendance->la_semester_id = $teacherData['semester_id'];
                    $lecturer_attendance->la_class_id = $teacherData['class_id'];
                    $lecturer_attendance->la_attendance = $teacherData['attendance']; // Or your desired default value
                    $lecturer_attendance->la_start_time = $request->start_time; // Or your desired default value
                    $lecturer_attendance->la_createdby = $user->user_id;
                    $lecturer_attendance->la_section_id = $request->section_id;
                    $lecturer_attendance->la_brwsr_info = $this->getBrwsrInfo();
                    $lecturer_attendance->la_ip_adrs = $this->getIp();
                    $lecturer_attendance->la_year_id = $this->getYearEndId();
                    $lecturer_attendance->la_created_datetime = Carbon::now();
                    $lecturer_attendance->la_date = $currentDate;
                    $lecturer_attendance->save();
                }
            } elseif ($load->tl_attendance_load == 0) {
                $lecturer_attendance = new MarkTeacherAttendanceModel();
                $lecturer_attendance->la_clg_id = $user->user_clg_id;
                $lecturer_attendance->la_branch_id = Session::get('branch_id');
                $lecturer_attendance->la_department_id = $dep_id->dep_id;
                $lecturer_attendance->la_type = 2;
                $lecturer_attendance->la_emp_id = $teacherData['teacher_id'];
                $lecturer_attendance->la_subject_id = $teacherData['subject_id'];
                $lecturer_attendance->la_semester_id = $teacherData['semester_id'];
                $lecturer_attendance->la_class_id = $teacherData['class_id'];
                $lecturer_attendance->la_attendance = $teacherData['attendance']; // Or your desired default value
                $lecturer_attendance->la_start_time = $request->start_time; // Or your desired default value
                $lecturer_attendance->la_createdby = $user->user_id;
                $lecturer_attendance->la_section_id = $request->section_id;
                $lecturer_attendance->la_brwsr_info = $this->getBrwsrInfo();
                $lecturer_attendance->la_ip_adrs = $this->getIp();
                $lecturer_attendance->la_year_id = $this->getYearEndId();
                $lecturer_attendance->la_created_datetime = Carbon::now();
                $lecturer_attendance->la_date = $currentDate;
                $lecturer_attendance->save();
            } else {
                // dd(4);
            }
        });

        return redirect()->route('add_lecturer_attendance')->with('success', 'Saved Successfully');
    }
    public function store_time(Request $request)
    {

        $user = Auth::user();
//         dd($request->all(),$user,2);
        $dateString = $request->lat_date;

        // Convert the date string to a UNIX timestamp
        $timestamp = strtotime($dateString);

        $currentDate = date('Y-m-d', $timestamp);
        // dd($currentDate);
        $teacherId = $request->input('teacher_id');

        $dep_id = User::where('user_id', $teacherId)->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'financials_users.user_department_id')->select('financials_users.user_id', 'financials_departments.dep_title', 'financials_departments.dep_id')->first();
        // dd($dep_id);

        // Retrieve teacher load information for the given teacher
        $load = TeacherLoadModel::where('tl_teacher_id', $teacherId)
            ->where('tl_branch_id', Session::get('branch_id'))
            ->where('tl_clg_id', $user->user_clg_id)
            ->first();
        // dd($load);
        if ($load == null) {
            // Redirect back with a message
            return redirect()->back()->with('success', 'Please Enter Teacher Load First');
        }
        // Iterate over each teacher
        foreach ($request->teacher_id as $key => $teacherId) {
            // Apply your logic for each teacher here

            // Retrieve other data for this row
            $classId = $request->class_id[$key];
            $sectionId = $request->section_id[$key];
            $semesterId = $request->semester_id[$key];
            $subjectId = $request->subject_id[$key];
            $attendance = $request->attendance[$key];
            $time = $request->time[$key];
            $leaveRemarks = $request->leave_remarks[$key];

            // Process attendance-related data for the single teacher entry in the request
            $count = MarkTeacherAttendanceModel::where('la_emp_id', $teacherId)
                ->where('la_clg_id', $user->user_clg_id)
                ->where('la_date', $currentDate)
                ->count();

            $count_present = MarkTeacherAttendanceItemsModel::where('lai_emp_id', $teacherId)
                ->where('lai_clg_id', $user->user_clg_id)
                ->where('lai_date', $currentDate)
                ->where('lai_attendance', 'P')
                ->count();

            $total_count = MarkTeacherAttendanceItemsModel::where('lai_emp_id', $teacherId)
                ->where('lai_clg_id', $user->user_clg_id)
                ->where('lai_date', $currentDate)
                ->count();

            $attendanceTypes = ['P', 'L', 'A'];
            $mix_count = MarkTeacherAttendanceItemsModel::where('lai_emp_id', $teacherId)
                ->where('lai_clg_id', $user->user_clg_id)
                ->where('lai_date', $currentDate)
                ->whereIn('lai_attendance', $attendanceTypes)
                ->count();
            // dd($mix_count);

            $count_absent = MarkTeacherAttendanceItemsModel::where('lai_emp_id', $teacherId)
                ->where('lai_clg_id', $user->user_clg_id)
                ->where('lai_date', $currentDate)
                ->where('lai_attendance', 'A')
                ->count();

            $count_leave = MarkTeacherAttendanceItemsModel::where('lai_emp_id', $teacherId)
                ->where('lai_clg_id', $user->user_clg_id)
                ->where('lai_date', $currentDate)
                ->where('lai_attendance', 'L')
                ->count();

            // Create an array to store the data for the single teacher
            $checkedTeachers = [
                'teacher_id' => $teacherId,
                'load' => $load, // Access the property on the model instance
                'check_entry' => $count,
                'count_present' => $count_present,
                'count_absent' => $count_absent,
                'count_leave' => $count_leave,
                'subject_id' => $subjectId,
                'semester_id' => $semesterId,
                'section_id' => $sectionId,
                'class_id' => $classId,
                'attendance' => $attendance,
                'time' => $time,
                'leave_remarks' => $leaveRemarks,
                'dep_id' => $dep_id,
                'total_count' => $total_count,
                'mix_count' => $mix_count,
            ];
            $teacherData = $checkedTeachers;
            // dd($checkedTeachers);

            // Your existing code for retrieving data

            DB::transaction(function () use ($request, $user, $currentDate, $load, $dep_id, $teacherData) {



                if($teacherData['attendance'] == 'M'){
                    $lecturer_attendance = new MarkTeacherAttendanceModel();
                    $lecturer_attendance->la_clg_id = $user->user_clg_id;
                    $lecturer_attendance->la_branch_id = Session::get('branch_id');
                    $lecturer_attendance->la_department_id = $dep_id->dep_id;
                    $lecturer_attendance->la_type = 5;
                    $lecturer_attendance->la_emp_id = $teacherData['teacher_id'];
                    $lecturer_attendance->la_subject_id = $teacherData['subject_id'];
                    $lecturer_attendance->la_semester_id = $teacherData['semester_id'];
                    $lecturer_attendance->la_class_id = $teacherData['class_id'];
                    $lecturer_attendance->la_attendance = $teacherData['attendance']; // Or your desired default value
                    $lecturer_attendance->la_start_time = $teacherData['time'];; // Or your desired default value
                    $lecturer_attendance->la_createdby = $user->user_id;
                    $lecturer_attendance->la_section_id = $teacherData['section_id'];;
                    $lecturer_attendance->la_brwsr_info = $this->getBrwsrInfo();
                    $lecturer_attendance->la_ip_adrs = $this->getIp();
                    $lecturer_attendance->la_year_id = $this->getYearEndId();
                    $lecturer_attendance->la_created_datetime = Carbon::now();
                    $lecturer_attendance->la_date = $currentDate;
                    $lecturer_attendance->save();
                }else{
                if ($teacherData['check_entry'] == 0 && $load->tl_attendance_load !== 0) {
                    // dump(1);
                    // Save data in MarkTeacherAttendanceModel
                    $lecturer_attendance = new MarkTeacherAttendanceModel();
                    $lecturer_attendance->la_clg_id = $user->user_clg_id;
                    $lecturer_attendance->la_branch_id = Session::get('branch_id');
                    $lecturer_attendance->la_department_id = $dep_id->dep_id;
                    $lecturer_attendance->la_emp_id = $teacherData['teacher_id'];
                    $lecturer_attendance->la_subject_id = $teacherData['subject_id'];
                    $lecturer_attendance->la_semester_id = $teacherData['semester_id'];
                    $lecturer_attendance->la_class_id = $teacherData['class_id'];
                    $lecturer_attendance->la_attendance = 'S.L'; // Or your desired default value
                    $lecturer_attendance->la_start_time = $teacherData['time']; // Or your desired default value
                    $lecturer_attendance->la_createdby = $user->user_id;
                    $lecturer_attendance->la_section_id = $teacherData['section_id'];
                    $lecturer_attendance->la_brwsr_info = $this->getBrwsrInfo();
                    $lecturer_attendance->la_ip_adrs = $this->getIp();
                    $lecturer_attendance->la_year_id = $this->getYearEndId();
                    $lecturer_attendance->la_created_datetime = Carbon::now();
                    $lecturer_attendance->la_date = $currentDate;
                    $lecturer_attendance->save();

                    // Save entry in MarkTeacherAttendanceItemsModel
                    $lecturer_attendance_items = new MarkTeacherAttendanceItemsModel();
                    $lecturer_attendance_items->lai_la_id = $lecturer_attendance->la_id;
                    $lecturer_attendance_items->lai_section_id = $teacherData['section_id'];;
                    $lecturer_attendance_items->lai_clg_id = $user->user_clg_id;
                    $lecturer_attendance_items->lai_branch_id = Session::get('branch_id');
                    if ($request->lec_attendance == 'L') {
                        $lecturer_attendance_items->lai_leave_remarks = $request->leave_remarks;
                    }
                    $lecturer_attendance_items->lai_emp_id = $teacherData['teacher_id'];
                    $lecturer_attendance_items->lai_department_id = $dep_id->dep_id;
                    $lecturer_attendance_items->lai_subject_id = $teacherData['subject_id'];
                    $lecturer_attendance_items->lai_semester_id = $teacherData['semester_id'];
                    $lecturer_attendance_items->lai_class_id = $teacherData['class_id'];
                    $lecturer_attendance_items->lai_date = $currentDate;
                    $lecturer_attendance_items->lai_start_time = $teacherData['time'];
                    $lecturer_attendance_items->lai_attendance = $teacherData['attendance'];
                    $lecturer_attendance_items->lai_createdby = $user->user_id;
                    $lecturer_attendance_items->lai_created_datetime = Carbon::now();
                    $lecturer_attendance_items->save();
                } elseif ($teacherData['check_entry'] > 0 && $teacherData['total_count'] < $load->tl_attendance_load) {
                    if ($teacherData['attendance'] == 'P' && $teacherData['count_present'] < $load->tl_attendance_load) {
                        // var_dump(2, $teacherData['total_count'], $teacherData['check_entry'], $teacherData['count_present'], $teacherData['count_absent'], $teacherData['count_leave']);

                        $lecturer_attendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                            ->where('la_clg_id', $user->user_clg_id)
                            ->where('la_date', $currentDate)
                            ->first();

                        if ($teacherData['count_present'] == $load->tl_attendance_load - 1) {
                            // dump(2.1);
                            $lastLecturerAttendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                            ->where('la_clg_id', $user->user_clg_id)
                            ->where('la_date', $currentDate)
                            ->orderBy('la_id', 'desc')
                            ->first();

                            if ($lastLecturerAttendance && $lastLecturerAttendance->la_attendance == 'S.L') {
                                // dump(2.2);
                                $lastLecturerAttendance->la_attendance = 'P';
                                $lastLecturerAttendance->save();
                            }
                        }
                        // Save entry in MarkTeacherAttendanceItemsModel
                        $lecturer_attendance_items = new MarkTeacherAttendanceItemsModel();
                        $lecturer_attendance_items->lai_la_id = $lecturer_attendance->la_id;
                        $lecturer_attendance_items->lai_section_id = $teacherData['section_id'];;
                        $lecturer_attendance_items->lai_clg_id = $user->user_clg_id;
                        $lecturer_attendance_items->lai_branch_id = Session::get('branch_id');
                        if ($request->lec_attendance == 'L') {
                            $lecturer_attendance_items->lai_leave_remarks = $request->leave_remarks;
                        }
                        $lecturer_attendance_items->lai_emp_id = $teacherData['teacher_id'];
                        $lecturer_attendance_items->lai_department_id = $dep_id->dep_id;
                        $lecturer_attendance_items->lai_subject_id = $teacherData['subject_id'];
                        $lecturer_attendance_items->lai_semester_id = $teacherData['semester_id'];
                        $lecturer_attendance_items->lai_class_id = $teacherData['class_id'];
                        $lecturer_attendance_items->lai_date = $currentDate;
                        $lecturer_attendance_items->lai_start_time = $teacherData['time'];
                        $lecturer_attendance_items->lai_attendance = $teacherData['attendance'];
                        $lecturer_attendance_items->lai_createdby = $user->user_id;
                        $lecturer_attendance->lai_created_datetime = Carbon::now();
                        $lecturer_attendance_items->save();
                    } elseif ($teacherData['attendance'] == 'A' && $teacherData['count_absent'] < $load->tl_attendance_load) {
                        // dd(2.1,$teacherData['total_count'], $teacherData['check_entry'], $teacherData['count_present'], $teacherData['count_absent'], $teacherData['count_leave']);

                        $lecturer_attendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                            ->where('la_clg_id', $user->user_clg_id)
                            ->where('la_date', $currentDate)
                            ->first();

                        if ($teacherData['count_absent'] == $load->tl_attendance_load - 1) {
                            // dd(1);
                            $absentLecturerAttendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                                ->where('la_clg_id', $user->user_clg_id)
                                ->where('la_date', $currentDate)
                                ->orderBy('la_id', 'desc') // Order by la_id in descending order
                                ->first();
                            // dd($absentLecturerAttendance);

                            if ($absentLecturerAttendance && $absentLecturerAttendance->la_attendance == 'S.L') {
                                // Update the attendance to 'P' for the last entry
                                $absentLecturerAttendance->la_attendance = 'A';
                                $absentLecturerAttendance->save();
                            }
                        }
                        // Save entry in MarkTeacherAttendanceItemsModel
                        $lecturer_attendance_items = new MarkTeacherAttendanceItemsModel();
                        $lecturer_attendance_items->lai_la_id = $lecturer_attendance->la_id;
                        $lecturer_attendance_items->lai_section_id = $teacherData['section_id'];;
                        $lecturer_attendance_items->lai_clg_id = $user->user_clg_id;
                        $lecturer_attendance_items->lai_branch_id = Session::get('branch_id');
                        if ($request->lec_attendance == 'L') {
                            $lecturer_attendance_items->lai_leave_remarks = $request->leave_remarks;
                        }
                        $lecturer_attendance_items->lai_emp_id = $teacherData['teacher_id'];
                        $lecturer_attendance_items->lai_department_id = $dep_id->dep_id;
                        $lecturer_attendance_items->lai_subject_id = $teacherData['subject_id'];
                        $lecturer_attendance_items->lai_semester_id = $teacherData['semester_id'];
                        $lecturer_attendance_items->lai_class_id = $teacherData['class_id'];
                        $lecturer_attendance_items->lai_date = $currentDate;
                        $lecturer_attendance_items->lai_start_time = $teacherData['time'];;
                        $lecturer_attendance_items->lai_attendance = $teacherData['attendance'];
                        $lecturer_attendance_items->lai_createdby = $user->user_id;
                        $lecturer_attendance->lai_created_datetime = Carbon::now();
                        $lecturer_attendance_items->save();
                    } elseif ($teacherData['attendance'] == 'L' && $teacherData['count_leave'] < $load->tl_attendance_load) {
                        // dd(2.2, $teacherData['total_count'], $teacherData['check_entry'], $teacherData['count_present'], $teacherData['count_absent'], $teacherData['count_leave']);

                        $lecturer_attendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                            ->where('la_clg_id', $user->user_clg_id)
                            ->where('la_date', $currentDate)
                            ->first();

                        if ($teacherData['count_leave'] == $load->tl_attendance_load - 1) {
                            // dd(1);
                            $leaveLecturerAttendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                                ->where('la_clg_id', $user->user_clg_id)
                                ->where('la_date', $currentDate)
                                ->orderBy('la_id', 'desc') // Order by la_id in descending order
                                ->first();
                            // dd($leaveLecturerAttendance);

                            if ($leaveLecturerAttendance && $leaveLecturerAttendance->la_attendance == 'S.L') {
                                // Update the attendance to 'P' for the last entry
                                $leaveLecturerAttendance->la_attendance = 'L';
                                $leaveLecturerAttendance->save();
                            }
                        }

                        // Save entry in MarkTeacherAttendanceItemsModel
                        $lecturer_attendance_items = new MarkTeacherAttendanceItemsModel();
                        $lecturer_attendance_items->lai_la_id = $lecturer_attendance->la_id;
                        $lecturer_attendance_items->lai_section_id = $teacherData['section_id'];;
                        $lecturer_attendance_items->lai_clg_id = $user->user_clg_id;
                        $lecturer_attendance_items->lai_branch_id = Session::get('branch_id');
                        if ($request->lec_attendance == 'L') {
                            $lecturer_attendance_items->lai_leave_remarks = $request->leave_remarks;
                        }
                        $lecturer_attendance_items->lai_emp_id = $teacherData['teacher_id'];
                        $lecturer_attendance_items->lai_department_id = $dep_id->dep_id;
                        $lecturer_attendance_items->lai_subject_id = $teacherData['subject_id'];
                        $lecturer_attendance_items->lai_semester_id = $teacherData['semester_id'];
                        $lecturer_attendance_items->lai_class_id = $teacherData['class_id'];
                        $lecturer_attendance_items->lai_date = $currentDate;
                        $lecturer_attendance_items->lai_start_time = $teacherData['time'];;
                        $lecturer_attendance_items->lai_attendance = $teacherData['attendance'];
                        $lecturer_attendance_items->lai_createdby = $user->user_id;
                        $lecturer_attendance->lai_created_datetime = Carbon::now();
                        $lecturer_attendance_items->save();
                    }
                } elseif ($teacherData['count_present'] >= $load->tl_attendance_load) {
                    // dump(3);

                    // Save data in MarkTeacherAttendanceModel
                    $lecturer_attendance = new MarkTeacherAttendanceModel();
                    $lecturer_attendance->la_clg_id = $user->user_clg_id;
                    $lecturer_attendance->la_branch_id = Session::get('branch_id');
                    $lecturer_attendance->la_department_id = $dep_id->dep_id;
                    $lecturer_attendance->la_type = 2;
                    $lecturer_attendance->la_emp_id = $teacherData['teacher_id'];
                    $lecturer_attendance->la_subject_id = $teacherData['subject_id'];
                    $lecturer_attendance->la_semester_id = $teacherData['semester_id'];
                    $lecturer_attendance->la_class_id = $teacherData['class_id'];
                    $lecturer_attendance->la_attendance = $teacherData['attendance']; // Or your desired default value
                    $lecturer_attendance->la_start_time = $teacherData['time'];; // Or your desired default value
                    $lecturer_attendance->la_createdby = $user->user_id;
                    $lecturer_attendance->la_section_id = $teacherData['section_id'];;
                    $lecturer_attendance->la_brwsr_info = $this->getBrwsrInfo();
                    $lecturer_attendance->la_ip_adrs = $this->getIp();
                    $lecturer_attendance->la_year_id = $this->getYearEndId();
                    $lecturer_attendance->la_created_datetime = Carbon::now();
                    if ($request->lec_attendance == 'L') {
                        $lecturer_attendance->la_leave_remarks = $request->leave_remarks;
                    }
                    $lecturer_attendance->la_date = $currentDate;
                    $lecturer_attendance->save();
                } elseif ($teacherData['mix_count'] >= $load->tl_attendance_load) {
                    // dump(4,$teacherData['mix_count']);
                    $lecturer_attendance = MarkTeacherAttendanceModel::where('la_emp_id', $teacherData['teacher_id'])
                        ->where('la_clg_id', $user->user_clg_id)
                        ->where('la_date', $currentDate)
                        ->first();
                    if ($lecturer_attendance->la_attendance == 'S.L') {
                        // dd(4.1, $lecturer_attendance);
                        // Save data in MarkTeacherAttendanceModel
                        $lecturer_attendance = new MarkTeacherAttendanceModel();
                        $lecturer_attendance->la_clg_id = $user->user_clg_id;
                        $lecturer_attendance->la_branch_id = Session::get('branch_id');
                        $lecturer_attendance->la_department_id = $dep_id->dep_id;
                        $lecturer_attendance->la_type = 2;
                        $lecturer_attendance->la_emp_id = $teacherData['teacher_id'];
                        $lecturer_attendance->la_subject_id = $teacherData['subject_id'];
                        $lecturer_attendance->la_semester_id = $teacherData['semester_id'];
                        $lecturer_attendance->la_class_id = $teacherData['class_id'];
                        $lecturer_attendance->la_attendance = $teacherData['attendance']; // Or your desired default value
                        $lecturer_attendance->la_start_time = $teacherData['time'];; // Or your desired default value
                        $lecturer_attendance->la_createdby = $user->user_id;
                        $lecturer_attendance->la_section_id = $teacherData['section_id'];;
                        $lecturer_attendance->la_brwsr_info = $this->getBrwsrInfo();
                        $lecturer_attendance->la_ip_adrs = $this->getIp();
                        $lecturer_attendance->la_year_id = $this->getYearEndId();
                        $lecturer_attendance->la_created_datetime = Carbon::now();
                        $lecturer_attendance->la_date = $currentDate;
                        $lecturer_attendance->save();
                    }
                } elseif ($load->tl_attendance_load == 0) {
                    // dump(5);
                    $lecturer_attendance = new MarkTeacherAttendanceModel();
                    $lecturer_attendance->la_clg_id = $user->user_clg_id;
                    $lecturer_attendance->la_branch_id = Session::get('branch_id');
                    $lecturer_attendance->la_department_id = $dep_id->dep_id;
                    $lecturer_attendance->la_type = 2;
                    $lecturer_attendance->la_emp_id = $teacherData['teacher_id'];
                    $lecturer_attendance->la_subject_id = $teacherData['subject_id'];
                    $lecturer_attendance->la_semester_id = $teacherData['semester_id'];
                    $lecturer_attendance->la_class_id = $teacherData['class_id'];
                    $lecturer_attendance->la_attendance = $teacherData['attendance']; // Or your desired default value
                    $lecturer_attendance->la_start_time = $teacherData['time'];; // Or your desired default value
                    $lecturer_attendance->la_createdby = $user->user_id;
                    $lecturer_attendance->la_section_id = $teacherData['section_id'];;
                    $lecturer_attendance->la_brwsr_info = $this->getBrwsrInfo();
                    $lecturer_attendance->la_ip_adrs = $this->getIp();
                    $lecturer_attendance->la_year_id = $this->getYearEndId();
                    $lecturer_attendance->la_created_datetime = Carbon::now();
                    $lecturer_attendance->la_date = $currentDate;
                    $lecturer_attendance->save();
                } else {
                    // dump(4);
                }
            }
            });
        }
        // dd(123);
        return redirect()->route('add_lecturer_attendance')->with('success', 'Saved Successfully');
    }
    public function edit($id)
    {
        // dd($id);
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $attendance = MarkTeacherAttendanceModel::where('la_clg_id', $user->user_clg_id)
            ->where('la_id', '=', $id)
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'lecturer_attendance.la_createdby')
            ->leftJoin('financials_users as user', 'user.user_id', '=', 'lecturer_attendance.la_emp_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'lecturer_attendance.la_section_id')
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'lecturer_attendance.la_subject_id')
            ->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'lecturer_attendance.la_department_id')
            ->leftJoin('teacher_load', 'teacher_load.tl_teacher_id', '=', 'lecturer_attendance.la_emp_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'lecturer_attendance.la_branch_id')
            ->select('lecturer_attendance.*', 'create_section.cs_name', 'subjects.subject_name', 'financials_departments.dep_title', 'user.user_name as employee', 'financials_users.user_name', 'branches.branch_name', 'teacher_load.tl_attendance_load')
            ->first();
        if ($attendance != null) {
            $attendance_items = MarkTeacherAttendanceItemsModel::where('lai_la_id', '=', $id)->leftJoin('financials_users as user', 'user.user_id', '=', 'lecturer_attendance_items.lai_emp_id')->leftJoin('create_section', 'create_section.cs_id', '=', 'lecturer_attendance_items.lai_section_id')->leftJoin('subjects', 'subjects.subject_id', '=', 'lecturer_attendance_items.lai_subject_id')->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'lecturer_attendance_items.lai_department_id')->leftJoin('teacher_load', 'teacher_load.tl_teacher_id', '=', 'lecturer_attendance_items.lai_emp_id')->leftJoin('branches', 'branches.branch_id', '=', 'lecturer_attendance_items.lai_branch_id')->select('lecturer_attendance_items.*', 'create_section.cs_name', 'subjects.subject_name', 'financials_departments.dep_title', 'user.user_name as employee', 'branches.branch_name', 'teacher_load.tl_attendance_load')->get();
            // dd($attendance_items, $attendance);
            return view('collegeViews.MarkTeacherAttendance.edit_teacher_attendance', compact('attendance', 'attendance_items'));
        }
        return redirect()->back();
    }
    public function update(Request $request)
    {
        // Retrieve the array of lai_id values from the form
        $laiIds = $request->input('lai_id');
        $laIds = $request->input('lai_la_id');
        $user = Auth::user();

        // Check for the presence of 'P' and 'A' in lec_attendance array
        $containsP = in_array('P', $request->input('lec_attendance'));
        $containsA = in_array('A', $request->input('lec_attendance'));
        $containsL = in_array('L', $request->input('lec_attendance'));

        // Determine the value for la_attendance based on the conditions
        if ($containsP && $containsA) {
            $la_attendance = 'S.L'; // Both 'P' and 'A' are present
        } elseif ($containsP && $containsL) {
            $la_attendance = 'S.L'; // Both 'P' and 'L' are present
        } elseif ($containsA) {
            $la_attendance = 'A'; // Only 'A' is present
        } elseif ($containsL) {
            $la_attendance = 'L'; // Only 'L' is present
        } else {
            $la_attendance = 'P'; // Default value when only 'P' is present or no attendance selected
        }

        // Update each lecturer attendance record
        foreach ($laIds as $laId) {
            // Find the lecturer attendance record by ID
            $lecturer_attendance = MarkTeacherAttendanceModel::find($laId);

            // Update the lecturer attendance record with the new values
            $lecturer_attendance->la_updatedby = $user->user_id;
            $lecturer_attendance->la_attendance = $la_attendance;

            // Save the updated record
            $lecturer_attendance->save();
        }

        // Loop through the lai_id values and update the corresponding lecturer attendance items
        foreach ($laiIds as $key => $laiId) {
            $attendance = $request->input("lec_attendance.$key");

            // Find the lecturer attendance item by lai_id
            $lecturerAttendanceItem = MarkTeacherAttendanceItemsModel::find($laiId);

            // Update the lecturer attendance item with the new values
            $lecturerAttendanceItem->lai_attendance = $attendance;
            $lecturerAttendanceItem->lai_updatedby = $user->user_id;

            // Save the updated item
            $lecturerAttendanceItem->save();
        }

        // Redirect to a success page or return a response
        return redirect()->route('lecturer_attendance_list')->with('success', 'Updated Successfully');
    }
    public function edit_extra($id)
    {
        // dd($id);
        $user = Auth::user();

        $branch_id = Session::get('branch_id');
        $attendance = MarkTeacherAttendanceModel::where('la_clg_id', $user->user_clg_id)
            ->where('la_id', '=', $id)
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'lecturer_attendance.la_createdby')
            ->leftJoin('financials_users as user', 'user.user_id', '=', 'lecturer_attendance.la_emp_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'lecturer_attendance.la_section_id')
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'lecturer_attendance.la_subject_id')
            ->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'lecturer_attendance.la_department_id')
            ->leftJoin('teacher_load', 'teacher_load.tl_teacher_id', '=', 'lecturer_attendance.la_emp_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'lecturer_attendance.la_branch_id')
            ->select('lecturer_attendance.*', 'create_section.cs_name', 'subjects.subject_name', 'financials_departments.dep_title', 'user.user_name as employee', 'financials_users.user_name', 'branches.branch_name', 'teacher_load.tl_attendance_load')
            ->first();
        $allsections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)
            ->where('cs_branch_id', $branch_id)
            ->where('cs_id', $attendance->la_section_id)
            ->first();
        $allteachers = User::where('user_clg_id', $user->user_clg_id)
            ->where('user_branch_id', $branch_id)
            ->where('user_id', $attendance->la_emp_id)
            ->first();
        $allsubjects = Subject::where('subject_clg_id', $user->user_clg_id)
            ->where('subject_id', $attendance->la_subject_id)
            ->first();
        // dd($attendance,$allsections,$allteachers,$allsubjects);
        return view('collegeViews.MarkTeacherAttendance.edit_extra_teacher_attendance', compact('attendance', 'allsections', 'allteachers', 'allsubjects'));
    }
    public function update_extra(Request $request)
    {
        // dd($request->all());
        // Retrieve the array of lai_id values from the form
        $user = Auth::user();
        $laId = $request->la_id;

        // Retrieve the lecturer attendance model instance by la_id
        $lecturer_attendance = MarkTeacherAttendanceModel::find($laId);

        if (!$lecturer_attendance) {
            // Handle the case where the lecturer attendance record with the given la_id is not found.
            // You can return an error message or redirect as needed.
            return redirect()->back()->with('error', 'Lecturer attendance record not found.');
        }

        // Update the attributes of the lecturer attendance model
        $lecturer_attendance->la_attendance = $request->lec_attendance;

        if ($request->lec_attendance == 'L') {
            $lecturer_attendance->la_leave_remarks = $request->leave_remarks;
        } else {
            $lecturer_attendance->la_leave_remarks = null;
        }

        $lecturer_attendance->la_updatedby = $user->user_id;

        // Save the updated model
        $lecturer_attendance->save();

        // Redirect to a success page or return a response
        return redirect()->route('lecturer_attendance_list')->with('success', 'Updated Successfully');
    }

    public function get_Lecturer_attendance(Request $request)
    {
        $user = Auth::user();
        $department_id = $request->department_id;
        $employees = User::where('user_department_id', $department_id)
            ->where('user_clg_id', $user->user_clg_id)
            ->select('user_id', 'user_name')
            ->get();

        return response()->json(compact('employees'), 200);
    }
    public function lecturer_attendance_view_details_SH(Request $request, $id)
    {
        $user = Auth::user();

        $attendance = MarkTeacherAttendanceItemsModel::where('lai_clg_id', $user->user_clg_id)
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'lecturer_attendance_items.lai_section_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'lecturer_attendance_items.lai_createdby')
            ->leftJoin('financials_users as user', 'user.user_id', '=', 'lecturer_attendance_items.lai_emp_id')
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'lecturer_attendance_items.lai_subject_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'lecturer_attendance_items.lai_class_id')
            ->leftJoin('semesters', 'semesters.semester_id', '=', 'lecturer_attendance_items.lai_semester_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'lecturer_attendance_items.lai_branch_id')
            ->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'lecturer_attendance_items.lai_department_id')
            ->where('cs_clg_id', $user->user_clg_id)
            ->where('lai_branch_id', Session::get('branch_id'))
            ->where('lai_la_id', $request->id)
            ->select('lecturer_attendance_items.*', 'subjects.subject_name', 'branches.branch_name', 'financials_departments.dep_title', 'create_section.cs_name', 'user.user_name as employee', 'financials_users.user_name', 'semesters.semester_name', 'classes.class_name')
            ->get();

        // dd($attendance);
        $type = 'grid';
        $pge_title = 'Lecturer Attendance';

        return view('collegeViews.MarkTeacherAttendance.view_teacher_attendance', compact('type', 'pge_title', 'attendance'));
    }
    public function mark_end_time_attendance_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $departments = Department::where('dep_clg_id', '=', $user->user_clg_id)
            ->orderBy('dep_title', 'ASC')
            ->get();
        $employees = User::where('user_clg_id', '=', $user->user_clg_id)
            ->where('user_delete_status', '!=', 1)
            ->orderBy('user_name', 'ASC')
            ->get();

        $search_department = !isset($request->department) && empty($request->department) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->department;
        $search_employee = !isset($request->employee) && empty($request->employee) ? (!empty($ar) ? $ar[2]->{'value'} : '') : $request->employee;
        $search_to = !isset($request->to) && empty($request->to) ? (!empty($ar) ? $ar[3]->{'value'} : '') : $request->to;
        $search_from = !isset($request->from) && empty($request->from) ? (!empty($ar) ? $ar[4]->{'value'} : '') : $request->from;

        $check_desktop = $request->check_desktop;
        $search_by_user = isset($request->search_by_user) && !empty($request->search_by_user) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_invoice_list.sale_invoice_list';
        $pge_title = 'Attendance List';
        $srch_fltr = [];
        array_push($srch_fltr, $search_department, $search_employee, $search_to, $search_from);

        $pagination_number = empty($ar) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = MarkTeacherAttendanceModel::where('la_clg_id', $user->user_clg_id)
            ->where('la_end_time', '=', null)
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'lecturer_attendance.la_createdby')
            ->leftJoin('financials_users as user', 'user.user_id', '=', 'lecturer_attendance.la_emp_id')
            ->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'lecturer_attendance.la_department_id');

        if (!empty($search_department)) {
            $query->where('la_department_id', $search_department);
        }

        if (!empty($search_employee)) {
            $query->where('la_emp_id', $search_employee);
        }

        if (!empty($search_to) && !empty($search_from)) {
            $query->whereDate('la_created_datetime', '>=', $start)->whereDate('la_created_datetime', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('la_created_datetime', $start);
        } elseif (!empty($search_from)) {
            $query->where('la_created_datetime', $end);
        }

        $datas = $query->select('financials_users.user_name', 'lecturer_attendance.*', 'financials_departments.dep_title', 'user.user_name as teacher')->orderBy('la_id', 'DESC')->paginate($pagination_number);
        // ->get();

        $employee_title = User::where('user_clg_id', $user->user_clg_id)
            ->orderBy('user_id', config('global_variables.query_sorting'))
            ->pluck('user_name')
            ->all(); //where('class_delete_status', '!=', 1)->

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
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } elseif ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } elseif ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.MarkTeacherAttendance.mark_end_time_attendance', compact('datas', 'employee_title', 'search_by_user', 'search_employee', 'search_department', 'search_from', 'search_to', 'employees', 'departments'));
        }
    }
    public function mark_end_attendance(Request $request)
    {
        $this->validate($request, [
            'end_time' => 'required',
        ]);
        foreach ($request->checkbox as $id) {
            $end_time_attendance = MarkTeacherAttendanceModel::where('la_id', '=', $id)->first();
            $end_time_attendance->la_end_time = $request->end_time;
            $start = Carbon::parse($end_time_attendance->la_start_time);
            $end = Carbon::parse($end_time_attendance->la_end_time);
            $minutes = $end->diffInMinutes($start); // 226
            //           $minutes / 60; for hour and minutes
            $end_time_attendance->la_total_time = $minutes;
            $end_time_attendance->la_update_datetime = Carbon::now();
            $end_time_attendance->save();
        }
        return redirect()->back()->with('success', 'Marked Attendance successfully');
    }
    public function create_other_attendance()
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $alldepartments = Department::where('dep_clg_id', $user->user_clg_id)->get();
        // dd($alldepartments);
        return view('collegeViews.OtherAttendance.add_other_attendance', compact('alldepartments'));
    }
    public function store_other_attendance(Request $request)
    {
        // dd($request->all());

        $user = Auth::user();
        $Date = date('Y-m-d', strtotime($request->date));
        $teacherIds = $request->teacher_id;
        $attendances = $request->attendance;
        $leaveDetails = $request->leave_remarks;

        // Your existing code for retrieving data

        DB::transaction(function () use ($request, $user, $Date, $teacherIds, $attendances, $leaveDetails) {
            foreach ($teacherIds as $key => $teacherId) {
                $lecturer_attendance = new MarkTeacherAttendanceModel();
                $lecturer_attendance->la_clg_id = $user->user_clg_id;
                $lecturer_attendance->la_branch_id = Session::get('branch_id');
                $lecturer_attendance->la_department_id = $request->dep_id;
                $lecturer_attendance->la_emp_id = $teacherId;
                $lecturer_attendance->la_attendance = $attendances[$key];
                $lecturer_attendance->la_list_status = 1;
                if (!empty($leaveDetails[$key])) {
                    $lecturer_attendance->la_leave_remarks = $leaveDetails[$key];
                }
                $lecturer_attendance->la_createdby = $user->user_id;
                $lecturer_attendance->la_brwsr_info = $this->getBrwsrInfo();
                $lecturer_attendance->la_ip_adrs = $this->getIp();
                $lecturer_attendance->la_year_id = $this->getYearEndId();
                $lecturer_attendance->la_created_datetime = Carbon::now();
                $lecturer_attendance->la_date = $Date;
                $lecturer_attendance->save();
            }
        });

        return redirect()->route('other_attendance_list')->with('success', 'Saved Successfully');
    }
    public function other_attendance_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->format('Y-m-d');
        $departments = Department::where('dep_clg_id', '=', $user->user_clg_id)
            ->orderBy('dep_title', 'ASC')
            ->get();
        $employees = User::where('user_clg_id', '=', $user->user_clg_id)
            ->orderBy('user_id', 'ASC')
            ->where('user_delete_status', '!=', 1)
            ->where('user_name', '!=', 'MasterCity College')
            ->where('user_name', '!=', 'Super AdminCity College')
            ->select('financials_users.user_name', 'financials_users.user_id')
            ->get();
        // dd($employees,$departments);
        $ar = json_decode($request->array);
        $search_department = !isset($request->department) && empty($request->department) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->department;
        $search_attendance = !isset($request->attendance) && empty($request->attendance) ? (!empty($ar) ? $ar[2]->{'value'} : '') : $request->attendance;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search = !isset($request->teacher) && empty($request->teacher) ? (!empty($ar) ? $ar[3]->{'value'} : '') : $request->teacher;
        $search_to = !isset($request->to) && empty($request->to) ? (!empty($ar) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = !isset($request->from) && empty($request->from) ? (!empty($ar) ? $ar[5]->{'value'} : '') : $request->from;

        $check_desktop = $request->check_desktop;
        $search_by_user = isset($request->search_by_user) && !empty($request->search_by_user) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_invoice_list.sale_invoice_list';
        $pge_title = 'Attendance List';
        $srch_fltr = [];
        array_push($srch_fltr, $search_department, $search, $search_to, $search_from,$search_year);

        $pagination_number = empty($ar) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));
        $query = MarkTeacherAttendanceModel::where('la_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'lecturer_attendance.la_createdby')
            ->leftJoin('financials_users as user', 'user.user_id', '=', 'lecturer_attendance.la_emp_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'lecturer_attendance.la_section_id')
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'lecturer_attendance.la_subject_id')
            ->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'lecturer_attendance.la_department_id')
            ->leftJoin('lecturer_attendance_items', 'lecturer_attendance_items.lai_la_id', '=', 'lecturer_attendance.la_id')
            ->leftJoin('teacher_load', 'teacher_load.tl_teacher_id', '=', 'lecturer_attendance.la_emp_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'lecturer_attendance.la_branch_id')
            ->where('la_clg_id', $user->user_clg_id)
            ->where('la_list_status', 1)
            ->select('lecturer_attendance.*', 'create_section.cs_name', 'subjects.subject_name', 'financials_departments.dep_title', 'user.user_name as employee', 'financials_users.user_name', 'branches.branch_name', 'teacher_load.tl_attendance_load');
        // ->selectRaw('count(lai_emp_id) as total_load,  lecturer_attendance.*,financials_departments.dep_title,user.user_name as employee, financials_users.user_name, branches.branch_name');
        // $result = $query->get();
        // dd($result);
        if (!empty($search)) {
            $query->where('la_emp_id', $search);
            $datas = $query->orderBy('la_id', 'ASC')->paginate($pagination_number);
        }
        if (!empty($search_department)) {
            $query->where('la_department_id', $search_department);
            $datas = $query->orderBy('la_id', 'ASC')->paginate($pagination_number);
        }
        if (!empty($search_attendance)) {
            $query->where('la_attendance', $search_attendance);
            $datas = $query->orderBy('la_id', 'ASC')->paginate($pagination_number);
        }
        if (!empty($search_to) && !empty($search_from)) {
            $query->whereDate('la_date', '>=', $start)->whereDate('la_date', '<=', $end);
            $datas = $query->orderBy('la_id', 'ASC')->paginate($pagination_number);
        } elseif (!empty($search_to)) {
            $query->where('la_date', $start);
            $datas = $query->orderBy('la_id', 'ASC')->paginate($pagination_number);
        } elseif (!empty($search_from)) {
            $query->where('la_date', $end);
            $datas = $query->orderBy('la_id', 'ASC')->paginate($pagination_number);
        }
        if (!empty($search_year)) {
            $query->where('la_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('la_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('la_id', 'DESC')->paginate($pagination_number);
        // ->get();
        // dd($datas);
        //where('class_delete_status', '!=', 1)->

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
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } elseif ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } elseif ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.OtherAttendance.other_attendance_list', compact('datas','search_year', 'search', 'search_attendance', 'search_from', 'search_to', 'employees', 'departments', 'search_department'));
        }
    }
    public function edit_other_attendance(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $alldepartments = Department::where('dep_clg_id', $user->user_clg_id)
            ->where('dep_id', $request->dep_id)
            ->first();
        $allteachers = User::where('user_clg_id', $user->user_clg_id)
            ->where('user_id', $request->emp_id)
            ->first();
        // dd($alldepartments,$allteachers);

        return view('collegeViews.OtherAttendance.edit_other_attendance', compact('alldepartments', 'allteachers', 'request'));
    }
    public function update_other_attendance(Request $request)
    {
        // dd($request->all());

        $user = Auth::user();
        $Date = date('Y-m-d', strtotime($request->date));

        // Your existing code for retrieving data

        DB::transaction(function () use ($request, $user, $Date) {
            $lecturer_attendance = MarkTeacherAttendanceModel::find($request->la_id);
            $lecturer_attendance->la_clg_id = $user->user_clg_id;
            $lecturer_attendance->la_updatedby = $user->user_id;
            $lecturer_attendance->la_branch_id = Session::get('branch_id');
            $lecturer_attendance->la_department_id = $request->dep_id;
            $lecturer_attendance->la_emp_id = $request->teacher_id;
            $lecturer_attendance->la_attendance = $request->lec_attendance;
            $lecturer_attendance->la_list_status = 1;
            if ($request->lec_attendance == 'L') {
                $lecturer_attendance->la_leave_remarks = $request->leave_remarks;
            } else {
                $lecturer_attendance->la_leave_remarks = null;
            }
            $lecturer_attendance->la_brwsr_info = $this->getBrwsrInfo();
            $lecturer_attendance->la_ip_adrs = $this->getIp();
            $lecturer_attendance->la_year_id = $this->getYearEndId();
            $lecturer_attendance->la_created_datetime = Carbon::now();
            $lecturer_attendance->la_date = $Date;
            $lecturer_attendance->save();
        });

        return redirect()->route('other_attendance_list')->with('success', 'Saved Successfully');
    }
}
