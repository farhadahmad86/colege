<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        View::share('nav', 'dashboard'); //ss
    }

    public function index()
    {
        return view('admin.pages.dashboard'); //ss
    }
    public function lists()
    {
        $auth = Auth::user();
        dd(12,$auth);
        return view('admin.pages.dashboard'); //ss
    }
}
