<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\College\AssignCoordinatorModel;
use App\Models\College\Classes;
use App\Models\College\MarkTeacherAttendanceItemsModel;
use App\Models\College\MarkTeacherAttendanceModel;
use App\Models\College\Semester;
use App\Models\College\Subject;
use App\Models\College\TeacherLoadModel;
use App\Models\College\TimeTableModel;
use App\Models\CreateSectionModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class TeacherAttendanceApiController extends Controller
{
    public function get_current_teacher(Request $request)
    {
        $selectedDate = Carbon::now();
        $user = Auth::user();
        $branch_id = $request->branchId;//Session::get('branch_id');
        // return response()->json(['user_Id' => $branch_id, 'req'=>$user]);
        if ($user->user_designation == 14) {
            $sectionId = AssignCoordinatorModel::where('ac_coordinator_id', $user->user_id)
                ->where('ac_disable_enable', 1)
                ->get();
            $sectionIds = $sectionId->pluck('ac_section_id')->implode(',');
            $sectionIdsArray = explode(',', $sectionIds);
            $timetableData = TimeTableModel::with('users')
                ->where('tm_college_id', $user->user_clg_id)
                ->where('tm_branch_id', $branch_id)
                ->whereIn('tm_section_id', $sectionIdsArray)
                ->where('tm_disable_enable', 1)
                ->where('checks', 2)
                ->whereJsonContains('tm_timetable', [['day' => Carbon::parse($selectedDate)->format('l')]])
                ->get();
        } else {
            $timetableData = TimeTableModel::with('users')
                ->where('tm_college_id', $user->user_clg_id)
                ->where('tm_branch_id', $branch_id)
                ->where('tm_disable_enable', 1)
                ->where('checks', 2)
                ->whereJsonContains('tm_timetable', [['day' => Carbon::parse($selectedDate)->format('l')]])
                ->get();
        }

        if (!empty($timetableData)) {
            $teachers = [];

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
                                        if (
                                            !MarkTeacherAttendanceModel::where('la_emp_id', $teacherId)
                                                ->where('la_clg_id', $user->user_clg_id)
                                                ->where('la_branch_id', $branch_id)
                                                ->whereDate('la_date', $selectedDate->format('Y-m-d'))
                                                ->exists()
                                        ) {
                                            // Add the teacher to the teachers array and record the teacherId
                                            $teachers[] = [
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

            // Return the teachers list in the desired format
            return response()->json(['teachers' => $teachers]);
        } else {
            return response()->json(['message' => 'No Teacher Found']);
        }
    }


    public function get_teachers_data_timeWise(Request $request)
    {
        // $selectedDate = Carbon::createFromFormat('d-M-Y', $request->input('selectedDate'))->toDateString();
        $selectedDate = Carbon::now()->format('d-M-Y');

        $teacherId = $request->teachersId;
        $user = Auth::user();
        $branch_id = $request->branchId;//Session::get('branch_id');
        //   return response()->json(['user_Id' => $branch_id, 'req'=>$user]);
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
        return response()->json(['teacher_data' => $timetableEntries]);
    }

    public function get_user()
    {

        $users = User::where('user_disabled', 0)
            ->where('user_type', '!=', 'Master')
            ->leftjoin('financials_designation', 'financials_designation.desig_id', '=', 'financials_users.user_designation')
            ->select('financials_users.user_id', 'financials_users.user_name', 'financials_users.user_profilepic', 'financials_users.user_fingerprint', 'financials_users.user_update_datetime', 'financials_designation.desig_name', 'financials_designation.desig_id')
            ->get();
        // Return the timetable entries for the specified teacher ID on the current day
        return response()->json(['user_data' => $users]);
    }

    public function get_biometric(Request $request)
    {

        // Fetch the user by userId, checking for null case
        $userId = $request->userId;
        $biometric = $request->biometric;

        $user = User::where('user_disabled', 0)
            ->where('user_type', '!=', 'Master')
            ->where('user_id', $userId)
            ->first();

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update user's fingerprint with biometric data
        $user->user_fingerprint = $biometric;

        // Save the updated user data
        $user->save();

        // Return success response
        return response()->json(['message' => 'Saved successfully.'], 200);
    }

    public function post_attendance(Request $request)
    {
        // Fetch the user by userId, checking for null case
        $userId = $request->userId;
        $time = $request->time;
        $date = $request->date;
        $machine = $request->machine_id;
        $branchId = $request->branchId;

        // Fetch the user from the database
        $user = User::where('user_disabled', 0)
            ->where('user_type', '!=', 'Master')
            ->where('user_id', $userId)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'User not found or disabled.'], 404);
        }

        // Check if attendance already exists for this user and date
        $existingAttendance = MarkTeacherAttendanceModel::where('la_emp_id', $userId)
            ->where('la_date', $date)
            ->where('la_list_status', 2)
            ->first();

        if ($existingAttendance) {
            // If attendance for the same date exists, update the la_timeOut field
            $existingAttendance->la_timeOut = $time;
            $existingAttendance->la_updatedby = $machine;
            $existingAttendance->la_update_datetime = Carbon::now();
            $existingAttendance->save();

            return response()->json(['message' => 'Time out updated successfully.'], 200);
        } else {
            // If no attendance record exists, create a new one
            $lecturer_attendance = new MarkTeacherAttendanceModel();
            $lecturer_attendance->la_clg_id = $user->user_clg_id;
            $lecturer_attendance->la_branch_id = $branchId;
            $lecturer_attendance->la_department_id = $user->user_department_id;
            $lecturer_attendance->la_emp_id = $userId;
            $lecturer_attendance->la_attendance = 'P';
            $lecturer_attendance->la_list_status = 2;
            $lecturer_attendance->la_createdby = $machine;
            $lecturer_attendance->la_machine_id = $machine;
            $lecturer_attendance->la_year_id = $this->getYearEndId();
            $lecturer_attendance->la_created_datetime = Carbon::now();
            $lecturer_attendance->la_date = $date;
            $lecturer_attendance->la_timeIn = $time;
            $lecturer_attendance->save();

            return response()->json(['message' => 'Attendance saved successfully.'], 200);
        }
    }

    public function store_time(Request $request)
    {

//        $user = Auth::user();
//        $dateString = $request->lat_date;
//
//        // Convert the date string to a UNIX timestamp
//        $timestamp = strtotime($dateString);

        $currentDate = Carbon::now()->format('Y-m-d');
        // dd($currentDate);
        $teacherId = $request->teacher_id;
        $branch_id = $request->branchId;//Session::get('branch_id');
        $user = User::where('user_id', $request->userId)->first();
        $dep_id = User::where('user_id', $teacherId)->leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'financials_users.user_department_id')->select('financials_users.user_id', 'financials_departments.dep_title', 'financials_departments.dep_id')->first();
        // dd($dep_id);

        // Retrieve teacher load information for the given teacher
        $load = TeacherLoadModel::where('tl_teacher_id', $teacherId)
            ->where('tl_branch_id', $branch_id)
            ->where('tl_clg_id', $user->user_clg_id)
            ->first();
        // dd($load);
        if ($load == null) {
            // Redirect back with a message
            return redirect()->back()->with('success', 'Please Enter Teacher Load First');
        }
        $data = $request->all();
