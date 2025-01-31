<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\AssignCoordinatorModel;
use App\Models\College\Classes;
use App\Models\College\ClassTimetableItem;
use App\Models\College\GroupItems;
use App\Models\College\MarkTeacherAttendanceModel;
use App\Models\College\Subject;
use App\Models\College\TimeTableModel;
use App\User;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

// farhad
class TimeTableController extends Controller
{
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = !isset($request->search) && empty($request->search) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = isset($request->search_by_user) && !empty($request->search_by_user) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.time_table_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = empty($ar) ? 30 : 100000000;

        $query = TimeTableModel::with('users')
            ->where('tm_college_id', $user->user_clg_id)
            ->leftJoin('classes', 'classes.class_id', '=', 'class_timetable.tm_class_id')
            ->where('class_clg_id', $user->user_clg_id)
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'class_timetable.tm_section_id')
            ->where('cs_clg_id', $user->user_clg_id)
            ->leftJoin('branches', 'branches.branch_id', '=', 'class_timetable.tm_branch_id')
            ->where('branch_clg_id', $user->user_clg_id)
            ->leftJoin('semesters', 'semesters.semester_id', '=', 'class_timetable.tm_semester_id')
            ->where('semester_clg_id', $user->user_clg_id)
            ->where('tm_branch_id', Session::get('branch_id'))
            ->select('class_timetable.*', 'classes.class_name', 'create_section.cs_name', 'branches.branch_name', 'semesters.semester_name');
        // ->get();
        // dd($query);

        if (!empty($search)) {
            $query->where('class_name', 'like', '%' . $search . '%')->orWhere('class_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('tm_createdby', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('tm_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('tm_year_id', '=', $search_year);
        }

        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('tm_delete_status', '=', 1);
        // } else {
        //     $query->where('tm_delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('tm_id', 'DESC')->paginate($pagination_number);
        // ->get();
        $class_title = TimeTableModel::with('users')
            ->where('tm_college_id', $user->user_clg_id)
            ->leftJoin('classes', 'classes.class_id', '=', 'class_timetable.tm_class_id')
            ->where('class_clg_id', $user->user_clg_id)
            ->where('tm_branch_id', Session::get('branch_id'))
            ->orderBy('class_id', config('global_variables.query_sorting'))
            ->pluck('class_name')
            ->all();
        // dd($class_title);
        // $tm_title = TimeTableModel::where('tm_clg_id', $user->user_clg_id)->orderBy('tm_id', config('global_variables.query_sorting'))->pluck('tm_name')->all(); //where('tm_delete_status', '!=', 1)->

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
            return view('collegeViews.TimeTable.list_timetable', compact('datas','search_year', 'search', 'search_by_user', 'restore_list', 'class_title'));
        }
    }

    public function create()
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

            // dd($allclasses);
        }else{
            $classes = Classes::where('class_clg_id', $user->user_clg_id)
                // ->where('class_type', 'Annual')
                ->get();
        }
        // $subjects = Subject::where('subject_clg_id', $user->user_clg_id)->get();
        return view('collegeViews.TimeTable.add_time_table', compact('classes'));
    }
    public function store(Request $request)
    {
//        dd($request->all()); // Remove this line when you are ready to proceed

        $user = Auth::user();
        $sectionId = $request->input('section_id');
        $numOfDays = $request->input('num_of_days');
        $classId = $request->input('class_id');
        $semesterId = $request->input('semester_id');

        // Check if a timetable with the same section_id already exists
        $existingTimetable = TimeTableModel::where('tm_section_id', $sectionId)
            ->where('tm_class_id', $classId)
            ->where('tm_semester_id', $semesterId)
            ->where('tm_branch_id', Session::get('branch_id'))
            ->where('tm_college_id', $user->user_clg_id)
            ->first();

        if ($existingTimetable) {
            return redirect()->route('add_time_table')->with('success', 'Timetable for this section & Semester already exists.');
        }

        DB::transaction(function () use ($request, $user, $numOfDays, $classId, $sectionId, $semesterId) {
            $time_table_array = [];
            $requested_arrays = is_array($request->end_time) ? $request->end_time : [];

            // Define days of the week
            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            // Get the starting day from the request
            $startingDay = $request->input('starting_days');
            $startIndex = array_search($startingDay, $daysOfWeek);

            // Reorder daysOfWeek to start from the selected starting day
            if ($startIndex !== false) {
                $daysOfWeek = array_merge(array_slice($daysOfWeek, $startIndex), array_slice($daysOfWeek, 0, $startIndex));
            }

            $records = [];
            for ($dayIndex = 0; $dayIndex < $numOfDays; $dayIndex++) {
                $currentDay = $daysOfWeek[$dayIndex];
                $dayData = [
                    'day' => $currentDay,
                    'items' => [],
                ];

                if (isset($requested_arrays[$dayIndex]) && is_array($requested_arrays[$dayIndex])) {
                    foreach ($requested_arrays[$dayIndex] as $index => $requested_array) {
                        $start_time = $request->start_time[$dayIndex][$index] ?? null;
                        $end_time = $request->end_time[$dayIndex][$index] ?? null;
                        $teacher_id = $request->teacher_id[$dayIndex][$index] ?? null;
                        $subject_id = $request->subject_id[$dayIndex][$index] ?? null;

                        // Check if data for the current day is empty
                        if (empty($start_time)) {
                            // Use data from Monday as a fallback
                            $start_time = $request->start_time[0][$index] ?? null;
                            $end_time = $request->end_time[0][$index] ?? null;
                            $teacher_id = $request->teacher_id[0][$index] ?? null;
                            $subject_id = $request->subject_id[0][$index] ?? null;
                        }

                        $item = [
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                            'teacher_id' => $teacher_id,
                            'subject_id' => $subject_id,
                        ];

                        $dayData['items'][] = $item;
                    }
                }

                // Add dayData to $time_table_array
                $time_table_array[] = $dayData;
            }

            $time_table_json = json_encode($time_table_array);

            $wef = date('Y-m-d', strtotime($request->wef));
            $semester_start_date = date('Y-m-d', strtotime($request->semester_start_date));

            // Save $time_table_json to the TimeTableModel
            $time_table = new TimeTableModel();
            $time_table->tm_college_id = $user->user_clg_id;
            $time_table->tm_branch_id = Session::get('branch_id');
            $time_table->tm_class_id = $classId;
            $time_table->tm_section_id = $sectionId;
            $time_table->tm_semester_id = $semesterId;
            $time_table->tm_wef = $wef;
            $time_table->semester_start_date = $semester_start_date;
            $time_table->tm_break_start_time = $request->break_start_time;
            $time_table->tm_break_end_time = $request->break_end_time;
            $time_table->tm_timetable = $time_table_json;
            $time_table->tm_created_by = $user->user_id;
            $time_table->tm_browser_info = $this->getBrwsrInfo();
            $time_table->tm_ip_address = $this->getIp();
            $time_table->tm_year_id = $this->getYearEndId();
            $time_table->save();

            for ($dayIndex = 0; $dayIndex < $numOfDays; $dayIndex++) {
                $currentDay = $daysOfWeek[$dayIndex];
                $dayData = [
                    'day' => $currentDay,
                    'items' => [],
                ];

                if (isset($requested_arrays[$dayIndex]) && is_array($requested_arrays[$dayIndex])) {
                    foreach ($requested_arrays[$dayIndex] as $index => $requested_array) {
                        $start_time = $request->start_time[$dayIndex][$index] ?? null;
                        $end_time = $request->end_time[$dayIndex][$index] ?? null;
                        $teacher_id = $request->teacher_id[$dayIndex][$index] ?? null;
                        $subject_id = $request->subject_id[$dayIndex][$index] ?? null;

                        // Check if data for the current day is empty
                        if (empty($start_time)) {
                            // Use data from Monday as a fallback
                            $start_time = $request->start_time[0][$index] ?? null;
                            $end_time = $request->end_time[0][$index] ?? null;
                            $teacher_id = $request->teacher_id[0][$index] ?? null;
                            $subject_id = $request->subject_id[0][$index] ?? null;
                        }

                        $item = [
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                            'teacher_id' => $teacher_id,
                            'subject_id' => $subject_id,
                        ];

                        $dayData['items'][] = $item;
                    }
                }

                // Add dayData to $time_table_array
                $time_table_array[] = $dayData;

                // Prepare records for insertion into class_timetable_item
                foreach ($dayData['items'] as $item) {
                    $time_table_item = new ClassTimetableItem();
                    $time_table_item->tmi_college_id = $user->user_clg_id;
                    $time_table_item->tmi_branch_id = Session::get('branch_id');
                    $time_table_item->tmi_tm_id = $time_table->tm_id;
                    $time_table_item->tmi_section_id = $sectionId;
                    $time_table_item->tmi_teacher_id = $item['teacher_id'];
                    $time_table_item->tmi_subject_id = $item['subject_id'];
                    $time_table_item->tmi_day = $currentDay;
                    $time_table_item->tmi_start_time = $item['start_time'];
                    $time_table_item->tmi_end_time = $item['end_time'];
                    $time_table_item->save();
//                    $records[] = [
//                        'tmi_section_id' => $sectionId,
//                        'tmi_teacher_id' => $item['teacher_id'],
//                        'tmi_subject_id' => $item['subject_id'],
//                        'tmi_day' => $currentDay,
//                        'tmi_start_time' => $item['start_time'],
//                        'tmi_end_time' => $item['end_time'],
//                    ];
                }
            }
            // Insert records into class_timetable_item
//            ClassTimetableItem::insert($records);
        });

        return redirect()->route('time_table_list')->with('success', 'Saved Successfully!');
    }

