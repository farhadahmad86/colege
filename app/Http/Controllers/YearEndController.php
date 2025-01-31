<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PackagesModel;
use App\Models\YearEndModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YearEndController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_type == 'Master') {
            $search_year = '';
            $datas = YearEndModel::orderBy('ye_id', 'DESC')->get();
            return view('year_end.index', compact('datas', 'search_year'));
        } else {
            return redirect()->route('home')->with('fail', 'You are not eligible person');
        }
    }

    public function create()
    {
        if (Auth::user()->user_type == 'Master') {
            return view('year_end.create');
        } else {
            return redirect()->route('home')->with('fail', 'You are not eligible person');
        }
    }

    public function store(Request $request)
    {
        $start = date('Y-m-d', strtotime($request->from));
        $end = date('Y-m-d', strtotime($request->to));

        $year_end = new YearEndModel();
        $year_end->ye_title = $request->title;
        $year_end->ye_from = $start;
        $year_end->ye_to = $end;
        $year_end->save();

        return redirect()->route('year_end.index')->with('success', 'Saved Successfully');
    }

}
