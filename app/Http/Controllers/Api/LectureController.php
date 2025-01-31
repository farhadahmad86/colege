<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\College\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    public function get_lecture(Request $request)
    {
        $user = Auth::user();
        $lectures = Lecture::where('lec_class_id',$request->class_id)->where('lec_subject_id',$request->subject_id)->where('lec_group_id',$user->group_id)->get();
        return response()->json(['lectures' => $lectures], 200);
    }
}
