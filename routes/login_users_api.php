<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});



Route::get('/auto_submit_db_backup', 'DatabaseBackUpController@auto_submit_db_backup')->name('auto_submit_db_backup');

Route::post('/submit_change_password_api', 'UserController@submit_change_password_Api')->name('submit_change_password_api');

///////////////////////////////////////// Survey login user android api routes ///////////////////////////////
Route::post('/authenticate_user_api', 'FineAd\Prerequisites\LoginSurveyorController@authenticate_user_api')->name('authenticate_user_api');

///////////////////////////////////////// Send data android api routes ///////////////////////////////
Route::get('/project_api', 'FineAd\Prerequisites\FineadApiController@project_api')->name('project_api');
Route::get('/company_api', 'FineAd\Prerequisites\FineadApiController@company_api')->name('company_api');
Route::get('/products_api', 'FineAd\Prerequisites\FineadApiController@products_api')->name('products_api');
Route::get('/region_api', 'FineAd\Prerequisites\FineadApiController@region_api')->name('region_api');
Route::get('/zone_api', 'FineAd\Prerequisites\FineadApiController@zone_api')->name('zone_api');
Route::get('/city_api', 'FineAd\Prerequisites\FineadApiController@city_api')->name('city_api');
Route::get('/grid_api', 'FineAd\Prerequisites\FineadApiController@grid_api')->name('grid_api');
Route::get('/franchise_api', 'FineAd\Prerequisites\FineadApiController@franchise_api')->name('franchise_api');
Route::get('/order_list_api', 'FineAd\Prerequisites\FineadApiController@order_list_api')->name('order_list_api');
Route::get('/services_api', 'FineAd\Prerequisites\FineadApiController@services_api')->name('services_api');

///////////////////////////////////////// EXECUTION API data android api routes ///////////////////////////////
Route::get('/surveyor_execution_shops_api', 'FineAd\Prerequisites\FineadApiController@surveyor_execution_shops_api')->name('surveyor_execution_shops_api');
Route::get('/surveyor_execution_images_types_api', 'FineAd\Prerequisites\FineadApiController@surveyor_execution_images_types_api')->name('surveyor_execution_images_types_api');

Route::post('/surveyor_execution_images_api', 'FineAd\Prerequisites\FineadApiController@surveyor_execution_images_api')->name('surveyor_execution_images_api');


///////////////////////////////////////// data receive Surveyor api routes ///////////////////////////////
Route::post('/surveyor_store', 'FineAd\Prerequisites\FineadSurveyorApiController@surveyor_store')->name('surveyor_store');
/// ///////////////////////////////////////// EXECUTION API data android api routes ///////////////////////////////
Route::post('/surveyor_execution_store', 'FineAd\Prerequisites\FineadSurveyorApiController@surveyor_execution_store')->name('surveyor_execution_store');
/// ///////////////////////////////////////// EXECUTION API data android api routes ///////////////////////////////
Route::post('/post_execution_api_store', 'FineAd\Prerequisites\FineadSurveyorApiController@post_execution_api_store')->name
('post_execution_api_store');

