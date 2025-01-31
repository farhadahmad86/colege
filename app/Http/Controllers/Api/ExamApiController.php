<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\College\ClassTimetableItem;
use App\Models\College\ExamModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class ExamApiController extends Controller
{
    public function teacherExam(Request $request)
    {
        $teacher_id = $request->teacher_id;
        $branch_id = $request->branch_id;
        $year_id = $this->getYearEndId();
        $classes_id = $this->teacher_classes($teacher_id,$branch_id);
        $exams = ExamModel::where(function ($query) use ($classes_id, $year_id) {
            foreach ($classes_id as $classId) {
                $query->orWhereRaw("FIND_IN_SET(?, exam_class_id)", [$classId->tm_class_id]);
            }
        })
            ->where('exam_year_id', $year_id)
            ->orderBy('exam_id', 'DESC')
            ->get();
        return response()->json(['exams' => $exams,'classesIds' => $classes_id]);
    }

    public function teacherSubject(Request $request)
    {
        $user = Auth::user();
        $teacher_subjects = ClassTimetableItem::where('tmi_teacher_id', $user->user_id)
            ->where('tmi_branch_id', Session::get('branch_id'))->where('tmi_tm_id', $request->tm_id)->get();
        return response()->json(['teacher_subjects' => $teacher_subjects]);
    }

    public function teacher_classes($teacher_id,$branch_id)
    {
        //This is for Teacher Classes
        $teacher_classes = ClassTimetableItem::where('tmi_teacher_id', $teacher_id)
            ->where('tmi_branch_id', $branch_id)
            ->leftJoin('class_timetable', 'class_timetable.tm_id', '=', 'class_timetable_item.tmi_tm_id')
            ->groupBy('class_timetable.tm_class_id')
            ->select('class_timetable.tm_id', 'class_timetable.tm_class_id', 'class_timetable.tm_section_id')
            ->get();
        return $teacher_classes;
    }

    public function exam_classes(Request $request)
    {
//        $exams = ExamModel::where(function ($query) use ($classes_id, $year_id) {
//            foreach ($classes_id as $classId) {
//                $query->orWhereRaw("FIND_IN_SET(?, exam_class_id)", [$classId->tm_class_id]);
//            }
//        })
    }
}