//    public function store(Request $request)
//    {
//        dd($request->all());
//        $user = Auth::user();
//        $sectionId = $request->input('section_id');
//        $numOfDays = $request->input('num_of_days');
//        $classId = $request->input('class_id');
//        $SemesterId = $request->input('semester_id');
//        // Check if a timetable with the same section_id already exists
//        $existingTimetable = TimeTableModel::where('tm_section_id', $sectionId)
//            ->where('tm_class_id', $classId)
//            ->where('tm_semester_id', $SemesterId)
//            ->where('tm_branch_id', Session::get('branch_id'))
//            ->where('tm_college_id', $user->user_clg_id)
//            ->first();
//
//
//
//        if ($existingTimetable) {
//            return redirect()->route('add_time_table')->with('success', 'Timetable for this section & Semester already exists.');
//        }
//        DB::transaction(function () use ($request, $user, $numOfDays, $classId) {
//            $time_table_array = [];
//            $requested_arrays = is_array($request->end_time) ? $request->end_time : [];
//
//            // Initialize an array to store the days of the week
//            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
//
//            // Get the starting day from the request
//            $startingDay = $request->input('starting_days');
//            $startIndex = array_search($startingDay, $daysOfWeek);
//
//            // Reorder daysOfWeek to start from the selected starting day
//            if ($startIndex !== false) {
//                $daysOfWeek = array_merge(array_slice($daysOfWeek, $startIndex), array_slice($daysOfWeek, 0, $startIndex));
//            }
//
//            for ($dayIndex = 0; $dayIndex < $numOfDays; $dayIndex++) {
//                $requestedDay = $daysOfWeek[$dayIndex];
//                $dayData = [
//                    'day' => $requestedDay,
//                    'items' => [],
//                ];
//                $dayIndex = array_search($requestedDay, $daysOfWeek);
//
//                if ($dayIndex !== false && isset($requested_arrays[$dayIndex]) && is_array($requested_arrays[$dayIndex])) {
//                    foreach ($requested_arrays[$dayIndex] as $index => $requested_array) {
//                        $start_time = $request->start_time[$dayIndex][$index] ?? null;
//                        $end_time = $request->end_time[$dayIndex][$index] ?? null;
//                        $teacher_id = $request->teacher_id[$dayIndex][$index] ?? null;
//                        $subject_id = $request->subject_id[$dayIndex][$index] ?? null;
//
//                        // Check if data for the current day is empty
//                        if (empty($start_time)) {
//                            // Use data from Monday as a fallback
//                            $start_time = $request->start_time[0][$index] ?? null;
//                            $end_time = $request->end_time[0][$index] ?? null;
//                            $teacher_id = $request->teacher_id[0][$index] ?? null;
//                            $subject_id = $request->subject_id[0][$index] ?? null;
//                        }
//
//                        $item = [
//                            'start_time' => $start_time,
//                            'end_time' => $end_time,
//                            'teacher_id' => $teacher_id,
//                            'subject_id' => $subject_id,
//                        ];
//
//                        $dayData['items'][] = $item;
//                    }
//                }
//
//                // Add dayData to $time_table_array
//                $time_table_array[] = $dayData;
//            }
//
//            $time_table_json = json_encode($time_table_array);
//            // dd($time_table_array);
//
//            $wef = date('Y-m-d', strtotime($request->wef));
//            $semester_start_date = date('Y-m-d', strtotime($request->semester_start_date));
//
//            // Save $time_table_json to the database or perform other operations
//
//            $time_table = new TimeTableModel();
//            $time_table->tm_college_id = $user->user_clg_id;
//            $time_table->tm_branch_id = Session::get('branch_id');
//            $time_table->tm_class_id = $classId;
//            $time_table->tm_section_id = $request->input('section_id');
//            $time_table->tm_semester_id = $request->input('semester_id');
//            $time_table->tm_wef = $wef;
//            $time_table->semester_start_date = $semester_start_date;
//            $time_table->tm_break_start_time = $request->break_start_time;
//            $time_table->tm_break_end_time = $request->break_end_time;
//            $time_table->tm_timetable = $time_table_json;
//            $time_table->tm_created_by = $user->user_id;
//            $time_table->tm_browser_info = $this->getBrwsrInfo();
//            $time_table->tm_ip_address = $this->getIp();
//            $time_table->tm_year_id = $this->getYearEndId();
//            $time_table->save();
//        });
//
//        return redirect()->route('time_table_list')->with('success', 'Saved Successfully!');
//    }

    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $user = Auth::user();
    //     $sectionId = $request->input('section_id');
    //     $num_days = $request->input('num_of_days');
    //     // Check if a timetable with the same section_id already exists
    //     // $existingTimetable = TimeTableModel::where('tm_section_id', $sectionId)
    //     // ->where('tm_branch_id',Session::get('branch_id'))
    //     // ->where('tm_college_id',$user->user_clg_id)
    //     // ->first();

    //     // if ($existingTimetable) {
    //     //     return redirect()
    //     //     ->route('add_time_table')
    //     //     ->with('success', 'Timetable for this section already exists.');
    //     // }
    //     DB::transaction(function () use ($request, $user,$num_days) {
    //         $time_table_array = [];
    //         $time_table_arrays = [];
    //         $classId = $request->input('class_id');
    //         $requested_arrays = is_array($request->end_time) ? $request->end_time : [];
    //         $day_request = $request->day;
    //         foreach ($day_request as $i => $requested_array) {
    //             $day = $request->day[$i];
    //             $dayData = [
    //                 'day' => $day,
    //                 'items' => [],
    //             ];

    //             if (isset($requested_arrays[$i]) && is_array($requested_arrays[$i])) {
    //                 $hasNonNullEntry = false; // Flag to check if there's at least one non-null entry

    //                 foreach ($requested_arrays[$i] as $index => $requested_array) {
    //                     $start_time = $request->start_time[$i][$index] ?? null;
    //                     $end_time = $request->end_time[$i][$index] ?? null;
    //                     $teacher_id = $request->teacher_id[$i][$index] ?? null;
    //                     $subject_id = $request->subject_id[$i][$index] ?? null;

    //                     // Check if there's at least one non-null entry
    //                     if ($start_time !== null || $end_time !== null || $teacher_id !== null || $subject_id !== null) {
    //                         $hasNonNullEntry = true;
    //                     }

    //                     $item = [
    //                         'start_time' => $start_time,
    //                         'end_time' => $end_time,
    //                         'teacher_id' => $teacher_id,
    //                         'subject_id' => $subject_id,
    //                     ];

    //                     $dayData['items'][] = $item;
    //                 }

    //                 // Add dayData to $time_table_array only if it has at least one non-null entry
    //                 if ($hasNonNullEntry) {
    //                     $time_table_array[] = $dayData;
    //                 }
    //             }
    //         }

    //         for($i=1; $i<4; $i++){
    //             $time_table_arrays+=$time_table_array ;
    //         }

    //         $time_table_json = json_encode($time_table_array);
    //         dd($time_table_array,$time_table_json,$time_table_arrays);
    //         $wef = date('Y-m-d', strtotime($request->wef));
    //         // Save $time_table_json to the database or perform other operations

    //         $time_table = new TimeTableModel();
    //         $time_table->tm_college_id = $user->user_clg_id;
    //         $time_table->tm_branch_id = Session::get('branch_id');
    //         $time_table->tm_class_id = $classId;
    //         $time_table->tm_section_id = $request->input('section_id');
    //         $time_table->tm_semester_id = $request->input('semester_id');
    //         $time_table->tm_wef = $wef;
    //         $time_table->tm_break_start_time = $request->break_start_time;
    //         $time_table->tm_break_end_time = $request->break_end_time;
    //         $time_table->tm_timetable = $time_table_json;
    //         $time_table->tm_created_by = $user->user_id;
    //         $time_table->tm_browser_info = $this->getBrwsrInfo();
    //         $time_table->tm_ip_address = $this->getIp();
    //         $time_table->save();
    //     });
    //     return redirect()
    //         ->route('time_table_list')
    //         ->with('success', 'Saved Successfully!');
    // }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $date = Carbon::now();
        $branch_id = Session::get('branch_id');
        $branch_ids = [$branch_id];

        // Retrieve all teachers in department 4
        $teachers = User::where('user_department_id', 4)
            ->where('user_disabled', 0)
            ->whereIn('user_branch_id', $branch_ids)
            ->get();

        $time_table = TimeTableModel::with('users')
            ->where('tm_college_id', $user->user_clg_id)
            ->where('tm_id', $request->tm_id)
            ->select('class_timetable.*')
            ->get();
