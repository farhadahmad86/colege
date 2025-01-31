<?php

use App\Http\Controllers\Master\Auth\LoginController;

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
        'auth:master',
    ],
], function () {
//    Route::get('/', 'MasterController@index')->name('dashboard');
//    Route::get('home', 'MasterController@index')->name('dashboard');
//    Route::get('dashboard', 'MasterController@index')->name('dashboard');
//    Route::get('list', 'MasterController@lists')->name('list');
});
