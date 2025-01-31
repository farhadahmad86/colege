<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student');

        View::share('nav', 'dashboard'); //ss
    }

    public function index()
    {
        return view('student.pages.dashboard'); //ss
    }
}
