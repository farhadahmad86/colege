<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\User;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeightageController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $allteachers = User::where('user_clg_id', $user->user_clg_id)
        ->where('user_mark', 1)
        ->where(function ($query) use ($branch_id) {
            $query->where('user_branch_id', $branch_id)
                ->orWhereRaw("FIND_IN_SET($branch_id, user_branch_id)");
        })
        ->where('user_type', '!=', 'master')
        ->get();
        // dd($allteachers);

        return view('collegeViews.Weightage.add_weightage', compact('allteachers'));
    }
    public function store(Request $request)
    {
        dd($request->all());
        $user = Auth::user();
        $branch_id = Session::get('branch_id');

        $allteachers = User::where('user_clg_id', $user->user_clg_id)
            ->where('user_mark', '=', 1)
            ->where('user_branch_id', $branch_id)
            ->where('user_type', '!=', 'master')
            ->get();
        // dd($allteachers);

        return view('collegeViews.Weightage.add_weightage', compact('allteachers'));
    }
}
