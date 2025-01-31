<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestingController extends Controller
{
    public function test_multi_inputs(){
        return view('test_multi_inputs');
    }
}
