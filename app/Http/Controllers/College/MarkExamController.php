<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Classes;
use App\Models\College\ClassTimetableItem;
use App\Models\College\ExamModel;
use App\Models\College\GroupItems;
use App\Models\College\MarkExamModel;
use App\Models\College\NewGroupsModel;
use App\Models\College\Student;
use App\Models\College\Subject;
use App\Models\College\TimeTableModel;
use App\Models\CreateSectionModel;
use App\Models\StudentAttendanceModel;
use App\User;
use App\Models\College\Branch;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class MarkExamController extends Controller
{
    public $clg_wise_result = '';
    public $section_wise_result = '';
    public $branch_wise_result = '';

    public function store_exam_marks(Request $request)
    {

        $user = Auth::user();
        $exam_mark = MarkExamModel::where('me_exam_id', $request->exam_id)->where('me_subject_id', $request->subject)
            ->where('me_class_id', $request->class_id)->where('me_section_id', $request->cs_id)->where('me_ng_id', $request->ng_id)->first();//firstOrNew($attributes);
            if(empty($exam_mark))
            {
                $exam_mark = new MarkExamModel;
            }
            $obtainMarksArray = $request->obtain_marks;
            $perArray = $request->per;
            $gradeArray = $request->grade;
            $students = $request->student_id;
//            $exam_mark = new MarkExamModel();
            $exam_mark->me_clg_id = $user->user_clg_id;
            $exam_mark->me_branch_id = Session::get('branch_id');
            $exam_mark->me_subject_id = $request->subject;
            $exam_mark->me_exam_id = $request->exam_id;
            $exam_mark->me_class_id = $request->class_id;
            $exam_mark->me_ng_id = $request->ng_id;
            $exam_mark->me_section_id = $request->cs_id;
            $exam_mark->me_passing_marks = $request->passing_marks;
            $exam_mark->me_total_marks = $request->total_marks;
            $exam_mark->me_students = json_encode($students);
            $exam_mark->me_obtain_marks = json_encode($obtainMarksArray);
            $exam_mark->me_precentage = json_encode($perArray);
            $exam_mark->me_grade = json_encode($gradeArray);
            $exam_mark->me_created_by = $user->user_id;
            $exam_mark->me_browser_info = $this->getBrwsrInfo();
            $exam_mark->me_ip_address = $this->getIp();
            $exam_mark->me_year_id = $this->getYearEndId();
            $exam_mark->save();
            Session::put(['class_id' => $request->class_id, 'cs_id' => $request->cs_id, 'ng_id' => $request->ng_id, 'exam_id' => $request->exam_id]);
            return redirect()->route('group_subject_list')->with('success', 'Successfully Saved');
//        }
    }

    public function class_result(Request $request, $array = null, $str = null)
    {
        // dd($request->all());
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search_class = (!isset($request->classs_id) && empty($request->classs_id)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->classs_id;
        $search_group = (!isset($request->group_id) && empty($request->group_id)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->group_id;
        $search_section = (!isset($request->section_id) && empty($request->section_id)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section_id;
        $search_exam = (!isset($request->exm_id) && empty($request->exm_id)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->exm_id;
        $search_exm_name = (!isset($request->exm_name) && empty($request->exm_name)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->exm_name;
        $prnt_page_dir = 'print.college.mark_report.result';
        $pge_title = 'Result';
        $srch_fltr = [];
        // array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 100000000 : 100000000;
        // if (empty($request->classs_id)) {
        //     return redirect()->route('exam_list');
        // }
        $class = Classes::where('class_clg_id', $user->user_clg_id)->where('class_id', $search_class)->pluck('class_name')->first();
        $group = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)->where('ng_id', $search_group)->pluck('ng_name')->first();
        $section = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_id', $search_section)->pluck('cs_name')->first();
        $teachers = DB::table('class_timetable')
            ->where('tm_section_id', $search_section)
            ->where('tm_disable_enable', 1)
            ->leftJoin('class_timetable_item as ct_items', 'ct_items.tmi_tm_id', '=', 'class_timetable.tm_id')
            ->where('tmi_branch_id', Session::get('branch_id'))
            ->leftJoin('financials_users as user', 'user.user_id', '=', 'ct_items.tmi_teacher_id')
            ->select('user.user_name', 'ct_items.tmi_subject_id') // Corrected alias
            ->groupBy('ct_items.tmi_teacher_id', 'user.user_name', 'ct_items.tmi_subject_id') // Grouping corrected
            ->get();
        $class_marks = MarkExamModel::where('me_clg_id', $user->user_clg_id)
            ->where('me_exam_id', $search_exam)
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'marks_exam.me_subject_id')
            ->where('me_class_id', $search_class)
            ->where('me_section_id', $search_section)
            ->where('me_ng_id', $search_group)->get();
        $subjects = GroupItems::where('grpi_class_id', $search_class)
            ->where('grpi_section_id', $search_section)
            ->where('grpi_gn_id', $search_group)
            ->leftjoin('subjects', 'subjects.subject_id', '=', 'group_items.grpi_subject_id')
            ->groupBy('grpi_subject_id')
            ->select('subjects.subject_id', 'subjects.subject_name')
            ->get();
//        dd($teachers,$subjects);
        $students = Student::where('clg_id', $user->user_clg_id)
            ->where('class_id', $search_class)
            ->where('section_id', $search_section)
            ->where('status', '!=', 3)
            ->where('group_id', $search_group)->orderBy('roll_no', 'ASC')->get();
        // dd($students);

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
            $pdf->loadView($prnt_page_dir, compact('section', 'teachers','search_exm_name', 'class_marks', 'subjects', 'students', 'class', 'group', 'type', 'pge_title'));
            // $pdf->setOptions($options);
            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($section, $class_marks,$subjects, $students, $class, $group, $srch_fltr, $type, $prnt_page_dir, $pge_title,), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.exam.exam_result', compact('class_marks', 'subjects', 'teachers','class', 'group', 'section', 'request', 'students'));
        }
    }

    public function result_sheet(Request $request)
    {
        $exam_id = $request->ex_id;
        $class_id = $request->clas_id;
        $section_id = $request->sect_id;
        $group_id = $request->gro_id;
        $branch_id = Session::get('branch_id');
        $user = Auth::user();

        $ar = json_decode($request->array);
        $prnt_page_dir = 'print.college.mark_report.print_result';
        $pge_title = 'Student Result';
        $srch_fltr = [];
        $class = Classes::where('class_clg_id', $user->user_clg_id)->where('class_id', $class_id)->pluck('class_name')->first();
        $group = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)->where('ng_id', $group_id)->pluck('ng_name')->first();
        $section = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_id', $section_id)->pluck('cs_name')->first();


        $exam_ids = MarkExamModel::where('me_clg_id', $user->user_clg_id)->where('me_class_id', $class_id)
            ->where('me_section_id', $section_id)
            ->where('me_ng_id', $group_id)
            ->where('me_exam_id', '<=', $exam_id)
            ->groupBy('me_exam_id')
            ->orderBy('me_exam_id', 'desc')
            ->take(3)
            ->pluck('me_exam_id');
        $exams_names = ExamModel::whereIn('exam_id', $exam_ids)->orderBy('exam_id', 'DESC')->get();

        $branch = Branch::where('branch_clg_id', $user->user_clg_id)->where('branch_id', $branch_id)->pluck('branch_name')->first();
        $class_marks = MarkExamModel::where('me_clg_id', $user->user_clg_id)
            ->whereIn('me_exam_id', $exam_ids)
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'marks_exam.me_subject_id')
            ->where('me_class_id', $class_id)
            ->where('me_section_id', $section_id)
            ->where('me_ng_id', $group_id)->orderBy('me_exam_id', 'desc')->get();


        $subject_marks = MarkExamModel::where('me_clg_id', $user->user_clg_id)
            ->whereIn('me_exam_id', $exam_ids)
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'marks_exam.me_subject_id')
            ->where('me_class_id', $class_id)
            ->where('me_section_id', $section_id)
            ->where('me_ng_id', $group_id)->orderBy('me_exam_id', 'desc')->groupBy('me_subject_id')->get();
        // dd($class_marks);
        $subjects = GroupItems::where('grpi_class_id', $class_id)
            ->where('grpi_section_id', $section_id)
            ->where('grpi_gn_id', $group_id)
            ->leftjoin('subjects', 'subjects.subject_id', '=', 'group_items.grpi_subject_id')
            ->groupBy('grpi_subject_id')
            ->select('subjects.subject_id', 'subjects.subject_name')
            ->get();
        $students = Student::where('clg_id', $user->user_clg_id)
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->where('status', '!=', 3)
            ->where('group_id', $group_id)->get();
        // $section_result = $this->section_wise_result($exam_id, $class_id, $section_id, $group_id, $user->user_clg_id);
        // $branch_result = $this->branch_wise_result($exam_id, $class_id, $group_id, $user->user_clg_id, $branch_id);
        $branch_result0 = [];
        $section_result0 = [];
        $college_result1 = '';
        $branch_result1 = [];
        $section_result1 = [];
        $college_result2 = '';
        $branch_result2 = [];
        $section_result2 = [];
        foreach ($exam_ids as $index => $exam_id) {
            ${'college_result' . $index} = $this->college_wise_result($exam_id, $class_id, $group_id, $user->user_clg_id);
            foreach (${'college_result' . $index} as $result) {
                $filteredData = Arr::only($result, ['branch_id']);
                $foundItem = $filteredData['branch_id'] == $branch_id ? $result : null;

                $filteredSection = Arr::only($result, ['section_id']);
                $sectionItem = $filteredSection['section_id'] == $section_id ? $result : null;

                // Check if $foundItem is set before using it
//                if ($foundItem) {
//                    ${'branch_result' . $index}[] = [
//                        "id" => $result['id'],
//                        "obtain" => $result['obtain'],
//                        "total_marks" => $result['total_marks'],
//                        "per" => $result['per'],
//                        "branch_id" => $result['branch_id'],
//                        "section_id" => $result['section_id'],
//                        "group_id" => $result['group_id'],
//                    ];
//                }

                // Check if $sectionItem is set before using it
                if ($sectionItem) {
                    ${'section_result' . $index}[] = [
                        "id" => $result['id'],
                        "obtain" => $result['obtain'],
                        "total_marks" => $result['total_marks'],
                        "per" => $result['per'],
                        "branch_id" => $result['branch_id'],
                        "section_id" => $result['section_id'],
                        "group_id" => $result['group_id'],
                    ];
                }
            }
        }
        $subject_teachers = $this->get_subjects_teacher($section_id);
        $attendances = $this->attendance_calculation($class_id, $section_id, $students);
        $clg0_positions = json_encode($college_result0);
        $clg1_positions = json_encode($college_result1);
        $clg2_positions = json_encode($college_result2);
        $bra0_positions = json_encode($branch_result0);
        $bra1_positions = json_encode($branch_result1);
        $bra2_positions = json_encode($branch_result2);
        $sec0_positions = json_encode($section_result0);
        $sec1_positions = json_encode($section_result1);
        $sec2_positions = json_encode($section_result2);
        $teachers = json_encode($subject_teachers);

        return view('collegeViews.exam.exam_sheet', compact(
            'class',
            'group',
            'section',
            'students',
            'request',
            'class_marks',
            'subjects',
            'branch',
            'teachers',
            'attendances',
            'clg0_positions',
            'clg1_positions',
            'clg2_positions',
            'bra0_positions',
            'bra1_positions',
            'bra2_positions',
            'sec0_positions',
            'sec1_positions',
            'sec2_positions',
            'exams_names',
            'subject_marks'
        ));
    }

    public function section_result(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $sections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_branch_id', Session::get('branch_id'))->get();
        $exams = ExamModel::where('exam_clg_id', $user->user_clg_id)->get();
        $ar = json_decode($request->array);
        $search_class = (!isset($request->classs_id) && empty($request->classs_id)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->classs_id;
        $search_group = (!isset($request->group_id) && empty($request->group_id)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->group_id;
        $search_section = (!isset($request->section_id) && empty($request->section_id)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section_id;
        $search_exam = (!isset($request->exm_id) && empty($request->exm_id)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->exm_id;
        $search_exm_name = (!isset($request->exm_name) && empty($request->exm_name)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->exm_name;
        $prnt_page_dir = 'print.college.mark_report.result';
        $pge_title = 'Result';
        $srch_fltr = [];
        $array = array();
        // array_push($srch_fltr, $search);


        $search_exam = 2;
        $search_section = 1538;
        $pagination_number = (empty($ar)) ? 100000000 : 100000000;

        $class = Classes::where('class_clg_id', $user->user_clg_id)->where('class_id', $search_class)->pluck('class_name')->first();
        $group = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)->where('ng_id', $search_group)->pluck('ng_name')->first();
        $section = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_id', $search_section)->pluck('cs_name')->first();
        $class_marks = MarkExamModel::where('me_clg_id', $user->user_clg_id)
            ->where('me_exam_id', $search_exam)
            //            ->where('me_class_id', $search_class)
            ->where('me_section_id', $search_section)
            //            ->where('me_ng_id', $search_group)
            ->get();
        $subjects = GroupItems::
        //where('grpi_class_id', $search_class)
        where('grpi_section_id', $search_section)
            //            ->where('grpi_gn_id', $search_group)
            ->leftjoin('subjects', 'subjects.subject_id', '=', 'group_items.grpi_subject_id')
            ->groupBy('grpi_subject_id')
            ->select('subjects.subject_id', 'subjects.subject_name')
            ->get();
        $students = Student::where('clg_id', $user->user_clg_id)
            //            ->where('class_id', $search_class)
            ->where('section_id', $search_section)
            //            ->where('group_id', $search_group)
            ->orderBy('roll_no', 'ASC')->get();
        $count = 0;
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

                    foreach ($subjects as $subject) {
                        if ($subject->subject_id == $class_mark->me_subject_id) {
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
                }
            }
            $count++;
            $formated = 0;
            $color = '';
            $color_name = '';
            if ($obtained_marks > 0) {
                $percentage = ($obtained_marks * 100) / $total_marks;
            } else {
                $percentage = 0;
            }

            $color_name = '';
            $color = '';

            $formated = sprintf('%0.2f', $percentage);
            if ($percentage <= 50) {
                $color_name = 'bg-danger';
                $color = 'Red';
            } elseif ($percentage > 50 && $percentage <= 65) {
                $color_name = 'bg-purple';
                $color = 'Purple';
            } elseif ($percentage > 65 && $percentage <= 75) {
                $color_name = 'bg-primary';
                $color = 'Blue';
            } elseif ($percentage > 75 && $percentage <= 85) {
                $color_name = 'bg-warning';
                $color = 'Yellow';
            } elseif ($percentage > 85 && $percentage <= 100) {
                $color_name = 'bg-success';
                $color = 'Green';
            }

            $array[$count] = array('id' => $student->id, 'reg_no' => $student->registration_no, 'roll_no' => $student->roll_no, 'name' => $student->full_name, 'father_name' =>
                $student->father_name, 'total_marks' => $total_marks, 'obtain_marks' => $obtained_marks, 'per' => $formated);
        }
        $people = collect($array);
        $sortedPosition = $people->sortByDesc('per');

        return view('collegeViews.exam.section_wise_position', compact('class_marks', 'subjects', 'class', 'group', 'section', 'sections', 'request', 'students', 'sortedPosition', 'search_section', 'exams', 'search_exam'));
    }

    public function college_wise_result($exam_id, $class_id, $group_id, $college_id)
    {
        $search_exam = $exam_id;
        $search_class = $class_id;
        $search_group = $group_id;
        $class_marks = MarkExamModel::where('me_clg_id', $college_id)
            ->where('me_exam_id', $search_exam)
            ->where('me_class_id', $search_class)
            ->where('me_ng_id', $search_group)
            ->get();

        $students = Student::where('clg_id', $college_id)
            ->where('class_id', $search_class)
            ->where('group_id', $search_group)
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
            $formated = 0;
            if ($obtained_marks > 0) {
                $percentage = ($obtained_marks * 100) / $total_marks;
            } else {
                $percentage = 0;
            }
            $formated = sprintf('%0.2f', $percentage);
            $array[$count] = array('id' => $student->id, 'obtain' => $obtained_marks, 'total_marks' => $total_marks, 'per' => $formated, 'branch_id' => $student->branch_id, 'section_id' =>
                $student->section_id, 'group_id' => $student->group_id);
        }
        $people = collect($array);
        $sortedPosition = $people->sortByDesc('per');

        return $sortedPosition;
    }


    public function branch_wise_sort($college_result, $branch_id, $group_id)
    {
        $filteredArray = [];

        foreach ($college_result as $result) {
            foreach ($result as $item) {
                if (isset($item['branch_id']) && $item['branch_id'] == $branch_id && $item['group_id'] == $group_id) {
                    $filteredArray[] = $item;
                }
            }
        }
        $people = collect($filteredArray);
        $sortedbranchPosition = $people->sortByDesc('per');
        // usort($filteredArray, function ($a, $b) {
        //     return $b['per'] <=> $a['per'];
        // });

        return $sortedbranchPosition;
    }

    public function section_wise_sort($college_result, $section_id, $group_id)
    {
        $filteredArray = [];

        foreach ($college_result as $result) {
            foreach ($result as $item) {
                if (isset($item['section_id']) && $item['section_id'] == $section_id && $item['group_id'] == $group_id) {
                    $filteredArray[] = $item;
                }
            }
        }

        $people = collect($filteredArray);
        $sortedsectionwise = $people->sortByDesc('per');

        return $sortedsectionwise;
    }

    public function get_subjects_teacher($section_id)
    {
        $user = Auth::user();

        $time_table = TimeTableModel::with('users')
            ->where('tm_college_id', $user->user_clg_id)
            ->leftJoin('classes', 'classes.class_id', '=', 'class_timetable.tm_class_id')
            ->where('class_clg_id', $user->user_clg_id)
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'class_timetable.tm_section_id')
            ->where('cs_clg_id', $user->user_clg_id)
            ->leftJoin('semesters', 'semesters.semester_id', '=', 'class_timetable.tm_semester_id')
            ->where('tm_college_id', $user->user_clg_id)
            ->where('tm_section_id', $section_id)
            ->select('class_timetable.*', 'classes.class_name', 'create_section.cs_name', 'semesters.semester_name')
            ->get();

        // Create an array to store the formatted data for all days
        $formattedData = [];
        $uniqueSubjects = [];
        $countSubject = 0;
        $formattedData = [];
        $uniqueTeachers = []; // Initialize an array to store unique teacher_ids

        // Loop through the $time_table collection and format the data
        foreach ($time_table as $row) {
            if (!is_null($row->tm_timetable)) {
                $tmTimetable = json_decode($row->tm_timetable, true);

                // Loop through the $tmTimetable and format the data for the current day
                foreach ($tmTimetable as $dayData) {
                    $day = $dayData['day'];
                    $items = $dayData['items'];

                    // Create an array to store the data for the current day
                    $dayRow = [
                        'teacher_name' => [],
                        'subject_name' => [],
                    ];

                    // Loop through the items for the current day and populate the dayRow array
                    foreach ($items as $key => $item) {
                        if (isset($item['teacher_id'])) {
                            // Fetch the teacher name directly from the users table based on teacher ID
                            if (!in_array($item['teacher_id'], $uniqueTeachers)) {
                                $uniqueTeachers[] = $item['teacher_id']; // Add to the unique teacher_ids array
                                $teacher = User::find($item['teacher_id']);
                                if ($teacher) {
                                    $dayRow['teacher_name'][$key] = $teacher->user_name;
                                }
                            }
                            // Fetch the subject name directly from the subjects table based on subject ID
                            $subject = Subject::find($item['subject_id']);
                            if ($subject) {
                                $dayRow['subject_name'][$key] = $subject->subject_name;
                                $dayRow['subject_id'][$key] = $subject->subject_id;
                            }
                        }
                    }

                    // Add the formatted data for the current day to the main formattedData array
                    $formattedData[] = $dayRow;
                }
            }
        }

        // $formattedData now contains the formatted data with unique teacher_ids

        return [$formattedData, $countSubject];
    }

    public function attendance_calculation($class_id, $section_id, $students)
    {
        // $attendances = StudentAttendanceModel::where('std_att_class_id', $class_id)->where('std_att_section_id', $section_id)->whereBetween('std_att_date', [Carbon::now()->subMonth(3), Carbon::now()])->get();
        $attendances = StudentAttendanceModel::where('std_att_class_id', $class_id)
            ->where('std_att_section_id', $section_id)
            ->whereBetween('std_att_date', [
                Carbon::now()->subMonth(4)->firstOfMonth(), // Start of the month 4 months ago
                Carbon::now()->subMonth(1)->lastOfMonth(),  // End of the last month
            ])
            ->get();
        $presents = [];

        foreach ($students as $student) {
            $monthlyCounts = []; // Initialize an array to store counts for each month

            foreach ($attendances as $items) {
                $att = json_decode($items->std_attendance, true);
                $monthName = date('M', strtotime($items->std_att_date));

                // Initialize count for the month if not set
                if (!isset($monthlyCounts[$monthName])) {
                    $monthlyCounts[$monthName] = 0;
                }

                foreach ($att as $attendance) {
                    if ($attendance['student_id'] == $student->id && $attendance['is_present'] == 'P') {
                        $monthlyCounts[$monthName]++;
                    }
                }
            }

            $presents[$student->id] = $monthlyCounts;
        }

        return $presents;
    }

    public function get_result(Request $request)
    {
        $std_id = $request->std_id;
        $results = MarkExamModel::where('me_class_id', $request->class_id)
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'marks_exam.me_subject_id')
            ->where('me_exam_id', $request->exam_id)
            ->where('me_section_id', $request->section_id)
            ->where('me_ng_id', $request->group_id)
            ->get();
        $final_result = [];
        foreach ($results as $result) {
            $marks = json_decode($result->me_obtain_marks, true);
            $students = json_decode($result->me_students, true);

            foreach ($students as $key => $student) {
                if ($std_id == $student) {
                    $obtained_marks = $marks[$key];
                    $total_marks = $result->me_total_marks;
                    $final_result[] = [
                        'subject_name' => $result->subject_name,
                        'obtain_marks' => $obtained_marks,
                        'total_marks' => $total_marks,
                    ];
                }
            }
        }
        return response()->json($final_result);
    }
}