//        return response()->json(['teachers' => $data,'currentDate' => $currentDate,'teacherId' => $teacherId,'load' => $load,'dep_id' => $dep_id]);
        // Iterate over each teacher
        foreach ($data['teachers'] as $teacher) {
            // Apply your logic for each teacher here

            // Retrieve data for this row
            $teacherId = $teacher['teacher_id'];
            $classId = $teacher['class_id'];
            $sectionId = $teacher['section_id'];
            $semesterId = $teacher['semester_id'];
            $subjectId = $teacher['subject_id'];
            $attendance = $teacher['attendance'];
            $time = $teacher['time'];
            $leaveRemarks = $teacher['leave_remarks'];

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

            DB::transaction(function () use ($request, $user, $currentDate, $load, $dep_id, $teacherData, $branch_id) {
                if ($teacherData['attendance'] == 'M') {
                    $lecturer_attendance = new MarkTeacherAttendanceModel();
                    $lecturer_attendance->la_clg_id = $user->user_clg_id;
                    $lecturer_attendance->la_branch_id = $branch_id;
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
                } else {
                    if ($teacherData['check_entry'] == 0 && $load->tl_attendance_load !== 0) {
                        // dump(1);
                        // Save data in MarkTeacherAttendanceModel
                        $lecturer_attendance = new MarkTeacherAttendanceModel();
                        $lecturer_attendance->la_clg_id = $user->user_clg_id;
                        $lecturer_attendance->la_branch_id = $branch_id;
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
                        $lecturer_attendance_items->lai_branch_id = $branch_id;
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
                            $lecturer_attendance_items->lai_branch_id = $branch_id;
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
                            $lecturer_attendance_items->lai_branch_id = $branch_id;
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
                            $lecturer_attendance_items->lai_branch_id = $branch_id;
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
                        $lecturer_attendance->la_branch_id = $branch_id;
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
                            $lecturer_attendance->la_branch_id = $branch_id;
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
                        $lecturer_attendance->la_branch_id = $branch_id;
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
        return response()->json(['message' => 'Saved Successfully.']);
    }

    public function schedule(Request $request)
    {
        $user = Auth::user();
        $branchId = $request->branchId;
        $teacherId = $user->user_id;

        $time_table = TimeTableModel::where('tm_branch_id', $branchId)
            ->where('tm_disable_enable', 1)
            ->get();

        if ($time_table->isNotEmpty()) {
            $formattedData = [];

            // Loop through each timetable entry
            foreach ($time_table as $row) {
                // Fetch class, semester, and section details
                $class = Classes::where('class_id', $row['tm_class_id'])->first();
                $semester = Semester::where('semester_id', $row['tm_semester_id'])->first();
                $section = CreateSectionModel::where('cs_id', $row['tm_section_id'])->first();

                if (!empty($row->tm_timetable)) {
                    $tmTimetable = json_decode($row->tm_timetable, true);

                    // Loop through each day's timetable
                    foreach ($tmTimetable as $dayData) {
                        $day = $dayData['day'];

                        // Initialize the day's entry if not already initialized
                        if (!isset($formattedData[$day])) {
                            $formattedData[$day] = [
                                'day' => $day,
                                'start_time' => [],
                                'end_time' => [],
                                'subject_name' => [],
                                'class_name' => [],
                                'section_name' => [],
                                'semester_name' => [],
                            ];
                        }

                        foreach ($dayData['items'] as $item) {
                            // Check if the item belongs to the specified teacher
                            if ($item['teacher_id'] == $teacherId) {
                                // Fetch subject and teacher data
                                $subject = Subject::find($item['subject_id']);

                                // Add data to the day's arrays
                                $formattedData[$day]['start_time'][] = $item['start_time'] ?? '';
                                $formattedData[$day]['end_time'][] = $item['end_time'] ?? '';
                                $formattedData[$day]['subject_name'][] = $subject ? $subject->subject_name : '';
                                $formattedData[$day]['class_name'][] = $class->class_name ?? '';
                                $formattedData[$day]['section_name'][] = $section->cs_name ?? '';
                                $formattedData[$day]['semester_name'][] = $semester->semester_name ?? '';
                            }
                        }
                    }
                }
            }

            // Format the data into the required JSON structure
            $result = [];
            foreach ($formattedData as $day => $data) {
                $result[] = $data;
            }

            return response()->json(['schedule' => $result]);
        } else {
            return response()->json(['message' => 'No Time Table Issued']);
        }
    }

    public function attendance(Request $request)
    {
        $user = Auth::user();
        $branchId = $request->branchId;
        $year = $request->year;
        $month = $request->month;

        // Get the total number of days in the given month
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        // If it's the current month, adjust the total days to the current date
        if ($month == Carbon::now()->month && $year == Carbon::now()->year) {
            $daysInMonth = Carbon::now()->day;
        }

        // Query to count attendance statuses
        $attendanceCounts = MarkTeacherAttendanceModel::where('la_clg_id', $user->user_clg_id)
            ->where('la_branch_id', $branchId)
            ->where('la_emp_id', $user->user_id)
            ->whereMonth('la_date', $month)
            ->whereYear('la_date', $year)
            ->selectRaw('
            COUNT(CASE WHEN la_attendance = "S.L" THEN 1 END) AS sl_count,
            COUNT(CASE WHEN la_attendance = "P" THEN 1 END) AS p_count,
            COUNT(CASE WHEN la_attendance = "A" THEN 1 END) AS a_count,
            COUNT(CASE WHEN la_attendance = "M" THEN 1 END) AS m_count,
            COUNT(CASE WHEN la_attendance = "L" THEN 1 END) AS l_count
        ')
            ->first();

        // Calculate raw percentages
        $slRawPercentage = ($attendanceCounts->sl_count / $daysInMonth) * 100;
        $pRawPercentage = ($attendanceCounts->p_count / $daysInMonth) * 100;
        $aRawPercentage = ($attendanceCounts->a_count / $daysInMonth) * 100;
        $mRawPercentage = ($attendanceCounts->m_count / $daysInMonth) * 100;
        $lRawPercentage = ($attendanceCounts->l_count / $daysInMonth) * 100;

        // Calculate the sum of the raw percentages
        $totalRawPercentage = $slRawPercentage + $pRawPercentage + $aRawPercentage + $mRawPercentage + $lRawPercentage;

        // Adjust each percentage to make the total equal to 100%
        if ($totalRawPercentage > 0) {
            $slPercentage = number_format(($slRawPercentage / $totalRawPercentage) * 100, 2);
            $pPercentage = number_format(($pRawPercentage / $totalRawPercentage) * 100, 2);
            $aPercentage = number_format(($aRawPercentage / $totalRawPercentage) * 100, 2);
            $mPercentage = number_format(($mRawPercentage / $totalRawPercentage) * 100, 2);
            $lPercentage = number_format(($lRawPercentage / $totalRawPercentage) * 100, 2);
        } else {
            $slPercentage = $pPercentage = $aPercentage = $mPercentage = $lPercentage = 0;
        }

        return response()->json([
            'count' => $attendanceCounts,
            'percentages' => [
                'sl_percentage' => $slPercentage,
                'p_percentage' => $pPercentage,
                'a_percentage' => $aPercentage,
                'm_percentage' => $mPercentage,
                'l_percentage' => $lPercentage,
            ]
        ]);

    }
}