//        dd($time_table);
        $formattedData = [];
        $teacherDetails = [];
        $addedTeacherIds = []; // To keep track of added teacher IDs

        foreach ($time_table as $row) {
            if (!is_null($row->tm_timetable)) {
                $tmTimetable = json_decode($row->tm_timetable, true);

                foreach ($tmTimetable as $dayData) {
                    $day = $dayData['day'];
                    $items = $dayData['items'];

                    foreach ($items as $key => $item) {
                        if (isset($item['teacher_id']) && !in_array($item['teacher_id'], $addedTeacherIds)) {
                            $teacher = User::find($item['teacher_id']);
                            if ($teacher) {
                                $teacherDetails[] = [
                                    'teacher_id' => $item['teacher_id'],
                                    'teacher_name' => $teacher->user_name,
                                ];
                                $addedTeacherIds[] = $item['teacher_id']; // Add teacher ID to the set
                            }
                        }
                    }
                }
            }
        }

        // Extract teacher IDs
        $teacherIds = array_column($teacherDetails, 'teacher_id');

        //Date range for the past 40 days

        $endDate = Carbon::now()->endOfDay();
        // Date range for the past 40 days
        $endDate = Carbon::now()->endOfDay();
// Fetch the semester start date
        $semesterStartDate = '';
        $startDate = '';
        $daysDifference = 0;

        if (!$time_table->isEmpty()) {
            // Assuming you are only interested in the first item
            $firstItem = $time_table->first();
            $semesterStartDate = Carbon::createFromFormat('Y-m-d', $firstItem->semester_start_date)->startOfDay();
            $currentDate = Carbon::now()->startOfDay();

            // Calculate the difference in days from now to the semester start date
            $daysDifference = $currentDate->diffInDays($semesterStartDate);
        }

        if ($daysDifference > 40) {
            $startDate = Carbon::now()->subDays(40)->startOfDay();
        } else {
            $startDate = $semesterStartDate;
        }

