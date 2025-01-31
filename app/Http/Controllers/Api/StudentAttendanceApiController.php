<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\College\AssignCoordinatorController;
use App\Http\Controllers\Controller;
use App\Models\College\AssignCoordinatorModel;
use App\Models\College\ClassTimetableItem;
use App\Models\College\ExamModel;
use App\Models\College\MarkExamModel;
use App\Models\College\Section;
use App\Models\College\Student;
use App\Models\CreateSectionModel;
use App\Models\StudentAttendanceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Carbon\Carbon;

class StudentAttendanceApiController extends Controller
{
    public function coordinator_classes(Request $request)
    {
        $user = Auth::user();
        if ($user->user_designation == 14) {
            //This is for Coordinator Classes
            $assign_sections = AssignCoordinatorModel::where("ac_coordinator_id", $user->user_id)
                ->where("ac_branch_id", $request->branch_id)->where('ac_disable_enable', '=', 1)
                ->leftJoin('classes', 'classes.class_id', '=', 'assign_coordinator.ac_class_id')
                ->select('classes.class_id', 'classes.class_name')
                ->get();
            return $assign_sections;
        }

    }

    public function coordinator_sections(Request $request)
    {
        $user = Auth::user();
        $section = AssignCoordinatorModel::where("ac_coordinator_id", $user->user_id)
            ->where("ac_branch_id", $request->branch_id)->where('ac_class_id', $request->class_id)->where('ac_disable_enable', '=', 1)->pluck('ac_section_id')->first();

        $sectionIds = explode(',', $section);
        $sections = CreateSectionModel::whereIn('cs_id', $sectionIds)
            ->whereDoesntHave('StudentAttendance', function ($query) {
                $query->whereDate('std_att_created_at', Carbon::now()->format('Y-m-d'));
            })
            ->select('cs_id', 'cs_name')
            ->get();
        return response()->json($sections);

    }

    public function section_student(Request $request)
    {
        $students = Student::where('section_id', $request->section_id)
            ->where('branch_id', $request->branch_id)
            ->whereIn('status', [1, 4])
            ->orderBy('roll_no', 'ASC')
            ->select('id', 'roll_no', 'full_name')
            ->get();
        return response()->json(['students' => $students]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $attendanceData = json_decode($request['attendance'], true);

        $attendanceRecords = [];
        foreach ($attendanceData as $studentId => $isPresent) {
            $attendanceRecords[] = [
                'student_id' => $studentId,
                'is_present' => $isPresent,
            ];
        }

// Now create the StudentAttendanceModel record
        $attendance = new StudentAttendanceModel();
        $attendance->std_att_class_id = $request['class_id'];
        $attendance->std_att_section_id = $request['section_id'];
        $attendance->std_att_branch_id = $request['branch_id'];
        $attendance->std_att_clg_id = $user->user_clg_id;  // Assuming you have $user defined
        $attendance->std_att_browser_info = $this->getBrwsrInfo();  // Assuming this method is defined in your class
        $attendance->std_att_ip_address = $this->getIp();  // Assuming this method is defined in your class
        $attendance->std_attendance = json_encode($attendanceRecords);
        $attendance->std_att_date = Carbon::now()->format('Y-m-d');
        $attendance->std_att_createdby = $user->user_id;  // Assuming you have $user defined
        $attendance->std_att_year_id = $this->getYearEndId();  // Assuming this method is defined in your class
        $attendance->save();
        return response()->json(['message' => 'Attendance marked successfully.']);
    }

    public function teacherClasses(Request $request)
    {
        $teacher = Auth::user();
        $teacherClasses = ClassTimetableItem::where('tmi_branch_id', $request->branch_id)
            ->leftJoin('class_timetable', 'class_timetable.tm_id', 'class_timetable_item.tmi_tm_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'class_timetable.tm_class_id')
            ->leftJoin('create_section', 'create_section.cs_id', 'class_timetable_item.tmi_section_id')
            ->where('tmi_teacher_id', $teacher->user_id)
            ->where('class_timetable.tm_disable_enable', 1)
            ->groupBy('class_timetable.tm_class_id')
            ->select('classes.class_id', 'classes.class_name', 'class_timetable.tm_id', 'create_section.cs_id', 'create_section.cs_name')->get();

        return response()->json(['classes' => $teacherClasses]);

    }

    public function classExams(Request $request)
    {
        $exams = ExamModel::whereRaw("FIND_IN_SET($request->class_id, exam_class_id)")->select('exam_name', 'exam_id', 'exam_start_date', 'exam_end_date')->get();
        return response()->json(['exams' => $exams]);
    }

    public function classSubjects(Request $request)
    {
        $teacher = Auth::user();
        $subjects = ClassTimetableItem::where('tmi_branch_id', $request->branch_id)
            ->where('tmi_teacher_id', $teacher->user_id)
            ->where('tmi_tm_id', $request->tm_id)
            ->where('tmi_section_id', $request->cs_id)
            ->leftJoin('subjects', 'subjects.subject_id', 'class_timetable_item.tmi_subject_id')
            ->groupBy('subjects.subject_id')
            ->select('subjects.subject_name', 'subjects.subject_id')->get();
        return response()->json(['subjects' => $subjects]);
    }

    public function examMarks(Request $request)
    {
        {
            // Fetch marks based on the criteria
            $marks = MarkExamModel::where('me_exam_id', $request->exam_id)
                ->where('me_branch_id', $request->branch_id)
                ->where('me_class_id', $request->class_id)
                ->where('me_section_id', $request->cs_id)
                ->where('me_subject_id', $request->subject_id)
                ->get();

            // Fetch students in the specified class, section, and branch
            $students = Student::where('branch_id', $request->branch_id)
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->cs_id)
                ->get()
                ->keyBy('id'); // Key students by their ID for easier lookup

            $result = [];

            foreach ($marks as $mark) {
                $stdIDS = json_decode($mark->me_students, true); // Decode student IDs
                $stdMarks = json_decode($mark->me_obtain_marks, true); // Decode marks

                foreach ($stdIDS as $index => $stdId) {
                    if (isset($students[$stdId])) { // Check if the student exists
                        $student = $students[$stdId];
                        $result[] = [
                            'student_name' => $student->full_name,
                            'marks' => $stdMarks[$index] ?? 0, // Safely handle missing marks
                            'total_marks' => $mark->me_total_marks, // Safely handle missing marks
                        ];
                    }
                }
            }

            return response()->json($result);
        }
    }
}
