<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\College\AssignCoordinatorModel;
use App\Models\College\Classes;
use App\Models\College\ClassTimetableItem;
use App\Models\College\GroupItems;
use App\Models\College\Program;
use App\Models\College\Student;
use App\Models\College\Subject;
use App\Models\College\TimeTableModel;
use App\Models\College\MarkTeacherAttendanceModel;
use App\Models\College\Section;
use App\Models\College\Semester;
use App\Models\College\StudentTransferModel;
use App\Models\CreateSectionModel;
use App\Models\StudentAttendanceModel;
use App\User;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

class AjaxController extends Controller
{
    public function get_employee(Request $request)
    {
        $user = Auth::user();
        // dd($user);
        $empoyee = User::where('user_department_id', $request->dep_id)
            ->where('user_designation', '!=', 1)
            ->where('user_clg_id', $user->user_clg_id)
            ->where('user_id', '!=', 1)
            ->get();
        return response()->json($empoyee);
    }

    public function get_program(Request $request)
    {
        $user = Auth::user();
        // dd($user);
        $program = Program::where('program_degree_id', $request->deg_id)->get();
        return response()->json($program);
    }

    // farhad
    public function get_groups(Request $request)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $groups = DB::table('groups')
            ->where('group_clg_id', $user->user_clg_id)
            ->where('group_class_id', $request->class_id)
            // ->where('group_branch_id', $branch_id)
            ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'groups.group_name')
            ->groupBy('ng_id')
            ->select('groups.group_id', 'new_groups.ng_name', 'new_groups.ng_id')
            ->get();
        $semesters = DB::table('groups')
            ->where('group_clg_id', $user->user_clg_id)
            ->where('group_class_id', $request->class_id)
            ->where('group_branch_id', $branch_id)
            ->leftJoin('semesters', 'semesters.semester_id', '=', 'groups.group_semester_id')
            ->groupBy('semester_id')
            ->select('groups.group_id', 'semesters.semester_name', 'semesters.semester_id')
            ->get();


        if ($user->user_designation == 14) {
            $sectionId = AssignCoordinatorModel::where('ac_coordinator_id', $user->user_id)
                ->where('ac_class_id', $request->class_id)
                ->where('ac_disable_enable', 1)
                ->pluck('ac_section_id')->first();
            $sectionIds = explode(',', $sectionId);

            $section = DB::table('sections')
                ->where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->leftJoin('create_section', 'create_section.cs_id', '=', 'sections.section_name')
                ->whereIn('cs_id', $sectionIds)
                ->groupBy('cs_id')
                ->select('sections.section_id', 'create_section.cs_name', 'create_section.cs_id')
                ->get();

        } else {
            $section = DB::table('sections')
                ->where('section_clg_id', $user->user_clg_id)
                ->where('section_class_id', $request->class_id)
                ->leftJoin('create_section', 'create_section.cs_id', '=', 'sections.section_name')
                ->groupBy('cs_id')
                ->where('section_branch_id', $branch_id)
                // ->where('cs_branch_id', $branch_id)
                ->select('sections.section_id', 'create_section.cs_name', 'create_section.cs_id')
                ->get();
        }
        // $cs_name = $section->select('sections.*','create_section.cs_name','create_section.cs_id')->get();
        return response()->json(['groups' => $groups, 'section' => $section, 'semesters' => $semesters]);
    }

    public function get_subjects(Request $request)
    {
        $user = Auth::user();
        // dd($user);
        $groups = GroupItems::where('grpi_class_id', $request->class_id)
            ->where('grpi_section_id', $request->section_id)
            ->where('grpi_semester_id', $request->semester_id)
            ->leftjoin('subjects', 'subjects.subject_id', '=', 'group_items.grpi_subject_id')
            ->groupBy('grpi_subject_id')
            ->select('subjects.subject_id', 'subjects.subject_name')
            ->get();
        return response()->json($groups);
    }

    // end farhad
    public function get_student(Request $request)
    {
        $user = Auth::user();
        $students = Student::where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('student_disable_enable', 1)
            ->where('branch_id', Session::get('branch_id'))
            ->get();
        return response()->json($students);
    }

    // start farhad
    public function get_teachers(Request $request)
    {
        $user = Auth::user();
        $teacher_ids = Subject::where('subject_id', $request->subject_id)
            ->pluck('subject_teacher_id')
            ->first(); // Retrieve the model instance
        $groupSubjectIds = explode(',', $teacher_ids);
        $teachers = User::whereIn('user_id', $groupSubjectIds)->select('user_id', 'user_name')->get();

        // dd($teachers);
        return response()->json($teachers);
    }
    // farhad
    // get teachersDepartment wise
    public function get_all_teachers(Request $request)
    {
        $user = Auth::user();
        $allTeachers = User::where('user_department_id', $request->dep_id)
            ->where('user_mark', '=', 1)
            ->select('user_id', 'user_name')
            ->get();

        // dd($allTeachers);
        return response()->json($allTeachers);
    }

    // end farhad
    public function get_sections(Request $request)
    {
        $user = Auth::user();
        $branch_id = $request->branch_id;
        //        $branch_id = Session::get('branch_id');

        $groups = DB::table('groups')
            ->where('group_clg_id', $user->user_clg_id)
            ->where('group_class_id', $request->class_id)
            ->where('group_branch_id', $branch_id)
            ->where('group_disable_enable', 1)
            ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'groups.group_name')
            ->groupBy('ng_id')
            ->select('groups.group_id', 'new_groups.ng_name', 'new_groups.ng_id')
            ->get();

        // dd($request->all());

        $section = DB::table('sections')
            ->where('section_clg_id', $user->user_clg_id)
            ->where('section_class_id', $request->class_id)
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'sections.section_name')
            ->groupBy('cs_id')
            ->where('sections.section_branch_id', $branch_id)
            ->select('sections.section_id', 'create_section.cs_name', 'create_section.cs_id')
            ->get();

        return response()->json(['groups' => $groups, 'section' => $section]);
    }

    // farhad
    public function get_section(Request $request)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        // dd($request->all());

        $section = DB::table('sections')
            ->where('section_clg_id', $user->user_clg_id)
            ->where('section_class_id', $request->class_id)
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'sections.section_name')
            ->groupBy('cs_id')
            ->where('section_branch_id', $branch_id)
            ->select('sections.section_id', 'create_section.cs_name', 'create_section.cs_id')
            ->get();
        return response()->json($section);
    }

    // farhad
    public function get_coordinator_section(Request $request)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $semesters = DB::table('groups')
            ->where('group_clg_id', $user->user_clg_id)
            ->where('group_class_id', $request->class_id)
            ->where('group_branch_id', $branch_id)
            ->leftJoin('semesters', 'semesters.semester_id', '=', 'groups.group_semester_id')
            ->groupBy('semester_id')
            ->select('groups.group_id', 'semesters.semester_name', 'semesters.semester_id')
            ->get();
        if ($user->user_designation == 14) {
            $sectionId = AssignCoordinatorModel::where('ac_coordinator_id', $user->user_id)
                ->where('ac_branch_id', $branch_id)
                ->where('ac_class_id', $request->class_id)
                ->where('ac_disable_enable', 1)
                ->get();
            $sectionIds = $sectionId->pluck('ac_section_id')->implode(','); // Extract section IDs and create a comma-separated string
            $sectionIdsArray = explode(',', $sectionIds); // Convert the string to an array

            $allsections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)
                ->where('cs_branch_id', $branch_id)
                ->whereIn('cs_id', $sectionIdsArray) // Use cs_id to match sections
                ->get();

            // dd($allsections);
        } else {
            $allsections = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $request->class_id)
                ->leftJoin('create_section', 'create_section.cs_id', '=', 'sections.section_name')
                ->select('sections.*', 'create_section.cs_name', 'create_section.cs_id')
                ->get();
            // dd($allsections);
        }
        return response()->json(['section' => $allsections, 'semesters' => $semesters]);
    }

    // farhad
    public function get_semester(Request $request)
    {
        $user = Auth::user();
        $get_semester = TimeTableModel::with('users')
            ->leftJoin('semesters', 'semesters.semester_id', '=', 'class_timetable.tm_semester_id')
            ->where('tm_college_id', $user->user_clg_id)
            ->where('tm_section_id', $request->section_id)
            ->where('tm_class_id', $request->class_id)
            ->where('tm_disable_enable', 1)
            ->where('checks', 2)
            ->select('class_timetable.tm_semester_id', 'semesters.semester_name', 'semesters.semester_id')
            ->get();
        // dd($get_semester);
        return response()->json($get_semester);
    }

    // farhad
    public function get_teacher(Request $request)
    {
        $user = Auth::user();
        $time_table = TimeTableModel::with('users')
            ->where('tm_college_id', $user->user_clg_id)
            ->where('tm_section_id', $request->section_id)
            ->where('tm_class_id', $request->class_id)
            ->where('tm_semester_id', $request->semester_id)
            ->where('tm_disable_enable', 1)
            ->where('checks', 2)
            ->select('class_timetable.*')
            ->get();
        // dd($time_table);

        // Create an array to store the formatted data for all days
        $formattedData = [];
        // $countSubject = 0;
        // Loop through the $time_table collection and format the data for the Blade template
        foreach ($time_table as $row) {
            if (!is_null($row->tm_timetable)) {
                $tmTimetable = json_decode($row->tm_timetable, true);

                // Loop through the $tmTimetable and format the data for the current day
                foreach ($tmTimetable as $dayData) {
                    $day = $dayData['day'];
                    $items = $dayData['items'];

                    // Initialize $dayRow with empty arrays for 'teacher_id' and 'subject_id'
                    $dayRow = [
                        'day' => $day,
                        'teacher_name' => [], // Change this from 'teacher_id' to 'teacher_name'
                        'teacher_id' => [], // Initialize 'teacher_id' as an empty array
                    ];

                    // Loop through the items for the current day and populate the dayRow array
                    foreach ($items as $key => $item) {
                        if (isset($item['teacher_id'])) {
                            // Fetch the teacher name directly from the users table based on teacher ID
                            $teacher = User::find($item['teacher_id']);
                            if ($teacher) {
                                $dayRow['teacher_name'][$key] = $teacher->user_name;
                            }

                            // Add 'teacher_id' to the array
                            $dayRow['teacher_id'][$key] = $item['teacher_id'];
                        }

                        // if (isset($item['subject_id'])) {
                        //     if (!isset($uniqueSubjects[$item['subject_id']])) {
                        //         $countSubject++; // Increment the count only for unique subjects
                        //         $uniqueSubjects[$item['subject_id']] = true; // Mark subject ID as encountered
                        //     }

                        //     // Fetch the subject name directly from the subjects table based on subject ID
                        //     $subject = Subject::find($item['subject_id']);
                        //     if ($subject) {
                        //         $dayRow['subject_name'][$key] = $subject->subject_name;
                        //     }

                        //     // Add 'subject_id' to the array
                        //     $dayRow['subject_id'][$key] = $item['subject_id'];
                        // }
                    }

                    // Add the formatted data for the current day to the main formattedData array
                    $formattedData[] = $dayRow;
                }
            }
        }
        // dd($formattedData);
        $days = [];
        foreach ($formattedData as $row) {
            $day = $row['day'];
            $days[$day][] = $row;
        }
        // $currentDay = date('l');  // Outputs the full day name (e.g., "Monday")
        // Assuming $currentDay contains the date "28-Mar-2024"
        $currentDay = $request->date; // Outputs the full day name (e.g., "Monday")

        // Convert the date string to a UNIX timestamp
        $timestamp = strtotime($currentDay);

        // Format the timestamp to get the full day name
        $currentDay = date('l', $timestamp);

        // $currentDay = 'Monday';
        $currentDayData = [];

        foreach ($formattedData as $row) {
            if (strcasecmp(trim($row['day']), $currentDay) === 0) {
                $currentDayData[] = $row;
            }
        }
        // dd($currentDayData);
        // $subjects = [];
        $teachers = [];

        foreach ($currentDayData as $row) {
            if (isset($row['teacher_id']) && isset($row['teacher_name'])) {
                foreach ($row['teacher_id'] as $key => $teacherId) {
                    $teacherName = isset($row['teacher_name'][$key]) ? $row['teacher_name'][$key] : 'N/A';

                    // Check if the teacher name is not "N/A" before adding to the array
                    if ($teacherName !== 'N/A') {
                        $teachers[] = [
                            'teacher_id' => $teacherId,
                            'teacher_name' => $teacherName,
                        ];
                    }
                }
            }
        }

        // dd($teachers);
        return response()->json($teachers);
    }

    // farhad
    public function get_teacher_subject(Request $request)
    {
        // dd($request->all());
        $teacherId = $request->input('teacher_id');
        $user = Auth::user();
        $time_table = TimeTableModel::with('users')
            ->where('tm_college_id', $user->user_clg_id)
            ->where('tm_section_id', $request->section_id)
            ->where('tm_semester_id', $request->semester_id)
            ->where('tm_disable_enable', 1)
            ->where('checks', 2)
            ->select('class_timetable.*')
            ->get();
        // dd($time_table);

        // Create an array to store the formatted data for all days
        $formattedData = [];
        $countSubject = 0;
        // Loop through the $time_table collection and format the data for the Blade template
        foreach ($time_table as $row) {
            if (!is_null($row->tm_timetable)) {
                $tmTimetable = json_decode($row->tm_timetable, true);

                // Loop through the $tmTimetable and format the data for the current day
                foreach ($tmTimetable as $dayData) {
                    $day = $dayData['day'];
                    $items = $dayData['items'];

                    // Initialize $dayRow with empty arrays for 'teacher_id' and 'subject_id'
                    $dayRow = [
                        'day' => $day,
                        'teacher_name' => [], // Change this from 'teacher_id' to 'teacher_name'
                        'teacher_id' => [], // Initialize 'teacher_id' as an empty array
                        'subject_id' => [], // Initialize 'subject_id' as an empty array
                        'subject_name' => [], // Change this from 'subject_id' to 'subject_name'
                    ];

                    // Loop through the items for the current day and populate the dayRow array
                    foreach ($items as $key => $item) {
                        if (isset($item['teacher_id'])) {
                            // Fetch the teacher name directly from the users table based on teacher ID
                            $teacher = User::find($item['teacher_id']);
                            if ($teacher) {
                                $dayRow['teacher_name'][$key] = $teacher->user_name;
                            }

                            // Add 'teacher_id' to the array
                            $dayRow['teacher_id'][$key] = $item['teacher_id'];
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

                            // Add 'subject_id' to the array
                            $dayRow['subject_id'][$key] = $item['subject_id'];
                        }
                    }

                    // Add the formatted data for the current day to the main formattedData array
                    $formattedData[] = $dayRow;
                }
            }
        }
        $days = [];
        foreach ($formattedData as $row) {
            $day = $row['day'];
            $days[$day][] = $row;
        }
        $currentDay = $request->date; // Outputs the full day name (e.g., "Monday")

        // Convert the date string to a UNIX timestamp
        $timestamp = strtotime($currentDay);

        // Format the timestamp to get the full day name
        $currentDay = date('l', $timestamp); // Outputs the full day name (e.g., "Monday")
        // $currentDay = 'Monday';
        $currentDayData = [];

        foreach ($formattedData as $row) {
            if (strcasecmp(trim($row['day']), $currentDay) === 0) {
                $currentDayData[] = $row;
            }
        }
        // dd($currentDayData);
        // Filter subjects based on the teacher's presence in the timetable
        $teacherSubjects = [];
        $encounteredSubjects = []; // Track encountered subjects

        foreach ($currentDayData as $row) {
            if (in_array($teacherId, $row['teacher_id'])) {
                // Initialize an array to store subjects for the current row
                $matchingSubjects = [];

                // Loop through all subjects in the row
                foreach ($row['teacher_id'] as $key => $teacherIdInRow) {
                    if ($teacherIdInRow == $teacherId && !in_array($row['subject_id'][$key], $encounteredSubjects)) {
                        // Add the subject that matches the teacher's ID and not encountered before
                        $matchingSubjects[] = [
                            'subject_id' => $row['subject_id'][$key],
                            'subject_name' => $row['subject_name'][$key],
                            // Add other data you need
                        ];

                        // Add subject ID to encountered subjects array
                        $encounteredSubjects[] = $row['subject_id'][$key];
                    }
                }

                // Merge the matching subjects for the current row with the result array
                $teacherSubjects = array_merge($teacherSubjects, $matchingSubjects);
            }
        }
        if (!empty($teacherSubjects)) {
            // Return the filtered subjects as a JSON response
            // dd($teacherSubjects);

            return response()->json(['subjects' => $teacherSubjects]);
        } else {
            // Handle the case where the teacher is not found for any subjects
            return response()->json(['error' => 'Teacher not found for any subjects'], 404);
        }
    }

    public function get_subject_time(Request $request)
    {
        // dd($request->all());
        $SubjectId = $request->input('subject_id');
        $teacherId = $request->input('teacher_id');
        $user = Auth::user();
        $time_table = TimeTableModel::with('users')
            ->where('tm_college_id', $user->user_clg_id)
            ->where('tm_section_id', $request->section_id)
            ->where('tm_semester_id', $request->semester_id)
            ->where('tm_disable_enable', 1)
            ->where('checks', 2)
            ->select('class_timetable.*')
            ->get();
        // dd($time_table);

        // Create an array to store the formatted data for all days
        $formattedData = [];
        $countSubject = 0;
        // Loop through the $time_table collection and format the data for the Blade template
        foreach ($time_table as $row) {
            if (!is_null($row->tm_timetable)) {
                $tmTimetable = json_decode($row->tm_timetable, true);

                // Loop through the $tmTimetable and format the data for the current day
                foreach ($tmTimetable as $dayData) {
                    $day = $dayData['day'];
                    $items = $dayData['items'];

                    // Initialize $dayRow with empty arrays for 'teacher_id' and 'subject_id'
                    $dayRow = [
                        'day' => $day,
                        'teacher_name' => [], // Change this from 'teacher_id' to 'teacher_name'
                        'teacher_id' => [], // Initialize 'teacher_id' as an empty array
                        'subject_id' => [], // Initialize 'subject_id' as an empty array
                        'subject_name' => [], // Change this from 'subject_id' to 'subject_name'
                        'start_time' => [],
                    ];

                    // Loop through the items for the current day and populate the dayRow array
                    foreach ($items as $key => $item) {
                        if (isset($item['teacher_id'])) {
                            // Fetch the teacher name directly from the users table based on teacher ID
                            $teacher = User::find($item['teacher_id']);
                            if ($teacher) {
                                $dayRow['teacher_name'][$key] = $teacher->user_name;
                            }

                            // Add 'teacher_id' to the array
                            $dayRow['teacher_id'][$key] = $item['teacher_id'];
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

                            // Add 'subject_id' to the array
                            $dayRow['subject_id'][$key] = $item['subject_id'];
                        }
                        if (isset($item['start_time'])) {
                            $dayRow['start_time'][$key] = $item['start_time'];
                        }
                    }

                    // Add the formatted data for the current day to the main formattedData array
                    $formattedData[] = $dayRow;
                }
            }
        }
        $days = [];
        foreach ($formattedData as $row) {
            $day = $row['day'];
            $days[$day][] = $row;
        }
        $currentDay = $request->date; // Outputs the full day name (e.g., "Monday")

        // Convert the date string to a UNIX timestamp
        $timestamp = strtotime($currentDay);

        // Format the timestamp to get the full day name
        $currentDay = date('l', $timestamp); // Outputs the full day name (e.g., "Monday")
        // $currentDay = 'Monday';
        $currentDayData = [];

        foreach ($formattedData as $row) {
            if (strcasecmp(trim($row['day']), $currentDay) === 0) {
                $currentDayData[] = $row;
            }
        }
        // dd($currentDayData,$currentDay);
        // Filter subjects based on the teacher's presence in the timetable
        $SubjectsTime = [];
        foreach ($currentDayData as $row) {
            if (in_array($SubjectId, $row['subject_id'])) {
                // Initialize an array to store subjects for the current row
                $matchingTime = [];

                // Loop through all subjects in the row
                foreach ($row['subject_id'] as $key => $SubjectIdInRow) {
                    if ($SubjectIdInRow == $SubjectId) {
                        // Add the subject that matches the subject's ID
                        $matchingTime[] = [
                            'start_time' => $row['start_time'][$key],
                            // Add other data you need
                        ];
                    }
                }

                // Merge the matching subjects for the current row with the result array
                $SubjectsTime = array_merge($SubjectsTime, $matchingTime);
            }
        }
        if (!empty($SubjectsTime)) {
            // Return the filtered subjects as a JSON response
            // dd($SubjectsTime);

            return response()->json(['start_time' => $SubjectsTime]);
        } else {
            // Handle the case where the subject is not found for any subjects
            return response()->json(['error' => 'Time not found for any subjects'], 404);
        }
    }
    // farhad
    // to get the current Day teachers
    public function get_current_teacher(Request $request)
    {
        $selectedDate = Carbon::createFromFormat('d-M-Y', $request->input('selectedDate'))->toDateString();
//        dd($selectedDate);
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        if ($user->user_designation == 14) {
            $sectionId = AssignCoordinatorModel::where('ac_coordinator_id', $user->user_id)
                ->where('ac_disable_enable', 1)
                ->get();
            $sectionIds = $sectionId->pluck('ac_section_id')->implode(','); // Extract section IDs and create a comma-separated string
            $sectionIdsArray = explode(',', $sectionIds); // Convert the string to an array
            $timetableData = TimeTableModel::with('users')
                ->where('tm_college_id', $user->user_clg_id)
                ->where('tm_branch_id', $branch_id)
                ->whereIn('tm_section_id', $sectionIdsArray)
                ->where('tm_disable_enable', 1)
                ->where('checks', 2)
                ->whereJsonContains('tm_timetable', [['day' => Carbon::parse($selectedDate)->format('l')]])
                ->get();
        } else {
            // Fetch timetable data for the selected date
            $timetableData = TimeTableModel::with('users')
                ->where('tm_college_id', $user->user_clg_id)
                ->where('tm_branch_id', $branch_id)
                ->where('tm_disable_enable', 1)
                ->where('checks', 2)
                ->whereJsonContains('tm_timetable', [['day' => Carbon::parse($selectedDate)->format('l')]])
                ->get();
            // dd($timetableData);
        }
        // Fetch timetable data for the selected date
//        $timetableData = TimeTableModel::with('users')
//            ->where('tm_college_id', $user->user_clg_id)
//            ->where('tm_branch_id', $branch_id)
//            ->where('tm_disable_enable', 1)
//            ->where('checks', 2)
//            ->whereDate('semester_start_date', '<=', $selectedDate)
//            ->whereJsonContains('tm_timetable', [['day' => Carbon::parse($selectedDate)->format('l')]])
//            ->get();
//        dd($timetableData);
        $teachers = [];

        // Extract teachers from the timetable data
        foreach ($timetableData as $row) {
            if (!empty($row->tm_timetable)) {
                $tmTimetable = json_decode($row->tm_timetable, true);

                foreach ($tmTimetable as $dayData) {
                    if ($dayData['day'] === Carbon::parse($selectedDate)->format('l')) {
                        foreach ($dayData['items'] as $item) {
                            if (isset($item['teacher_id'])) {
                                $teacherId = $item['teacher_id'];
                                $teacher = User::find($teacherId);
                                if ($teacher) {
                                    if (!isset($teachers[$teacherId])) {
                                        // If not, add teacher to $teachers array
                                        if (
                                            !MarkTeacherAttendanceModel::where('la_emp_id', $teacherId)
                                                ->where('la_clg_id', $user->user_clg_id)
                                                ->where('la_branch_id', $branch_id)
                                                ->whereDate('la_date', $selectedDate)
                                                ->exists()
                                        ) {
                                            $teachers[$teacherId] = [
                                                'teacher_id' => $teacherId,
                                                'teacher_name' => $teacher->user_name,
                                            ];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

//         dd($teachers);
        // Return the list of teachers for the selected date
        return response()->json($teachers);
    }

    // to get the current Day teachers all time
    public function get_teachers_all_time(Request $request)
    {
        // $selectedDate = Carbon::createFromFormat('d-M-Y', $request->input('selectedDate'))->toDateString();
        $selectedDate = Carbon::parse($request->input('date'))->toDateString();

        $teacherId = $request->input('teachers_id');
        // dd($request->all(),$teacherId);
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        if ($user->user_designation == 14) {
            $sectionId = AssignCoordinatorModel::where('ac_coordinator_id', $user->user_id)
                ->where('ac_disable_enable', 1)
                ->get();
            $sectionIds = $sectionId->pluck('ac_section_id')->implode(','); // Extract section IDs and create a comma-separated string
            $sectionIdsArray = explode(',', $sectionIds); // Convert the string to an array
            $timetableData = TimeTableModel::with('users')
                ->where('tm_college_id', $user->user_clg_id)
                ->where('tm_branch_id', $branch_id)
                ->whereIn('tm_section_id', $sectionIdsArray)
                ->where('tm_disable_enable', 1)
                ->where('checks', 2)
                ->whereJsonContains('tm_timetable', [['day' => Carbon::parse($selectedDate)->format('l')]])
                ->get();

            // dd($allsectiones);
        } else {
            // Fetch timetable data for the selected date
            $timetableData = TimeTableModel::with('users')
                ->where('tm_college_id', $user->user_clg_id)
                ->where('tm_branch_id', $branch_id)
                ->where('tm_disable_enable', 1)
                ->where('checks', 2)
                ->whereJsonContains('tm_timetable', [['day' => Carbon::parse($selectedDate)->format('l')]])
                ->get();
            // dd($timetableData);
        }
        $timetableEntries = [];

        // Extract timetable entries for the current day and specified teacher
        foreach ($timetableData as $row) {
            // var_dump($row);
            // Fetch class and section details from your database
            $class = Classes::where('class_id', $row['tm_class_id'])->first();
            $semester = Semester::where('semester_id', $row['tm_semester_id'])->first();
            $section = CreateSectionModel::where('cs_id', $row['tm_section_id'])->first();
            if (!empty($row->tm_timetable)) {
                $tmTimetable = json_decode($row->tm_timetable, true);

                foreach ($tmTimetable as $dayData) {
                    if ($dayData['day'] === Carbon::parse($selectedDate)->format('l')) {
                        foreach ($dayData['items'] as $item) {
                            // var_dump($item['items']);
                            if ($item['teacher_id'] == $teacherId) {
                                // var_dump($item['teacher_id']);
                                $teacher = User::find($teacherId);
                                $subject = Subject::find($item['subject_id']);
                                $timetableEntry = [
                                    'start_time' => $item['start_time'],
                                    'end_time' => $item['end_time'],
                                    'teacher_id' => $item['teacher_id'],
                                    'teacher_name' => $teacher->user_name,
                                    'class_name' => $class->class_name,
                                    'class_id' => $class->class_id,
                                    'section_name' => $section->cs_name,
                                    'section_id' => $section->cs_id,
                                    'subject_name' => $subject->subject_name,
                                    'subject_id' => $subject->subject_id,
                                    'semester_name' => $semester->semester_name,
                                    'semester_id' => $semester->semester_id,
                                ];

                                $timetableEntries[] = $timetableEntry;
                            }
                        }
                    }
                }
            }
        }
        // dd($timetableEntries);
        // Return the timetable entries for the specified teacher ID on the current day
        return response()->json($timetableEntries);
    }

    //    farhad
    public function get_allsubjects(Request $request)
    {
        $user = Auth::user();
        // $branch_id = Session::get('branch_id');
        // dd($user);

        $subjects = DB::table('subjects')
            ->whereRaw("FIND_IN_SET('$request->teacher_id', subject_teacher_id)")
            ->where('subject_clg_id', $user->user_clg_id)
            // ->where('subject_branch_id', $branch_id)
            ->get();
        // dd($subjects);
        return response()->json($subjects);
    }

    // farhad
    public function get_all_employees(Request $request)
    {
        // dd($request->all());
        $Date = date('Y-m-d', strtotime($request->date));
        // dd($Date);
        $user = Auth::user();
        $attendance = MarkTeacherAttendanceModel::where('la_date', $Date)
            ->where('la_department_id', $request->dep_id)
            ->count();
        // dd($attendance);
        // dd($user);
        $employee = '';
        if ($attendance == 0) {
            if ($request->attendance_status == 1) {
                $employee = DB::table('financials_users')
                    ->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'financials_users.user_department_id')
                    ->select('financials_departments.dep_id', 'financials_departments.dep_title', 'user_id', 'user_name', 'user_mark', 'user_department_id')
                    ->where('user_department_id', $request->dep_id)
                    ->where('user_clg_id', $user->user_clg_id)
                    ->where('user_mark', '!=', 1)
                    ->where('user_id', '!=', 1)
                    ->where('user_disabled', 0)
                    ->where('user_name', '!=', 'MasterCity College')
                    ->where('user_name', '!=', 'Super AdminCity College')
                    ->get();
            }
            if ($request->attendance_status == 2) {
                $employee = DB::table('financials_users')
                    ->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'financials_users.user_department_id')
                    ->select('financials_departments.dep_id', 'financials_departments.dep_title', 'user_id', 'user_name', 'user_mark', 'user_department_id')
                    ->where('user_department_id', $request->dep_id)
                    ->where('user_clg_id', $user->user_clg_id)
                    ->where('user_id', '!=', 1)
                    ->where('user_disabled', 0)
                    ->where('user_name', '!=', 'MasterCity College')
                    ->where('user_name', '!=', 'Super AdminCity College')
                    ->get();
            }
        }
        // dd($employee);
        return response()->json(['employee' => $employee, 'attendance' => $attendance]);
    }

    public function get_present_student(Request $request)
    {
        $present_student = StudentAttendanceModel::where('std_att_class_id', $request->class_id)
            ->where('std_att_class_id', $request->section_id)
            ->where('std_att_date', $request->date)
            ->first();
        return response()->json($present_student);
    }

    public function get_student_data(Request $request)
    {
        $get_data = StudentTransferModel::where('st_std_id', $request->std_id)
            ->where('st_branch_id', Session::get('branch_id'))
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'st_section_id')
            ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'st_group_id')
            ->groupBy('new_groups.ng_id', 'create_section.cs_id')
            ->get();
        return response()->json($get_data);
    }

    public function get_date(Request $request)
    {
        $get_date = StudentTransferModel::where('st_std_id', $request->std_id)
            ->where('st_branch_id', Session::get('branch_id'))
            ->where('st_section_id', $request->section_id)
            ->select('st_datetime')
            ->first();

        $date = Carbon::parse($get_date->st_datetime)->format('Y-m-d');

        $get_date_tp = StudentTransferModel::where('st_std_id', $request->std_id)
            ->where('st_branch_id', Session::get('branch_id'))
            ->whereDate('st_datetime', '<', date($date))
            ->count();

        if ($get_date_tp == 0) {
            $first_date = Student::where('id', $request->std_id)
                ->select('admission_date as start_date')
                ->first();
        } else {
            $first_date = StudentTransferModel::where('st_std_id', $request->std_id)
                ->where('st_branch_id', Session::get('branch_id'))
                ->whereDate('st_datetime', '<', $date)
                ->orderBy('st_id', 'DESC')
                ->select('st_datetime as start_date')
                ->first();
        }
        $start_date = Carbon::parse($first_date->start_date)->format('Y-m-d');
        // ->where('st_section_id', $request->section_id)->get();

        return response()->json(['start_date' => $start_date, 'end_date' => $date]);
    }

    public function get_students_for_promotion(Request $request)
    {
        $student_ids = Student::where('class_id', $request->class_id)
            ->where('group_id', $request->group)
            ->where('branch_id', Session::get('branch_id'))
            ->where('student_disable_enable', 1)
            ->where('status', '!=', 3)
            ->pluck('id')
            ->count();
        return response()->json(['students' => $student_ids]);
    }

    public function get_section_subject(Request $request)
    {
        $subjects = ClassTimetableItem::where('tmi_section_id', $request->section_id)
            ->where('tmi_branch_id', Session::get('branch_id'))
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'tmi_subject_id')
            ->select('subjects.subject_id','subjects.subject_name')
            ->groupBy('tmi_subject_id')->get();
        return response()->json(['subjects' => $subjects]);
    }
}