//        dd($semesterStartDate, $daysDifference, $endDate, $startDate);
//
//// Date range for the past 40 days or until the semester start date, whichever is earlier
//        $startDate = Carbon::now()->subDays(40)->startOfDay();
//        if ($semesterStartDate->gt(Carbon::now()->addDays(40))) {
//            $startDate = $semesterStartDate->copy()->subDays(40);
//        }
//        $endDate = $semesterStartDate->gt(Carbon::now()->endOfDay()) ? $semesterStartDate : Carbon::now()->endOfDay();


        // Fetch attendance records for the specified date range and teacher IDs
        $attendanceRecords = MarkTeacherAttendanceModel::whereBetween('la_date', [$startDate, $endDate])
            ->where('la_department_id', 4)
            ->where('la_clg_id', $user->user_clg_id)
            ->where('la_branch_id', $branch_id)
            ->whereIn('la_emp_id', $teacherIds)
            ->get();
//        dd($attendanceRecords, $teacherDetails, $branch_id, $teacherIds, $startDate, $endDate);
        // Convert la_date to Carbon instances
        $attendanceRecords->transform(function ($record) {
            $record->la_date = Carbon::parse($record->la_date);
            return $record;
        });

        // Create a set of all dates within the date range
        $dateRange = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dateRange[] = $date->toDateString();
        }

        // Check if all required dates for all teachers are present in the attendance records
        $allDatesPresent = true;
        foreach ($teacherIds as $teacherId) {
            foreach ($dateRange as $date) {
                $attendanceExists = $attendanceRecords->contains(function ($record) use ($date, $teacherId) {
                    return $record->la_date->toDateString() == $date && $record->la_emp_id == $teacherId;
                });

                if (!$attendanceExists) {
                    $allDatesPresent = false;
                    break 2;
                }
            }
        }
        // Check if the collection is not empty
        if (!$time_table->isEmpty()) {
            // Assuming you are only interested in the first item
            $firstItem = $time_table->first();

            if ($firstItem->checks == 1) {
                $allDatesPresent = true;
            }
        }
