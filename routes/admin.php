<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\College\CollegeController;

Route::group([
    'namespace' => 'Auth',
], function () {
    // Authentication Routes...
    Route::get('login', [LoginController::class,'showLoginForm'])->name('login_page');
//    Route::get('loginss', 'Admin/Auth/LoginController@showLoginForm')->name('login_page');
    Route::post('login', [LoginController::class,'login'])->name('login');
    Route::post('logout', [LoginController::class,'logout'])->name('logout');
});

Route::group([
    'middleware' => [
        'auth:admin',
    ],
], function () {
    Route::get('/', 'AdminController@index')->name('dashboard');
    Route::get('home', 'AdminController@index')->name('dashboard');
    Route::get('dashboard', 'AdminController@index')->name('dashboard');
    Route::get('list', 'AdminController@lists')->name('list');


});
