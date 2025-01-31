<?php

use App\Http\Controllers\Student\Auth\LoginController;
use App\Http\Controllers\Student\StudentController;

Route::group([
    'namespace' => 'Auth',
], function () {
    // Authentication Routes...
    Route::get('login', [LoginController::class,'showLoginForm'])->name('login_page');
//    Route::get('loginss', 'Admin/Auth/LoginController@showLoginForm')->name('login_page');
    Route::post('login', [LoginController::class,'login'])->name('login');
    Route::post('logout', [LoginController::class,'logout'])->name('logout');
    Route::get('logout', [LoginController::class,'logout'])->name('logout');
});

Route::group([
    'middleware' => [
        'auth:student',
    ],
], function () {
    Route::get('/', [StudentController::class,'index'])->name('dashboard');
    Route::get('home', [StudentController::class,'index'])->name('dashboard');
    Route::get('dashboard', [StudentController::class,'index'])->name('dashboard');
    Route::get('list', [StudentController::class,'lists'])->name('list');
});