//        dd($allDatesPresent);
        if ($allDatesPresent) {
            $classes = Classes::where('class_clg_id', $user->user_clg_id)
                ->where('class_id', $request->class_id)
                ->first();

            $sections = DB::table('sections')
                ->where('section_clg_id', $user->user_clg_id)
                ->where('section_name', $request->section_id)
                ->leftJoin('create_section', 'create_section.cs_id', '=', 'sections.section_name')
                ->where('section_branch_id', $branch_id)
                ->select('sections.section_id', 'create_section.cs_name', 'create_section.cs_id')
                ->groupBy('cs_id')
                ->first();

            $semesters = TimeTableModel::where('tm_college_id', $user->user_clg_id)
                ->where('tm_class_id', $request->class_id)
                ->where('tm_semester_id', $request->semester_id)
                ->leftJoin('semesters', 'semesters.semester_id', '=', 'class_timetable.tm_semester_id')
                ->select('semesters.semester_name', 'semesters.semester_id')
                ->first();

            $subjects = GroupItems::where('grpi_class_id', $request->class_id)
                ->where('grpi_section_id', $request->section_id)
                ->where('grpi_semester_id', $request->semester_id)
                ->leftjoin('subjects', 'subjects.subject_id', '=', 'group_items.grpi_subject_id')
                ->groupBy('grpi_subject_id')
                ->select('subjects.subject_id', 'subjects.subject_name')
                ->get();

            $time_table = TimeTableModel::with('users')
                ->where('tm_college_id', $user->user_clg_id)
                ->where('tm_id', $request->tm_id)
                ->get();

            return view('collegeViews.TimeTable.edit_time_table', compact('request', 'classes', 'sections', 'subjects', 'time_table', 'semesters'));
        } else {
            return redirect()->route('time_table_list')->with('success', 'Mark Attendance for All Teachers Before Editing');
        }
    }


    public function update(Request $request)
    {
        // Uncomment the dd line if you need to debug the request data
        // dd($request->all());

        $user = Auth::user();
        $classId = $request->input('class_id');
        $sectionId = $request->input('section_id');
        $semesterId = $request->input('semester_id');
        $wef = date('Y-m-d', strtotime($request->wef));

        DB::transaction(function () use ($request, $user, $classId, $sectionId, $semesterId, $wef) {
            // Prepare time table data
            $time_table_array = [];
            $requested_arrays = is_array($request->end_time) ? $request->end_time : [];
            $day_request = $request->day;

            // Process each day in the request
            foreach ($day_request as $i => $day) {
                $dayData = [
                    'day' => $day,
                    'items' => [],
                ];

                if (isset($requested_arrays[$i]) && is_array($requested_arrays[$i])) {
                    $hasNonNullEntry = false; // Flag to check if there's at least one non-null entry

                    foreach ($requested_arrays[$i] as $index => $requested_array) {
                        $start_time = $request->start_time[$i][$index] ?? null;
                        $end_time = $request->end_time[$i][$index] ?? null;
                        $teacher_id = $request->teacher_id[$i][$index] ?? null;
                        $subject_id = $request->subject_id[$i][$index] ?? null;

                        // Check if there's at least one non-null entry
                        if ($start_time !== null || $end_time !== null || $teacher_id !== null || $subject_id !== null) {
                            $hasNonNullEntry = true;
                        }

                        $item = [
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                            'teacher_id' => $teacher_id,
                            'subject_id' => $subject_id,
                        ];

                        $dayData['items'][] = $item;
                    }

                    // Add dayData to $time_table_array only if it has at least one non-null entry
                    if ($hasNonNullEntry) {
                        $time_table_array[] = $dayData;
                    }
                }
            }

            $time_table_json = json_encode($time_table_array);

            // Update the existing timetable record
            $time_table = TimeTableModel::find($request->tm_id);
            $time_table->tm_college_id = $user->user_clg_id;
            $time_table->tm_branch_id = Session::get('branch_id');
            $time_table->tm_class_id = $classId;
            $time_table->tm_section_id = $sectionId;
            $time_table->tm_semester_id = $semesterId;
            $time_table->tm_wef = $wef;
            $time_table->tm_break_start_time = $request->break_start_time;
            $time_table->tm_break_end_time = $request->break_end_time;
            $time_table->tm_timetable = $time_table_json;
            $time_table->tm_created_by = $user->user_id;
            $time_table->tm_browser_info = $this->getBrwsrInfo();
            $time_table->tm_ip_address = $this->getIp();
            $time_table->save();

            // Remove existing timetable items before adding new ones
            ClassTimetableItem::where('tmi_tm_id', $request->tm_id)->delete();

            // Add new records to the class_timetable_item table
            foreach ($day_request as $i => $day) {
                if (isset($requested_arrays[$i]) && is_array($requested_arrays[$i])) {
                    foreach ($requested_arrays[$i] as $index => $requested_array) {
                        $start_time = $request->start_time[$i][$index] ?? null;
                        $end_time = $request->end_time[$i][$index] ?? null;
                        $teacher_id = $request->teacher_id[$i][$index] ?? null;
                        $subject_id = $request->subject_id[$i][$index] ?? null;

                        if ($start_time !== null || $end_time !== null || $teacher_id !== null || $subject_id !== null) {
                            $time_table_item = new ClassTimetableItem();
                            $time_table_item->tmi_college_id = $user->user_clg_id;
                            $time_table_item->tmi_branch_id = Session::get('branch_id');
                            $time_table_item->tmi_tm_id = $time_table->tm_id;
                            $time_table_item->tmi_section_id = $sectionId;
                            $time_table_item->tmi_teacher_id = $teacher_id;
                            $time_table_item->tmi_subject_id = $subject_id;
                            $time_table_item->tmi_day = $day;
                            $time_table_item->tmi_start_time = $start_time;
                            $time_table_item->tmi_end_time = $end_time;
                            $time_table_item->save();
                        }
                    }
                }
            }
        });

        return redirect()->route('time_table_list')->with('success', 'Updated Successfully!');
    }

    public function timetable_view_details_SH(Request $request, $id)
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
            ->where('tm_id', $request->id)
            ->select('class_timetable.*', 'classes.class_name', 'create_section.cs_name', 'semesters.semester_name')
            ->get();
        // dd($time_table);

        // Create an array to store the formatted data for all days
        $formattedData = [];
        $uniqueSubjects = [];
        $countSubject = 0;

        // Loop through the $time_table collection and format the data for the Blade template
        foreach ($time_table as $row) {
            if (!is_null($row->tm_timetable)) {
                $tmTimetable = json_decode($row->tm_timetable, true);

                // Loop through the $tmTimetable and format the data for the current day
                foreach ($tmTimetable as $dayData) {
                    $day = $dayData['day'];
                    $items = $dayData['items'];

                    // Create an array to store the data for the current day
                    $dayRow = [
                        'day' => $day,
                        'start_time' => array_fill(0, count($items), null),
                        'end_time' => array_fill(0, count($items), null),
                        'teacher_name' => array_fill(0, count($items), null), // Change this from 'teacher_id' to 'teacher_name'
                        'subject_name' => array_fill(0, count($items), null), // Change this from 'subject_id' to 'subject_name'
                    ];

                    // Loop through the items for the current day and populate the dayRow array
                    foreach ($items as $key => $item) {
                        if (isset($item['start_time'])) {
                            $dayRow['start_time'][$key] = $item['start_time'];
                        }
                        if (isset($item['end_time'])) {
                            $dayRow['end_time'][$key] = $item['end_time'];
                        }
                        if (isset($item['teacher_id'])) {
                            // Fetch the teacher name directly from the users table based on teacher ID
                            $teacher = User::find($item['teacher_id']);
                            if ($teacher) {
                                $dayRow['teacher_name'][$key] = $teacher->user_name;
                            }
                        }
                        if (isset($item['subject_id'])) {
                            if (!isset($uniqueSubjects[$item['subject_id']])) {
                                $countSubject++; // Increment the count only for unique subjects
                                $uniqueSubjects[$item['subject_id']] = true; // Mark subject ID as encountered
                            }
                            // Fetch the subject name directly from the subjects table based on subject ID
                            $subject = Subject::find($item['subject_id']);
                            if ($subject) {
                                $dayRow['subject_name'][$key] = $subject->subject_name;
                            }
                        }
                    }

                    // Add the formatted data for the current day to the main formattedData array
                    $formattedData[] = $dayRow;
                }
            }
        }

        // Display the formatted data day-wise using the dd() function
        $days = [];
        foreach ($formattedData as $row) {
            $day = $row['day'];
            $days[$day][] = $row;
        }

        // dd($days);

        // Now $formattedData contains the formatted data for each day
        // dd($formattedData);
        // dd($formattedData,$countSubject);

        // $college_bank_info = TimeTableModel::where('tm_college_id', $user->user_clg_id)->first();
        // $items = TimeTableModel::where('fv_v_no', $request->id)->where('fv_clg_id', $user->user_clg_id)->first();
        $type = 'grid';
        $pge_title = 'Time Table';

        return view('collegeViews.TimeTable.view_time_table', compact('formattedData', 'type', 'pge_title', 'time_table', 'countSubject'));
    }

    public function timetable_view_details_pdf_SH(Request $request, $id)
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
            ->where('tm_id', $request->id)
            ->select('class_timetable.*', 'classes.class_name', 'create_section.cs_name', 'semesters.semester_name')
            ->get();
        // dd($time_table);

        // Create an array to store the formatted data for all days
        $formattedData = [];
        $uniqueSubjects = [];
        $countSubject = 0;

        // Loop through the $time_table collection and format the data for the Blade template
        foreach ($time_table as $row) {
            if (!is_null($row->tm_timetable)) {
                $tmTimetable = json_decode($row->tm_timetable, true);

                // Loop through the $tmTimetable and format the data for the current day
                foreach ($tmTimetable as $dayData) {
                    $day = $dayData['day'];
                    $items = $dayData['items'];

                    // Create an array to store the data for the current day
                    $dayRow = [
                        'day' => $day,
                        'start_time' => array_fill(0, count($items), null),
                        'end_time' => array_fill(0, count($items), null),
                        'teacher_name' => array_fill(0, count($items), null), // Change this from 'teacher_id' to 'teacher_name'
                        'subject_name' => array_fill(0, count($items), null), // Change this from 'subject_id' to 'subject_name'
                    ];

                    // Loop through the items for the current day and populate the dayRow array
                    foreach ($items as $key => $item) {
                        if (isset($item['start_time'])) {
                            $dayRow['start_time'][$key] = $item['start_time'];
                        }
                        if (isset($item['end_time'])) {
                            $dayRow['end_time'][$key] = $item['end_time'];
                        }
                        if (isset($item['teacher_id'])) {
                            // Fetch the teacher name directly from the users table based on teacher ID
                            $teacher = User::find($item['teacher_id']);
                            if ($teacher) {
                                $dayRow['teacher_name'][$key] = $teacher->user_name;
                            }
                        }
                        if (isset($item['subject_id'])) {
                            if (!isset($uniqueSubjects[$item['subject_id']])) {
                                $countSubject++; // Increment the count only for unique subjects
                                $uniqueSubjects[$item['subject_id']] = true; // Mark subject ID as encountered
                            }
                            // Fetch the subject name directly from the subjects table based on subject ID
                            $subject = Subject::find($item['subject_id']);
                            if ($subject) {
                                $dayRow['subject_name'][$key] = $subject->subject_name;
                            }
                        }
                    }

                    // Add the formatted data for the current day to the main formattedData array
                    $formattedData[] = $dayRow;
                }
            }
        }

        // Display the formatted data day-wise using the dd() function
        $days = [];
        foreach ($formattedData as $row) {
            $day = $row['day'];
            $days[$day][] = $row;
        }

        // dd($days);

        // Now $formattedData contains the formatted data for each day
        // dd($formattedData);
        // dd($formattedData, $countSubject);

        // $college_bank_info = TimeTableModel::where('tm_college_id', $user->user_clg_id)->first();
        // $items = TimeTableModel::where('fv_v_no', $request->id)->where('fv_clg_id', $user->user_clg_id)->first();
        $type = 'pdf';
        $pge_title = 'Time Table';

        $options = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ]);

        $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($options);
        $pdf->loadView('collegeViews.TimeTable.print_time_table', compact('formattedData', 'type', 'pge_title', 'time_table', 'countSubject'));

        return $pdf->stream('Time-Table-Detail.pdf');
    }
}
