<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\College\MarkExamController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SaveImageController;
use App\Http\Requests\LoginRequest;
use App\Models\BalancesModel;
use App\Models\College\AnnouncementModel;
use App\Models\College\Branch;
use App\Models\College\ClassTimetableItem;
use App\Models\College\College;
use App\Models\College\ExamModel;
use App\Models\College\FeeVoucherModel;
use App\Models\College\Group;
use App\Models\College\GroupItems;
use App\Models\College\MarkExamModel;
use App\Models\College\NewGroupsModel;
use App\Models\College\Student;
use App\Models\College\Subject;
use App\Models\College\TimeTableModel;
use App\Models\CompanyInfoModel;
use App\Models\DesignationModel;
use App\Models\StudentAttendanceModel;
use App\Models\Utility;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class AuthController extends Controller
{
    public function student_login(LoginRequest $request)
    {
        $credentials = $request->validated();

        /** @var Student $student */
        $student = null;

        // Check login with registration number
        if (filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            // If the entered username is an email, try to find the student by email
            $student = Student::where('email', $credentials['email'])->first();
        } else {
            // If the entered username is not an email, try to find the student by registration number
            $student = Student::where('registration_no', $credentials['email'])->first();
        }

        // If no student is found, authentication fails
        if (!$student) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Authenticate the student
        if (Auth::guard('student')->attempt(['registration_no' => $student->registration_no, 'password' => $credentials['password']])) {
            $student = Auth::guard('student')->user();

            $data = DB::table('students')
                ->where('id', '=', $student->id)
                ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
                ->leftJoin('programs', 'programs.program_id', '=', 'classes.class_program_id')
                ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
                ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'students.group_id')
                ->leftJoin('branches', 'branches.branch_id', '=', 'students.branch_id')
                ->select('students.*', 'classes.class_name as class', 'programs.program_name as program', 'create_section.cs_name as section', 'new_groups.ng_name as group', 'branches.branch_name as campus')
                ->first();

            // Create an access token or return a token as needed
            $token = $student->createToken('main')->plainTextToken;

            $exams = ExamModel::whereRaw("FIND_IN_SET($student->class_id, exam_class_id)")->orderBy('exam_id', 'DESC')->get();
            $latestExam = $this->LatestExamPer($student);
            $currentDayName = Carbon::now()->format('l');
            $time_table_data = [];
            $time_table = TimeTableModel::where('tm_branch_id', $student->branch_id)
                ->where('tm_class_id', $student->class_id)
                ->where('tm_section_id', $student->section_id)
                ->first();
            if (!empty($time_table)) {
                $time_table_json = json_decode($time_table->tm_timetable, true);

                foreach ($time_table_json as $time_data) {
                    if ($currentDayName == $time_data['day']) {
                        foreach ($time_data['items'] as $item) {
                            $subject_name = Subject::where('subject_id', $item['subject_id'])
                                ->pluck('subject_name')
                                ->first();
                            $teacher_name = User::where('user_id', $item['teacher_id'])
                                ->pluck('user_name')
                                ->first();
                            $time_table_data[] = [
                                'time' => $item['start_time'] . ' - ' . $item['end_time'],
                                'subject' => $subject_name,
                                'teacher' => $teacher_name,
                            ];
                        }
                        //                        return response()->json(['data' => $time_data, 'day' => $data['day']]);
                    }
                }
            }

            $unpaid_amount = FeeVoucherModel::where('fv_std_id', '=', $student->id)
                ->where('fv_status_update', '=', 0)
                ->sum('fv_total_amount');

            $paid_amount = FeeVoucherModel::where('fv_std_id', '=', $student->id)
                ->where('fv_status_update', '=', 1)
                ->sum('fv_total_amount');

            return response()->json(['message' => 'Login successful', 'user' => $data, 'token' => $token, 'exams' => $exams, 'time_table' => $time_table_data, 'current_day' => $currentDayName, 'unpaid_amount' => $unpaid_amount, 'paid_amount' => $paid_amount, 'latestExam' => $latestExam]);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function staff_login(LoginRequest $request)
    {
        $credentials = $request->validated();

        /** @var User $user */
        $user = null;
        if (filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            // If the entered username is an email, try to find the student by email
            $user = User::where('user_email', $credentials['email'])->first();
        } else {
            // If the entered username is not an email, try to find the student by registration number
            $user = User::where('user_username', $credentials['email'])->first();
        }

        // If no student is found, authentication fails
        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        if (Auth::attempt(['user_username' => $user->user_username, 'password' => $credentials['password']])) {
            // Authentication passed, return the user
            DB::table('personal_access_tokens')->where('tokenable_id', $user->user_id)->delete();
            $token = $user->createToken('main')->plainTextToken;

            if ($user) {
                // Assuming $user->user_branch_id contains a comma-separated list
                $campuses = Branch::whereIn('branch_id', explode(',', $user->user_branch_id))->select('branch_id', 'branch_name', 'branch_no')->get();
                if ($user->user_id != 1) {
                    Session::put(['branch_id' => $campuses[0]->branch_id, 'branch_name' => $campuses[0]->branch_name, 'branch_no' => $campuses[0]->branch_no]);
                }

                $designation = DesignationModel::where('desig_id', $user->user_designation)
                    ->select('desig_id', 'desig_name')
                    ->get();

            }
            if ($user->user_status == 'Machine') {
                return response()->json([
                    'message' => 'Login successful',
                    'user' => $user,
                    'token' => $token
                ], 200);
            }
//            if ($user->user_fingure_status != 1) {
//                return response()->json([
//                    'message' => 'Invalid user Login successful',
//                    'user' => '',
//                    'token' => ''
//                ], 200);
//            }
            return response()->json([
                'message' => 'Login successful',
                'branch_id' => $campuses[0]->branch_id,
                'user' => $user,
                'token' => $token,
                'campuses' => $campuses,
                'designation' => $designation,
            ], 200);

        } else {
            return response()->json(['error' => 'Invalid credentials: Password mismatch'], 401);
        }
    }

    public function update_device_token(Request $request)
    {
        $student_id = Auth::user()->id;
        $student = Student::findOrfail($student_id);
        $student->device_id = $request->device_token;
        $student->save();
        return response()->json(['success' => 'Device Token Update Successfully'], 200);
    }

    public function notification_list(Request $request)
    {
        $branchId = $request->branch_id;
        $class_id = $request->class_id;
        $announcements = AnnouncementModel::where('an_branch_id', $branchId)->where('an_class_id', $class_id)->orderBy('an_id', 'DESC')->select('an_title', 'an_description', 'an_created_at')->get();
        return response()->json(['data' => $announcements], 200);

        return response()->json($announcements, 200);
    }

    public function student_result(Request $request)
    {
        $student = Auth::user();

        $exam_marks = MarkExamModel::where('me_branch_id', $student->branch_id)
            ->where('me_exam_id', $request->exam_id)
            ->where('me_class_id', $student->class_id)
            ->where('me_section_id', $student->section_id)
            ->where('me_ng_id', $student->group_id)
            ->get();
        $index_number = '';
        $obtain_number = '';
        $percentage = '';
        $grade = '';
        $data = [];

        foreach ($exam_marks as $marks) {
            $subject_name = Subject::where('subject_id', $marks->me_subject_id)
                ->pluck('subject_name')
                ->first();
            $studentsArray = json_decode($marks->me_students, true);
            $obtainArray = json_decode($marks->me_obtain_marks, true);
            $percentageArray = json_decode($marks->me_precentage, true);
            $gradeArray = json_decode($marks->me_grade, true);
            foreach ($studentsArray as $index => $item) {
                if ($request->user_id == $item) {
                    $index_number = $index;
                }
            }

            foreach ($obtainArray as $index => $obtain_marks) {
                if ($index_number == $index) {
                    $obtain_number = $obtain_marks;
                }
            }

            foreach ($percentageArray as $index => $get_percentage) {
                if ($index_number == $index) {
                    $percentage = $get_percentage;
                }
            }
            foreach ($gradeArray as $index => $grad) {
                if ($index_number == $index) {
                    $grade = $grad;
                }
            }

            $data[] = [
                'subject' => $subject_name,
                'obtain_marks' => $obtain_number,
                'percentage' => $percentage,
                'grade' => $grade,
                'totalMarks' => $marks->me_total_marks,
            ];
        }
        $get_position = new MarkExamController();

        $student_id = $student->id;
        $group_id = $student->group_id;
        $class_id = $student->class_id;
        $section_id = $student->section_id;
        $exam_id = $request->exam_id;
        $college_id = $student->clg_id;
        $branch_id = $student->branch_id;
        $type = $request->type;
        // $abc = $type .'-'. $request->type;
        // return $abc;
        //        $section_result = $get_position->section_wise_result($exam_id, $class_id, $section_id, $group_id, $college_id);
        //        $branch_result = $get_position->branch_wise_result($exam_id, $class_id, $group_id, $college_id, $branch_id);
        $exams_names = ExamModel::where('exam_id', $exam_id)
            ->orderBy('exam_id', 'DESC')
            ->get();

        $branch = Branch::where('branch_clg_id', $college_id)
            ->where('branch_id', $branch_id)
            ->pluck('branch_name')
            ->first();
        $class_marks = MarkExamModel::where('me_clg_id', $college_id)
            ->where('me_exam_id', $exam_id)
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'marks_exam.me_subject_id')
            ->where('me_class_id', $class_id)
            ->where('me_section_id', $section_id)
            ->where('me_ng_id', $group_id)
            ->orderBy('me_exam_id', 'desc')
            ->get();

        $subject_marks = MarkExamModel::where('me_clg_id', $college_id)
            ->where('me_exam_id', $exam_id)
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'marks_exam.me_subject_id')
            ->where('me_class_id', $class_id)
            ->where('me_section_id', $section_id)
            ->where('me_ng_id', $group_id)
            ->orderBy('me_exam_id', 'desc')
            ->groupBy('me_subject_id')
            ->get();

        $subjects = GroupItems::where('grpi_class_id', $class_id)
            ->where('grpi_section_id', $section_id)
            ->where('grpi_gn_id', $group_id)
            ->leftjoin('subjects', 'subjects.subject_id', '=', 'group_items.grpi_subject_id')
            ->groupBy('grpi_subject_id')
            ->select('subjects.subject_id', 'subjects.subject_name')
            ->get();

        $college_result0 = '';
        // $branch_result0 = [];
        $section_result0 = [];
        // $college_result1 = '';
        // $branch_result1 = [];
        // $section_result1 = [];
        // $college_result2 = '';
        // $branch_result2 = [];
        // $section_result2 = [];
        $get_position = new MarkExamController();

        $college_result0 = $get_position->college_wise_result($exam_id, $class_id, $group_id, $college_id);
        foreach ($college_result0 as $result) {
            $filteredData = Arr::only($result, ['branch_id']);
            $foundItem = $filteredData['branch_id'] == $branch_id ? $result : null;

            $filteredSection = Arr::only($result, ['section_id']);
            $sectionItem = $filteredSection['section_id'] == $section_id ? $result : null;

            // Check if $foundItem is set before using it
            // if ($foundItem) {
            //     $branch_result0[] = [
            //         "id" => $result['id'],
            //         "obtain" => $result['obtain'],
            //         "total_marks" => $result['total_marks'],
            //         "per" => $result['per'],
            //         "branch_id" => $result['branch_id'],
            //         "section_id" => $result['section_id'],
            //         "group_id" => $result['group_id'],
            //     ];
            // }

            // Check if $sectionItem is set before using it
            if ($sectionItem) {
                $section_result0[] = [
                    'id' => $result['id'],
                    'obtain' => $result['obtain'],
                    'total_marks' => $result['total_marks'],
                    'per' => $result['per'],
                    'branch_id' => $result['branch_id'],
                    'section_id' => $result['section_id'],
                    'group_id' => $result['group_id'],
                ];
            }
        }

        // $clg_0_position = [];
        // $current_position = 0;
        // $previous_percentage = null;
        // foreach ($college_result0 as $student) {
        //     $student_id = $student['id'];
        //     $current_percentage = $student['per'];
        //     if ($current_percentage !== $previous_percentage) {
        //     $current_position++;
        //     }
        //     $clg_0_position[$student_id] = $current_position;
        //     $previous_percentage = $current_percentage;
        //     }

        //             // $bra0 = json_decode($bra0_positions);
        // $bra_0_position = [];
        // $current_position = 0;
        // $previous_percentage = null;
        // foreach ($branch_result0 as $student) {
        //     $student_id = $student['id'];
        // $current_percentage = $student['per'];
        // if ($current_percentage !== $previous_percentage) {
        // $current_position++;
        // }
        // $bra_0_position[$student_id] = $current_position;
        // $previous_percentage = $current_percentage;
        // }

        // $sec0 = json_decode($sec0_positions);
        $sec_0_position = [];
        $current_position = 0;
        $previous_percentage = null;
        foreach ($section_result0 as $student) {
            $student_id = $student['id'];
            $current_percentage = $student['per'];
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
            $sec_0_position[$student_id] = $current_position;
            $previous_percentage = $current_percentage;
        }
        $r1 = '';
        // $r2 = '';
        // $r3 = '';
        // foreach ($clg_0_position as $key => $value){
        //     if ($key == $student_id){
        //         $r1 = $value;
        //     }

        // }
        // foreach ($bra_0_position as $key => $value){
        //     if ($key == $student_id){
        //         $r2 = $value;
        //     }

        // }
        foreach ($sec_0_position as $key => $value) {
            if ($key == $student_id) {
                $r1 = $value;
            }
        }
        return response()->json(
            [
                'r1' => $r1,
                'data' => $data,
            ],
            200,
        );
    }

    public function time_table(Request $request)
    {
        $student = Auth::user();
//        Student::where('id', $request->user_id)->first();
        // dd($student);
        $currentDayName = Carbon::now()->format('l');
        $data = [];
        $time_table = TimeTableModel::where('tm_branch_id', $student->branch_id)
            ->where('tm_class_id', $student->class_id)
            ->where('tm_section_id', $student->section_id)
            ->where('tm_disable_enable', 1)
            ->first();

        if (!empty($time_table)) {
            $time_table_json = json_decode($time_table->tm_timetable, true);

            // Initialize an array to store formatted data for all days
            $formattedData = [];

            // Iterate through each day and update null values
            foreach ($time_table_json as $day) {
                // Initialize arrays for each property
                $start_time = [];
                $end_time = [];
                $teacher_name = [];
                $subject_name = [];

                foreach ($day['items'] as $item) {
                    // Fetch subject name based on subject_id
                    $subject = Subject::find($item['subject_id']);
                    $subject_name[] = $subject ? $subject->subject_name : '';

                    // Fetch teacher name based on teacher_id
                    $teacher = User::find($item['teacher_id']);
                    $teacher_name[] = $teacher ? $teacher->user_name : '';

                    // Add data to arrays
                    $start_time[] = $item['start_time'] ?? '';
                    $end_time[] = $item['end_time'] ?? '';
                }

                // Add object for the current day to the array of formatted data
                $formattedData[] = [
                    'day' => $day['day'],
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'teacher_name' => $teacher_name,
                    'subject_name' => $subject_name,
                ];
            }

            return response()->json(['data' => $formattedData]);
        } else {
            return response()->json(['message' => 'No Time Table Issued']);
        }
    }

    function upload_image(Request $request)
    {
        $user_clg_id = 1;
        $uniqueId = Utility::uniqidReal() . mt_rand();
        $student = Auth::user();
//            Student::where('id', $request->id)->first();

        $save_image = new SaveImageController();

        $common_path = config('global_variables.common_path');
        $inquiry_path = config('global_variables.inquiry_path');

        // // Handle Image
        $fileNameToStore = $save_image->SaveImage($request, 'pimage', $request->folder, $inquiry_path . '_' . $user_clg_id . '_' . $request->branch, $request->fullname . $uniqueId . $request->username);
        if (!empty($request->pimage)) {
            $student->profile_pic = $common_path . $fileNameToStore;
        } else {
            $student->profile_pic = $fileNameToStore;
        }

        $student->save();

        return response()->json(['msg' => 'Image upload successfully', 'student' => $student], 200);
    }

    public function attendance_calculation(Request $request)
    {
        $user = Auth::user();//Student::where('id', $request->user_id)->first();

        if (!empty($user)) {
            $attendances = StudentAttendanceModel::where('std_att_class_id', $user->class_id)
                ->where('std_att_section_id', $user->section_id)
                ->whereBetween('std_att_date', [Carbon::now()->subMonth(3), Carbon::now()])
                ->get();
            $present = 0; // Initialize an array to store counts for each month
            $Leave = 0; // Initialize an array to store counts for each month
            $absent = 0; // Initialize an array to store counts for each month
            $notMark = 0; // Initialize an array to store counts for each month
            // $date = '';
            foreach ($attendances as $items) {
                $date = $items->std_att_date;
                $att = json_decode($items->std_attendance, true);
                $monthName = date('M', strtotime($items->std_att_date));
                foreach ($att as $attendance) {
                    if ($attendance['student_id'] == $user->id) {
                        if ($attendance['is_present'] == 'P') {
                            $present++;
                        } elseif ($attendance['is_present'] == 'L') {
                            $Leave++;
                        } elseif ($attendance['is_present'] == 'A') {
                            $absent++;
                        } else{
                            $notMark++;
                        }
                    }
                }
            }
            return response()->json(['presents' => $present, 'Leave' => $Leave, 'absent' => $absent, 'notMark' => $notMark], 200);
        } else {
            return response()->json(['presents' => 'User Not Found'], 400);
        }
    }

    public function month_attendance(Request $request)
    {
        $user = Auth::user();//Student::where('id', $request->user_id)->first();
        if (!empty($user)) {
            $attendances = StudentAttendanceModel::where('std_att_class_id', $user->class_id)
                ->where('std_att_section_id', $user->section_id)
                ->whereMonth('std_att_date', $request->month)
                ->whereYear('std_att_date', $request->year)
                ->get();
            $present = 0;
            $absent = 0;
            $leave = 0;
            $presents = [];
            //  return $attendances;
            foreach ($attendances as $items) {
                $att = json_decode($items->std_attendance, true);
                $date = $items->std_att_date;

                // $monthName = date('M', strtotime($items->std_att_date));
                if (!isset($presents[$date])) {
                    $presents[$date] = '';
                }
                foreach ($att as $attendance) {
                    if ($attendance['student_id'] == $user->id && $attendance['is_present'] == 'P') {
                        $presents[$date] = 'P';
                    } elseif ($attendance['student_id'] == $user->id && $attendance['is_present'] == 'L') {
                        $presents[$date] = 'L';
                    } elseif ($attendance['student_id'] == $user->id && $attendance['is_present'] == 'A') {
                        $presents[$date] = 'A';
                    }
                }
            }

            return response()->json(['present' => $presents], 200);
        } else {
            return response()->json(['presents' => 'User Not Found'], 400);
        }
    }

    public function course_outline(Request $request)
    {
        $user = Auth::user();

//        $user = Student::where('id', $auth->id)->first();
//        $user = Student::where('id', $request->user_id)->first();
//        return $user;
        $group_subject = Group::where('group_name', $user->group_id)->where('group_discipline', 'A')->pluck('group_semester_id')->first();
        $query = DB::table('course_outlines')
            ->where('co_subject_id', $request->subject_id)
            ->where('co_group_id', $group_subject)
            ->leftJoin('financials_users as users', 'users.user_id', '=', 'course_outlines.co_created_by')
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'course_outlines.co_subject_id')
            ->get();
        return response()->json(['outlines' => $query], 200);
        // }else{
        //     return response()->json(['outlines' => 'User Not Found'],400);
        // }
    }

    public function subjects(Request $request)
    {
        $user = Auth::user();//Student::where('id', $request->user_id)->first();
        $group = Group::where('group_name', $user->group_id)
            ->where('group_section_id', $user->section_id)
            ->where('group_branch_id', $request->branch_id)
            ->pluck('group_subject_id')
            ->first();
        $subjectIds = explode(',', $group);

        // if (!$group) {
        //     return response()->json(['error' => 'Group not found'], 404);
        // }

        // // Check if group_subject_id is not null
        // if (!$group->group_subject_id) {
        //     return response()->json(['error' => 'No subjects found for the group'], 404);
        // }

        $subjects = Subject::whereIn('subject_id', $subjectIds)->get();
        return response()->json(['subjects' => $subjects], 200);
    }

    public function LatestExamPer($student)
    {
        $examID = ExamModel::whereRaw("FIND_IN_SET($student->class_id, exam_class_id)")->orderBy('exam_created_at', 'desc')->first();
        $markExam = MarkExamModel::
        where('me_exam_id', $examID->exam_id)
            ->where('me_class_id', $student->class_id)
            ->where('me_section_id', $student->section_id)
            ->where('me_ng_id', $student->group_id)->get();
        $totalObtain = 0;
        $totalMarks = 0;
        foreach ($markExam as $marks) {
            $students = json_decode($marks->me_students, true);
            $obtainMarks = json_decode($marks->me_obtain_marks, true);

            if (in_array($student->id, $students)) {
                $studentIndex = array_search($student->id, $students);
                $obtain_number = $obtainMarks[$studentIndex] ?? 0;
                $totalObtain += $obtain_number;
            }

            $totalMarks += $marks->me_total_marks;
        }

        $percentageExam = $totalMarks > 0 ? ($totalObtain * 100) / $totalMarks : 0;
        $data = [];
        $data [] = ['percentage' => number_format($percentageExam, 2),
            'examName' => $examID->exam_name];

        return $data;

    }

    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function ledger($account_id)
    {
        $ledger = DB::table('financials_balances_1')->where('bal_account_id', $account_id)->select('bal_transaction_type', 'bal_remarks', 'bal_dr', 'bal_cr')->get();
        return response()->json(['ledger' => $ledger], 200);
    }

    public function comp_info()
    {
        $user = Auth::user();
        $comp_info = CompanyInfoModel::where('ci_clg_id', $user->user_clg_id)->first();
        return response()->json(['comp_info'=> $comp_info]);
    }
}
