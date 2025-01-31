<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::get('/database', function () {
//    return \Illuminate\Support\Facades\Artisan::call('migrate:fresh  --seed');
//});


//Route::get('/', function () {
//    return view('pages.index');
//});


Route::group(['middleware' => ['auth']], function () {


    Route::group(['middleware' => ['adminOnly']], function () {
        /* Company */
        Route::get('/staff', 'FineAd\StaffController@index')->name('staff.index');
        Route::get('/staff/create', 'FineAd\StaffController@create')->name('staff.create');
        Route::post('/staff', 'FineAd\StaffController@store')->name('staff.store');
        Route::get('/staff/{staff}', 'FineAd\StaffController@show')->name('staff.show');
        Route::get('/staff/{staff}/edit', 'FineAd\StaffController@edit')->name('staff.edit');
        Route::put('/staff/{staff}', 'FineAd\StaffController@update')->name('staff.update');
        Route::delete('/staff/{staff}', 'FineAd\StaffController@destroy')->name('staff.destroy');
    });


    /* Company */
    Route::get('/companies', 'FineAd\Prerequisites\CompanyController@index')->name('companies.index');
    Route::get('/companies/create', 'FineAd\Prerequisites\CompanyController@create')->name('companies.create');
    Route::post('/companies', 'FineAd\Prerequisites\CompanyController@store')->name('companies.store');
    Route::get('/companies/{company}', 'FineAd\Prerequisites\CompanyController@show')->name('companies.show');
    Route::get('/companies/{company}/edit', 'FineAd\Prerequisites\CompanyController@edit')->name('companies.edit');
    Route::put('/companies/{company}', 'FineAd\Prerequisites\CompanyController@update')->name('companies.update');
    Route::delete('/companies/{company}', 'FineAd\Prerequisites\CompanyController@destroy')->name('companies.destroy');
    /* Api */
    Route::post('api/companies/options', 'FineAd\Prerequisites\CompanyController@apiOptions')->name('api.companies.options');


    /* Region */
    Route::get('/regions/list/{array?}/{str?}', 'FineAd\Prerequisites\RegionController@index')->name('regions.list');

    Route::post('/regions/list', 'FineAd\Prerequisites\RegionController@index')->name('regions.list');
//    Route::get('/regions', 'FineAd\Prerequisites\RegionController@index')->name('regions.index');
    Route::get('/regions/create', 'FineAd\Prerequisites\RegionController@create')->name('regions.create');
    Route::post('/region', 'FineAd\Prerequisites\RegionController@store')->name('regions.store');
    Route::get('/regions/{region}', 'FineAd\Prerequisites\RegionController@show')->name('regions.show');
    Route::get('/regions/{region}/edit', 'FineAd\Prerequisites\RegionController@edit')->name('regions.edit');
    Route::put('/regions/{region}', 'FineAd\Prerequisites\RegionController@update')->name('regions.update');
    Route::delete('/regions', 'FineAd\Prerequisites\RegionController@destroy')->name('regions.destroy');
//    Route::delete('/regions/{region}', 'FineAd\Prerequisites\RegionController@destroy')->name('regions.destroy');
    /* Api */
    Route::post('api/regions/options', 'FineAd\Prerequisites\RegionController@apiOptions')->name('api.regions.options');


    /* Zone */
    Route::get('/zones/list/{array?}/{str?}', 'FineAd\Prerequisites\ZoneController@index')->name('zones.list');

    Route::post('/zones/list', 'FineAd\Prerequisites\ZoneController@index')->name('zones.list');

//    Route::get('/zones', 'FineAd\Prerequisites\ZoneController@index')->name('zones.index');
    Route::get('/zones/create', 'FineAd\Prerequisites\ZoneController@create')->name('zones.create');
    Route::post('/zones', 'FineAd\Prerequisites\ZoneController@store')->name('zones.store');
    Route::get('/zones/{zone}', 'FineAd\Prerequisites\ZoneController@show')->name('zones.show');
    Route::get('/zones/{zone}/edit', 'FineAd\Prerequisites\ZoneController@edit')->name('zones.edit');
    Route::put('/zones/{zone}', 'FineAd\Prerequisites\ZoneController@update')->name('zones.update');
    Route::delete('/zones/', 'FineAd\Prerequisites\ZoneController@destroy')->name('zones.destroy');
//    Route::delete('/zones/{zone}', 'FineAd\Prerequisites\ZoneController@destroy')->name('zones.destroy');
    /* Api */
    Route::post('api/zones/options', 'FineAd\Prerequisites\ZoneController@apiOptions')->name('api.zones.options');

    Route::get('get_zones', 'FineAd\Prerequisites\ZoneController@get_zones')->name('get_zones');

    /* City */
    Route::get('/city', 'FineAd\Prerequisites\CitiesController@index')->name('city.index');
    Route::get('/city/create', 'FineAd\Prerequisites\CitiesController@create')->name('city.create');
    Route::post('/city', 'FineAd\Prerequisites\CitiesController@store')->name('city.store');
    Route::get('/city/{cityCrud}', 'FineAd\Prerequisites\CitiesController@show')->name('city.show');
    Route::get('/city/{cityCrud}/edit', 'FineAd\Prerequisites\CitiesController@edit')->name('city.edit');
    Route::put('/city/{cityCrud}', 'FineAd\Prerequisites\CitiesController@update')->name('city.update');
    Route::delete('/city/{cityCrud}', 'FineAd\Prerequisites\CitiesController@destroy')->name('city.destroy');
    /* Api */
//    Route::post('api/city/options', 'FineAd\Prerequisites\CitiesController@apiOptions')->name('api.city.options');


    /* City */
    Route::get('/cities', 'FineAd\Prerequisites\CityController@index')->name('cities.index');
    Route::get('/cities/create', 'FineAd\Prerequisites\CityController@create')->name('cities.create');
    Route::post('/cities', 'FineAd\Prerequisites\CityController@store')->name('cities.store');
    Route::get('/cities/{city}', 'FineAd\Prerequisites\CityController@show')->name('cities.show');
    Route::get('/cities/{city}/edit', 'FineAd\Prerequisites\CityController@edit')->name('cities.edit');
    Route::put('/cities/{city}', 'FineAd\Prerequisites\CityController@update')->name('cities.update');
    Route::delete('/cities/{city}', 'FineAd\Prerequisites\CityController@destroy')->name('cities.destroy');
    /* Api */
    Route::post('api/cities/options', 'FineAd\Prerequisites\CityController@apiOptions')->name('api.cities.options');


    /* Grid */

    Route::get('/grids/list/{array?}/{str?}', 'FineAd\Prerequisites\GridController@index')->name('grids.list');

    Route::post('/grids/list', 'FineAd\Prerequisites\GridController@index')->name('grids.list');

//    Route::get('/grids', 'FineAd\Prerequisites\GridController@index')->name('grids.index');
    Route::get('/grids/create', 'FineAd\Prerequisites\GridController@create')->name('grids.create');
    Route::post('/grids', 'FineAd\Prerequisites\GridController@store')->name('grids.store');
    Route::get('/grids/{grid}', 'FineAd\Prerequisites\GridController@show')->name('grids.show');
    Route::get('/grids/{grid}/edit', 'FineAd\Prerequisites\GridController@edit')->name('grids.edit');
    Route::put('/grids/{grid}', 'FineAd\Prerequisites\GridController@update')->name('grids.update');
    Route::delete('/grids/', 'FineAd\Prerequisites\GridController@destroy')->name('grids.destroy');
//    Route::delete('/grids/{grid}', 'FineAd\Prerequisites\GridController@destroy')->name('grids.destroy');
    /* Api */
    Route::post('api/grids/options', 'FineAd\Prerequisites\GridController@apiOptions')->name('api.grids.options');


    /* Franchise / Area */
    Route::get('/franchise-area/list/{array?}/{str?}', 'FineAd\Prerequisites\FranchiseAreaController@index')->name('franchise-area.list');

    Route::post('/franchise-area/list', 'FineAd\Prerequisites\FranchiseAreaController@index')->name('franchise-area.list');

//    Route::get('/franchise-area', 'FineAd\Prerequisites\FranchiseAreaController@index')->name('franchise-area.index');
    Route::get('/franchise-area/create', 'FineAd\Prerequisites\FranchiseAreaController@create')->name('franchise-area.create');
    Route::post('/franchise-area', 'FineAd\Prerequisites\FranchiseAreaController@store')->name('franchise-area.store');
    Route::get('/franchise-area/{franchiseArea}', 'FineAd\Prerequisites\FranchiseAreaController@show')->name('franchise-area.show');
    Route::get('/franchise-area/{franchiseArea}/edit', 'FineAd\Prerequisites\FranchiseAreaController@edit')->name('franchise-area.edit');
    Route::put('/franchise-area/{franchiseArea}', 'FineAd\Prerequisites\FranchiseAreaController@update')->name('franchise-area.update');
    Route::delete('/franchise-area/', 'FineAd\Prerequisites\FranchiseAreaController@destroy')->name('franchise-area.destroy');
//    Route::delete('/franchise-area/{franchiseArea}', 'FineAd\Prerequisites\FranchiseAreaController@destroy')->name('franchise-area.destroy');
    /* Api */
    Route::post('api/franchise-area/options', 'FineAd\Prerequisites\FranchiseAreaController@apiOptions')->name('api.franchise-area.options');


    /* Circle */
    Route::get('/circles', 'FineAd\Prerequisites\CircleController@index')->name('circles.index');
    Route::get('/circles/create', 'FineAd\Prerequisites\CircleController@create')->name('circles.create');
    Route::post('/circles', 'FineAd\Prerequisites\CircleController@store')->name('circles.store');
    Route::get('/circles/{circle}', 'FineAd\Prerequisites\CircleController@show')->name('circles.show');
    Route::get('/circles/{circle}/edit', 'FineAd\Prerequisites\CircleController@edit')->name('circles.edit');
    Route::put('/circles/{circle}', 'FineAd\Prerequisites\CircleController@update')->name('circles.update');
    Route::delete('/circles/{circle}', 'FineAd\Prerequisites\CircleController@destroy')->name('circles.destroy');
    /* Api */
    Route::post('api/circles/options', 'FineAd\Prerequisites\CircleController@apiOptions')->name('api.circles.options');


    /* survey*/

//================================================================= Survey Report
    Route::get('/add_survey', 'FineAd\Prerequisites\SurveyController@add_survey')->name('add_survey');

    Route::get('/get_companies', 'FineAd\Prerequisites\SurveyController@get_companies')->name('get_companies');
    Route::get('/gets_project', 'FineAd\Prerequisites\SurveyController@gets_project')->name('gets_project');
    Route::get('/get_franchises', 'FineAd\Prerequisites\SurveyController@get_franchises')->name('get_franchises');
    Route::get('/get_products', 'FineAd\Prerequisites\SurveyController@get_products')->name('get_products');


    Route::get('/survey/{array?}/{str?}', 'FineAd\Prerequisites\SurveyController@index')->name('survey');

    Route::post('/survey_items_view_details', 'FineAd\Prerequisites\SurveyController@survey_items_view_details')->name('survey_items_view_details');

    Route::get('/survey_items_view_details/view/{id}', 'FineAd\Prerequisites\SurveyController@survey_items_view_details_SH')->name('survey_items_view_details_sh');

    Route::get('/survey_items_view_details/view/pdf/{id}/{array?}/{str?}', 'FineAd\Prerequisites\SurveyController@survey_items_view_details_pdf_SH')->name('survey_items_view_details_pdf_sh');

    Route::get('/survey_list/{array?}/{str?}', 'FineAd\Prerequisites\SurveyController@survey_list')->name('survey_list');
    Route::post('/survey_list', 'FineAd\Prerequisites\SurveyController@survey_list')->name('survey_list');


    Route::get('/before/image/{vis_id?}', 'FineAd\Prerequisites\SurveyController@before_modal')->name('before-image');

    Route::get('/survey_pending_list/{array?}/{str?}', 'FineAd\Prerequisites\SurveyController@survey_pending_list')->name('survey_pending_list');
    Route::post('/survey_pending_list', 'FineAd\Prerequisites\SurveyController@survey_pending_list')->name('survey_pending_list');

    Route::post('/survey_approve', 'FineAd\Prerequisites\SurveyController@survey_approve')->name('survey_approve');
    Route::post('/survey_reject', 'FineAd\Prerequisites\SurveyController@survey_reject')->name('survey_reject');

    Route::get('/survey_approve_list/{array?}/{str?}', 'FineAd\Prerequisites\SurveyController@survey_approve_list')->name('survey_approve_list');
    Route::post('/survey_approve_list', 'FineAd\Prerequisites\SurveyController@survey_approve_list')->name('survey_approve_list');
    Route::get('/survey_reject_list/{array?}/{str?}', 'FineAd\Prerequisites\SurveyController@survey_reject_list')->name('survey_reject_list');
    Route::post('/survey_reject_list', 'FineAd\Prerequisites\SurveyController@survey_reject_list')->name('survey_reject_list');

    Route::post('/survey_approved', 'FineAd\Prerequisites\SurveyController@survey_approved')->name('survey_approved');

//================================================================= Product Types Report

    Route::get('/product_measurement_config', 'FineAd\Prerequisites\ProductTypesController@product_measurement_config')->name('product_measurement_config');
    Route::post('/submit_product_measurement_config', 'FineAd\Prerequisites\ProductTypesController@submit_product_measurement_config')->name('submit_product_measurement_config');


    Route::get('/product_measurement_config_list/{array?}/{str?}', 'FineAd\Prerequisites\ProductTypesController@product_measurement_config_list')->name('product_measurement_config_list');

    Route::post('/product_measurement_config_list', 'FineAd\Prerequisites\ProductTypesController@product_measurement_config_list')->name('product_measurement_config_list');

    Route::post('/edit_product_measurement_config', 'FineAd\Prerequisites\ProductTypesController@edit_product_measurement_config')->name('edit_product_measurement_config');

    Route::post('/update_product_measurement_config', 'FineAd\Prerequisites\ProductTypesController@update_product_measurement_config')->name('update_product_measurement_config');

    Route::get('/edit_product_measurement_config', 'FineAd\Prerequisites\ProductTypesController@product_measurement_config_list')->name('edit_product_measurement_config');

    Route::post('/delete_product_measurement_config', 'FineAd\Prerequisites\ProductTypesController@delete_product_measurement_config')->name('delete_product_measurement_config');

//================================================================= Project Creation Report old

    Route::get('/add_project_creation', 'FineAd\Prerequisites\ProjectCreationController@add_project_creation')->name('add_project_creation');
    Route::post('/submit_project_creation', 'FineAd\Prerequisites\ProjectCreationController@submit_project_creation')->name('submit_project_creation');

    ////////
    Route::get('/project_creation_list/{array?}/{str?}', 'FineAd\Prerequisites\ProjectCreationController@project_creation_list')->name('project_creation_list');


    Route::post('/project_creation_list', 'FineAd\Prerequisites\ProjectCreationController@project_creation_list')->name('project_creation_list');

//    Project items
    Route::post('/project_items_view_details', 'FineAd\Prerequisites\ProjectCreationController@project_items_view_details')->name('project_items_view_details');

    Route::get('/project_items_view_details/view/{id}', 'FineAd\Prerequisites\ProjectCreationController@project_items_view_details_SH')->name('project_items_view_details_SH');

    Route::get('/project_items_view_details/pdf/{id}', 'FineAd\Prerequisites\ProjectCreationController@project_items_view_details_pdf_SH')->name('project_items_view_details_pdf_SH');


//    Material
    Route::post('/material_items_view_details', 'FineAd\Prerequisites\ProjectCreationController@material_items_view_details')->name('material_items_view_details');

    Route::get('/material_items_view_details/view/{id}', 'FineAd\Prerequisites\ProjectCreationController@material_items_view_details_SH')->name('material_items_view_details_SH');

    Route::get('/material_items_view_details/pdf/{id}', 'FineAd\Prerequisites\ProjectCreationController@material_items_view_details_pdf_SH')->name('material_items_view_details_pdf_SH');


//    expense
    Route::post('/expense_items_view_details', 'FineAd\Prerequisites\ProjectCreationController@expense_items_view_details')->name('expense_items_view_details');

    Route::get('/expense_items_view_details/view/{id}', 'FineAd\Prerequisites\ProjectCreationController@expense_items_view_details_SH')->name('expense_items_view_details_SH');

    Route::get('/expense_items_view_details/pdf/{id}', 'FineAd\Prerequisites\ProjectCreationController@expense_items_view_details_pdf_SH')->name('expense_items_view_details_pdf_SH');


    Route::get('/project_creation_list/{array?}/{str?}', 'FineAd\Prerequisites\ProjectCreationController@project_creation_list')->name('project_creation_list');

    Route::post('/project_creation_list', 'FineAd\Prerequisites\ProjectCreationController@project_creation_list')->name('project_creation_list');

    Route::post('/delete_project_creation', 'FineAd\Prerequisites\ProjectCreationController@delete_project_creation')->name('delete_project_creation');

//    recepie items details
//    expense


    Route::post('/get_regions', 'FineAd\Prerequisites\ProjectCreationController@get_regions')->name('get_regions');


//================================================================= Original Purchase Order Route
    Route::get('/original_purchase_order', 'FineAd\Prerequisites\OriginalPurchaseOrderController@original_purchase_order')->name('original_purchase_order');
    Route::get('/edit_original_purchase_order', 'FineAd\Prerequisites\OriginalPurchaseOrderController@edit_original_purchase_order')->name('edit_original_purchase_order');
    Route::post('/submit_original_purchase_order', 'FineAd\Prerequisites\OriginalPurchaseOrderController@submit_original_purchase_order')->name('submit_original_purchase_order');
    Route::post('/update_original_purchase_order', 'FineAd\Prerequisites\OriginalPurchaseOrderController@update_original_purchase_order')->name('update_original_purchase_order');
    Route::post('/get_calculate_amount', 'FineAd\Prerequisites\OriginalPurchaseOrderController@get_calculate_amount')->name('get_calculate_amount');
    Route::post('/get_expense_amount', 'FineAd\Prerequisites\OriginalPurchaseOrderController@get_expense_amount')->name('get_expense_amount');
    Route::get('/get_qty', 'FineAd\Prerequisites\OriginalPurchaseOrderController@get_qty')->name('get_qty');
    Route::get('/get_ser_qty', 'FineAd\Prerequisites\OriginalPurchaseOrderController@get_ser_qty')->name('get_ser_qty');
    Route::get('/get_projects', 'FineAd\Prerequisites\OriginalPurchaseOrderController@get_projects')->name('get_projects');


    Route::get('/original_purchase_order_list/{array?}/{str?}', 'FineAd\Prerequisites\OriginalPurchaseOrderController@original_purchase_order_list')->name('original_purchase_order_list');

    Route::post('/original_purchase_order_list', 'FineAd\Prerequisites\OriginalPurchaseOrderController@original_purchase_order_list')->name('original_purchase_order_list');

    Route::post('/original_purchase_order_items_view_details', 'FineAd\Prerequisites\OriginalPurchaseOrderController@original_purchase_order_items_view_details')->name('original_purchase_order_items_view_details');


    Route::get('/original_purchase_order_items_view_details/view/{id}', 'FineAd\Prerequisites\OriginalPurchaseOrderController@original_purchase_order_items_view_details_SH')->name('original_purchase_order_items_view_details_SH');

    Route::get('/original_purchase_order_items_view_details/pdf/{id}', 'FineAd\Prerequisites\OriginalPurchaseOrderController@original_purchase_order_items_view_details_pdf_SH')->name('original_purchase_order_items_view_details_pdf_SH');

    Route::get('/get_purchased_items_for_edit', 'FineAd\Prerequisites\OriginalPurchaseOrderController@get_purchased_items_for_edit')->name('get_purchased_items_for_edit');

    Route::post('/get_job_order', 'FineAd\Prerequisites\OriginalPurchaseOrderController@get_job_order')->name('get_job_order');
    Route::post('/get_jo_products', 'FineAd\Prerequisites\OriginalPurchaseOrderController@get_jo_products')->name('get_jo_products');


//================================================================= Purchase Order Route
    Route::get('/purchase_order', 'FineAd\Prerequisites\PurchaseOrderController@purchase_order')->name('purchase_order');
    Route::get('/edit_purchase_order', 'FineAd\Prerequisites\PurchaseOrderController@edit_purchase_order')->name('edit_purchase_order');
    Route::post('/submit_purchase_order', 'FineAd\Prerequisites\PurchaseOrderController@submit_purchase_order')->name('submit_purchase_order');
    Route::post('/update_purchase_order', 'FineAd\Prerequisites\PurchaseOrderController@update_purchase_order')->name('update_purchase_order');
    Route::post('/get_calculate_amount', 'FineAd\Prerequisites\PurchaseOrderController@get_calculate_amount')->name('get_calculate_amount');
    Route::post('/get_expense_amount', 'FineAd\Prerequisites\PurchaseOrderController@get_expense_amount')->name('get_expense_amount');
    Route::get('/get_qty', 'FineAd\Prerequisites\PurchaseOrderController@get_qty')->name('get_qty');
    Route::get('/get_ser_qty', 'FineAd\Prerequisites\PurchaseOrderController@get_ser_qty')->name('get_ser_qty');
    Route::get('/get_projects', 'FineAd\Prerequisites\PurchaseOrderController@get_projects')->name('get_projects');


    Route::get('/purchase_order_list/{array?}/{str?}', 'FineAd\Prerequisites\PurchaseOrderController@purchase_order_list')->name('purchase_order_list');

    Route::post('/purchase_order_list', 'FineAd\Prerequisites\PurchaseOrderController@purchase_order_list')->name('purchase_order_list');

    Route::post('/purchase_order_items_view_details', 'FineAd\Prerequisites\PurchaseOrderController@purchase_order_items_view_details')->name('purchase_order_items_view_details');

    Route::get('/purchase_order_items_view_details/view/{id}', 'FineAd\Prerequisites\PurchaseOrderController@purchase_order_items_view_details_SH')->name('purchase_order_items_view_details_SH');

    Route::get('/purchase_order_items_view_details/pdf/{id}', 'FineAd\Prerequisites\PurchaseOrderController@purchase_order_items_view_details_pdf_SH')->name('purchase_order_items_view_details_pdf_SH');

    Route::get('/get_purchased_items_for_edit', 'FineAd\Prerequisites\PurchaseOrderController@get_purchased_items_for_edit')->name('get_purchased_items_for_edit');

//================================================================= Order List Items Route
    Route::get('/order_list', 'FineAd\Prerequisites\OrderListController@order_list')->name('order_list');
    Route::post('/submit_order_list', 'FineAd\Prerequisites\OrderListController@submit_order_list')->name('submit_order_list');

    Route::get('/get_oder_calculation', 'FineAd\Prerequisites\OrderListController@get_oder_calculation')->name('get_oder_calculation');
    Route::get('/get_company_products', 'FineAd\Prerequisites\OrderListController@get_company_products')->name('get_company_products');
    Route::get('/get_company_config_products', 'FineAd\Prerequisites\OrderListController@get_company_config_products')->name('get_company_config_products');
    Route::get('/get_region_product', 'FineAd\Prerequisites\OrderListController@get_region_product')->name('get_region_product');
    Route::get('/get_product_budget', 'FineAd\Prerequisites\OrderListController@get_product_budget')->name('get_product_budget');


    Route::get('/order_items_list/{array?}/{str?}', 'FineAd\Prerequisites\OrderListController@order_items_list')->name('order_items_list');

    Route::post('/order_items_list', 'FineAd\Prerequisites\OrderListController@order_items_list')->name('order_items_list');

    Route::post('/order_items_items_view_details', 'FineAd\Prerequisites\OrderListController@order_items_items_view_details')->name('order_items_items_view_details');

    Route::get('/order_items_items_view_details/view/{id}', 'FineAd\Prerequisites\OrderListController@order_items_items_view_details_SH')->name('order_items_items_view_details_SH');

    Route::get('/order_items_items_view_details/pdf/{id}', 'FineAd\Prerequisites\OrderListController@order_items_items_view_details_pdf_SH')->name('order_items_items_view_details_pdf_SH');

    Route::get('/get_order_list', 'FineAd\Prerequisites\OrderListController@get_order_list')->name('get_order_list');

////================================================================= Survey Working Area Route
    Route::get('/survey_working_area', 'FineAd\Prerequisites\SurveyWorkingAreaController@survey_working_area')->name('survey_working_area');
    Route::get('/get_company', 'FineAd\Prerequisites\SurveyWorkingAreaController@get_company')->name('get_company');
    Route::post('/submit_survey_working_area', 'FineAd\Prerequisites\SurveyWorkingAreaController@submit_survey_working_area')->name('submit_survey_working_area');
//

    Route::get('/survey_working_area_list/{array?}/{str?}', 'FineAd\Prerequisites\SurveyWorkingAreaController@survey_working_area_list')->name('survey_working_area_list');

    Route::post('/survey_working_area_list', 'FineAd\Prerequisites\SurveyWorkingAreaController@survey_working_area_list')->name('survey_working_area_list');

    Route::post('/working_area_items_view_details', 'FineAd\Prerequisites\SurveyWorkingAreaController@working_area_items_view_details')->name('working_area_items_view_details');

    Route::get('/working_area_items_view_details/view/{id}', 'FineAd\Prerequisites\SurveyWorkingAreaController@working_area_items_view_details_SH')->name('working_area_items_view_details_SH');

    Route::get('/working_area_items_view_details/pdf/{id}', 'FineAd\Prerequisites\SurveyWorkingAreaController@working_area_items_view_details_pdf_SH')->name('working_area_items_view_details_pdf_SH');


    //================================================================= Survey Work Area Route
    Route::get('/survey_work_area', 'FineAd\Prerequisites\SurveyWorkAreaController@survey_work_area')->name('survey_work_area');

    Route::post('/submit_survey_work_area', 'FineAd\Prerequisites\SurveyWorkAreaController@submit_survey_work_area')->name('submit_survey_work_area');

//    Route::get('/edit_survey_work_area', 'FineAd\Prerequisites\SurveyWorkAreaController@edit_survey_work_area')->name('edit_survey_work_area');

    Route::get('/edit_survey_work_area', 'FineAd\Prerequisites\SurveyWorkAreaController@edit_survey_work_area')->name('edit_survey_work_area');

    Route::get('/order_list_region', 'FineAd\Prerequisites\SurveyWorkAreaController@order_list_region')->name('order_list_region');
    Route::get('/get_employee_username', 'FineAd\Prerequisites\SurveyWorkAreaController@get_employee_username')->name('get_employee_username');
    Route::get('/get_supplier_username', 'FineAd\Prerequisites\SurveyWorkAreaController@get_supplier_username')->name('get_supplier_username');
    Route::get('/get_ser_order_qty', 'FineAd\Prerequisites\SurveyWorkAreaController@get_ser_order_qty')->name('get_ser_order_qty');


    Route::get('/survey_work_area_list/{array?}/{str?}', 'FineAd\Prerequisites\SurveyWorkAreaController@survey_work_area_list')->name('survey_work_area_list');

    Route::post('/survey_work_area_list', 'FineAd\Prerequisites\SurveyWorkAreaController@survey_work_area_list')->name('survey_work_area_list');

    Route::post('/work_area_items_view_details', 'FineAd\Prerequisites\SurveyWorkAreaController@work_area_items_view_details')->name('work_area_items_view_details');

    Route::get('/work_area_items_view_details/view/{id}', 'FineAd\Prerequisites\SurveyWorkAreaController@work_area_items_view_details_SH')->name('work_area_items_view_details_SH');

    Route::get('/work_area_items_view_details/pdf/{id}', 'FineAd\Prerequisites\SurveyWorkAreaController@work_area_items_view_details_pdf_SH')->name('work_area_items_view_details_pdf_SH');

    Route::get('/survey_work_area_item_delete/{id}', 'FineAd\Prerequisites\SurveyWorkAreaController@survey_work_area_item_delete')->name('survey_work_area_item_delete');

    Route::post('/update_survey_work_area', 'FineAd\Prerequisites\SurveyWorkAreaController@update_survey_work_area')->name('update_survey_work_area');

//================================================================= Designer Working Area Route
    Route::get('/designer_working_area', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_working_area')->name('designer_working_area');
    Route::post('/submit_designer_working_area', 'FineAd\Prerequisites\DesignerWorkingAreaController@submit_designer_working_area')->name('submit_designer_working_area');


    Route::get('/designer_working_area_list/{array?}/{str?}', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_working_area_list')->name('designer_working_area_list');

    Route::post('/designer_working_area_list', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_working_area_list')->name('designer_working_area_list');

    Route::post('/designer_working_area_items_view_details', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_working_area_items_view_details')->name('designer_working_area_items_view_details');

    Route::get('/designer_working_area_items_view_details/view/{id}', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_working_area_items_view_details_SH')->name('designer_working_area_items_view_details_SH');

    Route::get('/designer_working_area_items_view_details/pdf/{id}', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_working_area_items_view_details_pdf_SH')->name('designer_working_area_items_view_details_pdf_SH');

    Route::get('/designer_list/{array?}/{str?}', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_list')->name('designer_list');
    Route::post('/designer_list', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_list')->name('designer_list');
    Route::post('/designer_upload_image', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_upload_image')->name('designer_upload_image');

    Route::get('/designer_pending_list/{array?}/{str?}', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_pending_list')->name('designer_pending_list');

    Route::post('/designer_pending_list', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_pending_list')->name('designer_pending_list');

    Route::get('/designer_approved_list/{array?}/{str?}', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_approved_list')->name('designer_approved_list'); //new

    Route::post('/designer_approved_list', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_approved_list')->name('designer_approved_list');//new

    Route::get('/designer_rejected_list/{array?}/{str?}', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_rejected_list')->name('designer_rejected_list');//new

    Route::post('/designer_rejected_list', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_rejected_list')->name('designer_rejected_list');//new

    Route::post('/designer_approve', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_approve')->name('designer_approve');

    Route::post('/designer_reject', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_reject')->name('designer_reject');
    Route::post('/designer_approved', 'FineAd\Prerequisites\DesignerWorkingAreaController@designer_approved')->name('designer_approved');

//================================================================= Expense Budget Route
    Route::get('/expense_budget', 'FineAd\Prerequisites\ExpenseBudgetController@expense_budget')->name('expense_budget');
    Route::post('/submit_expense_budget', 'FineAd\Prerequisites\ExpenseBudgetController@submit_expense_budget')->name('submit_expense_budget');


    Route::get('/expense_budget_list/{array?}/{str?}', 'FineAd\Prerequisites\ExpenseBudgetController@expense_budget_list')->name('expense_budget_list');

    Route::post('/expense_budget_list', 'FineAd\Prerequisites\ExpenseBudgetController@expense_budget_list')->name('expense_budget_list');

    Route::post('/expense_budget_items_view_details', 'FineAd\Prerequisites\ExpenseBudgetController@expense_budget_items_view_details')->name('expense_budget_items_view_details');

    Route::get('/expense_budget_items_view_details/view/{id}', 'FineAd\Prerequisites\ExpenseBudgetController@expense_budget_items_view_details_SH')->name('expense_budget_items_view_details_SH');

    Route::get('/expense_budget_items_view_details/pdf/{id}', 'FineAd\Prerequisites\ExpenseBudgetController@expense_budget_items_view_details_pdf_SH')->name('expense_budget_items_view_details_pdf_SH');

    //================================================================= Material Budget Route
    Route::get('/material_budget', 'FineAd\Prerequisites\MaterialBudgetController@material_budget')->name('material_budget');
    Route::post('/submit_material_budget', 'FineAd\Prerequisites\MaterialBudgetController@submit_material_budget')->name('submit_material_budget');


    Route::get('/material_budget_list/{array?}/{str?}', 'FineAd\Prerequisites\MaterialBudgetController@material_budget_list')->name('material_budget_list');

    Route::post('/material_budget_list', 'FineAd\Prerequisites\MaterialBudgetController@material_budget_list')->name('material_budget_list');

    Route::post('/material_budget_items_view_details', 'FineAd\Prerequisites\MaterialBudgetController@material_budget_items_view_details')->name('material_budget_items_view_details');

    Route::get('/material_budget_items_view_details/view/{id}', 'FineAd\Prerequisites\MaterialBudgetController@material_budget_items_view_details_SH')->name('material_budget_items_view_details_SH');

    Route::get('/material_budget_items_view_details/pdf/{id}', 'FineAd\Prerequisites\MaterialBudgetController@material_budget_items_view_details_pdf_SH')->name('material_budget_items_view_details_pdf_SH');

    //================================================================= Assign Surveyor Budget Route
    Route::get('/assign_username', 'FineAd\Prerequisites\FineadSurvyorAssignUsernameController@create')->name('assign_username');
    Route::post('/store', 'FineAd\Prerequisites\FineadSurvyorAssignUsernameController@store')->name('store');

    Route::get('/assign_username_list/{array?}/{str?}', 'FineAd\Prerequisites\FineadSurvyorAssignUsernameController@assign_username_list')->name('assign_username_list');
    Route::post('/assign_username_list', 'FineAd\Prerequisites\FineadSurvyorAssignUsernameController@assign_username_list')->name('assign_username_list');
    Route::get('/edit_area', 'FineAd\Prerequisites\FineadSurvyorAssignUsernameController@assign_username_list')->name('edit_area');


//================================================================= Surveyor

    Route::get('/surveyor/create', 'FineAd\Prerequisites\SurveyorController@create')->name('surveyor.create');
    Route::post('/surveyor/store', 'FineAd\Prerequisites\SurveyorController@store')->name('surveyor.store');
    Route::get('/surveyor/{array?}/{str?}', 'FineAd\Prerequisites\SurveyorController@index')->name('surveyor.index');
    Route::post('/surveyor', 'FineAd\Prerequisites\SurveyorController@index')->name('surveyor.index');
    Route::post('/surveyor/edit', 'FineAd\Prerequisites\SurveyorController@edit')->name('surveyor.edit');
    Route::post('/surveyor/update', 'FineAd\Prerequisites\SurveyorController@update')->name('surveyor.update');
    Route::get('/surveyor/edit', 'FineAd\Prerequisites\SurveyorController@index')->name('surveyor.edit');
    Route::post('/surveyor/destroy', 'FineAd\Prerequisites\SurveyorController@destroy')->name('surveyor.destroy');

    Route::post('/surveyor_change_password', 'FineAd\Prerequisites\SurveyorController@surveyor_change_password')->name('surveyor_change_password');

    //================================================================= Additional Budget

    Route::get('/additional_budget', 'FineAd\Prerequisites\PurchaseOrderController@additional_budget')->name('additional_budget');
    Route::get('/get_additional_amount', 'FineAd\Prerequisites\PurchaseOrderController@get_additional_amount')->name('get_additional_amount');
    Route::post('/submit_additional_amount', 'FineAd\Prerequisites\PurchaseOrderController@submit_additional_amount')->name('submit_additional_amount');

    //================================================================= Additional Budget

    Route::get('/additional_order_list', 'FineAd\Prerequisites\AdditionalBudgetOrderListController@additional_order_list')->name('additional_order_list');
    Route::post('/submit_additional_order_list', 'FineAd\Prerequisites\AdditionalBudgetOrderListController@submit_additional_order_list')->name('submit_additional_order_list');

    Route::get('/get_additional_company_products', 'FineAd\Prerequisites\AdditionalBudgetOrderListController@get_additional_company_products')->name('get_additional_company_products');
//    Route::get('/get_company_config_products', 'FineAd\Prerequisites\AdditionalBudgetOrderListController@get_company_config_products')->name('get_company_config_products');
//    Route::get('/get_region_product', 'FineAd\Prerequisites\AdditionalBudgetOrderListController@get_region_product')->name('get_region_product');
//    Route::get('/get_product_budget', 'FineAd\Prerequisites\AdditionalBudgetOrderListController@get_product_budget')->name('get_product_budget');


    /***************************************************************************/
    /******************* Budget Planning Routes **************************/
    /***************************************************************************/

    Route::get('/budget_planning/{array?}/{str?}', 'FineAd\Prerequisites\BudgetPlanningController@budget_planning')->name('budget_planning');

    Route::post('/budget_planning', 'FineAd\Prerequisites\BudgetPlanningController@budget_planning')->name('budget_planning');
    Route::post('/submit_budget_planning', 'FineAd\Prerequisites\BudgetPlanningController@submit_budget_planning')->name('submit_budget_planning');


    Route::get('/budget_planning_list/{array?}/{str?}', 'FineAd\Prerequisites\BudgetPlanningController@budget_planning_list')->name('budget_planning_list');

    Route::post('/budget_planning_list', 'FineAd\Prerequisites\BudgetPlanningController@budget_planning_list')->name('budget_planning_list');

    /***************************************************************************/
    /******************* Billing OF Quantity Routes **************************/
    /***************************************************************************/

    Route::get('/billing_of_quantity/{array?}/{str?}', 'FineAd\Prerequisites\BillingOfQuantityController@billing_of_quantity')->name('billing_of_quantity');

    Route::post('/billing_of_quantity', 'FineAd\Prerequisites\BillingOfQuantityController@billing_of_quantity')->name('billing_of_quantity');
    Route::post('/submit_billing_of_quantity', 'FineAd\Prerequisites\BillingOfQuantityController@submit_billing_of_quantity')->name('submit_billing_of_quantity');


    Route::get('/billing_of_quantity_list/{array?}/{str?}', 'FineAd\Prerequisites\BillingOfQuantityController@billing_of_quantity_list')->name('billing_of_quantity_list');

    Route::post('/billing_of_quantity_list', 'FineAd\Prerequisites\BillingOfQuantityController@billing_of_quantity_list')->name('billing_of_quantity_list');

    /***************************************************************************/
    /******************* Board Material Routes **************************/
    /***************************************************************************/

    Route::get('/add_board_material', 'FineAd\Prerequisites\BoardMaterialController@add_board_material')->name('add_board_material');

    Route::post('/submit_board_material', 'FineAd\Prerequisites\BoardMaterialController@submit_board_material')->name('submit_board_material');


    Route::get('/board_material_list/{array?}/{str?}', 'FineAd\Prerequisites\BoardMaterialController@board_material_list')->name('board_material_list');

    Route::post('/board_material_list', 'FineAd\Prerequisites\BoardMaterialController@board_material_list')->name('board_material_list');


    Route::post('/edit_board_material', 'FineAd\Prerequisites\BoardMaterialController@edit_board_material')->name('edit_board_material');

    Route::post('/update_board_material', 'FineAd\Prerequisites\BoardMaterialController@update_board_material')->name('update_board_material');

    Route::get('/edit_board_material', 'FineAd\Prerequisites\BoardMaterialController@board_material_list')->name('edit_board_material');

    Route::post('/delete_board_material', 'FineAd\Prerequisites\BoardMaterialController@delete_board_material')->name('delete_board_material');

    /***************************************************************************/
    /******************* Board Type Routes **************************/
    /***************************************************************************/

//    Route::get('/add_board_type', 'FineAd\Prerequisites\BoardTypeController@add_board_type')->name('add_board_type');

    Route::post('/submit_board_type', 'FineAd\Prerequisites\BoardTypeController@submit_board_type')->name('submit_board_type');


    Route::get('/board_type_list/{array?}/{str?}', 'FineAd\Prerequisites\BoardTypeController@board_type_list')->name('board_type_list');

    Route::post('/board_type_list', 'FineAd\Prerequisites\BoardTypeController@board_type_list')->name('board_type_list');


    Route::post('/edit_board_type', 'FineAd\Prerequisites\BoardTypeController@edit_board_type')->name('edit_board_type');

    Route::post('/update_board_type', 'FineAd\Prerequisites\BoardTypeController@update_board_type')->name('update_board_type');

    Route::get('/edit_board_type', 'FineAd\Prerequisites\BoardTypeController@board_type_list')->name('edit_board_type');

    Route::post('/delete_board_type', 'FineAd\Prerequisites\BoardTypeController@delete_board_type')->name('delete_board_type');


    /***************************************************************************/
    /******************* Assign Board Material Routes **************************/
    /***************************************************************************/

    Route::get('/assign_board_material', 'FineAd\Prerequisites\AssignBoardMaterialController@assign_board_material')->name('assign_board_material');

    Route::post('/submit_assign_board_material', 'FineAd\Prerequisites\AssignBoardMaterialController@submit_assign_board_material')->name('submit_assign_board_material');

    Route::get('/assign_board_material_list/{array?}/{str?}', 'FineAd\Prerequisites\AssignBoardMaterialController@assign_board_material_list')->name('assign_board_material_list');

    Route::post('/assign_board_material_list', 'FineAd\Prerequisites\AssignBoardMaterialController@assign_board_material_list')->name('assign_board_material_list');


    Route::get('/assign_board_material/{id}/edit', 'FineAd\Prerequisites\AssignBoardMaterialController@edit_assign_board_material')->name('edit_assign_board_material');
    Route::put('/assign_board_material/{id}', 'FineAd\Prerequisites\AssignBoardMaterialController@update_assign_board_material')->name('update_assign_board_material');
    Route::delete('/assign_board_material_delete', 'FineAd\Prerequisites\AssignBoardMaterialController@delete_assign_board_material')->name('assign_board_material.destroy');


    Route::post('/assign_board_material_items_view_details', 'FineAd\Prerequisites\AssignBoardMaterialController@assign_board_material_items_view_details')->name('assign_board_material_items_view_details');

    Route::get('/assign_board_material_items_view_details/view/{id}', 'FineAd\Prerequisites\AssignBoardMaterialController@assign_board_material_items_view_details_SH')->name('assign_board_material_items_view_details_SH');

    Route::get('/assign_board_material_items_view_details/pdf/{id}', 'FineAd\Prerequisites\AssignBoardMaterialController@assign_board_material_items_view_details_pdf_SH')->name('assign_board_material_items_view_details_pdf_SH');


    /***************************************************************************/
    /******************* Angle Calibration Routes **************************/
    /***************************************************************************/

    Route::get('/add_angle_calibration', 'FineAd\Prerequisites\AngleInchSoterCalibrationController@add_angle_calibration')->name('add_angle_calibration');

    Route::post('/submit_angle_calibration', 'FineAd\Prerequisites\AngleInchSoterCalibrationController@submit_angle_calibration')->name('submit_angle_calibration');


    Route::get('/angle_calibration_list/{array?}/{str?}', 'FineAd\Prerequisites\AngleInchSoterCalibrationController@angle_calibration_list')->name('angle_calibration_list');

    Route::post('/angle_calibration_list', 'FineAd\Prerequisites\AngleInchSoterCalibrationController@angle_calibration_list')->name('angle_calibration_list');


    Route::post('/edit_angle_calibration', 'FineAd\Prerequisites\AngleInchSoterCalibrationController@edit_angle_calibration')->name('edit_angle_calibration');

    Route::post('/update_angle_calibration', 'FineAd\Prerequisites\AngleInchSoterCalibrationController@update_angle_calibration')->name('update_angle_calibration');

    Route::get('/edit_angle_calibration', 'FineAd\Prerequisites\AngleInchSoterCalibrationController@angle_calibration_list')->name('edit_angle_calibration');

    Route::post('/delete_angle_calibration', 'FineAd\Prerequisites\AngleInchSoterCalibrationController@delete_angle_calibration')->name('delete_angle_calibration');

    Route::get('/angle_pipe', 'FineAd\Prerequisites\AngleInchSoterCalibrationController@angle_pipe')->name('angle_pipe');
    Route::get('/angle_update_pipe', 'FineAd\Prerequisites\AngleInchSoterCalibrationController@angle_update_pipe')->name('angle_update_pipe');

    /***************************************************************************/
    /******************* Pipe Width Calibration Routes **************************/
    /***************************************************************************/


    Route::get('/add_width_calibration', 'FineAd\Prerequisites\PipeWidthCalibrationController@add_width_calibration')->name('add_width_calibration');

    Route::post('/submit_width_calibration', 'FineAd\Prerequisites\PipeWidthCalibrationController@submit_width_calibration')->name('submit_width_calibration');


    Route::get('/width_calibration_list/{array?}/{str?}', 'FineAd\Prerequisites\PipeWidthCalibrationController@width_calibration_list')->name('width_calibration_list');

    Route::post('/width_calibration_list', 'FineAd\Prerequisites\PipeWidthCalibrationController@width_calibration_list')->name('width_calibration_list');


    Route::post('/edit_width_calibration', 'FineAd\Prerequisites\PipeWidthCalibrationController@edit_width_calibration')->name('edit_width_calibration');

    Route::post('/update_width_calibration', 'FineAd\Prerequisites\PipeWidthCalibrationController@update_width_calibration')->name('update_width_calibration');

    Route::get('/edit_width_calibration', 'FineAd\Prerequisites\PipeWidthCalibrationController@width_calibration_list')->name('edit_width_calibration');

    Route::post('/delete_width_calibration', 'FineAd\Prerequisites\PipeWidthCalibrationController@delete_width_calibration')->name('delete_width_calibration');

    Route::get('/width_pipe', 'FineAd\Prerequisites\PipeWidthCalibrationController@width_pipe')->name('width_pipe');
    Route::get('/width_update_pipe', 'FineAd\Prerequisites\PipeWidthCalibrationController@width_update_pipe')->name('width_update_pipe');

    /***************************************************************************/
    /******************* Pipe Length Calibration Routes **************************/
    /***************************************************************************/


    Route::get('/add_length_calibration', 'FineAd\Prerequisites\PipeLengthCalibrationController@add_length_calibration')->name('add_length_calibration');

    Route::post('/submit_length_calibration', 'FineAd\Prerequisites\PipeLengthCalibrationController@submit_length_calibration')->name('submit_length_calibration');


    Route::get('/length_calibration_list/{array?}/{str?}', 'FineAd\Prerequisites\PipeLengthCalibrationController@length_calibration_list')->name('length_calibration_list');

    Route::post('/length_calibration_list', 'FineAd\Prerequisites\PipeLengthCalibrationController@length_calibration_list')->name('length_calibration_list');


    Route::post('/edit_length_calibration', 'FineAd\Prerequisites\PipeLengthCalibrationController@edit_length_calibration')->name('edit_length_calibration');

    Route::post('/update_length_calibration', 'FineAd\Prerequisites\PipeLengthCalibrationController@update_length_calibration')->name('update_length_calibration');

    Route::get('/edit_length_calibration', 'FineAd\Prerequisites\PipeLengthCalibrationController@length_calibration_list')->name('edit_length_calibration');

    Route::post('/delete_length_calibration', 'FineAd\Prerequisites\PipeLengthCalibrationController@delete_length_calibration')->name('delete_length_calibration');

    Route::get('/length_pipe', 'FineAd\Prerequisites\PipeLengthCalibrationController@length_pipe')->name('length_pipe');
    Route::get('/length_update_pipe', 'FineAd\Prerequisites\PipeLengthCalibrationController@length_update_pipe')->name('length_update_pipe');


    /***************************************************************************/
    /******************* Fasica Calculation Routes **************************/
    /***************************************************************************/


    Route::get('/fasica_calculator', 'FineAd\Prerequisites\FasicaCalculatorController@fasica_calculator')->name('fasica_calculator');

    Route::post('/submit_fasica_calculator', 'FineAd\Prerequisites\FasicaCalculatorController@submit_fasica_calculator')->name('submit_fasica_calculator');

 /***************************************************************************/
    /******************* Batch Routes **************************/
    /***************************************************************************/

    Route::get('/create_batch/{array?}/{str?}', 'FineAd\Prerequisites\BatchController@create_batch')->name('create_batch'); //new

    Route::post('/create_batch', 'FineAd\Prerequisites\BatchController@create_batch')->name('create_batch');//new

    Route::post('/submit_batch', 'FineAd\Prerequisites\BatchController@submit_batch')->name('submit_batch');

//    nabeel
    Route::get('/batch_list/{array?}/{str?}', 'FineAd\Prerequisites\BatchController@batch_list')->name('batch_list');

    Route::post('/batch_list', 'FineAd\Prerequisites\BatchController@batch_list')->name('batch_list');

    Route::post('/batch_items_view_details', 'FineAd\Prerequisites\BatchController@batch_items_view_details')->name('batch_items_view_details');

    Route::get('/batch_items_view_details/view/{id}', 'FineAd\Prerequisites\BatchController@batch_items_view_details_SH')->name('batch_items_view_details_SH');

    Route::get('/batch_items_view_details/pdf/{id}', 'FineAd\Prerequisites\BatchController@batch_items_view_details_pdf_SH')->name('batch_items_view_details_pdf_SH');

    Route::get('/delete_batch_item/{id}', 'FineAd\Prerequisites\BatchController@delete_batch_item')->name('delete_batch_item');
    Route::get('/delete_batch/{id}', 'FineAd\Prerequisites\BatchController@delete_batch')->name('delete_batch');


    Route::get('/edit_batch/{array?}/{str?}', 'FineAd\Prerequisites\BatchController@edit_batch')->name('edit_batch'); //new

    Route::post('/edit_batch', 'FineAd\Prerequisites\BatchController@edit_batch')->name('edit_batch');//new
    Route::post('/update_batch', 'FineAd\Prerequisites\BatchController@update_batch')->name('update_batch');//new

    Route::get('/get_batch_details', 'FineAd\Prerequisites\BatchController@get_batch_details')->name('get_batch_details');


    /***************************************************************************/
    /***************************** Product Batch Recipe Routes ***********************/
    /***************************************************************************/

    Route::post('/get_batch_recipe', 'FineAd\Prerequisites\ProductBatchRecipeController@getBatchRecipe')->name('get_batch_recipe');

    Route::get('/product_batch_recipe', 'FineAd\Prerequisites\ProductBatchRecipeController@product_batch_recipe')->name('product_batch_recipe');

    Route::post('/submit_product_batch_recipe', 'FineAd\Prerequisites\ProductBatchRecipeController@submit_product_batch_recipe')->name('submit_product_batch_recipe');

    Route::get('/product_batch_recipe_list/{array?}/{str?}', 'FineAd\Prerequisites\ProductBatchRecipeController@product_batch_recipe_list')->name('product_batch_recipe_list');

    Route::post('/product_batch_recipe_list', 'FineAd\Prerequisites\ProductBatchRecipeController@product_batch_recipe_list')->name('product_batch_recipe_list');

    Route::post('/edit_product_batch_recipe', 'FineAd\Prerequisites\ProductBatchRecipeController@edit_product_batch_recipe')->name('edit_product_batch_recipe');

    Route::post('/update_product_batch_recipe', 'FineAd\Prerequisites\ProductBatchRecipeController@update_product_batch_recipe')->name('update_product_batch_recipe');

    Route::get('/edit_product_batch_recipe', 'FineAd\Prerequisites\ProductBatchRecipeController@product_batch_recipe_list')->name('edit_product_batch_recipe');

    Route::post('/delete_product_batch_recipe', 'FineAd\Prerequisites\ProductBatchRecipeController@delete_product_batch_recipe')->name('delete_product_batch_recipe');

    Route::post('/get_product_batch_recipe_details', 'FineAd\Prerequisites\ProductBatchRecipeController@get_product_batch_recipe_details')->name('get_product_batch_recipe_details');



    /***************************************************************************/
    /***************************** Batch Work Order Routes ***********************/
    /***************************************************************************/

    Route::resource('batch_work_order', 'FineAd\Prerequisites\BatchWorkOrderController');



//    Route::post('/get_budget_view_details/view/{id}', 'FineAd\Prerequisites\BatchWorkOrderController@get_budget_view_details')->name('get_budget_view_details');
 Route::get('/get_budget_view_details/view', 'FineAd\Prerequisites\BatchWorkOrderController@get_budget_view_details')->name('get_budget_view_details');

//    nabeel panga start
    Route::get('/manufacturing_plan_stock_position_list/{array?}/{str?}', 'FineAd\Prerequisites\BatchWorkOrderController@stock_position_list')->name('stock_position_list');
    Route::post('/manufacturing_plan_stock_position_list', 'FineAd\Prerequisites\BatchWorkOrderController@stock_position_list')->name('stock_position_list');

    //Route::get('/sale_items_view_details/view/{id}', 'SaleInvoiceController@sale_items_view_details_SH')->name('sale_items_view_details_sh');
    //Route::get('/sale_items_view_details/view/pdf/{id}/{array?}/{str?}', 'SaleInvoiceController@sale_items_view_details_pdf_SH')->name('sale_items_view_details_pdf_sh');

//    Batch Work Order List By Nabeel
    Route::get('/manufacturing_plan_admin_list/{array?}/{str?}', 'FineAd\Prerequisites\BatchWorkOrderController@manufacturing_plan_admin_list')->name('manufacturing_plan_admin_list');
    Route::post('/manufacturing_plan_admin_list', 'FineAd\Prerequisites\BatchWorkOrderController@manufacturing_plan_admin_list')->name('manufacturing_plan_admin_list');
    Route::post('/manufacturing_plan_admin_list_details', 'FineAd\Prerequisites\BatchWorkOrderController@manufacturing_plan_admin_list_details')->name('manufacturing_plan_admin_list_details');

    Route::get('/get_budget_view_details/view', 'FineAd\Prerequisites\BatchWorkOrderController@get_budget_view_details')->name('get_budget_view_details');
    Route::post('/move_raw_budget_stock', 'FineAd\Prerequisites\BatchWorkOrderController@move_raw_budget_stock')->name('move_raw_budget_stock');
    Route::post('/move_all_manufacturing_budget_stock', 'FineAd\Prerequisites\BatchWorkOrderController@move_all_manufacturing_budget_stock')->name('move_all_manufacturing_budget_stock');


    Route::get('/generate_purchase_requisition_list/{array?}/{str?}', 'FineAd\Prerequisites\BatchWorkOrderController@generate_purchase_requisition_list')->name('generate_purchase_requisition_list');
    Route::post('/generate_purchase_requisition_list', 'FineAd\Prerequisites\BatchWorkOrderController@generate_purchase_requisition_list')->name('generate_purchase_requisition_list');








    /***************************************************************************/
    /***************************** Purchase Requisition Routes *********************/
    /***************************************************************************/
        Route::get('/Purchase_Requisition_invoice', 'FineAd\Prerequisites\PurchaseRequisitionController@Purchase_Requisition_invoice')->name('Purchase_Requisition_invoice');
        Route::get('/manufacturing_Purchase_Requisition_invoice_create/{id}', 'FineAd\Prerequisites\PurchaseRequisitionController@Manufacturing_Purchase_Requisition_invoice_create')->name('manufacturing_Purchase_Requisition_invoice_create');


        Route::post('/submit_manufacturing_Purchase_Requisition_invoice', 'FineAd\Prerequisites\PurchaseRequisitionController@submit_manufacturing_Purchase_Requisition_invoice')->name('submit_manufacturing_Purchase_Requisition_invoice');
        Route::post('/submit_Purchase_Requisition_invoice', 'FineAd\Prerequisites\PurchaseRequisitionController@submit_Purchase_Requisition_invoice')->name('submit_Purchase_Requisition_invoice');


        Route::get('/Purchase_Requisition_invoice_list/{array?}/{str?}', 'FineAd\Prerequisites\PurchaseRequisitionController@Purchase_Requisition_invoice_list')->name('Purchase_Requisition_invoice_list');
        Route::get('/Purchase_Requisition_items_invoice_list', 'FineAd\Prerequisites\PurchaseRequisitionController@Purchase_Requisition_items_invoice_list')->name('Purchase_Requisition_items_invoice_list');
        Route::get('/Purchase_Requisition_items_invoice_list/view/{id}', 'FineAd\Prerequisites\PurchaseRequisitionController@Purchase_Requisition_items_view_details_SH')->name('Purchase_Requisition_items_view_details_SH');
        Route::get('/Purchase_Requisition_items_invoice_list/view/pdf/{id}/{array?}/{str?}', 'FineAd\Prerequisites\PurchaseRequisitionController@Purchase_Requisition_items_view_details_pdf_SH')->name('Purchase_Requisition_items_view_details_pdf_SH');

        Route::post('/pr_approve', 'FineAd\Prerequisites\PurchaseRequisitionController@pr_approve')->name('pr_approve');
        Route::post('/pr_disapprove', 'FineAd\Prerequisites\PurchaseRequisitionController@pr_disapprove')->name('pr_disapprove');


        Route::post('/Purchase_Requisition_invoice_list', 'FineAd\Prerequisites\PurchaseRequisitionController@Purchase_Requisition_invoice_list')->name('Purchase_Requisition_invoice_list');
        Route::post('/get_work_order_items_for_return', 'FineAd\Prerequisites\PurchaseRequisitionController@get_work_order_items_for_return')->name('get_work_order_items_for_return');


        Route::get('/Purchase_Requisition_invoice_Approved_list/{array?}/{str?}', 'FineAd\Prerequisites\PurchaseRequisitionController@Purchase_Requisition_invoice_Approved_list')->name('Purchase_Requisition_invoice_Approved_list');
        Route::get('/Purchase_Requisition_invoice_Reject_list/{array?}/{str?}', 'FineAd\Prerequisites\PurchaseRequisitionController@Purchase_Requisition_invoice_Reject_list')->name('Purchase_Requisition_invoice_Reject_list');




    /***************************************************************************/
    /***************************** Purchase Order Routes *********************/
    /***************************************************************************/
    Route::get('/po_invoice', 'FineAd\Prerequisites\PurchaseRequisitionController@po_invoice')->name('po_invoice');
    Route::get('/manufacturing_po_invoice_create/{id}', 'FineAd\Prerequisites\PurchaseRequisitionController@Manufacturing_po_invoice_create')->name('manufacturing_po_invoice_create');


    Route::post('/submit_manufacturing_po_invoice', 'FineAd\Prerequisites\PurchaseRequisitionController@submit_manufacturing_po_invoice')->name('submit_manufacturing_po_invoice');
    Route::post('/submit_po_invoice', 'FineAd\Prerequisites\PurchaseRequisitionController@submit_po_invoice')->name('submit_po_invoice');


    Route::get('/po_invoice_list/{array?}/{str?}', 'FineAd\Prerequisites\PurchaseRequisitionController@po_invoice_list')->name('po_invoice_list');
    Route::get('/po_items_invoice_list', 'FineAd\Prerequisites\PurchaseRequisitionController@po_items_invoice_list')->name('po_items_invoice_list');
    Route::get('/po_items_invoice_list/view/{id}', 'FineAd\Prerequisites\PurchaseRequisitionController@po_items_view_details_SH')->name('po_items_view_details_SH');
    Route::get('/po_items_invoice_list/view/pdf/{id}/{array?}/{str?}', 'FineAd\Prerequisites\PurchaseRequisitionController@po_items_view_details_pdf_SH')->name('po_items_view_details_pdf_SH');


    Route::post('/Purchase_Requisition_invoice_list', 'FineAd\Prerequisites\PurchaseRequisitionController@Purchase_Requisition_invoice_list')->name('Purchase_Requisition_invoice_list');
    Route::post('/get_work_order_items_for_return', 'FineAd\Prerequisites\PurchaseRequisitionController@get_work_order_items_for_return')->name('get_work_order_items_for_return');



    //    nabeel panga end

    /***************************************************************************/
    /***************************** Third Party Work Order Routes ***********************/
    /***************************************************************************/

    Route::resource('third_party_work_order', 'FineAd\Prerequisites\ThirdPartyWorkOrderController');
    Route::post('/get_batch_items', 'FineAd\Prerequisites\ThirdPartyWorkOrderController@getBatchItems')->name('get_batch_items');



//
//    Route::resource('/departments', 'DepartmentController');
//
//    Route::post('/search_department', 'DepartmentController@index')->name('search_department');
//
//    Route::get('/enable_disable_department', 'EnabledDisabledController@enable_disable_department')->name('enable_disable_department');
//
//    Route::get('/enable_disable_product_measurement_config', 'EnabledDisabledController@enable_disable_product_measurement_config')->name('enable_disable_product_measurement_config');
//
//    Route::get('/enable_disable_project', 'EnabledDisabledController@enable_disable_project')->name('enable_disable_project');
//
//    Route::get('/enable_disable_project_expense', 'EnabledDisabledController@enable_disable_project_expense')->name('enable_disable_project_expense');
//
//    Route::resource('/production', 'FineAd\Prerequisites\ProductionController');

    /***************************************************************************/
    /***************************** Execution Routes ***********************/
    /***************************************************************************/

    Route::get('/execution_list/{array?}/{str?}', 'FineAd\Prerequisites\ExecutionController@execution_list')->name('execution_list'); //new

    Route::post('/execution_list', 'FineAd\Prerequisites\ExecutionController@execution_list')->name('execution_list');//new

});







//
//
//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
