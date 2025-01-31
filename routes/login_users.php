<?php
//asdasdasdasdasd
/* hello world abdullah
 hello world abdullah 123


|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Http\Controllers\AccountOpeningBalancesController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\College\BankIntegrationController;
use App\Http\Controllers\College\CronJobController;
use App\Http\Controllers\College\CustomVoucherController;
use App\Http\Controllers\College\FeeVoucherController;
use App\Http\Controllers\College\PaidFeeVoucherController;
use App\Http\Controllers\College\TransportVoucherController;
use App\Http\Controllers\Controller;

use App\Http\Controllers\EnabledDisabledController;
use App\Http\Controllers\GenerateSalarySlipVoucherController;
use App\Http\Controllers\LoanReceiptVoucherController;
use App\Http\Controllers\LoanVoucherController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\SingleEntryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CardController;
use App\Http\Controllers\FixedAssetVoucherController;
use App\Http\Controllers\IMEIRegisterConroller;
use App\Http\Controllers\College\BankAccountInformationController;

Route::middleware(['auth', 'check.login'])->group(function () {
//Route::group(['middleware' => 'auth'], function () {
    Route::get('/product_search_1', 'ProductSearchTestController@product_search_1');
    Route::get('/product_search_2', 'ProductSearchTestController@product_search_2');
    Route::get('/product_search_3', 'ProductSearchTestController@product_search_3');
    Route::get('/product_dummy', function () {
        for ($i = 20000; $i < 40000; $i++) {
            \App\Models\ProductModel::create([
                'pro_group_id' => 1,
                'pro_category_id' => 1,
                'pro_code' => substr(md5($i), 0, 13),
                'pro_p_code' => substr(md5($i), 0, 13),
                'pro_alternative_code' => substr(md5($i), 0, 13),
                'pro_ISBN' => substr(md5($i), 0, 13),
                'pro_title' => 'Test Product - ' . $i,
            ]);
        }
    });

    Route::group(['middleware' => ['checkEmployee']], function () {
        /***************************************************************************/
        /********************** Welcome Wizard Routes ******************************/
        /***************************************************************************/
        Route::get('/welcome', 'Wizard\WizardController@index')->name('wizard.index');
        Route::get('/welcome2', 'Wizard\WizardController@index2')->name('wizard.index2');
        Route::get('ajax/get-wizard-info', 'Wizard\WizardController@ajaxGetWizardInfo')->name('ajax-get-wizard-info');

        Route::get('/all_listings', function () {
            // $listRoutes = \App\Models\ModularConfigDefinitionModel::where('mcd_title', 'like', '%list%')->orderBy('mcd_title', 'ASC')->get();
            return view('_ab.all_listings', compact('listRoutes'));
        })->name('all_listings');


        /***************************************************************************/
        /******************************** Convert Quantity ******************************/
        /***************************************************************************/

        Route::get('/convert_quantity', 'ConvertQuantityController@show_convert_quantity')->name('convert_quantity');
        Route::post('/submit_convert_quantity', 'ConvertQuantityController@submit_convert_quantity')->name('submit_convert_quantity');
        Route::get('/convert_quantity_list/{array?}/{str?}', 'ConvertQuantityController@convert_quantity_list')->name('convert_quantity_list');
        Route::post('/convert_quantity_list', 'ConvertQuantityController@convert_quantity_list')->name('convert_quantity_list');


        Route::group(['middleware' => ['advancePackage']], function () {

            /***************************************************************************/
            /***************************** Balance Sheet Reports Routes *****************/
            /***************************************************************************/

            Route::get('/balance_sheet_report/{array?}/{str?}', 'FinancialsController@balance_sheet')->name('balance_sheet_report');
            Route::post('/balance_sheet_report', 'FinancialsController@balance_sheet')->name('balance_sheet_report');
            Route::get('/balance_sheet_report_generator', 'FinancialsController@balance_sheet_report_generator')->name('balance_sheet_report_generator');

            /***************************************************************************/
            /***************************** Profit N Loss Reports Routes *****************/
            /***************************************************************************/

            Route::get('/profit_n_loss_generator', 'FinancialsController@profit_n_loss_generator')->name('profit_n_loss_generator');
            Route::get('/profit_n_loss/{array?}/{str?}', 'FinancialsController@profit_n_loss2')->name('profit_n_loss2');
            Route::post('/profit_n_loss', 'FinancialsController@profit_n_loss2')->name('profit_n_loss2');
        });
        /***************************************************************************/
        /******************************** Trade Convert Quantity ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['premiumPackage', 'dayEnd']], function () {
            Route::get('/trade_convert_quantity', 'TradeInvoices\TradeConvertQuantityController@show_trade_convert_quantity')->name('trade_convert_quantity');
            Route::post('/submit_trade_convert_quantity', 'TradeInvoices\TradeConvertQuantityController@submit_trade_convert_quantity')->name('submit_trade_convert_quantity');
            Route::get('/trade_convert_quantity_list/{array?}/{str?}', 'TradeInvoices\TradeConvertQuantityController@trade_convert_quantity_list')->name('trade_convert_quantity_list');
            Route::post('/trade_convert_quantity_list', 'TradeInvoices\TradeConvertQuantityController@trade_convert_quantity_list')->name('trade_convert_quantity_list');
        });

        /***************************************************************************/
        /***************************** Info Box Routes *****************************/
        /***************************************************************************/


        Route::resource('info_box', 'InfoBoxController');
        Route::get('info_box/view/{id}', 'InfoBoxController@info_box_view')->name('info_box_view');
        Route::post('win_size/view', 'InfoBoxController@win_view')->name('win_size');


        /***************************************************************************/
        /******************************** Home Routes ******************************/
        /***************************************************************************/

        Route::get('/index', 'UserController@welcome')->name('index');

        Route::get('/home', 'UserController@welcome')->name('home');
        Route::get('/dashboard', 'UserController@admin_dashboard')->name('dashboard');

        //Route::get('/side_bar_menus', 'SideBarMenusController@side_bar_menus')->name('side_bar_menus');
        //Route::get('/system_config', 'SystemConfigController@store')->name('system_config');

        Route::get('/system_config/system-date', 'SystemConfigController@edit_date')->name('system_config_show_date');
        Route::post('/system_config/system-date', 'SystemConfigController@update_date')->name('system_config_update_date');
        Route::get('/opening_invoice_voucher_sequence', 'SystemConfigController@index')->name('opening_invoice_voucher_sequence');
        Route::resource('/system_config', 'SystemConfigController');


        /***************************************************************************************************/
        /**************************************** Change Profile Routes************************************/
        /***************************************************************************************************/

        Route::get('/admin_profile/{employee_id}', 'UserController@admin_profile')->name('admin_profile');
        Route::post('/update_admin_profile', 'UserController@update_admin_profile')->name('update_admin_profile');

        //        Route::get('/edit_profile', 'UserController@edit_profile')->name('edit_profile');

        //update url by shahzaib start
        Route::get('/prfl_wd_actvty/show/{id}/{array}', 'UserController@prfl_wd_actvty')->name('profile_activity');
        Route::get('/prnt_chck', function () {
            return view('print.region_list.region_list');
        })->name('prnt_chck');
        //update url by shahzaib end


        //        Route::post('/submit_update_profile', 'UserController@update_profile')->name('submit_update_profile');

        Route::group(['middleware' => ['advancePackage']], function () {
            /***************************************************************************/
            /***************************** Region Routes ******************************/
            /***************************************************************************/
            Route::get('/add_region_search_test', 'RegionController@add_region_search_test')->name('add_region_search_test');
            Route::get('/add_region', 'RegionController@add_region')->name('add_region');


            Route::post('/submit_region', 'RegionController@submit_region')->name('submit_region');

            Route::post('/submit_region_excel', 'RegionController@submit_region_excel')->name('submit_region_excel');

            Route::get('/region_list/{array?}/{str?}', 'RegionController@region_list')->name('region_list');

            Route::post('/region_list', 'RegionController@region_list')->name('region_list');

            Route::post('/edit_region', 'RegionController@edit_region')->name('edit_region');

            Route::post('/update_region', 'RegionController@update_region')->name('update_region');

            Route::get('/edit_region', 'RegionController@region_list')->name('edit_region');

            Route::post('/delete_region', 'RegionController@delete_region')->name('delete_region');
            /***************************************************************************/
            /***************************** Designation Routes ******************************/
            /***************************************************************************/
            Route::get('/add_desig', 'DesignationController@add_desig')->name('add_desig');


            Route::post('/submit_desig', 'DesignationController@submit_desig')->name('submit_desig');

            Route::get('/desig_list/{array?}/{str?}', 'DesignationController@desig_list')->name('desig_list');

            Route::post('/desig_list', 'DesignationController@desig_list')->name('desig_list');

            Route::post('/edit_desig', 'DesignationController@edit_desig')->name('edit_desig');

            Route::post('/update_desig', 'DesignationController@update_desig')->name('update_desig');

            Route::get('/edit_desig', 'DesignationController@desig_list')->name('edit_desig');

            Route::post('/delete_desig', 'DesignationController@delete_desig')->name('delete_desig');


            /***************************************************************************/
            /******************************** Area Routes ******************************/
            /***************************************************************************/

            Route::get('/add_area', 'AreaController@add_area')->name('add_area');

            Route::post('/submit_area', 'AreaController@submit_area')->name('submit_area');

            Route::post('/submit_area_excel', 'AreaController@submit_area_excel')->name('submit_area_excel');

            Route::get('/area_list/{array?}/{str?}', 'AreaController@area_list')->name('area_list');

            Route::post('/area_list', 'AreaController@area_list')->name('area_list');

            Route::post('/edit_area', 'AreaController@edit_area')->name('edit_area');

            Route::post('/update_area', 'AreaController@update_area')->name('update_area');

            Route::get('/edit_area', 'AreaController@area_list')->name('edit_area');

            Route::post('/delete_area', 'AreaController@delete_area')->name('delete_area');


            /***************************************************************************/
            /***************************** Sector Routes ******************************/
            /***************************************************************************/

            Route::get('/add_sector', 'SectorController@add_sector')->name('add_sector');

            Route::post('/submit_sector', 'SectorController@submit_sector')->name('submit_sector');

            Route::post('/submit_sector_excel', 'SectorController@submit_sector_excel')->name('submit_sector_excel');

            Route::get('/sector_list/{array?}/{str?}', 'SectorController@sector_list')->name('sector_list');

            Route::post('/sector_list', 'SectorController@sector_list')->name('sector_list');

            Route::post('/edit_sector', 'SectorController@edit_sector')->name('edit_sector');

            Route::post('/update_sector', 'SectorController@update_sector')->name('update_sector');

            Route::get('/edit_sector', 'SectorController@sector_list')->name('edit_sector');

            Route::post('/delete_sector', 'SectorController@delete_sector')->name('delete_sector');
        });

        /***************************************************************************/
        /********************** Account Registeration Routes ***********************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/account_registration', 'AccountRegisterationsController@account_registration')->name('account_registration');
        });
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/expense_account_registration', 'AccountRegisterationsController@expense_account_registration')->name('expense_account_registration');

            Route::get('/expense_account_list/{array?}/{str?}', 'AccountRegisterationsController@expense_account_list')->name('expense_account_list');

            Route::post('/expense_account_list', 'AccountRegisterationsController@expense_account_list')->name('expense_account_list');
        });

        Route::post('/get_head', 'AccountRegisterationsController@get_head')->name('get_head');

        Route::post('/get_account_heads', 'AccountRegisterationsController@get_account_heads')->name('get_account_heads');

        Route::post('/submit_account', 'AccountRegisterationsController@submit_other_account')->name('submit_account');

        Route::post('/submit_account_excel', 'AccountRegisterationsController@submit_other_account_excel')->name('submit_account_excel');

        Route::post('/check_name', 'AccountRegisterationsController@check_name')->name('check_name');

        Route::get('/account_list', 'AccountRegisterationsController@account_list')->name('account_list');

        Route::post('/account_list', 'AccountRegisterationsController@account_list')->name('account_list');

        Route::post('/edit_account', 'AccountRegisterationsController@edit_account')->name('edit_account');

        Route::post('/update_account', 'AccountRegisterationsController@update_account')->name('update_account');

        Route::get('/edit_account', 'AccountRegisterationsController@account_list')->name('edit_account');

        Route::post('/delete_account', 'AccountRegisterationsController@delete_account')->name('delete_account');


        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/receivables_account_registration', 'AccountRegisterationsController@receivables_account_registration')->name('receivables_account_registration');

            Route::post('/submit_receivables_account', 'AccountRegisterationsController@submit_receivables_payable_account')->name('submit_receivables_account');

            Route::post('/submit_receivables_account_excel', 'AccountRegisterationsController@submit_receivables_payable_account_excel')->name('submit_receivables_account_excel');

            Route::get('/payables_account_registration', 'AccountRegisterationsController@payables_account_registration')->name('payables_account_registration');

            Route::get('/payables_account_registration_excel', 'AccountRegisterationsController@payables_account_registration_excel')->name('payables_account_registration_excel');

            Route::post('/submit_payables_account', 'AccountRegisterationsController@submit_receivables_payable_account')->name('submit_payables_account');
            Route::post('/submit_payables_account_excel', 'AccountRegisterationsController@submit_receivables_payable_account_excel')->name('submit_payables_account_excel');

            Route::post('/edit_account_receivable_payable', 'AccountRegisterationsController@edit_account_receivable_payable')->name('edit_account_receivable_payable');

            Route::post('/update_account_receivable_payable', 'AccountRegisterationsController@update_account_receivable_payable')->name('update_account_receivable_payable');

            Route::get('/edit_account_receivable_payable', 'AccountRegisterationsController@account_receivable_payable_list')->name('edit_account_receivable_payable');

            Route::get('/account_receivable_payable_list/{array?}/{str?}', 'AccountRegisterationsController@account_receivable_payable_list')->name('account_receivable_payable_list');

            Route::post('/account_receivable_payable_list', 'AccountRegisterationsController@account_receivable_payable_list')->name('account_receivable_payable_list');

            Route::get('/client_recovery_report/{array?}/{str?}', 'AllReportsController@client_recovery_report')->name('client_recovery_report');

            Route::post('/client_recovery_report', 'AllReportsController@client_recovery_report')->name('client_recovery_report');


            ///***************************************************************************/
            ///***************************** Client Supplier Account Balance by nabeel ********************************/
            ///***************************************************************************/

            Route::get('/account_receivable_payable_simple_list/{array?}/{str?}', 'AccountRegisterationsController@account_receivable_payable_simple_list')->name('account_receivable_payable_simple_list');

            Route::post('/account_receivable_payable_simple_list', 'AccountRegisterationsController@account_receivable_payable_simple_list')->name('account_receivable_payable_simple_list');
        });


        /***************************************************************************/
        /***************************** Group Routes ********************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/add_group', 'GroupInfoController@add_group')->name('add_group');

            Route::post('/submit_group', 'GroupInfoController@submit_group')->name('submit_group');

            Route::post('/submit_group_excel', 'GroupInfoController@submit_group_excel')->name('submit_group_excel');

            Route::get('/group_list', 'GroupInfoController@group_list')->name('group_list');

            Route::post('/group_list', 'GroupInfoController@group_list')->name('group_list');

            Route::post('/edit_group', 'GroupInfoController@edit_group')->name('edit_group');

            Route::post('/update_group', 'GroupInfoController@update_group')->name('update_group');

            Route::get('/edit_group', 'GroupInfoController@group_list')->name('edit_group');

            Route::post('/delete_group', 'GroupInfoController@delete_group')->name('delete_group');


            /***************************************************************************/
            /***************************** Category Routes *****************************/
            /***************************************************************************/

            Route::get('/add_category', 'CategoryInfoController@add_category')->name('add_category');

            Route::post('/submit_category', 'CategoryInfoController@submit_category')->name('submit_category');

            Route::post('/submit_category_excel', 'CategoryInfoController@submit_category_excel')->name('submit_category_excel');

            Route::post('/get_category', 'CategoryInfoController@get_category')->name('get_category');

            Route::get('/category_list/{array?}/{str?}', 'CategoryInfoController@category_list')->name('category_list');

            Route::post('/category_list', 'CategoryInfoController@category_list')->name('category_list');

            Route::post('/edit_category', 'CategoryInfoController@edit_category')->name('edit_category');

            Route::post('/update_category', 'CategoryInfoController@update_category')->name('update_category');

            Route::get('/edit_category', 'CategoryInfoController@category_list')->name('edit_category');

            Route::post('/delete_category', 'CategoryInfoController@delete_category')->name('delete_category');


            /***************************************************************************/
            /***************************** Main Unit Routes ****************************/
            /***************************************************************************/

            Route::get('/add_main_unit', 'MainUnitController@add_main_unit')->name('add_main_unit');

            Route::post('/submit_main_unit', 'MainUnitController@submit_main_unit')->name('submit_main_unit');

            Route::post('/submit_main_unit_excel', 'MainUnitController@submit_main_unit_excel')->name('submit_main_unit_excel');

            Route::get('/main_unit_list/{array?}/{str?}', 'MainUnitController@main_unit_list')->name('main_unit_list');

            Route::post('/main_unit_list', 'MainUnitController@main_unit_list')->name('main_unit_list');

            Route::post('/edit_main_unit', 'MainUnitController@edit_main_unit')->name('edit_main_unit');

            Route::get('/edit_main_unit', 'MainUnitController@unit_main_list')->name('edit_main_unit');

            Route::post('/update_main_unit', 'MainUnitController@update_main_unit')->name('update_main_unit');

            Route::post('/delete_main_unit', 'MainUnitController@delete_main_unit')->name('delete_main_unit');


            /***************************************************************************/
            /***************************** Unit Routes *********************************/
            /***************************************************************************/

            Route::get('/add_unit', 'UnitInfoController@add_unit')->name('add_unit');

            Route::post('/submit_unit', 'UnitInfoController@submit_unit')->name('submit_unit');

            Route::post('/submit_unit_excel', 'UnitInfoController@submit_unit_excel')->name('submit_unit_excel');

            Route::post('/get_unit', 'UnitInfoController@get_unit')->name('get_unit');

            Route::get('/unit_list', 'UnitInfoController@unit_list')->name('unit_list');

            Route::post('/unit_list', 'UnitInfoController@unit_list')->name('unit_list');

            Route::post('/edit_unit', 'UnitInfoController@edit_unit')->name('edit_unit');

            Route::post('/update_unit', 'UnitInfoController@update_unit')->name('update_unit');

            Route::get('/edit_unit', 'UnitInfoController@unit_list')->name('edit_unit');

            Route::post('/delete_unit', 'UnitInfoController@delete_unit')->name('delete_unit');
        });
        /***************************************************************************/
        /***************************** Product Routes ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/add_product', 'ProductController@add_product')->name('add_product');

            Route::post('/submit_product', 'ProductController@submit_product')->name('submit_product');

            Route::post('/submit_product_excel', 'ProductController@submit_product_excel')->name('submit_product_excel');

            Route::get('/product_list/{array?}/{str?}', 'ProductController@product_list')->name('product_list');

            Route::post('/product_list', 'ProductController@product_list')->name('product_list');

            Route::post('/edit_product', 'ProductController@edit_product')->name('edit_product');

            Route::post('/update_product', 'ProductController@update_product')->name('update_product');

            Route::get('/edit_product', 'ProductController@product_list')->name('edit_product');

            //Route::get('/product_wise_report', 'ProductController@product_wise_report')->name('product_wise_report');
            //
            //Route::post('/product_wise_purchases_sales_report', 'ProductController@product_wise_purchases_sales_report')->name('product_wise_purchases_sales_report');
            //
            //Route::get('/product_wise_return_report', 'ProductController@product_wise_return_report')->name('product_wise_return_report');
            //
            //Route::post('/product_wise_purchases_sales_return_report', 'ProductController@product_wise_purchases_sales_return_report')->name('product_wise_purchases_sales_return_report');

            Route::post('/delete_product', 'ProductController@delete_product')->name('delete_product');

            Route::post('/change_status_product', 'ProductController@change_status_product')->name('change_status_product');

            Route::get('/change_sale_bottom_price', 'ProductController@change_sale_bottom_price')->name('change_sale_bottom_price');

            /***************************************************************************/
            /******************** Product Online Routes *************************/
            /***************************************************************************/

            Route::get('/online_product_list/{array?}/{str?}', 'ProductController@online_product_list')->name('online_product_list');

            Route::post('/online_product_list', 'ProductController@online_product_list')->name('online_product_list');

            Route::post('/update_online_product_list', 'ProductController@update_online_product_list')->name('update_online_product_list');
        });
        /***************************************************************************/
        /***************************** Product Loss Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/product_loss', 'ProductLossController@product_loss')->name('product_loss');

            Route::post('/submit_product_loss', 'ProductLossController@submit_product_loss')->name('submit_product_loss');

            Route::get('/product_loss_list', 'ProductLossController@product_loss_list')->name('product_loss_list');

            Route::post('/product_loss_list', 'ProductLossController@product_loss_list')->name('product_loss_list');

            Route::post('/product_loss_recover_items_view_details', 'ProductLossController@product_loss_recover_items_view_details')->name('product_loss_recover_items_view_details');

            Route::get('/product_loss_recover_items_view_details/view/{id}', 'ProductLossController@product_loss_recover_items_view_details_SH')->name('product_loss_recover_items_view_details_SH');

            Route::get('/product_loss_recover_items_view_details/view/pdf/{id}', 'ProductLossController@product_loss_recover_items_view_details_pdf_SH')->name('product_loss_recover_items_view_details_pdf_SH');


            /***************************************************************************/
            /***************************** Trade Product Loss Routes *************************/
            /***************************************************************************/

            Route::get('/trade_product_loss', 'TradeInvoices\TradeProductLossController@trade_product_loss')->name('trade_product_loss');

            Route::post('/submit_trade_product_loss', 'TradeInvoices\TradeProductLossController@submit_trade_product_loss')->name('submit_trade_product_loss');


            Route::get('/trade_product_loss_list', 'TradeInvoices\TradeProductLossController@trade_product_loss_list')->name('trade_product_loss_list');

            Route::post('/trade_product_loss_list', 'TradeInvoices\TradeProductLossController@trade_product_loss_list')->name('trade_product_loss_list');

            Route::post('/trade_product_loss_recover_items_view_details', 'TradeInvoices\TradeProductLossController@trade_product_loss_recover_items_view_details')->name('trade_product_loss_recover_items_view_details');

            Route::get('/trade_product_loss_recover_items_view_details/view/{id}', 'TradeInvoices\TradeProductLossController@trade_product_loss_recover_items_view_details_SH')->name('trade_product_loss_recover_items_view_details_SH');

            Route::get('/trade_product_loss_recover_items_view_details/view/pdf/{id}', 'TradeInvoices\TradeProductLossController@trade_product_loss_recover_items_view_details_pdf_SH')->name('trade_product_loss_recover_items_view_details_pdf_SH');


            /***************************************************************************/
            /***************************** Product Recover Routes **********************/
            /***************************************************************************/

            Route::get('/product_recover', 'ProductRecoverController@product_recover')->name('product_recover');

            Route::post('/submit_product_recover', 'ProductRecoverController@submit_product_recover')->name('submit_product_recover');

            Route::get('/product_recover_list/{array?}/{str?}', 'ProductRecoverController@product_recover_list')->name('product_recover_list');

            Route::post('/product_recover_list', 'ProductRecoverController@product_recover_list')->name('product_recover_list');


            /***************************************************************************/
            /***************************** Trade Product Recover Routes **********************/
            /***************************************************************************/

            Route::get('/trade_product_recover', 'TradeInvoices\TradeProductRecoverController@trade_product_recover')->name('trade_product_recover');

            Route::post('/submit_trade_product_recover', 'TradeInvoices\TradeProductRecoverController@submit_trade_product_recover')->name('submit_trade_product_recover');


            Route::get('/trade_product_recover_list/{array?}/{str?}', 'TradeInvoices\TradeProductRecoverController@trade_product_recover_list')->name('trade_product_recover_list');

            Route::post('/trade_product_recover_list', 'TradeInvoices\TradeProductRecoverController@trade_product_recover_list')->name('trade_product_recover_list');
        });
        /***************************************************************************/
        /***************************** Purchase Invoice Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {


            Route::get('/purchase_invoice', 'PurchaseInvoiceController@purchase_invoice')->name('purchase_invoice');

            Route::post('/submit_purchase_invoice', 'PurchaseInvoiceController@submit_purchase_invoice')->name('submit_purchase_invoice');

            Route::post('/get_purchase_items_for_return', 'PurchaseInvoiceController@get_purchase_items_for_return')->name('get_purchase_items_for_return');

            Route::get('/purchase_invoice_list/{array?}/{str?}', 'PurchaseInvoiceController@purchase_invoice_list')->name('purchase_invoice_list');

            Route::post('/purchase_invoice_list', 'PurchaseInvoiceController@purchase_invoice_list')->name('purchase_invoice_list');

            Route::post('/purchase_items_view_details', 'PurchaseInvoiceController@purchase_items_view_details')->name('purchase_items_view_details');

            Route::get('/purchase_items_view_details/view/{id}', 'PurchaseInvoiceController@purchase_items_view_details_SH')->name('purchase_items_view_details_sh');

            Route::get('/purchase_items_view_details/view/pdf/{id}/{array?}/{str?}', 'PurchaseInvoiceController@purchase_items_view_details_pdf_SH')->name('purchase_items_view_details_pdf_sh');
        });


        /***************************************************************************/
        /******************* Purchase Sale Tax Invoice Routes **********************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/sale_tax_purchase_invoice_list', 'PurchaseInvoiceController@sale_tax_purchase_invoice_list')->name('sale_tax_purchase_invoice_list');

            Route::post('/sale_tax_purchase_invoice_list', 'PurchaseInvoiceController@sale_tax_purchase_invoice_list')->name('sale_tax_purchase_invoice_list');

            Route::get('/purchase_items_sale_tax_view_details/view/{id}', 'PurchaseInvoiceController@sale_tax_purchase_items_view_details_SH')->name('sale_tax_purchase_items_view_details_SH');

            Route::get('/purchase_items_sale_tax_view_details/view/pdf/{id}/{array?}/{str?}', 'PurchaseInvoiceController@sale_tax_purchase_items_view_details_pdf_SH')->name('sale_tax_purchase_items_view_details_pdf_SH');
        });
        /***************************************************************************/
        /***************************** Purchase Return Invoice Routes **************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/purchase_return_invoice', 'PurchaseReturnInvoiceController@purchase_return_invoice')->name('purchase_return_invoice');

            Route::post('/submit_purchase_return_invoice', 'PurchaseReturnInvoiceController@submit_purchase_return_invoice')->name('submit_purchase_return_invoice');

            Route::get('/purchase_return_invoice_list/{array?}/{str?}', 'PurchaseReturnInvoiceController@purchase_return_invoice_list')->name('purchase_return_invoice_list');

            Route::get('/purchase_return_items_invoice_list/view/{id}', 'PurchaseReturnInvoiceController@purchase_return_items_view_details_SH')->name('purchase_return_items_view_details_SH');

            Route::get('/purchase_return_items_invoice_list/view/pdf/{id}/{array?}/{str?}', 'PurchaseReturnInvoiceController@purchase_return_items_view_details_pdf_SH')->name('purchase_return_items_view_details_pdf_SH');

            Route::post('/purchase_return_invoice_list', 'PurchaseReturnInvoiceController@purchase_return_invoice_list')->name('purchase_return_invoice_list');

            Route::post('/get_purchased_items_for_return', 'PurchaseInvoiceController@get_purchased_items_for_return')->name('get_purchased_items_for_return');
        });

        /***************************************************************************/
        /*****************************Prego Temp Purchase Invoice Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {


            Route::get('/get_temp_purchase_items_for_purchase', 'TempPurchaseInvoiceController@get_temp_purchase_items_for_purchase')->name('get_temp_purchase_items_for_purchase');
            Route::get('/temp_purchase_invoice', 'TempPurchaseInvoiceController@temp_purchase_invoice')->name('temp_purchase_invoice');

            Route::post('/submit_temp_to_purchase_invoice', 'TempPurchaseInvoiceController@submit_temp_to_purchase_invoice')->name('submit_temp_to_purchase_invoice');

            // Route::post('/get_purchase_items_for_return', 'TempPurchaseInvoiceController@get_purchase_items_for_return')->name('get_purchase_items_for_return');

            Route::get('/purchase_invoice_temp_list/{array?}/{str?}', 'TempPurchaseInvoiceController@purchase_invoice_temp_list')->name('purchase_invoice_temp_list');

            Route::post('/purchase_invoice_temp_list', 'TempPurchaseInvoiceController@purchase_invoice_temp_list')->name('purchase_invoice_temp_list');

            // Route::post('/purchase_items_view_details', 'TempPurchaseInvoiceController@purchase_items_view_details')->name('purchase_items_view_details');

            // Route::get('/purchase_items_view_details/view/{id}', 'TempPurchaseInvoiceController@purchase_items_view_details_SH')->name('purchase_items_view_details_sh');

            // Route::get('/purchase_items_view_details/view/pdf/{id}/{array?}/{str?}', 'TempPurchaseInvoiceController@purchase_items_view_details_pdf_SH')->name('purchase_items_view_details_pdf_sh');

        });
        /***************************************************************************/
        /******************* Purchase Return Sale Tax Invoice Routes ***************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/sale_tax_purchase_return_invoice_list', 'PurchaseInvoiceController@sale_tax_purchase_return_invoice_list')->name('sale_tax_purchase_return_invoice_list');

            Route::post('/sale_tax_purchase_return_invoice_list', 'PurchaseInvoiceController@sale_tax_purchase_return_invoice_list')->name('sale_tax_purchase_return_invoice_list');

            Route::get('/return_purchase_items_sale_tax_view_details/view/{id}', 'PurchaseInvoiceController@return_sale_tax_purchase_items_view_details_SH')->name('return_sale_tax_purchase_items_view_details_SH');

            Route::get('/return_purchase_items_sale_tax_view_details/view/pdf/{id}/{array?}/{str?}', 'PurchaseInvoiceController@return_sale_tax_purchase_items_view_details_pdf_SH')->name('return_sale_tax_purchase_items_view_details_pdf_SH');
        });
        /***************************************************************************/
        /***************************** Sale Invoice Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/sale_invoice', 'SaleInvoiceController@sale_invoice')->name('sale_invoice');

            Route::get('/sale_invoice_old', 'SaleInvoiceController@sale_invoice_old')->name('sale_invoice_old');

            Route::post('/submit_sale_invoice', 'SaleInvoiceController@submit_sale_invoice')->name('submit_sale_invoice');

            Route::get('/sale_invoice_list/{array?}/{str?}', 'SaleInvoiceController@sale_invoice_list')->name('sale_invoice_list');

            Route::post('/sale_invoice_list', 'SaleInvoiceController@sale_invoice_list')->name('sale_invoice_list');

            Route::post('/sale_items_view_details', 'SaleInvoiceController@sale_items_view_details')->name('sale_items_view_details');

            //Route::get('/sale_items_view_details/view/{id}', 'SaleInvoiceController@sale_items_view_details_SH')->name('sale_items_view_details_sh');

            //Route::get('/sale_items_view_details/view/pdf/{id}/{array?}/{str?}', 'SaleInvoiceController@sale_items_view_details_pdf_SH')->name('sale_items_view_details_pdf_sh');


            //    panga by nabeel
            Route::get('/sale_register/{array?}/{str?}', 'SaleInvoiceController@sale_register')->name('sale_register');

            Route::post('/sale_register', 'SaleInvoiceController@sale_register')->name('sale_register');

            Route::post('/sale_items_view_details', 'SaleInvoiceController@sale_items_view_details')->name('sale_items_view_details');

            Route::get('/purchase_register/{array?}/{str?}', 'PurchaseInvoiceController@purchase_register')->name('purchase_register');

            Route::post('/purchase_register', 'PurchaseInvoiceController@purchase_register')->name('purchase_register');


            Route::post('/get_credit_limit', 'SaleInvoiceController@get_credit_limit')->name('get_credit_limit');

            Route::get('/get_sale_person', 'SaleInvoiceController@get_sale_person')->name('get_sale_person');
        });
        /***************************************************************************/
        /******************* Sale Sale Tax Invoice Routes **************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/sale_tax_sale_invoice_list', 'SaleInvoiceController@sale_tax_sale_invoice_list')->name('sale_tax_sale_invoice_list');

            Route::post('/sale_tax_sale_invoice_list', 'SaleInvoiceController@sale_tax_sale_invoice_list')->name('sale_tax_sale_invoice_list');

            Route::get('/sale_tax_sale_invoice_list/view/{id}', 'SaleInvoiceController@sale_sale_tax_items_view_details_SH')->name('sale_sale_tax_items_view_details_SH');

            //Route::get('/sale_tax_sale_invoice_list/view/pdf/{id}/{array?}/{str?}', 'SaleInvoiceController@sale_sale_tax_items_view_details_pdf_SH')->name('sale_sale_tax_items_view_details_pdf_SH');

        });
        /***************************************************************************/
        /***************** new Trade Sale Return Invoice Routes ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/trade_sale_return_invoice', 'TradeInvoices\TradeSaleReturnInvoiceController@sale_return_invoice')->name('trade_sale_return_invoice');

            Route::post('/get_trade_sale_items_for_return', 'TradeInvoices\TradeSaleReturnInvoiceController@get_trade_sale_items_for_return')->name('get_trade_sale_items_for_return');

            Route::post('/submit_trade_sale_return_invoice', 'TradeInvoices\TradeSaleReturnInvoiceController@submit_trade_sale_return_invoice')->name('submit_trade_sale_return_invoice');


            Route::get('/trade_sale_return_invoice_list', 'TradeInvoices\TradeSaleReturnInvoiceController@trade_sale_return_invoice_list')->name('trade_sale_return_invoice_list');

            Route::post('/trade_sale_return_invoice_list', 'TradeInvoices\TradeSaleReturnInvoiceController@trade_sale_return_invoice_list')->name('trade_sale_return_invoice_list');


            Route::get('/trade_sale_return_invoice_list/view/{id}', 'TradeInvoices\TradeSaleReturnInvoiceController@trade_sale_return_items_view_details_SH')->name('trade_sale_return_items_view_details_SH');

            Route::get('/trade_sale_return_invoice_list/view/pdf/{id}/{array?}/{str?}', 'TradeInvoices\TradeSaleReturnInvoiceController@trade_sale_return_items_view_details_pdf_SH')->name('trade_sale_return_items_view_details_pdf_SH');
        });
        //nabeel
        /***************************************************************************/
        /***************** new Trade Sale Tax Return Invoice Routes ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/trade_sale_tax_return_invoice', 'TradeInvoices\TradeSaleTaxReturnInvoiceController@trade_sale_tax_return_invoice')->name('trade_sale_tax_return_invoice');

            Route::post('/get_trade_sale_items_for_return', 'TradeInvoices\TradeSaleTaxReturnInvoiceController@get_trade_sale_items_for_return')->name('get_trade_sale_items_for_return');

            Route::post('/submit_trade_sale_tax_return_invoice', 'TradeInvoices\TradeSaleTaxReturnInvoiceController@submit_trade_sale_tax_return_invoice')->name('submit_trade_sale_tax_return_invoice');

            Route::get('/trade_sale_tax_sale_return_invoice_list', 'TradeInvoices\TradeSaleTaxReturnInvoiceController@trade_sale_tax_sale_return_invoice_list')->name('trade_sale_tax_sale_return_invoice_list');

            Route::post('/trade_sale_tax_sale_return_invoice_list', 'TradeInvoices\TradeSaleTaxReturnInvoiceController@trade_sale_tax_sale_return_invoice_list')->name('trade_sale_tax_sale_return_invoice_list');

            Route::get('/trade_sale_tax_sale_return_invoice_list/view/{id}', 'TradeInvoices\TradeSaleTaxReturnInvoiceController@trade_sale_return_saletax_items_view_details_SH')->name('trade_sale_return_saletax_items_view_details_SH');

            //    Route::get('/trade_sale_tax_sale_return_invoice_list/view/pdf/{id}/{array?}/{str?}', 'TradeSaleTaxReturnInvoiceController@trade_sale_return_saletax_items_view_details_pdf_SH')->name('trade_sale_return_saletax_items_view_details_pdf_SH');

        });


        /***************************************************************************/
        /***************** new Simple Sale Return Invoice Routes ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/simple_sale_return_invoice', 'SimpleInvoices\SimpleSaleReturnInvoiceController@simple_sale_return_invoice')->name('simple_sale_return_invoice');

            Route::post('/get_simple_sale_items_for_return', 'SimpleInvoices\SimpleSaleReturnInvoiceController@get_simple_sale_items_for_return')->name('get_simple_sale_items_for_return');

            Route::post('/submit_simple_sale_return_invoice', 'SimpleInvoices\SimpleSaleReturnInvoiceController@submit_simple_sale_return_invoice')->name('submit_simple_sale_return_invoice');


            Route::get('/simple_sale_return_invoice_list', 'SimpleInvoices\SimpleSaleReturnInvoiceController@simple_sale_return_invoice_list')->name('simple_sale_return_invoice_list');

            Route::post('/simple_sale_return_invoice_list', 'SimpleInvoices\SimpleSaleReturnInvoiceController@simple_sale_return_invoice_list')->name('simple_sale_return_invoice_list');


            Route::get('/simple_sale_return_invoice_list/view/{id}', 'SimpleInvoices\SimpleSaleReturnInvoiceController@simple_sale_return_items_view_details_SH')->name('simple_sale_return_items_view_details_SH');

            Route::get('/simple_sale_return_invoice_list/view/pdf/{id}/{array?}/{str?}', 'SimpleInvoices\SimpleSaleReturnInvoiceController@simple_sale_return_items_view_details_pdf_SH')->name('simple_sale_return_items_view_details_pdf_SH');
        });
        //nabeel


        /***************************************************************************/
        /***************** new Simple Sale Tax Return Invoice Routes ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/sale_tax_return_invoice', 'SimpleInvoices\SimpleSaleTaxReturnInvoiceController@simple_sale_tax_return_invoice')->name('simple_sale_tax_return_invoice');

            Route::post('/get_simple_sale_items_for_return', 'SimpleInvoices\SimpleSaleTaxReturnInvoiceController@get_simple_sale_items_for_return')->name('get_simple_sale_items_for_return');

            Route::post('/submit_simple_sale_tax_return_invoice', 'SimpleInvoices\SimpleSaleTaxReturnInvoiceController@submit_simple_sale_tax_return_invoice')->name('submit_simple_sale_tax_return_invoice');

            Route::get('/simple_sale_tax_sale_return_invoice_list', 'SimpleInvoices\SimpleSaleTaxReturnInvoiceController@simple_sale_tax_sale_return_invoice_list')->name('simple_sale_tax_sale_return_invoice_list');

            Route::post('/simple_sale_tax_sale_return_invoice_list', 'SimpleInvoices\SimpleSaleTaxReturnInvoiceController@simple_sale_tax_sale_return_invoice_list')->name('simple_sale_tax_sale_return_invoice_list');

            Route::get('/simple_sale_tax_sale_return_invoice_list/view/{id}', 'SimpleInvoices\SimpleSaleTaxReturnInvoiceController@simple_sale_return_saletax_items_view_details_SH')->name('simple_sale_return_saletax_items_view_details_SH');

            //    Route::get('/simple_sale_tax_sale_return_invoice_list/view/pdf/{id}/{array?}/{str?}', 'SimpleSaleTaxReturnInvoiceController@trade_sale_return_saletax_items_view_details_pdf_SH')->name('trade_sale_return_saletax_items_view_details_pdf_SH');

        });


        /***************************************************************************/
        /***************** Sale Return Invoice Routes ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/sale_return_invoice', 'SaleReturnInvoiceController@sale_return_invoice')->name('sale_return_invoice');

            Route::post('/submit_sale_return_invoice', 'SaleReturnInvoiceController@submit_sale_return_invoice')->name('submit_sale_return_invoice');

            Route::get('/sale_return_invoice_list', 'SaleReturnInvoiceController@sale_return_invoice_list')->name('sale_return_invoice_list');

            Route::post('/sale_return_invoice_list', 'SaleReturnInvoiceController@sale_return_invoice_list')->name('sale_return_invoice_list');

            Route::post('/get_sale_items_for_return', 'SaleReturnInvoiceController@get_sale_items_for_return')->name('get_sale_items_for_return');


            Route::get('/sale_return_invoice_list/view/{id}', 'SaleReturnInvoiceController@sale_return_items_view_details_SH')->name('sale_return_items_view_details_SH');

            //Route::get('/sale_return_invoice_list/view/pdf/{id}/{array?}/{str?}', 'SaleReturnInvoiceController@sale_return_items_view_details_pdf_SH')->name('sale_return_items_view_details_pdf_SH');

        });
        /***************************************************************************/
        /**************** Sale Return Sale Tax Invoice Routes **********************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/sale_tax_sale_return_invoice_list', 'SaleReturnInvoiceController@sale_tax_sale_return_invoice_list')->name('sale_tax_sale_return_invoice_list');

            Route::post('/sale_tax_sale_return_invoice_list', 'SaleReturnInvoiceController@sale_tax_sale_return_invoice_list')->name('sale_tax_sale_return_invoice_list');

            Route::get('/sale_tax_sale_return_invoice_list/view/{id}', 'SaleReturnInvoiceController@sale_return_saletax_items_view_details_SH')->name('sale_return_saletax_items_view_details_SH');

            //Route::get('/sale_tax_sale_return_invoice_list/view/pdf/{id}/{array?}/{str?}', 'SaleReturnInvoiceController@sale_return_saletax_items_view_details_pdf_SH')->name('sale_return_saletax_items_view_details_pdf_SH');
        });

        /***************************************************************************/
        /***************************** Inventory Routes ******************************/
        /***************************************************************************/

        Route::post('/get_inventory', 'InventoryController@get_inventory')->name('get_inventory');

        /***************************************************************************/
        /***************************** Journal Voucher Routes **********************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/journal_voucher', 'JournalVoucherController@journal_voucher')->name('journal_voucher');

            Route::get('/journal_voucher_bank', 'JournalVoucherController@journal_voucher_bank')->name('journal_voucher_bank');

            //Route::get('/journal_voucher_reference', 'JournalVoucherController@journal_voucher_reference')->name('journal_voucher_reference');

            Route::post('/submit_journal_voucher', 'JournalVoucherController@submit_journal_voucher')->name('submit_journal_voucher');

            Route::get('/journal_voucher_list/{array?}/{str?}', 'JournalVoucherController@journal_voucher_list')->name('journal_voucher_list');

            Route::post('/journal_voucher_list', 'JournalVoucherController@journal_voucher_list')->name('journal_voucher_list');

            Route::post('/journal_voucher_items_view_details', 'JournalVoucherController@journal_voucher_items_view_details')->name('journal_voucher_items_view_details');

            Route::get('/journal_voucher_bank_list', 'JournalVoucherController@journal_voucher_list')->name('journal_voucher_bank_list');

            Route::post('/journal_voucher_bank_list', 'JournalVoucherController@journal_voucher_list')->name('journal_voucher_bank_list');

            Route::get('/journal_voucher_items_view_details/view/{id}', 'JournalVoucherController@journal_voucher_items_view_details_SH')->name('journal_voucher_items_view_details_SH');

            Route::get('/journal_voucher_items_view_details/pdf/{id}', 'JournalVoucherController@journal_voucher_items_view_details_pdf_SH')->name('journal_voucher_items_view_details_pdf_SH');
        });

        /***************************************************************************/
        /***************************** Journal Voucher Reference  Routes **********************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            //Route::get('/journal_voucher', 'JournalVoucherReferenceController@journal_voucher')->name('journal_voucher');

            //Route::get('/journal_voucher_bank', 'JournalVoucherReferenceController@journal_voucher_bank')->name('journal_voucher_bank');

            Route::get('/journal_voucher_reference', 'JournalVoucherReferenceController@journal_voucher_reference')->name('journal_voucher_reference');

            Route::post('/submit_journal_voucher_reference', 'JournalVoucherReferenceController@submit_journal_voucher_reference')->name('submit_journal_voucher_reference');

            Route::get('/journal_voucher_reference_list/{array?}/{str?}', 'JournalVoucherReferenceController@journal_voucher_reference_list')->name('journal_voucher_reference_list');

            Route::post('/journal_voucher_reference_list', 'JournalVoucherReferenceController@journal_voucher_reference_list')->name('journal_voucher_reference_list');

            Route::post('/journal_voucher_reference_items_view_details', 'JournalVoucherReferenceController@journal_voucher_reference_items_view_details')->name('journal_voucher_reference_items_view_details');

            Route::get('/journal_voucher_bank_list', 'JournalVoucherReferenceController@journal_voucher_list')->name('journal_voucher_bank_list');

            Route::post('/journal_voucher_bank_list', 'JournalVoucherReferenceController@journal_voucher_list')->name('journal_voucher_bank_list');

            Route::get('/journal_voucher_reference_items_view_details/view/{id}', 'JournalVoucherReferenceController@journal_voucher_reference_items_view_details_SH')->name('journal_voucher_reference_items_view_details_SH');

            Route::get('/journal_voucher_reference_items_view_details/pdf/{id}', 'JournalVoucherReferenceController@journal_voucher_reference_items_view_details_pdf_SH')->name('journal_voucher_reference_items_view_details_pdf_SH');
        });

        /***************************************************************************/
        /***************************** Fixed Asset Voucher Routes *****************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/fixed_asset_voucher', [FixedAssetVoucherController::class, 'fixed_asset_voucher'])->name('fixed_asset_voucher');

            Route::post('/submit_fixed_asset_voucher', [FixedAssetVoucherController::class, 'submit_fixed_asset_voucher'])->name('submit_fixed_asset_voucher');

            Route::get('/fixed_asset_voucher_list/{array?}/{str?}', [FixedAssetVoucherController::class, 'fixed_asset_voucher_list'])->name('fixed_asset_voucher_list');

            Route::post('/fixed_asset_voucher_list', [FixedAssetVoucherController::class, 'fixed_asset_voucher_list'])->name('fixed_asset_voucher_list');

            Route::post('/fixed_asset_items_view_details', [FixedAssetVoucherController::class, 'fixed_asset_items_view_details'])->name('fixed_asset_items_view_details');

            Route::get('/fixed_asset_items_view_details/view/{id}', [FixedAssetVoucherController::class, 'fixed_asset_items_view_details_SH'])->name('fixed_asset_items_view_details_SH');

            Route::get('/fixed_asset_items_view_details/pdf/{id}', [FixedAssetVoucherController::class, 'fixed_asset_items_view_details_pdf_SH'])->name('fixed_asset_items_view_details_pdf_SH');
        });

        /***************************************************************************/
        /***************************** Loan Voucher Routes *****************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/loan_voucher', [LoanVoucherController::class, 'loan_voucher'])->name('loan_voucher');

            Route::post('/submit_loan_voucher', [LoanVoucherController::class, 'submit_loan_voucher'])->name('submit_loan_voucher');

            Route::get('/loan_voucher_list/{array?}/{str?}', [LoanVoucherController::class, 'loan_voucher_list'])->name('loan_voucher_list');

            Route::post('/loan_voucher_list', [LoanVoucherController::class, 'loan_voucher_list'])->name('loan_voucher_list');

            Route::post('/loan_items_view_details', [LoanVoucherController::class, 'loan_items_view_details'])->name('loan_items_view_details');

            Route::get('/loan_items_view_details/view/{id}', [LoanVoucherController::class, 'loan_items_view_details_SH'])->name('loan_items_view_details_SH');

            Route::get('/loan_items_view_details/pdf/{id}', [LoanVoucherController::class, 'loan_items_view_details_pdf_SH'])->name('loan_items_view_details_pdf_SH');
        });

        /***************************************************************************/
        /***************************** Loan Receipt Voucher Routes *****************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/loan_receipt_voucher', [LoanReceiptVoucherController::class, 'loan_receipt_voucher'])->name('loan_receipt_voucher');

            Route::post('/submit_loan_receipt_voucher', [LoanReceiptVoucherController::class, 'submit_loan_receipt_voucher'])->name('submit_loan_receipt_voucher');

            Route::get('/loan_receipt_voucher_list/{array?}/{str?}', [LoanReceiptVoucherController::class, 'loan_receipt_voucher_list'])->name('loan_receipt_voucher_list');

            Route::post('/loan_receipt_voucher_list', [LoanReceiptVoucherController::class, 'loan_receipt_voucher_list'])->name('loan_receipt_voucher_list');

            Route::post('/loan_receipt_items_view_details', [LoanReceiptVoucherController::class, 'loan_receipt_items_view_details'])->name('loan_receipt_items_view_details');

            Route::get('/loan_receipt_items_view_details/view/{id}', [LoanReceiptVoucherController::class, 'loan_receipt_items_view_details_SH'])->name('loan_receipt_items_view_details_SH');

            Route::get('/loan_receipt_items_view_details/pdf/{id}', [LoanReceiptVoucherController::class, 'loan_receipt_items_view_details_pdf_SH'])->name('loan_receipt_items_view_details_pdf_SH');
        });


        /***************************************************************************/
        /***************************** Cash Receipt Voucher Routes *****************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/cash_receipt_voucher', 'CashReceiptVoucherController@cash_receipt_voucher')->name('cash_receipt_voucher');

            Route::post('/submit_cash_receipt_voucher', 'CashReceiptVoucherController@submit_cash_receipt_voucher')->name('submit_cash_receipt_voucher');

            Route::get('/cash_receipt_voucher_list/{array?}/{str?}', 'CashReceiptVoucherController@cash_receipt_voucher_list')->name('cash_receipt_voucher_list');

            Route::post('/cash_receipt_voucher_list', 'CashReceiptVoucherController@cash_receipt_voucher_list')->name('cash_receipt_voucher_list');

            //post voucher list
            Route::get('/cash_receipt_post_voucher_list/{array?}/{str?}', 'CashReceiptVoucherController@cash_receipt_post_voucher_list')->name('cash_receipt_post_voucher_list');

            Route::post('/cash_receipt_post_voucher_list', 'CashReceiptVoucherController@cash_receipt_post_voucher_list')->name('cash_receipt_post_voucher_list');
            // post voucher route
            Route::post('/post_cash_receipt_voucher', 'CashReceiptVoucherController@post_cash_receipt_voucher')->name('post_cash_receipt_voucher');
            // post voucher route end
            Route::post('/cash_receipt_items_view_details', 'CashReceiptVoucherController@cash_receipt_items_view_details')->name('cash_receipt_items_view_details');

            Route::get('/cash_receipt_items_view_details/view/{id}', 'CashReceiptVoucherController@cash_receipt_items_view_details_SH')->name('cash_receipt_items_view_details_SH');

            Route::get('/cash_receipt_items_view_details/pdf/{id}', 'CashReceiptVoucherController@cash_receipt_items_view_details_pdf_SH')->name('cash_receipt_items_view_details_pdf_SH');

            //edit voucher route
            Route::get('/edit_cash_receipt_voucher/{id}', 'CashReceiptVoucherController@edit_cash_receipt_voucher')->name('edit_cash_receipt_voucher');
            Route::get('/delete_cash_receipt_voucher/{id}', 'CashReceiptVoucherController@delete_cash_receipt_voucher')->name('delete_cash_receipt_voucher');
            //        update voucher route
            Route::post('/update_cash_receipt_voucher/{id}', 'CashReceiptVoucherController@update_cash_receipt_voucher')->name('update_cash_receipt_voucher');
            /***************************************************************************/
            /***************************** Cash Payment Voucher Routes *****************/
            /***************************************************************************/

            Route::get('/cash_payment_voucher', 'CashPaymentVoucherController@cash_payment_voucher')->name('cash_payment_voucher');

            Route::post('/submit_cash_payment_voucher', 'CashPaymentVoucherController@submit_cash_payment_voucher')->name('submit_cash_payment_voucher');

            Route::get('/cash_payment_voucher_list/{array?}/{str?}', 'CashPaymentVoucherController@cash_payment_voucher_list')->name('cash_payment_voucher_list');

            Route::post('/cash_payment_voucher_list', 'CashPaymentVoucherController@cash_payment_voucher_list')->name('cash_payment_voucher_list');

            Route::post('/cash_payment_items_view_details', 'CashPaymentVoucherController@cash_payment_items_view_details')->name('cash_payment_items_view_details');


            Route::get('/cash_payment_items_view_details/view/{id}', 'CashPaymentVoucherController@cash_payment_items_view_details_SH')->name('cash_payment_items_view_details_SH');

            Route::get('/cash_payment_items_view_details/pdf/{id}', 'CashPaymentVoucherController@cash_payment_items_view_details_pdf_SH')->name('cash_payment_items_view_details_pdf_SH');

            //post voucher list
            Route::get('/cash_payment_post_voucher_list/{array?}/{str?}', 'CashPaymentVoucherController@cash_payment_post_voucher_list')->name('cash_payment_post_voucher_list');

            Route::post('/cash_payment_post_voucher_list', 'CashPaymentVoucherController@cash_payment_post_voucher_list')->name('cash_payment_post_voucher_list');
            // post voucher route
            Route::post('/post_cash_payment_voucher/{id}', 'CashPaymentVoucherController@post_cash_payment_voucher')->name('post_cash_payment_voucher');
            // post voucher route end
            //edit voucher route
            Route::get('/edit_cash_payment_voucher/{id}', 'CashPaymentVoucherController@edit_cash_payment_voucher')->name('edit_cash_payment_voucher');
            Route::get('/delete_cash_payment_voucher/{id}', 'CashPaymentVoucherController@delete_cash_payment_voucher')->name('delete_cash_payment_voucher');
            //        update voucher route
            Route::post('/update_cash_payment_voucher/{id}', 'CashPaymentVoucherController@update_cash_payment_voucher')->name('update_cash_payment_voucher');
        });

        /***************************************************************************/
        /***************************** Approval Journal Voucher Project Routes *****************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            /***************************************************************************/
            /***************************** Approval Journal Voucher Routes *****************/
            /***************************************************************************/

            Route::get('/approval_journal_voucher', 'ApprovalJournalVoucherController@approval_journal_voucher')->name('approval_journal_voucher');

            Route::get('/approval_journal_voucher_bank', 'ApprovalJournalVoucherController@approval_journal_voucher_bank')->name('approval_journal_voucher_bank');

            Route::get('/approval_journal_voucher_reference', 'ApprovalJournalVoucherController@approval_journal_voucher_reference')->name('approval_journal_voucher_reference');

            Route::post('/submit_approval_journal_voucher', 'ApprovalJournalVoucherController@submit_approval_journal_voucher')->name('submit_approval_journal_voucher');

            Route::get('/approval_journal_voucher_list/{array?}/{str?}', 'ApprovalJournalVoucherController@approval_journal_voucher_list')->name('approval_journal_voucher_list');

            Route::get('/approval_journal_voucher_all_list/{array?}/{str?}', 'ApprovalJournalVoucherController@approval_journal_voucher_list')->name('approval_journal_voucher_all_list');
            Route::get('/approval_journal_voucher_approved_list/{array?}/{str?}', 'ApprovalJournalVoucherController@approval_journal_voucher_list')->name('approval_journal_voucher_approved_list');
            Route::get('/approval_journal_voucher_rejected_list/{array?}/{str?}', 'ApprovalJournalVoucherController@approval_journal_voucher_list')->name('approval_journal_voucher_rejected_list');

            Route::post('/approval_journal_voucher_list', 'ApprovalJournalVoucherController@approval_journal_voucher_list')->name('approval_journal_voucher_list');
            Route::post('/approval_journal_voucher_all_list', 'ApprovalJournalVoucherController@approval_journal_voucher_list')->name('approval_journal_voucher_all_list');
            Route::post('/approval_journal_voucher_approved_list', 'ApprovalJournalVoucherController@approval_journal_voucher_list')->name('approval_journal_voucher_approved_list');
            Route::post('/approval_journal_voucher_rejected_list', 'ApprovalJournalVoucherController@approval_journal_voucher_list')->name('approval_journal_voucher_rejected_list');

            Route::post('/approval_journal_voucher_items_view_details', 'ApprovalJournalVoucherController@approval_journal_voucher_items_view_details')->name('approval_journal_voucher_items_view_details');


            //Route::get('/approval_journal_voucher_items_view_details/view/{id}', 'ApprovalJournalVoucherController@expense_account_registration')->name('approval_journal_voucher_items_view_details_SH');
            // write the wrong function name od team

            Route::get('/approval_journal_voucher_items_view_details/view/{id}', 'ApprovalJournalVoucherController@approval_journal_voucher_items_view_details_SH')->name('approval_journal_voucher_items_view_details_SH'); // mustafa change the function name

            Route::get('/approval_journal_voucher_items_view_details/pdf/{id}', 'ApprovalJournalVoucherController@approval_journal_voucher_items_view_details_pdf_SH')->name('approval_journal_voucher_items_view_details_pdf_SH');

            Route::post('/approval_journal_voucher_edit', 'ApprovalJournalVoucherController@approval_journal_voucher_edit')->name('approval_journal_voucher_edit');
            Route::post('/approval_journal_voucher_update', 'ApprovalJournalVoucherController@approval_journal_voucher_update')->name('approval_journal_voucher_update');

            Route::post('/approval_journal_voucher_response', 'ApprovalJournalVoucherController@approval_journal_voucher_response')->name('approval_journal_voucher_response');
            Route::post('/approval_journal_voucher_confirm', 'ApprovalJournalVoucherController@approval_journal_voucher_confirm')->name('approval_journal_voucher_confirm');
        });
        /***************************************************************************/
        /***************************** Bank Receipt Voucher Routes *****************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/bank_receipt_voucher', 'BankReceiptVoucherController@bank_receipt_voucher')->name('bank_receipt_voucher');

            Route::get('/online_payment_receive', 'BankReceiptVoucherController@bank_receipt_voucher')->name('online_payment_receive');

            Route::post('/submit_bank_receipt_voucher', 'BankReceiptVoucherController@submit_bank_receipt_voucher')->name('submit_bank_receipt_voucher');

            Route::get('/bank_receipt_voucher_list/{array?}/{str?}', 'BankReceiptVoucherController@bank_receipt_voucher_list')->name('bank_receipt_voucher_list');

            Route::post('/bank_receipt_voucher_list', 'BankReceiptVoucherController@bank_receipt_voucher_list')->name('bank_receipt_voucher_list');

            Route::post('/bank_receipt_items_view_details', 'BankReceiptVoucherController@bank_receipt_items_view_details')->name('bank_receipt_items_view_details');

            Route::get('/online_payment_receive_list', 'BankReceiptVoucherController@bank_receipt_voucher_list')->name('online_payment_receive_list');

            Route::post('/online_payment_receive_list', 'BankReceiptVoucherController@bank_receipt_voucher_list')->name('online_payment_receive_list');

            Route::get('/bank_receipt_items_view_details/view/{id}', 'BankReceiptVoucherController@bank_receipt_items_view_details_SH')->name('bank_receipt_items_view_details_SH');

            Route::get('/bank_receipt_items_view_details/pdf/{id}', 'BankReceiptVoucherController@bank_receipt_items_view_details_pdf_SH')->name('bank_receipt_items_view_details_pdf_SH');
            // post voucher route
            Route::get('/bank_receipt_post_voucher_list/{array?}/{str?}', 'BankReceiptVoucherController@bank_receipt_post_voucher_list')->name('bank_receipt_post_voucher_list');

            Route::post('/bank_receipt_post_voucher_list', 'BankReceiptVoucherController@bank_receipt_post_voucher_list')->name('bank_receipt_post_voucher_list');

            Route::post('/post_bank_receipt_voucher/{id}', 'BankReceiptVoucherController@post_bank_receipt_voucher')->name('post_bank_receipt_voucher');
            // post voucher route end
            //edit voucher route
            Route::get('/edit_bank_receipt_voucher/{id}', 'BankReceiptVoucherController@edit_bank_receipt_voucher')->name('edit_bank_receipt_voucher');
            Route::get('/delete_bank_receipt_voucher/{id}', 'BankReceiptVoucherController@delete_bank_receipt_voucher')->name('delete_bank_receipt_voucher');
            //        update voucher route
            Route::post('/update_bank_receipt_voucher/{id}', 'BankReceiptVoucherController@update_bank_receipt_voucher')->name('update_bank_receipt_voucher');

            /***************************************************************************/
            /***************************** Bank Payment Voucher Routes *****************/
            /***************************************************************************/

            Route::get('/bank_payment_voucher', 'BankPaymentVoucherController@bank_payment_voucher')->name('bank_payment_voucher');

            Route::get('/online_payment_paid', 'BankPaymentVoucherController@bank_payment_voucher')->name('online_payment_paid');

            Route::post('/submit_bank_payment_voucher', 'BankPaymentVoucherController@submit_bank_payment_voucher')->name('submit_bank_payment_voucher');

            Route::get('/bank_payment_voucher_list/{array?}/{str?}', 'BankPaymentVoucherController@bank_payment_voucher_list')->name('bank_payment_voucher_list');

            Route::post('/bank_payment_voucher_list', 'BankPaymentVoucherController@bank_payment_voucher_list')->name('bank_payment_voucher_list');

            Route::post('/bank_payment_items_view_details', 'BankPaymentVoucherController@bank_payment_items_view_details')->name('bank_payment_items_view_details');

            Route::get('/online_payment_paid_list', 'BankPaymentVoucherController@bank_payment_voucher_list')->name('online_payment_paid_list');

            Route::post('/online_payment_paid_list', 'BankPaymentVoucherController@bank_payment_voucher_list')->name('online_payment_paid_list');

            Route::get('/bank_payment_items_view_details/view/{id}', 'BankPaymentVoucherController@bank_payment_items_view_details_SH')->name('bank_payment_items_view_details_SH');

            Route::get('/bank_payment_items_view_details/pdf/{id}', 'BankPaymentVoucherController@bank_payment_items_view_details_pdf_SH')->name('bank_payment_items_view_details_pdf_SH');

            Route::get('/bank_payment_post_voucher_list/{array?}/{str?}', 'BankPaymentVoucherController@bank_payment_post_voucher_list')->name('bank_payment_post_voucher_list');

            Route::post('/bank_payment_post_voucher_list', 'BankPaymentVoucherController@bank_payment_post_voucher_list')->name('bank_payment_post_voucher_list');
            // post voucher route
            Route::post('/post_bank_payment_voucher/{id}', 'BankPaymentVoucherController@post_bank_payment_voucher')->name('post_bank_payment_voucher');
            // post voucher route end
            //edit voucher route
            Route::get('/edit_bank_payment_voucher/{id}', 'BankPaymentVoucherController@edit_bank_payment_voucher')->name('edit_bank_payment_voucher');
//            delete voucher
            Route::get('/delete_bank_payment_voucher/{id}', 'BankPaymentVoucherController@delete_bank_payment_voucher')->name('delete_bank_payment_voucher');
            //        update voucher route
            Route::post('/update_bank_payment_voucher/{id}', 'BankPaymentVoucherController@update_bank_payment_voucher')->name('update_bank_payment_voucher');
        });
        /***************************************************************************/
        /***************************** Chart Of Account Routes *********************/
        /***************************************************************************/

        Route::get('/chart_of_account', 'ChartOfAccountController@chart_of_account')->name('chart_of_account');

        Route::get('/first_level_chart_of_account', 'ChartOfAccountController@chart_of_account')->name('first_level_chart_of_account');

        //nabeel store entries in chart of account tree
        Route::post('/store_chart_of_account', 'ChartOfAccountController@store_chart_of_account')->name('store_chart_of_account');
        Route::post('/store_chart_of_account2', 'ChartOfAccountController@store_chart_of_account2')->name('store_chart_of_account2');
        Route::post('/store_chart_of_account3', 'ChartOfAccountController@store_chart_of_account3')->name('store_chart_of_account3');


        /***************************************************************************/
        /***************************** Account Ledger Routes ***********************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/account_ledger/{array?}/{str?}', 'AccountLedgerController@account_ledger')->name('account_ledger');


            //Route::get('/balances_controle', 'AccountLedgerController@balanceAmountSet')->name('balances_controle');


            Route::post('/account_ledger', 'AccountLedgerController@account_ledger')->name('account_ledger');

            Route::get('/parent_account_ledger/{array?}/{str?}', 'AccountLedgerController@parent_account_ledger')->name('parent_account_ledger');

            Route::post('/parent_account_ledger', 'AccountLedgerController@parent_account_ledger')->name('parent_account_ledger');

            Route::get('/chart_of_account_ledger/{array?}/{str?}', 'AccountLedgerController@chart_of_account_ledger')->name('chart_of_account_ledger');

            Route::post('/chart_of_account_ledger', 'AccountLedgerController@chart_of_account_ledger')->name('chart_of_account_ledger');


            Route::get('/parties_account_ledger/{array?}/{str?}', 'AccountLedgerController@parties_account_ledger')->name('parties_account_ledger');

            Route::post('/parties_account_ledger', 'AccountLedgerController@parties_account_ledger')->name('parties_account_ledger');


            Route::get('/customer_aging_report/{array?}/{str?}', 'AccountLedgerController@customer_aging_report')->name('customer_aging_report');

            Route::post('/customer_aging_report', 'AccountLedgerController@customer_aging_report')->name('customer_aging_report');

            Route::get('/supplier_aging_report/{array?}/{str?}', 'SupplierAgingReportController@supplier_aging_report')->name('supplier_aging_report');

            Route::post('/supplier_aging_report', 'SupplierAgingReportController@supplier_aging_report')->name('supplier_aging_report');
        });

        /***************************************************************************/
        /***************************** Employee Routes *****************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/add_employee', 'EmployeeController@add_employee')->name('add_employee');

            Route::post('/submit_employee', 'EmployeeController@submit_employee')->name('submit_employee');

            Route::post('/submit_employee_excel', 'EmployeeController@submit_employee_excel')->name('submit_employee_excel');

            Route::get('/employee_list/{array?}/{str?}', 'EmployeeController@employee_list')->name('employee_list');

            Route::post('/employee_list', 'EmployeeController@employee_list')->name('employee_list');

            Route::post('/resend_employee_password_email', 'EmployeeController@resend_employee_password_email')->name('resend_employee_password_email');

            Route::post('/edit_employee', 'EmployeeController@edit_employee')->name('edit_employee');

            Route::get('/edit_employee', 'EmployeeController@employee_list')->name('edit_employee');

            Route::post('/update_employee', 'EmployeeController@update_employee')->name('update_employee');

            Route::post('/delete_employee', 'EmployeeController@delete_employee')->name('delete_employee');

            Route::get('/mark_teacher/{array?}/{str?}', 'EmployeeController@mark_teacher')->name('mark_teacher');

            Route::post('/mark_teacher', 'EmployeeController@mark_teacher')->name('mark_teacher');
        });
        /***************************************************************************/
        /****************** Check UserName And Email Of Employee Routes ************/
        /***************************************************************************/

        Route::post('/check_employee_username', 'EmployeeController@check_employee_username')->name('check_employee_username');

        Route::post('/check_employee_email', 'EmployeeController@check_employee_email')->name('check_employee_email');


        /***************************************************************************/
        /***************************** User Routes *********************************/
        /***************************************************************************/

        Route::post('/enable_disable_user', 'UserController@enable_disable_user')->name('enable_disable_user');


        /***************************************************************************/
        /***************************** Nabeel Day End Routes  hahaha ******************************/
        /***************************************************************************/
        Route::get('/nabeel_day_end', 'DayEndController@nabeel_day_end')->name('nabeel_day_end');
        Route::get('/nabeel_day_end_array', 'DayEndController@nabeel_day_end_array')->name('nabeel_day_end_array');
        Route::get('/nabeel_balance_sheet', 'DayEndController@nabeel_balance_sheet')->name('nabeel_balance_sheet');

        Route::get('/nabeel_income_statement', 'DayEndController@nabeel_income_statement')->name('nabeel_income_statement');


        /***************************************************************************/
        /***************************** Day End Routes ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/start_day_end', 'DayEndController@start_day_end')->name('start_day_end');
            Route::get('/execute_day_end/{array?}/{str?}/{tableformat?}', 'DayEndController@execute_day_end')->name('execute_day_end');
            Route::get('/day_end_report/{array?}/{str?}/{tableformat?}', 'DayEndController@day_end_report')->name('day_end_report');
            Route::post('/day_end_unlock', 'DayEndController@day_end_unlock')->name('day_end_unlock');

            //Route::get('/close_day_end', 'DayEndController@close_day_end')->name('close_day_end');
            //
            //Route::get('/day_end_report', 'DayEndController@close_day_end')->name('day_end_report');

            //Route::get('/day_end_login', 'DayEndController@day_end_login')->name('day_end_login');
            //
            //Route::post('/day_end_login', 'DayEndController@day_end_login')->name('day_end_login');

            /***************************** Day End Routes new ******************************/
            /***************************************************************************/


            Route::get('/day_end_reports/{array?}/{str?}', 'DayEndReportController@day_end_reports')->name('day_end_reports');

            Route::post('/day_end_reports', 'DayEndReportController@day_end_reports')->name('day_end_reports');


            /***************************************************************************/
            /***************************** Trial Balance Routes ************************/
            /***************************************************************************/

            Route::get('/trial_balance/{array?}/{str?}', 'TrialBalanceController@trial_balance')->name('trial_balance');

            Route::post('/trial_balance', 'TrialBalanceController@trial_balance')->name('trial_balance');
        });
        /***************************************************************************/
        /***************************** Defaults Account Routes *********************/
        /***************************************************************************/

        Route::get('/default_account_list_view/{array?}/{str?}', 'DefaultAccountsController@default_account_list_view')->name('default_account_list_view');

        Route::get('/default_account_list', 'DefaultAccountsController@default_account_list')->name('default_account_list');

        Route::post('/update_default_account_list', 'DefaultAccountsController@update_default_account_list')->name('update_default_account_list');

        Route::post('/set_default_account', 'DefaultAccountsController@set_default_account')->name('set_default_account');


        /***************************************************************************/
        /***************************** Income Statement Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/income_statement/{array?}/{str?}', 'IncomeStatementController@income_statement')->name('income_statement');

            Route::post('/income_statement', 'IncomeStatementController@income_statement')->name('income_statement');


            /***************************************************************************/
            /***************************** Balance Sheet Routes ************************/
            /***************************************************************************/

            Route::get('/balance_sheet/{array?}/{str?}', 'AllReportsController@balance_sheet')->name('balance_sheet');


            /***************************************************************************/
            /***************************** Transaction View Routes *********************/
            /***************************************************************************/

            Route::post('/transaction_view_details', 'AccountLedgerController@transaction_view_details')->name('transaction_view_details');


            Route::get('/transaction_view_details_SH/{id}', 'AccountLedgerController@transaction_view_details_SH')->name('transaction_view_details_SH');
        });
        /***************************************************************************/
        /***************************** Account Group Routes ************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/add_account_group', 'AccountGroupController@add_account_group')->name('add_account_group');

            Route::post('/submit_account_group', 'AccountGroupController@submit_account_group')->name('submit_account_group');

            Route::post('/submit_account_group_excel', 'AccountGroupController@submit_account_group_excel')->name('submit_account_group_excel');

            Route::get('/account_group_list/{array?}/{str?}', 'AccountGroupController@account_group_list')->name('account_group_list');

            Route::post('/account_group_list', 'AccountGroupController@account_group_list')->name('account_group_list');

            Route::post('/edit_account_group', 'AccountGroupController@edit_account_group')->name('edit_account_group');

            Route::post('/update_account_group', 'AccountGroupController@update_account_group')->name('update_account_group');

            Route::get('/edit_account_group', 'AccountGroupController@account_group_list')->name('edit_account_group');

            Route::post('/delete_account_group', 'AccountGroupController@delete_account_group')->name('delete_account_group');
        });

        /***************************************************************************/
        /***************************** Warehouse Routes ****************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/add_warehouse', 'WarehouseController@add_warehouse')->name('add_warehouse');

            Route::post('/submit_warehouse', 'WarehouseController@submit_warehouse')->name('submit_warehouse');

            Route::post('/submit_warehouse_excel', 'WarehouseController@submit_warehouse_excel')->name('submit_warehouse_excel');

            Route::get('/warehouse_list/{array?}/{str?}', 'WarehouseController@warehouse_list')->name('warehouse_list');

            Route::post('/warehouse_list', 'WarehouseController@warehouse_list')->name('warehouse_list');

            Route::post('/edit_warehouse', 'WarehouseController@edit_warehouse')->name('edit_warehouse');

            Route::post('/update_warehouse', 'WarehouseController@update_warehouse')->name('update_warehouse');

            Route::get('/edit_warehouse', 'WarehouseController@warehouse_list')->name('edit_warehouse');

            Route::post('/delete_warehouse', 'WarehouseController@delete_warehouse')->name('delete_warehouse');
        });

        /***************************************************************************/
        /********** Transfer Product Stock Warehouse to Warehouse Routes ***********/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/add_transfer_product_stock', 'ProductTransferHistoryController@add_transfer_product_stock')->name('add_transfer_product_stock');

            Route::post('/submit_transfer_product_stock', 'ProductTransferHistoryController@submit_transfer_product_stock')->name('submit_transfer_product_stock');

            Route::post('/submit_transfer_product_stock_excel', 'ProductTransferHistoryController@submit_transfer_product_stock_excel')->name('submit_transfer_product_stock_excel');

            Route::post('/get_product_stock_warehouse_wise', 'ProductTransferHistoryController@get_product_stock_warehouse_wise')->name('get_product_stock_warehouse_wise');

            Route::get('/transfer_product_stock_list', 'ProductTransferHistoryController@transfer_product_stock_list')->name('transfer_product_stock_list');

            Route::post('/transfer_product_stock_list', 'ProductTransferHistoryController@transfer_product_stock_list')->name('transfer_product_stock_list');


            /***************************************************************************/
            /********** Trade Transfer Product Stock Warehouse to Warehouse Routes ***********/
            /***************************************************************************/

            Route::get('/add_trade_transfer_product_stock', 'TradeInvoices\TradeAddTransferProductStockController@add_trade_transfer_product_stock')->name('add_trade_transfer_product_stock');

            Route::post('/submit_trade_transfer_product_stock', 'TradeInvoices\TradeAddTransferProductStockController@submit_trade_transfer_product_stock')->name('submit_trade_transfer_product_stock');

            Route::post('/submit_trade_transfer_product_stock_excel', 'TradeInvoices\TradeAddTransferProductStockController@submit_trade_transfer_product_stock_excel')->name('submit_trade_transfer_product_stock_excel');


            Route::get('/trade_transfer_product_stock_list', 'TradeInvoices\TradeAddTransferProductStockController@trade_transfer_product_stock_list')->name('trade_transfer_product_stock_list');

            Route::post('/trade_transfer_product_stock_list', 'TradeInvoices\TradeAddTransferProductStockController@trade_transfer_product_stock_list')->name('trade_transfer_product_stock_list');
        });
        /***************************************************************************/
        /***************************** Cash Transfer Routes ************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/cash_transfer', 'CashTransferController@cash_transfer')->name('cash_transfer');

            Route::post('/submit_cash_transfer', 'CashTransferController@submit_cash_transfer')->name('submit_cash_transfer');

            Route::post('/submit_cash_transfer_excel', 'CashTransferController@submit_cash_transfer_excel')->name('submit_cash_transfer_excel');

            Route::get('/pending_cash_transfer_list/{array?}/{str?}', 'CashTransferController@pending_cash_transfer_list')->name('pending_cash_transfer_list');

            Route::post('/pending_cash_transfer_list', 'CashTransferController@pending_cash_transfer_list')->name('pending_cash_transfer_list');

            Route::get('/approve_cash_transfer_list/{array?}/{str?}', 'CashTransferController@approve_cash_transfer_list')->name('approve_cash_transfer_list');

            Route::post('/approve_cash_transfer_list', 'CashTransferController@approve_cash_transfer_list')->name('approve_cash_transfer_list');

            Route::get('/reject_cash_transfer_list', 'CashTransferController@reject_cash_transfer_list')->name('reject_cash_transfer_list');

            Route::post('/reject_cash_transfer_list', 'CashTransferController@reject_cash_transfer_list')->name('reject_cash_transfer_list');

            Route::post('/edit_cash_transfer', 'CashTransferController@edit_cash_transfer')->name('edit_cash_transfer');

            Route::post('/update_cash_transfer', 'CashTransferController@update_cash_transfer')->name('update_cash_transfer');

            Route::get('/edit_cash_transfer', 'CashTransferController@cash_transfer_list')->name('edit_cash_transfer');
        });
        /***************************************************************************/
        /***************************** Cash Receive Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/pending_cash_receive_list/{array?}/{str?}', 'CashReceiveController@pending_cash_receive_list')->name('pending_cash_receive_list');

            Route::post('/pending_cash_receive_list', 'CashReceiveController@pending_cash_receive_list')->name('pending_cash_receive_list');

            Route::post('/approve_cash_receive', 'CashReceiveController@approve_cash_receive')->name('approve_cash_receive');

            Route::get('/approve_cash_receive_list/{array?}/{str?}', 'CashReceiveController@approve_cash_receive_list')->name('approve_cash_receive_list');

            Route::post('/approve_cash_receive_list', 'CashReceiveController@approve_cash_receive_list')->name('approve_cash_receive_list');

            Route::post('/reject_cash_receive', 'CashReceiveController@reject_cash_receive')->name('reject_cash_receive');

            Route::get('/reject_cash_receive_list/{array?}/{str?}', 'CashReceiveController@reject_cash_receive_list')->name('reject_cash_receive_list');

            Route::post('/reject_cash_receive_list', 'CashReceiveController@reject_cash_receive_list')->name('reject_cash_receive_list');
        });
        /***************************************************************************/
        /***************** Expense Payment Voucher Routes **************************/
        /***************************************************************************/

        Route::get('/expense_payment_voucher', 'ExpensePaymentVoucherController@expense_payment_voucher')->name('expense_payment_voucher');

        Route::post('/submit_expense_payment_voucher', 'ExpensePaymentVoucherController@submit_expense_payment_voucher')->name('submit_expense_payment_voucher');

        Route::get('/expense_payment_voucher_list/{array?}/{str?}', 'ExpensePaymentVoucherController@expense_payment_voucher_list')->name('expense_payment_voucher_list');

        Route::post('/expense_payment_voucher_list', 'ExpensePaymentVoucherController@expense_payment_voucher_list')->name('expense_payment_voucher_list');

        Route::post('/expense_payment_items_view_details', 'ExpensePaymentVoucherController@expense_payment_items_view_details')->name('expense_payment_items_view_details');

        Route::get('/expense_payment_items_view_details/view/{id}', 'ExpensePaymentVoucherController@expense_payment_items_view_details_SH')->name('expense_payment_items_view_details_SH');

        Route::get('/expense_payment_items_view_details/pdf/{id}', 'ExpensePaymentVoucherController@expense_payment_items_view_details_pdf_SH')->name('expense_payment_items_view_details_pdf_SH');

        // post voucher route
        Route::get('/expense_payment_post_voucher_list/{array?}/{str?}', 'ExpensePaymentVoucherController@expense_payment_post_voucher_list')->name('expense_payment_post_voucher_list');

        Route::post('/expense_payment_post_voucher_list', 'ExpensePaymentVoucherController@expense_payment_post_voucher_list')->name('expense_payment_post_voucher_list');

        Route::post('/post_expense_payment_voucher/{id}', 'ExpensePaymentVoucherController@post_expense_payment_voucher')->name('post_expense_payment_voucher');
        // post voucher route end
        //edit voucher route
        Route::get('/edit_expense_payment_voucher/{id}', 'ExpensePaymentVoucherController@edit_expense_payment_voucher')->name('edit_expense_payment_voucher');
        //        update voucher route
        Route::post('/update_expense_payment_voucher/{id}', 'ExpensePaymentVoucherController@update_expense_payment_voucher')->name('update_expense_payment_voucher');


        /***************************************************************************/
        /*********************** Salary Payment Voucher Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/salary_payment_voucher', 'SalaryPaymentVoucherController@salary_payment_voucher')->name('salary_payment_voucher');

            Route::post('/submit_salary_payment_voucher', 'SalaryPaymentVoucherController@submit_salary_payment_voucher')->name('submit_salary_payment_voucher');

            Route::get('/salary_payment_voucher_list/{array?}/{str?}', 'SalaryPaymentVoucherController@salary_payment_voucher_list')->name('salary_payment_voucher_list');

            Route::post('/salary_payment_voucher_list', 'SalaryPaymentVoucherController@salary_payment_voucher_list')->name('salary_payment_voucher_list');

            Route::post('/salary_payment_items_view_details', 'SalaryPaymentVoucherController@salary_payment_items_view_details')->name('salary_payment_items_view_details');

            Route::get('/salary_payment_items_view_details/view/{id}', 'SalaryPaymentVoucherController@salary_payment_items_view_details_SH')->name('salary_payment_items_view_details_SH');

            Route::get('/salary_payment_items_view_details/pdf/{id}', 'SalaryPaymentVoucherController@salary_payment_items_view_details_pdf_SH')->name('salary_payment_items_view_details_pdf_SH');

            Route::get('/salary_payment_items_view_details/single/pdf/{id}', 'SalaryPaymentVoucherController@salary_payment_items_view_details_single_pdf_SH')->name('salary_payment_items_view_details_single_pdf_SH');


            /***************************************************************************/
            /*********************** New Salary Payment Voucher Routes *********************/
            /***************************************************************************/

            Route::get('/new_salary_payment_voucher', 'NewSalaryPaymentVoucherController@new_salary_payment_voucher')->name('new_salary_payment_voucher');

            Route::post('/submit_salary_payment', 'NewSalaryPaymentVoucherController@submit_salary_payment')->name('submit_salary_payment');

            Route::get('/salary_payment_list/{array?}/{str?}', 'NewSalaryPaymentVoucherController@salary_payment_list')->name('salary_payment_list');

            Route::post('/salary_payment_list', 'NewSalaryPaymentVoucherController@salary_payment_list')->name('salary_payment_list');

            Route::post('/new_salary_payment_items_view_details', 'NewSalaryPaymentVoucherController@new_salary_payment_items_view_details')->name('new_salary_payment_items_view_details');

            Route::get('/new_salary_payment_items_view_details/view/{id}', 'NewSalaryPaymentVoucherController@new_salary_payment_items_view_details_SH')->name('new_salary_payment_items_view_details_SH');

            Route::get('/new_salary_payment_items_view_details/pdf/{id}', 'NewSalaryPaymentVoucherController@new_salary_payment_items_view_details_pdf_SH')->name('new_salary_payment_items_view_details_pdf_SH');

            Route::get('/new_salary_payment_items_view_details/single/pdf/{id}', 'NewSalaryPaymentVoucherController@new_salary_payment_items_view_details_single_pdf_SH')->name('new_salary_payment_items_view_details_single_pdf_SH');


            Route::post('/get_salary_payment_accounts', 'NewSalaryPaymentVoucherController@get_salary_payment_accounts')->name('get_salary_payment_accounts');

            /***************************************************************************/
            /***************************** Salary Slip Voucher Routes ******************/
            /***************************************************************************/

            Route::get('/salary_slip_voucher', 'SalarySlipVoucherController@salary_slip_voucher')->name('salary_slip_voucher');

            Route::post('/submit_salary_slip_voucher', 'SalarySlipVoucherController@submit_salary_slip_voucher')->name('submit_salary_slip_voucher');

            Route::get('/salary_slip_voucher_list/{array?}/{str?}', 'SalarySlipVoucherController@salary_slip_voucher_list')->name('salary_slip_voucher_list');

            Route::post('/salary_slip_voucher_list', 'SalarySlipVoucherController@salary_slip_voucher_list')->name('salary_slip_voucher_list');

            Route::post('/salary_slip_items_view_details', 'SalarySlipVoucherController@salary_slip_items_view_details')->name('salary_slip_items_view_details');

            Route::get('/salary_slip_items_view_details/view/{id}', 'SalarySlipVoucherController@salary_slip_items_view_details_SH')->name('salary_slip_items_view_details_SH');

            Route::get('/salary_slip_items_view_details/pdf/{id}', 'SalarySlipVoucherController@salary_slip_items_view_details_pdf_SH')->name('salary_slip_items_view_details_pdf_SH');

            Route::post('/get_salary_details', 'SalarySlipVoucherController@get_salary_details')->name('get_salary_details');


            /***************************************************************************/
            /***************************** New Salary Slip Voucher Routes ******************/
            /***************************************************************************/

            Route::get('/generate_salary_slip_voucher_with_load', 'GenerateSalarySlipVoucherController@generate_salary_slip_voucher_with_load')->name('generate_salary_slip_voucher_with_load');


            Route::get('/generate_salary_slip_voucher', 'GenerateSalarySlipVoucherController@generate_salary_slip_voucher')->name('generate_salary_slip_voucher');

            Route::post('/submit_generate_salary_slip_voucher', 'GenerateSalarySlipVoucherController@submit_generate_salary_slip_voucher')->name('submit_generate_salary_slip_voucher');

            Route::get('/generate_salary_slip_voucher_list/{array?}/{str?}', 'GenerateSalarySlipVoucherController@generate_salary_slip_voucher_list')->name('generate_salary_slip_voucher_list');

            Route::post('/generate_salary_slip_voucher_list', 'GenerateSalarySlipVoucherController@generate_salary_slip_voucher_list')->name('generate_salary_slip_voucher_list');

            Route::post('/generate_salary_slip_items_view_details', 'GenerateSalarySlipVoucherController@generate_salary_slip_items_view_details')->name('generate_salary_slip_items_view_details');

            Route::get('/generate_salary_slip_items_view_details/view/{id}', 'GenerateSalarySlipVoucherController@generate_salary_slip_items_view_details_SH')->name('generate_salary_slip_items_view_details_SH');

            Route::get('/generate_salary_slip_items_view_details/pdf/{id}', 'GenerateSalarySlipVoucherController@generate_salary_slip_items_view_details_pdf_SH')->name('generate_salary_slip_items_view_details_pdf_SH');

            Route::post('/get_salary_details', 'SalarySlipVoucherController@get_salary_details')->name('get_salary_details');

            Route::get('/get_salary_accounts', 'GenerateSalarySlipVoucherController@get_salary_accounts')->name('get_salary_accounts');

            Route::get('/get_salary_accounts_with_load', 'GenerateSalarySlipVoucherController@get_salary_accounts_with_load')->name('get_salary_accounts_with_load');


            Route::get('/month_wise_salary_detail_list/{array?}/{str?}', 'GenerateSalarySlipVoucherController@month_wise_salary_detail_list')->name('month_wise_salary_detail_list');

            Route::post('/month_wise_salary_detail_list', 'GenerateSalarySlipVoucherController@month_wise_salary_detail_list')->name('month_wise_salary_detail_list');

            Route::get('/getAllowanceDeduction/{userId}', 'GenerateSalarySlipVoucherController@getAllowanceDeduction');


            Route::post('/allowance_deduction_items_view_details', [GenerateSalarySlipVoucherController::class, 'allowance_deduction_items_view_details'])->name('allowance_deduction_items_view_details');

            Route::get('/allowance_deduction_items_view_details/view/{id}/{month}', [GenerateSalarySlipVoucherController::class, 'allowance_deduction_items_view_details_SH'])->name('allowance_deduction_items_view_details_SH');

        });
        /***************************************************************************/
        /***************************** New Salary Slip Voucher Routes ******************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('add_attendance', [AttendanceController::class, 'add_attendance'])->name('add_attendance');


            Route::post('/submit_attendance', [AttendanceController::class, 'submit_attendance'])->name('submit_attendance');

            Route::get('/attendance_list/{array?}/{str?}', [AttendanceController::class, 'attendance_list'])->name('attendance_list');

            Route::post('/attendance_list', [AttendanceController::class, 'attendance_list'])->name('attendance_list');

            Route::get('/edit_attendance', [AttendanceController::class, 'attendance_list'])->name('edit_attendance');
            Route::post('/edit_attendance', [AttendanceController::class, 'edit_attendance'])->name('edit_attendance');

            Route::post('/update_attendance/{attendance}', [AttendanceController::class, 'update_attendance'])->name('update_attendance');
            Route::get('/get_employees', [AttendanceController::class, 'get_employees'])->name('get_employees');
        });
        /***************************************************************************/
        /***************************** Services Routes *****************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/add_services', 'ServicesController@add_services')->name('add_services');

            Route::post('/submit_services', 'ServicesController@submit_services')->name('submit_services');

            Route::post('/submit_services_excel', 'ServicesController@submit_services_excel')->name('submit_services_excel');

            Route::get('/services_list/{array?}/{str?}', 'ServicesController@services_list')->name('services_list');

            Route::post('/services_list', 'ServicesController@services_list')->name('services_list');

            Route::post('/edit_services', 'ServicesController@edit_services')->name('edit_services');

            Route::post('/update_services', 'ServicesController@update_services')->name('update_services');

            Route::get('/edit_services', 'ServicesController@services_list')->name('edit_services');

            Route::post('/delete_services', 'ServicesController@delete_services')->name('delete_services');


            /***************************************************************************/
            /***************************** Service Invoice Routes **********************/
            /***************************************************************************/

            Route::get('/services_invoice', 'ServicesInvoiceController@services_invoice')->name('services_invoice');

            Route::get('/services_invoice_on_cash', 'ServicesInvoiceController@services_invoice_on_cash')->name('services_invoice_on_cash');

            Route::post('/submit_services_invoice', 'ServicesInvoiceController@submit_services_invoice')->name('submit_services_invoice');

            Route::get('/services_invoice_list/{array?}/{str?}', 'ServicesInvoiceController@services_invoice_list')->name('services_invoice_list');

            Route::post('/services_invoice_list', 'ServicesInvoiceController@services_invoice_list')->name('services_invoice_list');

            Route::post('/services_items_view_details', 'ServicesInvoiceController@services_items_view_details')->name('services_items_view_details');

            Route::get('/services_items_view_details/view/{id}', 'ServicesInvoiceController@services_items_view_details_SH')->name('services_items_view_details_SH');

            Route::get('/services_items_view_details/view/pdf/{id}', 'ServicesInvoiceController@services_items_view_details_pdf_SH')->name('services_items_view_details_pdf_SH');

            Route::get('/service_tax_invoice_list', 'ServicesInvoiceController@service_tax_invoice_list')->name('service_tax_invoice_list');

            Route::post('/service_tax_invoice_list/{array?}/{str?}', 'ServicesInvoiceController@service_tax_invoice_list')->name('service_tax_invoice_list');

            Route::get('/services_tax_items_view_details/view/{id}', 'ServicesInvoiceController@services_tax_items_view_details_SH')->name('services_tax_items_view_details_SH');

            Route::get('/services_tax_items_view_details/view/pdf/{id}', 'ServicesInvoiceController@services_tax_items_view_details_pdf_SH')->name('services_tax_items_view_details_pdf_SH');
        });
        /***************************************************************************/
        /***************************** All Reports Routes **************************/
        /***************************************************************************/

        //Route::get('/all_reports', 'AllReportsController@all_reports')->name('all_reports');
        //
        //Route::post('/get_all_reports', 'AllReportsController@get_all_reports')->name('get_all_reports');


        /***************************************************************************/
        /********************* Opening Balance Account Routes **********************/
        /***************************************************************************/
        //        Route::group(['middleware' => ['basicPackage']], function () {
        Route::get('/account_opening_balance/{array?}/{str?}', 'AccountOpeningBalancesController@account_opening_balance')->name('account_opening_balance');


        Route::post('/account_opening_balance', 'AccountOpeningBalancesController@account_opening_balance')->name('account_opening_balance');

        Route::post('/update_account_opening_balance_excel', 'AccountOpeningBalancesController@update_account_opening_balance_excel')->name('update_account_opening_balance_excel');
        //Route::get('/parties_opening_balance', 'AccountOpeningBalancesController@parties_opening_balance')->name('parties_opening_balance');
        //
        //Route::post('/parties_opening_balance', 'AccountOpeningBalancesController@parties_opening_balance')->name('parties_opening_balance');

        //            Route::get('/update_account_opening_balance', 'AccountOpeningBalancesController@update_account_opening_balance')->name('update_account_opening_balance');

        Route::post('/update_account_opening_balance', [AccountOpeningBalancesController::class, 'update_account_opening_balance'])->name('update_account_opening_balance');

        Route::get('/view_account_opening_balance/{array?}/{str?}', 'AccountOpeningBalancesController@view_account_opening_balance')->name('view_account_opening_balance');

        Route::post('/view_account_opening_balance', 'AccountOpeningBalancesController@view_account_opening_balance')->name('view_account_opening_balance');

        Route::post('/submit_account_opening_balance', 'AccountOpeningBalancesController@submit_account_opening_balance')->name('submit_account_opening_balance');


        /***************************************************************************/
        /******************** Product Opening Stock Routes *************************/
        /***************************************************************************/

        Route::get('/product_opening_stock/{array?}/{str?}', 'ProductOpeningStockController@product_opening_stock')->name('product_opening_stock');

        Route::post('/product_opening_stock', 'ProductOpeningStockController@product_opening_stock')->name('product_opening_stock');

        Route::post('/update_product_opening_stock', 'ProductOpeningStockController@update_product_opening_stock')->name('update_product_opening_stock');
        Route::post('/update_product_opening_stock_excel', 'ProductOpeningStockController@update_product_opening_stock_excel')->name('update_product_opening_stock_excel');
        //
        //Route::get('/view_product_opening_stock/{array?}/{str?}', 'ProductOpeningStockController@view_product_opening_stock')->name('view_product_opening_stock');
        //
        //Route::post('/view_product_opening_stock', 'ProductOpeningStockController@view_product_opening_stock')->name('view_product_opening_stock');
        //
        //Route::post('/submit_product_opening_stock', 'ProductOpeningStockController@submit_product_opening_stock')->name('submit_product_opening_stock');

        /***************************************************************************/
        /******************** Product Price Update Routes *************************/
        /***************************************************************************/

        Route::get('/product_price_update/{array?}/{str?}', 'ProductPriceUpdateController@product_price_update')->name('product_price_update');

        Route::post('/product_price_update', 'ProductPriceUpdateController@product_price_update')->name('product_price_update');

        Route::post('/update_product_price', 'ProductPriceUpdateController@update_product_price')->name('update_product_price');
        //        });
        /***************************************************************************/
        /******************* Bank Account Registration Routes **********************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/bank_account_registration', 'AccountRegisterationsController@bank_account_registration')->name('bank_account_registration');

            Route::post('/submit_bank_account_registration', 'AccountRegisterationsController@submit_other_account')->name('submit_bank_account_registration');

            Route::post('/submit_bank_account_registration_excel', 'AccountRegisterationsController@submit_other_account_excel')->name('submit_bank_account_registration_excel');

            Route::get('/bank_account_list/{array?}/{str?}', 'AccountRegisterationsController@bank_account_list')->name('bank_account_list');

            Route::post('/bank_account_list', 'AccountRegisterationsController@bank_account_list')->name('bank_account_list');

            Route::post('/get_account_info', 'AccountRegisterationsController@get_account_info')->name('get_account_info');
        });

        /***************************************************************************/
        /******************** Salary Account Registration Routes *******************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/salary_account_registration', 'AccountRegisterationsController@salary_account_registration')->name('salary_account_registration');

            Route::post('/submit_salary_account_registration', 'AccountRegisterationsController@submit_salary_account_registration')->name('submit_salary_account_registration');

            Route::post('/submit_salary_account_registration_excel', 'AccountRegisterationsController@submit_salary_account_registration_excel')->name('submit_salary_account_registration_excel');

            Route::get('/salary_account_list/{array?}/{str?}', 'AccountRegisterationsController@salary_account_list')->name('salary_account_list');

            Route::post('/salary_account_list', 'AccountRegisterationsController@salary_account_list')->name('salary_account_list');
        });
        /***************************************************************************/
        /******************* Credit Card Machine Routes ****************************/
        /***************************************************************************/

        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/add_credit_card_machine', 'CreditCardMachineController@add_credit_card_machine')->name('add_credit_card_machine');

            Route::post('/submit_credit_card_machine', 'CreditCardMachineController@submit_credit_card_machine')->name('submit_credit_card_machine');

            Route::post('/submit_credit_card_machine_excel', 'CreditCardMachineController@submit_credit_card_machine_excel')->name('submit_credit_card_machine_excel');

            Route::get('/credit_card_machine_list', 'CreditCardMachineController@credit_card_machine_list')->name('credit_card_machine_list');

            Route::post('/credit_card_machine_list', 'CreditCardMachineController@credit_card_machine_list')->name('credit_card_machine_list');

            Route::post('/edit_credit_card_machine', 'CreditCardMachineController@edit_credit_card_machine')->name('edit_credit_card_machine');

            Route::post('/update_credit_card_machine', 'CreditCardMachineController@update_credit_card_machine')->name('update_credit_card_machine');

            Route::get('/edit_credit_card_machine', 'CreditCardMachineController@credit_card_machine_list')->name('edit_credit_card_machine');

            Route::post('/delete_credit_card_machine', 'CreditCardMachineController@delete_credit_card_machine')->name('delete_credit_card_machine');
        });

        /***************************************************************************/
        /****************** Post Dated Cheque Issue Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/add_post_dated_cheque_issue', 'PostDatedChequeIssueController@add_post_dated_cheque_issue')->name('add_post_dated_cheque_issue');

            Route::post('/submit_post_dated_cheque_issue', 'PostDatedChequeIssueController@submit_post_dated_cheque_issue')->name('submit_post_dated_cheque_issue');

            Route::get('/post_dated_cheque_issue_list/{array?}/{str?}', 'PostDatedChequeIssueController@post_dated_cheque_issue_list')->name('post_dated_cheque_issue_list');

            Route::post('/post_dated_cheque_issue_list', 'PostDatedChequeIssueController@post_dated_cheque_issue_list')->name('post_dated_cheque_issue_list');

            Route::post('/approve_post_dated_cheque_issue', 'PostDatedChequeIssueController@approve_post_dated_cheque_issue')->name('approve_post_dated_cheque_issue');

            Route::post('/reject_post_dated_cheque_issue', 'PostDatedChequeIssueController@reject_post_dated_cheque_issue')->name('reject_post_dated_cheque_issue');

            Route::get('/approve_post_dated_cheque_issue_list/{array?}/{str?}', 'PostDatedChequeIssueController@approve_post_dated_cheque_issue_list')->name('approve_post_dated_cheque_issue_list');

            Route::post('/approve_post_dated_cheque_issue_list', 'PostDatedChequeIssueController@approve_post_dated_cheque_issue_list')->name('approve_post_dated_cheque_issue_list');

            Route::get('/reject_post_dated_cheque_issue_list/{array?}/{str?}', 'PostDatedChequeIssueController@reject_post_dated_cheque_issue_list')->name('reject_post_dated_cheque_issue_list');

            Route::post('/reject_post_dated_cheque_issue_list', 'PostDatedChequeIssueController@reject_post_dated_cheque_issue_list')->name('reject_post_dated_cheque_issue_list');

            Route::get('/post_dated_cheque_issue/view/pdf/{id}', 'PostDatedChequeIssueController@post_dated_cheque_issue_pdf_SH')->name('post_dated_cheque_issue_pdf_SH');


            /***************************************************************************/
            /***************** Post Dated Cheque Received Routes ***********************/
            /***************************************************************************/


            Route::get('/add_post_dated_cheque_received', 'PostDatedChequeReceivedController@add_post_dated_cheque_received')->name('add_post_dated_cheque_received');

            Route::post('/submit_post_dated_cheque_received', 'PostDatedChequeReceivedController@submit_post_dated_cheque_received')->name('submit_post_dated_cheque_received');

            Route::get('/post_dated_cheque_received_list/{array?}/{str?}', 'PostDatedChequeReceivedController@post_dated_cheque_received_list')->name('post_dated_cheque_received_list');

            Route::post('/post_dated_cheque_received_list', 'PostDatedChequeReceivedController@post_dated_cheque_received_list')->name('post_dated_cheque_received_list');
            Route::post('/approve_post_dated_cheque_received', 'PostDatedChequeReceivedController@approve_post_dated_cheque_received')->name('approve_post_dated_cheque_received');
            Route::post('/reject_post_dated_cheque_received', 'PostDatedChequeReceivedController@reject_post_dated_cheque_received')->name('reject_post_dated_cheque_received');
            Route::get('/approve_post_dated_cheque_received_list', 'PostDatedChequeReceivedController@approve_post_dated_cheque_received_list')->name('approve_post_dated_cheque_received_list');
            Route::post('/approve_post_dated_cheque_received_list', 'PostDatedChequeReceivedController@approve_post_dated_cheque_received_list')->name('approve_post_dated_cheque_received_list');
            Route::get('/reject_post_dated_cheque_received_list', 'PostDatedChequeReceivedController@reject_post_dated_cheque_received_list')->name('reject_post_dated_cheque_received_list');
            Route::post('/reject_post_dated_cheque_received_list', 'PostDatedChequeReceivedController@reject_post_dated_cheque_received_list')->name('reject_post_dated_cheque_received_list');
            Route::get('/post_dated_cheque_received/view/pdf/{id}', 'PostDatedChequeReceivedController@post_dated_cheque_received_pdf_SH')->name('post_dated_cheque_received_pdf_SH');
        });
        /***************************************************************************/
        /***************************** Advance Salary Routes ***********************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/add_advance_salary', 'AdvanceSalaryController@add_advance_salary')->name('add_advance_salary');
            Route::post('/submit_advance_salary', 'AdvanceSalaryController@submit_advance_salary')->name('submit_advance_salary');
            Route::get('/advance_salary_list/{array?}/{str?}', 'AdvanceSalaryController@advance_salary_list')->name('advance_salary_list');
            Route::post('/advance_salary_list', 'AdvanceSalaryController@advance_salary_list')->name('advance_salary_list');
            Route::post('/get_advance_salary', 'AdvanceSalaryController@get_advance_salary')->name('get_advance_salary');

            Route::post('/advance_salary_items_view_details', 'AdvanceSalaryController@advance_salary_items_view_details')->name('advance_salary_items_view_details');
            Route::get('/advance_salary_items_view_details/view/{id}', 'AdvanceSalaryController@advance_salary_items_view_details_SH')->name('advance_salary_items_view_details_SH');

            Route::get('/advance_salary_view_details/view/pdf/{id}', 'AdvanceSalaryController@advance_salary_view_details_pdf_SH')->name('advance_salary_view_details_pdf_SH');


            Route::get('/queryForShiftingData', 'AdvanceSalaryController@queryForShiftingData')->name('queryForShiftingData');
            Route::get('/assignDepartmentToEmployee', 'AdvanceSalaryController@assignDepartmentToEmployee')->name('assignDepartmentToEmployee');

            Route::post('/get_adv_accounts', 'AdvanceSalaryController@get_adv_accounts')->name('get_adv_accounts');

            Route::get('/advance_salary_report', 'AdvanceSalaryController@advance_salary_report')->name('advance_salary_report');

            Route::get('/add_new_advance_salary', 'AdvanceSalaryController@add_new_advance_salary')->name('add_new_advance_salary');
            Route::post('/submit_new_advance_salary', 'AdvanceSalaryController@submit_new_advance_salary')->name('submit_new_advance_salary');
        });
        /***************************************************************************/
        /******************* Add Second Level Chart Of Account Routes **************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/add_second_level_chart_of_account', 'ChartOfAccountController@add_second_level_chart_of_account')->name('add_second_level_chart_of_account');

            Route::post('/submit_second_level_chart_of_account', 'ChartOfAccountController@submit_second_level_chart_of_account')->name('submit_second_level_chart_of_account');

            Route::post('/submit_second_level_chart_of_account_excel', 'ChartOfAccountController@submit_second_level_chart_of_account_excel')->name('submit_second_level_chart_of_account_excel');

            Route::get('/second_level_chart_of_account_list', 'ChartOfAccountController@second_level_chart_of_account_list')->name('second_level_chart_of_account_list');

            Route::post('/second_level_chart_of_account_list', 'ChartOfAccountController@second_level_chart_of_account_list')->name('second_level_chart_of_account_list');

            Route::post('/edit_second_level_chart_of_account', 'ChartOfAccountController@edit_second_level_chart_of_account')->name('edit_second_level_chart_of_account');

            Route::get('/edit_second_level_chart_of_account', 'ChartOfAccountController@second_level_chart_of_account_list')->name('edit_second_level_chart_of_account');

            Route::post('/update_chart_of_account', 'ChartOfAccountController@update_chart_of_account')->name('update_chart_of_account');

            Route::post('/delete_second_level_chart_of_account', 'ChartOfAccountController@delete_second_level_chart_of_account')->name('delete_second_level_chart_of_account');


            /***************************************************************************/
            /***************** Add Third Level Chart Of Account Routes *****************/
            /***************************************************************************/

            Route::get('/add_third_level_chart_of_account', 'ChartOfAccountController@add_third_level_chart_of_account')->name('add_third_level_chart_of_account');

            Route::post('/submit_third_level_chart_of_account', 'ChartOfAccountController@submit_third_level_chart_of_account')->name('submit_third_level_chart_of_account');

            Route::post('/submit_third_level_chart_of_account_excel', 'ChartOfAccountController@submit_third_level_chart_of_account_excel')->name('submit_third_level_chart_of_account_excel');

            Route::get('/third_level_chart_of_account_list/{array?}/{str?}', 'ChartOfAccountController@third_level_chart_of_account_list')->name('third_level_chart_of_account_list');

            Route::post('/third_level_chart_of_account_list', 'ChartOfAccountController@third_level_chart_of_account_list')->name('third_level_chart_of_account_list');

            Route::post('/edit_third_level_chart_of_account', 'ChartOfAccountController@edit_third_level_chart_of_account')->name('edit_third_level_chart_of_account');

            Route::get('/edit_third_level_chart_of_account', 'ChartOfAccountController@third_level_chart_of_account_list')->name('edit_third_level_chart_of_account');

            Route::post('/delete_third_level_chart_of_account', 'ChartOfAccountController@delete_third_level_chart_of_account')->name('delete_third_level_chart_of_account');
        });
        /***************************************************************************/
        /****************** Party Wise Purchase Aging Report Routes ****************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/aging_report_party_wise_purchase/{array?}/{str?}', 'AllReportsController@aging_report_party_wise_purchase')->name('aging_report_party_wise_purchase');

            Route::post('/aging_report_party_wise_purchase', 'AllReportsController@aging_report_party_wise_purchase')->name('aging_report_party_wise_purchase');
        });

        /***************************************************************************/
        /****************** Stock Activity Report Routes ****************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/stock_activity_report/{array?}/{str?}', 'AllReportsController@stock_activity_report')->name('stock_activity_report');

            Route::post('/stock_activity_report', 'AllReportsController@stock_activity_report')->name('stock_activity_report');
        });
        /***************************************************************************/
        /********************** Party Wise Sale Aging Report Routes ****************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/aging_report_party_wise_sale', 'AllReportsController@aging_report_party_wise_sale')->name('aging_report_party_wise_sale');

            Route::post('/aging_report_party_wise_sale', 'AllReportsController@aging_report_party_wise_sale')->name('aging_report_party_wise_sale');
        });
        /***************************************************************************/
        /****************** Product Wise Aging Report Routes ***********************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/aging_report_product_wise/{array?}/{str?}', 'AllReportsController@aging_report_product_wise')->name('aging_report_product_wise');

            Route::post('/aging_report_product_wise', 'AllReportsController@aging_report_product_wise')->name('aging_report_product_wise');
        });
        /***************************************************************************/
        /**************** Sale Invoice Wise Profit Report Routes *******************/
        /***************************************************************************/

        Route::get('/sale_invoice_wise_profit/{array?}/{str?}', 'AllReportsController@sale_invoice_wise_profit')->name('sale_invoice_wise_profit');

        Route::post('/sale_invoice_wise_profit', 'AllReportsController@sale_invoice_wise_profit')->name('sale_invoice_wise_profit');


        /***************************************************************************/
        /************ Sale Person Wise Profit Report Routes ************************/
        /***************************************************************************/

        Route::get('/sale_person_wise_profit/{array?}/{str?}', 'AllReportsController@sale_person_wise_profit')->name('sale_person_wise_profit');

        Route::post('/sale_person_wise_profit', 'AllReportsController@sale_person_wise_profit')->name('sale_person_wise_profit');


        /***************************************************************************/
        /*************** Client (Receivable) Wise Profit Report Routes *************/
        /***************************************************************************/

        Route::get('/client_wise_profit/{array?}/{str?}', 'AllReportsController@client_wise_profit')->name('client_wise_profit');

        Route::post('/client_wise_profit', 'AllReportsController@client_wise_profit')->name('client_wise_profit');


        /******************************************************************************************************/
        /***************************** Supplier (Payable) Wise Profit Report Routes ***************************/
        /******************************************************************************************************/

        Route::get('/supplier_wise_profit/{array?}/{str?}', 'AllReportsController@supplier_wise_profit')->name('supplier_wise_profit');

        Route::post('/supplier_wise_profit', 'AllReportsController@supplier_wise_profit')->name('supplier_wise_profit');


        /******************************************************************************************************/
        /***************************** Product Wise Profit Report Routes **************************************/
        /******************************************************************************************************/

        Route::get('/product_wise_profit/{array?}/{str?}', 'AllReportsController@product_wise_profit')->name('product_wise_profit');

        Route::post('/product_wise_profit', 'AllReportsController@product_wise_profit')->name('product_wise_profit');


        /******************************************************************************************************/
        /***************************** Product Last Purchase Rate Verification Report Routes ******************/
        /******************************************************************************************************/

        Route::get('/product_last_purchase_rate_verification/{array?}/{str?}', 'AllReportsController@product_last_purchase_rate_verification')->name('product_last_purchase_rate_verification');

        Route::post('/product_last_purchase_rate_verification', 'AllReportsController@product_last_purchase_rate_verification')->name('product_last_purchase_rate_verification');


        /******************************************************************************************************/
        /***************************** Product Last Purchase Rate Verification Report Routes Using Party By Nabeel ******************/
        /******************************************************************************************************/

        Route::get('/party_last_purchase_rate_verification/{array?}/{str?}', 'AllReportsController@party_last_purchase_rate_verification')->name('party_last_purchase_rate_verification');

        Route::post('/party_last_purchase_rate_verification', 'AllReportsController@party_last_purchase_rate_verification')->name('party_last_purchase_rate_verification');


        /******************************************************************************************************/
        /***************************** Product Last Sale Rate Verification Report Routes **********************/
        /******************************************************************************************************/

        Route::get('/product_last_sale_rate_verification/{array?}/{str?}', 'AllReportsController@product_last_sale_rate_verification')->name('product_last_sale_rate_verification');

        Route::post('/product_last_sale_rate_verification', 'AllReportsController@product_last_sale_rate_verification')->name('product_last_sale_rate_verification');

        Route::post('/product_last_sale_rate_verification', 'AllReportsController@product_last_sale_rate_verification')->name('product_last_sale_rate_verification');


        /******************************************************************************************************/
        /***************************** Party Product Last Sale Rate Verification Report Routes **********************/
        /******************************************************************************************************/

        Route::get('/party_last_sale_rate_verification/{array?}/{str?}', 'AllReportsController@party_last_sale_rate_verification')->name('party_last_sale_rate_verification');

        Route::post('/party_last_sale_rate_verification', 'AllReportsController@party_last_sale_rate_verification')->name('party_last_sale_rate_verification');

        Route::post('/party_last_sale_rate_verification', 'AllReportsController@party_last_sale_rate_verification')->name('party_last_sale_rate_verification');


        /******************************************************************************************************/
        /***************************** Account Receivable List for Ledger Report Routes ***********************/
        /******************************************************************************************************/

        Route::get('/account_receivable_list/{array?}/{str?}', 'AllReportsController@account_receivable_list')->name('account_receivable_list');

        Route::post('/account_receivable_list', 'AllReportsController@account_receivable_list')->name('account_receivable_list');


        /******************************************************************************************************/
        /***************************** Account Payable List for Ledger Report Routes *************************/
        /*****************************************************************************************************/

        Route::get('/account_payable_list/{array?}/{str?}', 'AllReportsController@account_payable_list')->name('account_payable_list');

        Route::post('/account_payable_list', 'AllReportsController@account_payable_list')->name('account_payable_list');


        /*****************************************************************************************************/
        /***************************** Party Wise Opening Closing Report Routes ******************************/
        /*****************************************************************************************************/

        Route::get('/party_wise_opening_closing/{array?}/{str?}', 'AllReportsController@party_wise_opening_closing')->name('party_wise_opening_closing');

        Route::post('/party_wise_opening_closing', 'AllReportsController@party_wise_opening_closing')->name('party_wise_opening_closing');


        /*****************************************************************************************************/
        /***************************** Product Ledger Stock Wise Report Routes *******************************/
        /*****************************************************************************************************/

        Route::get('/product_ledger_stock_wise/{array?}/{str?}', 'AllReportsController@product_ledger_stock_wise')->name('product_ledger_stock_wise');

        Route::post('/product_ledger_stock_wise', 'AllReportsController@product_ledger_stock_wise')->name('product_ledger_stock_wise');

        /*****************************************************************************************************/
        /***************************** Product Wise Ledger Report Routes *******************************/
        /*****************************************************************************************************/

        Route::get('/product_wise_ledger/{array?}/{str?}', 'AllReportsController@product_wise_ledger')->name('product_wise_ledger');

        Route::post('/product_wise_ledger', 'AllReportsController@product_wise_ledger')->name('product_wise_ledger');


        /*****************************************************************************************************/
        /***************************** Product Ledger Amount Wise Report Routes ******************************/
        /*****************************************************************************************************/

        Route::get('/product_ledger_amount_wise/{array?}/{str?}', 'AllReportsController@product_ledger_amount_wise')->name('product_ledger_amount_wise');

        Route::post('/product_ledger_amount_wise', 'AllReportsController@product_ledger_amount_wise')->name('product_ledger_amount_wise');


        /*****************************************************************************************************/
        /***************************** Module Group Configuration Routes *************************************/
        /*****************************************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/add_modular_group', 'ModularGroupController@add_modular_group')->name('add_modular_group');

            Route::post('/submit_modular_group', 'ModularGroupController@submit_modular_group')->name('submit_modular_group');

            Route::post('/submit_modular_group_excel', 'ModularGroupController@submit_modular_group_excel')->name('submit_modular_group_excel');

            Route::get('/modular_group_list', 'ModularGroupController@modular_group_list')->name('modular_group_list');

            Route::post('/modular_group_list', 'ModularGroupController@modular_group_list')->name('modular_group_list');

            Route::post('/edit_modular_group', 'ModularGroupController@edit_modular_group')->name('edit_modular_group');

            Route::post('/update_modular_group', 'ModularGroupController@update_modular_group')->name('update_modular_group');

            Route::get('/edit_modular_group', 'ModularGroupController@modular_group_list')->name('edit_modular_group');

            Route::post('/delete_modular_group', 'ModularGroupController@delete_modular_group')->name('delete_modular_group');
        });
        /*****************************************************************************************************/
        /***************************** Warehouse Stock Routes ************************************************/
        /*****************************************************************************************************/

        Route::get('/warehouse_stock', 'AllReportsController@warehouse_stock')->name('warehouse_stock');

        Route::post('/warehouse_stock', 'AllReportsController@warehouse_stock')->name('warehouse_stock');


        /***************************************************************************/
        /***************************** Product Rate Change Routes ******************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/product_rate_change/{array?}/{str?}', 'ProductController@product_rate_change')->name('product_rate_change');

            Route::post('/product_rate_change', 'ProductController@product_rate_change')->name('product_rate_change');

            Route::post('/update_product_rate_change', 'ProductController@update_product_rate_change')->name('update_product_rate_change');
        });

        /***************************************************************************/
        /***************************** Company Info Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/company_info', 'CompanyInfoController@company_info')->name('company_info');

            Route::post('/update_compsubmit_areaany_info', 'CompanyInfoController@update_company_info')->name('update_company_info');
        });
        /***************************************************************************/
        /***************************** Print Template ******************************/
        /***************************************************************************/
        Route::get('/print', function (\Illuminate\Http\Request $request) {
            return view('print_template', compact(''));
        })->name('print');


        /***************************************************************************/
        /***************************** Cash Book Routes ****************************/
        /***************************************************************************/

        Route::get('/cashbook/{array?}/{str?}', 'AccountLedgerController@cashbook')->name('cashbook');
        Route::post('/cashbook', 'AccountLedgerController@cashbook')->name('cashbook');


        /***************************************************************************/
        /***************************** Db Back up  Routes **************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/db_backup', 'DatabaseBackUpController@db_backup')->name('db_backup');

            Route::get('/submit_db_backup', 'DatabaseBackUpController@submit_db_backup')->name('submit_db_backup');

            Route::get('/db_backup_list/{array?}/{str?}', 'DatabaseBackUpController@db_backup_list')->name('db_backup_list');

            Route::post('/db_backup_list', 'DatabaseBackUpController@db_backup_list')->name('db_backup_list');

            Route::post('/restore_db_backup', 'DatabaseBackUpController@restore_db_backup')->name('restore_db_backup');

            Route::post('/download_db_file', 'DatabaseBackUpController@download_db_file')->name('download_db_file');
        });

        /***************************************************************************/
        /***************************** Walk in Customer Routes *********************/
        /***************************************************************************/

        Route::get('/walk_in_customers_report', 'AllReportsController@walk_in_customers_report')->name('walk_in_customers_report');

        Route::get('/walk_in_customers_report', 'AllReportsController@walk_in_customers_report')->name('walk_in_customers_report');


        Route::get('/add_inventory', 'AddInventoryController@add_inventory')->name('add_inventory');
        Route::post('/submit_add_inventory', 'AddInventoryController@submit_add_inventory')->name('submit_add_inventory');
        Route::get('/add_inventory_list', 'AddInventoryController@add_inventory_list')->name('add_inventory_list');


        /***************************************************************************/
        /***************************** Product Clubbing Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {

            Route::get('/product_clubbing', 'ProductClubbingController@product_clubbing')->name('product_clubbing');

            Route::post('/product_clubbing', 'ProductClubbingController@product_clubbing')->name('product_clubbing');

            Route::post('/submit_product_clubbing', 'ProductClubbingController@submit_product_clubbing')->name('submit_product_clubbing');

            Route::post('/submit_product_clubbing_excel', 'ProductClubbingController@submit_product_clubbing_excel')->name('submit_product_clubbing_excel');

            Route::get('/product_clubbing_list/{array?}/{str?}', 'ProductClubbingController@product_clubbing_list')->name('product_clubbing_list');

            Route::post('/product_clubbing_list', 'ProductClubbingController@product_clubbing_list')->name('product_clubbing_list');


            /***************************************************************************/
            /***************************** Product Packages Routes *********************/
            /***************************************************************************/

            Route::get('/product_packages', 'ProductPackagesController@product_packages')->name('product_packages');

            Route::post('/submit_product_packages', 'ProductPackagesController@submit_product_packages')->name('submit_product_packages');

            Route::get('/product_packages_list/{array?}/{str?}', 'ProductPackagesController@product_packages_list')->name('product_packages_list');

            Route::post('/product_packages_list', 'ProductPackagesController@product_packages_list')->name('product_packages_list');

            Route::post('/edit_product_packages', 'ProductPackagesController@edit_product_packages')->name('edit_product_packages');

            Route::get('/edit_product_packages', 'ProductPackagesController@product_packages_list')->name('edit_product_packages');

            Route::post('/update_product_packages', 'ProductPackagesController@update_product_packages')->name('update_product_packages');

            Route::post('/delete_product_packages', 'ProductPackagesController@delete_product_packages')->name('delete_product_packages');

            Route::post('/get_product_packages_details', 'ProductPackagesController@get_product_packages_details')->name('get_product_packages_details');


            /***************************************************************************/
            /***************************** Trade Product Packages Routes *********************/
            /***************************************************************************/

            Route::get('/trade_product_packages', 'TradeInvoices\TradeProductPackagesController@trade_product_packages')->name('trade_product_packages');

            Route::post('/submit_trade_product_packages', 'TradeInvoices\TradeProductPackagesController@submit_trade_product_packages')->name('submit_trade_product_packages');

            Route::get('/trade_product_packages_list/{array?}/{str?}', 'TradeInvoices\TradeProductPackagesController@trade_product_packages_list')->name('trade_product_packages_list');

            Route::post('/trade_product_packages_list', 'TradeInvoices\TradeProductPackagesController@trade_product_packages_list')->name('trade_product_packages_list');

            Route::post('/edit_trade_product_packages', 'TradeInvoices\TradeProductPackagesController@edit_trade_product_packages')->name('edit_trade_product_packages');

            Route::get('/edit_trade_product_packages', 'TradeInvoices\TradeProductPackagesController@trade_product_packages_list')->name('edit_trade_product_packages');

            Route::post('/update_trade_product_packages', 'TradeInvoices\TradeProductPackagesController@update_trade_product_packages')->name('update_trade_product_packages');

            Route::post('/delete_trade_product_packages', 'TradeInvoices\TradeProductPackagesController@delete_trade_product_packages')->name('delete_trade_product_packages');

            //Route::post('/get_trade_product_packages_details', 'TradeInvoices\TradeProductPackagesController@get_trade_product_packages_details')->name('get_trade_product_packages_details');

        });
        /***************************************************************************/
        /***************************** Product Recipe Routes ***********************/
        /***************************************************************************/

        //Route::get('/product_recipe', function (){
        //    view('product_recipe');
        //})->name('product_recipe');

        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::post('/get_recipe', 'ProductRecipeController@getRecipe')->name('get_recipe');

            Route::get('/product_recipe', 'ProductRecipeController@product_recipe')->name('product_recipe');

            Route::post('/submit_product_recipe', 'ProductRecipeController@submit_product_recipe')->name('submit_product_recipe');

            Route::get('/product_recipe_list/{array?}/{str?}', 'ProductRecipeController@product_recipe_list')->name('product_recipe_list');

            Route::post('/product_recipe_list', 'ProductRecipeController@product_recipe_list')->name('product_recipe_list');

            Route::post('/edit_product_recipe', 'ProductRecipeController@edit_product_recipe')->name('edit_product_recipe');

            Route::post('/update_product_recipe', 'ProductRecipeController@update_product_recipe')->name('update_product_recipe');

            Route::get('/edit_product_recipe', 'ProductRecipeController@product_recipe_list')->name('edit_product_recipe');

            Route::post('/delete_product_recipe', 'ProductRecipeController@delete_product_recipe')->name('delete_product_recipe');

            Route::post('/get_product_recipe_details', 'ProductRecipeController@get_product_recipe_details')->name('get_product_recipe_details');

            Route::resource('work_order', 'WorkOrderController');


            Route::get('/enable_disable_product_measurement_config', 'EnabledDisabledController@enable_disable_product_measurement_config')->name('enable_disable_product_measurement_config');

            Route::get('/enable_disable_project', 'EnabledDisabledController@enable_disable_project')->name('enable_disable_project');

            Route::get('/enable_disable_project_expense', 'EnabledDisabledController@enable_disable_project_expense')->name('enable_disable_project_expense');

            Route::resource('/production', 'ProductionController');
        });
        /***************************************************************************/
        /***************************** Department Routes ******************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::resource('/departments', 'DepartmentController');

            Route::post('/search_department', 'DepartmentController@index')->name('search_department');

            Route::get('/enable_disable_department', 'EnabledDisabledController@enable_disable_department')->name('enable_disable_department');
        });

        /***************************************************************************/
        /***************************** Manufacture Product Routes ******************/
        /***************************************************************************/

        Route::get('/manufacture_product', 'ManufactureProductController@manufacture_product')->name('manufacture_product');

        Route::post('/submit_manufacture_product', 'ManufactureProductController@submit_manufacture_product')->name('submit_manufacture_product');

        Route::get('/manufacture_product_list/{array?}/{str?}', 'ManufactureProductController@manufacture_product_list')->name('manufacture_product_list');

        Route::post('/manufacture_product_list', 'ManufactureProductController@manufacture_product_list')->name('manufacture_product_list');

        Route::post('/edit_manufacture_product', 'ManufactureProductController@edit_manufacture_product')->name('edit_manufacture_product');

        Route::post('/update_manufacture_product', 'ManufactureProductController@update_manufacture_product')->name('update_manufacture_product');

        Route::get('/edit_manufacture_product', 'ManufactureProductController@manufacture_product_list')->name('edit_manufacture_product');

        Route::post('/complete_manufacture_product', 'ManufactureProductController@complete_manufacture_product')->name('complete_manufacture_product');

        Route::get('/complete_manufacture_product_list/{array?}/{str?}', 'ManufactureProductController@complete_manufacture_product_list')->name('complete_manufacture_product_list');

        Route::post('/complete_manufacture_product_list', 'ManufactureProductController@complete_manufacture_product_list')->name('complete_manufacture_product_list');

        Route::post('/reject_manufacture_product', 'ManufactureProductController@reject_manufacture_product')->name('reject_manufacture_product');

        Route::get('/reject_manufacture_product_list/{array?}/{str?}', 'ManufactureProductController@reject_manufacture_product_list')->name('reject_manufacture_product_list');

        Route::post('/reject_manufacture_product_list', 'ManufactureProductController@reject_manufacture_product_list')->name('reject_manufacture_product_list');

        Route::post('/get_manufacture_product_details', 'ManufactureProductController@get_manufacture_product_details')->name('get_manufacture_product_details');

        Route::get('/get_manufacture_product_details/view/{id}', 'ManufactureProductController@get_manufacture_product_details_SH')->name('get_manufacture_product_details_SH');

        Route::get('/get_manufacture_product_details/view/pdf/{id}', 'ManufactureProductController@get_manufacture_product_details_pdf_SH')->name('get_manufacture_product_details_pdf_SH');


        /***************************************************************************/
        /***************************** Town Routes *********************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {

            Route::get('/add_town', 'TownController@add_town')->name('add_town');

            Route::post('/submit_town', 'TownController@submit_town')->name('submit_town');

            Route::post('/submit_town_excel', 'TownController@submit_town_excel')->name('submit_town_excel');

            Route::get('/town_list/{array?}/{str?}', 'TownController@town_list')->name('town_list');

            Route::post('/town_list', 'TownController@town_list')->name('town_list');

            Route::post('/edit_town', 'TownController@edit_town')->name('edit_town');

            Route::get('/edit_town', 'TownController@town_list')->name('edit_town');

            Route::post('/update_town', 'TownController@update_town')->name('update_town');

            Route::post('/delete_town', 'TownController@delete_town')->name('delete_town');
        });
        /***************************************************************************/
        /***************************** Fixed Assets Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/fixed_asset', 'AccountRegisterationsController@fixed_asset')->name('fixed_asset');

            Route::post('/submit_fixed_asset', 'AccountRegisterationsController@submit_fixed_asset')->name('submit_fixed_asset');

            Route::post('/submit_fixed_asset_excel', 'AccountRegisterationsController@submit_fixed_asset_excel')->name('submit_fixed_asset_excel');

            Route::get('/fixed_asset_list', 'AccountRegisterationsController@fixed_asset_list')->name('fixed_asset_list');

            Route::post('/fixed_asset_list', 'AccountRegisterationsController@fixed_asset_list')->name('fixed_asset_list');

            Route::get('/edit_fixed_asset', 'AccountRegisterationsController@fixed_asset_list')->name('edit_fixed_asset');

            Route::post('/edit_fixed_asset', 'AccountRegisterationsController@edit_fixed_asset')->name('edit_fixed_asset');

            Route::post('/update_fixed_asset', 'AccountRegisterationsController@update_fixed_asset')->name('update_fixed_asset');
        });

        /***************************************************************************/
        /***************************** Capital Registration Routes *****************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/capital_registration', 'AccountRegisterationsController@capital_registration')->name('capital_registration');

            Route::post('/submit_capital_registration', 'AccountRegisterationsController@submit_capital_registration')->name('submit_capital_registration');

            Route::post('/submit_capital_registration_excel', 'AccountRegisterationsController@submit_capital_registration_excel')->name('submit_capital_registration_excel');

            Route::get('/capital_registration_list/{array?}/{str?}', 'AccountRegisterationsController@capital_registration_list')->name('capital_registration_list');

            Route::post('/capital_registration_list', 'AccountRegisterationsController@capital_registration_list')->name('capital_registration_list');

            Route::get('/edit_capital_registration', 'AccountRegisterationsController@capital_registration_list')->name('edit_capital_registration');

            Route::post('/edit_capital_registration', 'AccountRegisterationsController@edit_capital_registration')->name('edit_capital_registration');

            Route::post('/update_capital_registration', 'AccountRegisterationsController@update_capital_registration')->name('update_capital_registration');

            //Route::get('{any}', function () {
            //    return view('dashboard');
            //})->where('any','.*');
        });

        /***************************************************************************/
        /***************************** Product Group Routes ************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/product_group', 'ProductGroupController@product_group')->name('product_group');

            Route::post('/submit_product_group', 'ProductGroupController@submit_product_group')->name('submit_product_group');

            Route::post('/submit_product_group_excel', 'ProductGroupController@submit_product_group_excel')->name('submit_product_group_excel');

            Route::get('/product_group_list/{array?}/{str?}', 'ProductGroupController@product_group_list')->name('product_group_list');

            Route::post('/product_group_list', 'ProductGroupController@product_group_list')->name('product_group_list');

            Route::post('/edit_product_group', 'ProductGroupController@edit_product_group')->name('edit_product_group');

            Route::post('/update_product_group', 'ProductGroupController@update_product_group')->name('update_product_group');

            Route::get('/edit_product_group', 'ProductGroupController@product_group_list')->name('edit_product_group');

            Route::post('/delete_product_group', 'ProductGroupController@delete_product_group')->name('delete_product_group');
        });

        /***************************************************************************/
        /***************************** Refresh Ajax Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::post('/refresh_region', 'RefreshAjaxController@refresh_region')->name('refresh_region');

            Route::post('/refresh_area', 'RefreshAjaxController@refresh_area')->name('refresh_area');

            Route::post('/refresh_sector', 'RefreshAjaxController@refresh_sector')->name('refresh_sector');

            Route::post('/refresh_reporting_group', 'RefreshAjaxController@refresh_reporting_group')->name('refresh_reporting_group');
            Route::post('/refresh_sale_person', 'RefreshAjaxController@refresh_sale_person')->name('refresh_sale_person');

            Route::post('/refresh_head', 'RefreshAjaxController@refresh_head')->name('refresh_head');

            Route::post('/refresh_second_head', 'RefreshAjaxController@refresh_second_head')->name('refresh_second_head');

            Route::post('/refresh_third_head', 'RefreshAjaxController@refresh_third_head')->name('refresh_third_head');

            Route::post('/refresh_product_group', 'RefreshAjaxController@refresh_product_group')->name('refresh_product_group');

            Route::post('/refresh_modular_group', 'RefreshAjaxController@refresh_modular_group')->name('refresh_modular_group');

            Route::post('/refresh_mainUnit', 'RefreshAjaxController@refresh_mainUnit')->name('refresh_mainUnit');

            Route::post('/refresh_category_group', 'RefreshAjaxController@refresh_category_group')->name('refresh_category_group');

            Route::post('/refresh_GroupInfo_group', 'RefreshAjaxController@refresh_GroupInfo_group')->name('refresh_GroupInfo_group');

            Route::post('/refresh_unit', 'RefreshAjaxController@refresh_unit')->name('refresh_unit');

            Route::post('/refresh_warehouse', 'RefreshAjaxController@refresh_warehouse')->name('refresh_warehouse');

            Route::post('/refresh_posting_reference', 'RefreshAjaxController@refresh_posting_reference')->name('refresh_posting_reference');

            Route::post('/refresh_store_warehouse', 'RefreshAjaxController@refresh_store_warehouse')->name('refresh_store_warehouse');

            Route::post('/refresh_cash_transfer_to', 'RefreshAjaxController@refresh_cash_transfer_to')->name('refresh_cash_transfer_to');

            Route::post('/refresh_bank', 'RefreshAjaxController@refresh_bank')->name('refresh_bank');

            Route::post('/refresh_purchase_account_code', 'RefreshAjaxController@refresh_purchase_account_code')->name('refresh_purchase_account_code');
            Route::post('/refresh_purchase_account_name', 'RefreshAjaxController@refresh_purchase_account_name')->name('refresh_purchase_account_name');

            Route::post('/refresh_cash_receipt', 'RefreshAjaxController@refresh_cash_receipt')->name('refresh_cash_receipt');

            Route::post('/refresh_credit_card_machine', 'RefreshAjaxController@refresh_credit_card_machine')->name('refresh_credit_card_machine');

            Route::post('/refresh_to_bank', 'RefreshAjaxController@refresh_to_bank')->name('refresh_to_bank');

            Route::post('/refresh_from_bank', 'RefreshAjaxController@refresh_from_bank')->name('refresh_from_bank');

            Route::post('/refresh_expense_payment', 'RefreshAjaxController@refresh_expense_payment')->name('refresh_expense_payment');

            Route::post('/refresh_advance_salary_issue_to', 'RefreshAjaxController@refresh_advance_salary_issue_to')->name('refresh_advance_salary_issue_to');

            Route::post('/refresh_employee', 'RefreshAjaxController@refresh_employee')->name('refresh_employee');

            Route::post('/refresh_product_code', 'RefreshAjaxController@refresh_product_code')->name('refresh_product_code');
            Route::post('/refresh_products_code', 'RefreshAjaxController@refresh_products_code')->name('refresh_products_code');

            Route::post('/refresh_product_name', 'RefreshAjaxController@refresh_product_name')->name('refresh_product_name');
            Route::post('/refresh_products_name', 'RefreshAjaxController@refresh_products_name')->name('refresh_products_name');

            Route::post('/refresh_recipe', 'RefreshAjaxController@refresh_recipe')->name('refresh_recipe');

            Route::post('/refresh_manufacture_account_name', 'RefreshAjaxController@refresh_manufacture_account_name')->name('refresh_manufacture_account_name');

            Route::post('/refresh_manufacture_account_code', 'RefreshAjaxController@refresh_manufacture_account_code')->name('refresh_manufacture_account_code');

            Route::post('/refresh_packages', 'RefreshAjaxController@refresh_packages')->name('refresh_packages');

            Route::post('/refresh_equity_second_account', 'RefreshAjaxController@refresh_equity_second_account')->name('refresh_equity_second_account');

            Route::post('/refresh_user_name', 'RefreshAjaxController@refresh_user_name')->name('refresh_user_name');

            Route::post('/refresh_fixed_assets', 'RefreshAjaxController@refresh_fixed_assets')->name('refresh_fixed_assets');

            Route::post('/refresh_expense_head', 'RefreshAjaxController@refresh_expense_head')->name('refresh_expense_head');
            Route::post('/refresh_expense_parent_account', 'RefreshAjaxController@refresh_expense_parent_account')->name('refresh_expense_parent_account');

            Route::post('/refresh_accounts_code', 'RefreshAjaxController@refresh_account_code')->name('refresh_accounts_code');
            Route::get('/refresh_accounts_name', 'RefreshAjaxController@refresh_accounts_name')->name('refresh_accounts_name');

            Route::get('/refresh_accounts', 'RefreshAjaxController@refresh_accounts')->name('refresh_accounts');


            Route::post('/refresh_account_voucher_code', 'RefreshAjaxController@refresh_account_voucher_code')->name('refresh_account_voucher_code');
            Route::post('/refresh_account_voucher_name', 'RefreshAjaxController@refresh_account_voucher_name')->name('refresh_account_voucher_name');

            Route::post('/refresh_bank_code', 'RefreshAjaxController@refresh_bank_code')->name('refresh_bank_code');
            Route::post('/refresh_bank_name', 'RefreshAjaxController@refresh_bank_name')->name('refresh_bank_name');

            Route::post('/refresh_expense_account_code', 'RefreshAjaxController@refresh_expense_account_code')->name('refresh_expense_account_code');
            Route::post('/refresh_expense_account_name', 'RefreshAjaxController@refresh_expense_account_name')->name('refresh_expense_account_name');

            Route::post('/refresh_new_employee_name', 'RefreshAjaxController@refresh_new_employee_name')->name('refresh_new_employee_name');

            Route::post('/refresh_expense_accounts_code', 'RefreshAjaxController@refresh_expense_accounts_code')->name('refresh_expense_accounts_code');
            Route::post('/refresh_expense_accounts_name', 'RefreshAjaxController@refresh_expense_accounts_name')->name('refresh_expense_accounts_name');


            Route::post('/refresh_sale_product_code', 'RefreshAjaxController@refresh_sale_product_code')->name('refresh_sale_product_code');
            Route::post('/refresh_sale_product_name', 'RefreshAjaxController@refresh_sale_product_name')->name('refresh_sale_product_name');

            Route::post('/refresh_recipe_product_code', 'RefreshAjaxController@refresh_recipe_product_code')->name('refresh_recipe_product_code');
            Route::post('/refresh_recipe_product_name', 'RefreshAjaxController@refresh_recipe_product_name')->name('refresh_recipe_product_name');

            Route::post('/refresh_manufacture_product_code', 'RefreshAjaxController@refresh_manufacture_product_code')->name('refresh_manufacture_product_code');
            Route::post('/refresh_manufacture_product_name', 'RefreshAjaxController@refresh_manufacture_product_name')->name('refresh_manufacture_product_name');

            Route::post('/refresh_parent_head', 'RefreshAjaxController@refresh_parent_head')->name('refresh_parent_head');
            Route::post('/refresh_accounting_group', 'RefreshAjaxController@refresh_accounting_group')->name('refresh_accounting_group');

            Route::post('/refresh_categorys_group', 'RefreshAjaxController@refresh_categorys_group')->name('refresh_categorys_group');

            Route::post('/refresh_Group_cat_group', 'RefreshAjaxController@refresh_Group_cat_group')->name('refresh_Group_cat_group');

            Route::post('/refresh_product_club_name', 'RefreshAjaxController@refresh_product_club_name')->name('refresh_product_club_name');
            Route::post('/refresh_product_club_code', 'RefreshAjaxController@refresh_product_club_code')->name('refresh_product_club_code');


            Route::post('/refresh_jv_account_code', 'RefreshAjaxController@refresh_jv_account_code')->name('refresh_jv_account_code');
            Route::post('/refresh_jv_account_name', 'RefreshAjaxController@refresh_jv_account_name')->name('refresh_jv_account_name');

            Route::post('/refresh_salary_slip_account_code', 'RefreshAjaxController@refresh_salary_slip_account_code')->name('refresh_salary_slip_account_code');
            Route::post('/refresh_salary_slip_account_name', 'RefreshAjaxController@refresh_salary_slip_account_name')->name('refresh_salary_slip_account_name');

            Route::post('/refresh_salary_payment_account', 'RefreshAjaxController@refresh_salary_payment_account')->name('refresh_salary_payment_account');


            Route::post('/refresh_sale_account_code', 'RefreshAjaxController@refresh_sale_account_code')->name('refresh_sale_account_code');
            Route::post('/refresh_sale_account_name', 'RefreshAjaxController@refresh_sale_account_name')->name('refresh_sale_account_name');

            Route::post('/refresh_service', 'RefreshAjaxController@refresh_service')->name('refresh_service');

            Route::post('/refresh_party_claim', 'RefreshAjaxController@refresh_party_claim')->name('refresh_party_claim');

            Route::post('/refresh_publisher', 'RefreshAjaxController@refresh_publisher')->name('refresh_publisher');

            Route::post('/refresh_topic', 'RefreshAjaxController@refresh_topic')->name('refresh_topic');

            Route::post('/refresh_class', 'RefreshAjaxController@refresh_class')->name('refresh_class');

            Route::post('/refresh_currency', 'RefreshAjaxController@refresh_currency')->name('refresh_currency');

            Route::post('/refresh_language', 'RefreshAjaxController@refresh_language')->name('refresh_language');

            Route::post('/refresh_imprint', 'RefreshAjaxController@refresh_imprint')->name('refresh_imprint');

            Route::post('/refresh_illustrated', 'RefreshAjaxController@refresh_illustrated')->name('refresh_illustrated');

            Route::post('/refresh_author', 'RefreshAjaxController@refresh_author')->name('refresh_author');

            Route::post('/refresh_genre', 'RefreshAjaxController@refresh_genre')->name('refresh_genre');

            Route::post('/refresh_courier', 'RefreshAjaxController@refresh_courier')->name('refresh_courier');

            Route::post('/refresh_town', 'RefreshAjaxController@refresh_town')->name('refresh_town');

            Route::post('/refresh_advance_payment', 'RefreshAjaxController@refresh_advance_payment')->name('refresh_advance_payment');

            Route::post('/refresh_brand', 'RefreshAjaxController@refresh_brand')->name('refresh_brand');
            Route::post('/refresh_department', 'RefreshAjaxController@refresh_department')->name('refresh_department');
            Route::post('/refresh_designation', 'RefreshAjaxController@refresh_designation')->name('refresh_designation');
        });
        /***************************************************************************/
        /***************************** Force Offline User Routes *******************/
        /***************************************************************************/

        Route::get('/force_offline_user', 'AllReportsController@force_offline_user')->name('force_offline_user');

        Route::post('/force_offline_user', 'AllReportsController@force_offline_user')->name('force_offline_user');

        Route::post('/update_force_offline_user', 'EmployeeController@update_force_offline_user')->name('update_force_offline_user');

        Route::post('/update_all_force_offline_user', 'EmployeeController@update_all_force_offline_user')->name('update_all_force_offline_user');


        /***************************************************************************/
        /***************************** Enable Disable Routes ***************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/enable_disable_region', 'EnabledDisabledController@enable_disable_region')->name('enable_disable_region');
            Route::get('/enable_disable_desig', 'EnabledDisabledController@enable_disable_desig')->name('enable_disable_desig');

            Route::get('/enable_disable_project_reference', 'EnabledDisabledController@enable_disable_project_reference')->name('enable_disable_project_reference');

            Route::get('/enable_disable_brand', 'EnabledDisabledController@enable_disable_brand')->name('enable_disable_brand');

            Route::get('/enable_disable_area', 'EnabledDisabledController@enable_disable_area')->name('enable_disable_area');

            Route::get('/enable_disable_sector', 'EnabledDisabledController@enable_disable_sector')->name('enable_disable_sector');

            Route::get('/enable_disable_account', 'EnabledDisabledController@enable_disable_account')->name('enable_disable_account');

            Route::get('/enable_disable_account_group', 'EnabledDisabledController@enable_disable_account_group')->name('enable_disable_account_group');

            Route::get('/enable_disable_account_heads', 'EnabledDisabledController@enable_disable_account_heads')->name('enable_disable_account_heads');

            Route::get('/enable_disable_credit_card_machine', 'EnabledDisabledController@enable_disable_credit_card_machine')->name('enable_disable_credit_card_machine');

            Route::get('/enable_disable_warehouse', 'EnabledDisabledController@enable_disable_warehouse')->name('enable_disable_warehouse');

            Route::get('/enable_disable_employee', 'EnabledDisabledController@enable_disable_employee')->name('enable_disable_employee');

            Route::get('/enable_disable_finger', 'EnabledDisabledController@enable_disable_finger')->name('enable_disable_finger');


            Route::get('/enable_disable_main_unit', 'EnabledDisabledController@enable_disable_main_unit')->name('enable_disable_main_unit');

            Route::get('/enable_disable_unit', 'EnabledDisabledController@enable_disable_unit')->name('enable_disable_unit');

            Route::get('/enable_disable_group', 'EnabledDisabledController@enable_disable_group')->name('enable_disable_group');

            Route::get('/enable_disable_category', 'EnabledDisabledController@enable_disable_category')->name('enable_disable_category');

            Route::get('/enable_disable_product', 'EnabledDisabledController@enable_disable_product')->name('enable_disable_product');

            Route::get('/enable_disable_service', 'EnabledDisabledController@enable_disable_service')->name('enable_disable_service');

            Route::get('/enable_disable_modular_group', 'EnabledDisabledController@enable_disable_modular_group')->name('enable_disable_modular_group');

            Route::get('/enable_disable_role_permission', 'EnabledDisabledController@enable_disable_role_permission')->name('enable_disable_role_permission');

            Route::get('/enable_disable_town', 'EnabledDisabledController@enable_disable_town')->name('enable_disable_town');

            Route::get('/enable_disable_product_package', 'EnabledDisabledController@enable_disable_product_package')->name('enable_disable_product_package');

            Route::get('/enable_disable_product_batch_recipe', 'EnabledDisabledController@enable_disable_product_batch_recipe')->name('enable_disable_product_batch_recipe');

            Route::get('/enable_disable_product_recipe', 'EnabledDisabledController@enable_disable_product_recipe')->name('enable_disable_product_recipe');

            Route::post('/enable_disable_product_handling', 'EnabledDisabledController@enable_disable_product_handling')->name('enable_disable_product_handling');

            Route::get('/enable_disable_publisher', 'EnabledDisabledController@enable_disable_publisher')->name('enable_disable_publisher');

            Route::get('/enable_disable_topic', 'EnabledDisabledController@enable_disable_topic')->name('enable_disable_topic');

            Route::get('/enable_disable_author', 'EnabledDisabledController@enable_disable_author')->name('enable_disable_author');

            Route::get('/enable_disable_class', 'EnabledDisabledController@enable_disable_class')->name('enable_disable_class');

            Route::get('/enable_disable_imPrint', 'EnabledDisabledController@enable_disable_imPrint')->name('enable_disable_imPrint');

            Route::get('/enable_disable_currency', 'EnabledDisabledController@enable_disable_currency')->name('enable_disable_currency');

            Route::get('/enable_disable_language', 'EnabledDisabledController@enable_disable_language')->name('enable_disable_language');

            Route::get('/enable_disable_genre', 'EnabledDisabledController@enable_disable_genre')->name('enable_disable_genre');

            Route::get('/enable_disable_illustrated', 'EnabledDisabledController@enable_disable_illustrated')->name('enable_disable_illustrated');

            Route::get('/enable_disable_product_detail', 'EnabledDisabledController@enable_disable_product_detail')->name('enable_disable_product_detail');

            Route::get('/enable_disable_courier', 'EnabledDisabledController@enable_disable_courier')->name('enable_disable_courier');

            Route::get('/enable_disable_table', 'EnabledDisabledController@enable_disable_table')->name('enable_disable_table');

            Route::get('/enable_disable_advertising', 'EnabledDisabledController@enable_disable_advertising')->name('enable_disable_advertising');
            Route::get('/enable_disable_surveyor', 'EnabledDisabledController@enable_disable_surveyor')->name('enable_disable_surveyor');

            Route::get('/enable_disable_fixed_asset', 'EnabledDisabledController@enable_disable_fixed_asset')->name('enable_disable_fixed_asset');


            /****************************************************************************************/
            /***************************** College Enable Disable  Routes ***************************/
            /****************************************************************************************/

            Route::get('/mark_teacherOrNot', 'EnabledDisabledController@mark_teacherOrNot')->name('mark_teacherOrNot');
            Route::get('/enable_disable_student', 'EnabledDisabledController@enable_disable_student')->name('enable_disable_student');
            Route::get('/enable_disable_school', 'EnabledDisabledController@enable_disable_school')->name('enable_disable_school');
            Route::get('/enable_disable_subject', 'EnabledDisabledController@enable_disable_subject')->name('enable_disable_subject');
            Route::get('/enable_disable_degree', 'EnabledDisabledController@enable_disable_degree')->name('enable_disable_degree');
            Route::get('/enable_disable_groups', 'EnabledDisabledController@enable_disable_groups')->name('enable_disable_groups');
            Route::get('/enable_disable_session', 'EnabledDisabledController@enable_disable_session')->name('enable_disable_session');
            Route::get('/enable_disable_semester', 'EnabledDisabledController@enable_disable_semester')->name('enable_disable_semester');
            Route::get('/enable_disable_clg_group', 'EnabledDisabledController@enable_disable_clg_group')->name('enable_disable_clg_group');
            Route::get('/enable_disable_section_coordinator', 'EnabledDisabledController@enable_disable_section_coordinator')->name('enable_disable_section_coordinator');
            Route::get('/enable_disable_hr_plan', 'EnabledDisabledController@enable_disable_hr_plan')->name('enable_disable_hr_plan');
            Route::get('/enable_disable_program', 'EnabledDisabledController@enable_disable_program')->name('enable_disable_program');
            Route::get('/enable_disable_section', 'EnabledDisabledController@enable_disable_section')->name('enable_disable_section');
            Route::get('/enable_disable_class_section', 'EnabledDisabledController@enable_disable_class_section')->name('enable_disable_class_section');
            Route::get('/enable_disable_class_timetable', 'EnabledDisabledController@enable_disable_class_timetable')->name('enable_disable_class_timetable');
            Route::get('/check_class_timetable', 'EnabledDisabledController@check_class_timetable')->name('check_class_timetable');
        });

        /****************************************************************************************/
        /***************************** Claim Stock Issue To Party  Routes ***************************/
        /****************************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/add_claim_stock_issue_to_party', 'ClaimStockIssueToPartyController@add_claim_stock_issue_to_party')->name('add_claim_stock_issue_to_party');
            Route::post('/submit_claim_stock_issue_to_party', 'ClaimStockIssueToPartyController@submit_claim_stock_issue_to_party')->name('submit_claim_stock_issue_to_party');

            Route::get('/claim_stock_issue_to_party_list/{array?}/{str?}', 'ClaimStockIssueToPartyController@claim_stock_issue_to_party_list')->name('claim_stock_issue_to_party_list');
            Route::post('/claim_stock_issue_to_party_list', 'ClaimStockIssueToPartyController@claim_stock_issue_to_party_list')->name('claim_stock_issue_to_party_list');

            Route::get('/claim_stock_issue_to_party_items_view_details/view/{id}', 'ClaimStockIssueToPartyController@claim_stock_issue_to_party_items_view_details_SH')->name('claim_stock_issue_to_party_items_view_details_SH');
            Route::get('/claim_stock_issue_to_party_items_view_details/pdf/{id}', 'ClaimStockIssueToPartyController@claim_stock_issue_to_party_items_view_details_pdf_SH')->name('claim_stock_issue_to_party_items_view_details_pdf_SH');

            /****************************************************************************************/
            /***************************** Trade Claim Stock Issue To Party  Routes ***************************/
            /****************************************************************************************/

            Route::get('/add_trade_claim_stock_issue_to_party', 'TradeInvoices\TradeClaimStockIssueToPartyController@add_trade_claim_stock_issue_to_party')->name('add_trade_claim_stock_issue_to_party');
            Route::post('/submit_trade_claim_stock_issue_to_party', 'TradeInvoices\TradeClaimStockIssueToPartyController@submit_trade_claim_stock_issue_to_party')->name('submit_trade_claim_stock_issue_to_party');

            Route::get('/trade_claim_stock_issue_to_party_list/{array?}/{str?}', 'TradeInvoices\TradeClaimStockIssueToPartyController@trade_claim_stock_issue_to_party_list')->name('trade_claim_stock_issue_to_party_list');
            Route::post('/trade_claim_stock_issue_to_party_list', 'TradeInvoices\TradeClaimStockIssueToPartyController@trade_claim_stock_issue_to_party_list')->name('trade_claim_stock_issue_to_party_list');

            Route::get('/trade_claim_stock_issue_to_party_items_view_details/view/{id}', 'TradeInvoices\TradeClaimStockIssueToPartyController@trade_claim_stock_issue_to_party_items_view_details_SH')->name('trade_claim_stock_issue_to_party_items_view_details_SH');
            Route::get('/trade_claim_stock_issue_to_party_items_view_details/pdf/{id}', 'TradeInvoices\TradeClaimStockIssueToPartyController@trade_claim_stock_issue_to_party_items_view_details_pdf_SH')->name('trade_claim_stock_issue_to_party_items_view_details_pdf_SH');

            /****************************************************************************************/
            /***************************** Claim Stock Receive To Party  Routes ***************************/
            /****************************************************************************************/

            Route::get('/add_claim_stock_receive', 'InternalClaimStockReceiveController@add_claim_stock_receive')->name('add_claim_stock_receive');
            Route::post('/submit_claim_stock_receive', 'InternalClaimStockReceiveController@submit_claim_stock_receive')->name('submit_claim_stock_receive');

            Route::get('/claim_stock_receive_list/{array?}/{str?}', 'InternalClaimStockReceiveController@claim_stock_receive_list')->name('claim_stock_receive_list');
            Route::post('/claim_stock_receive_list', 'InternalClaimStockReceiveController@claim_stock_receive_list')->name('claim_stock_receive_list');

            Route::get('/claim_stock_receive_items_view_details/view/{id}', 'InternalClaimStockReceiveController@claim_stock_receive_items_view_details_SH')->name('claim_stock_receive_items_view_details_SH');
            Route::get('/claim_stock_receive_items_view_details/pdf/{id}', 'InternalClaimStockReceiveController@claim_stock_receive_items_view_details_pdf_SH')->name('claim_stock_receive_items_view_details_pdf_SH');

            /****************************************************************************************/
            /***************************** Claim Stock Receive To Party  Routes ***************************/
            /****************************************************************************************/

            Route::get('/add_trade_claim_stock_receive', 'TradeInvoices\TradeInternalClaimStockReceiveController@add_trade_claim_stock_receive')->name('add_trade_claim_stock_receive');
            Route::post('/submit_trade_claim_stock_receive', 'TradeInvoices\TradeInternalClaimStockReceiveController@submit_trade_claim_stock_receive')->name('submit_trade_claim_stock_receive');

            Route::get('/trade_claim_stock_receive_list/{array?}/{str?}', 'TradeInvoices\TradeInternalClaimStockReceiveController@trade_claim_stock_receive_list')->name('trade_claim_stock_receive_list');
            Route::post('/trade_claim_stock_receive_list', 'TradeInvoices\TradeInternalClaimStockReceiveController@trade_claim_stock_receive_list')->name('trade_claim_stock_receive_list');

            Route::get('/trade_claim_stock_receive_items_view_details/view/{id}', 'TradeInvoices\TradeInternalClaimStockReceiveController@trade_claim_stock_receive_items_view_details_SH')->name('trade_claim_stock_receive_items_view_details_SH');
            Route::get('/trade_claim_stock_receive_items_view_details/pdf/{id}', 'TradeInvoices\TradeInternalClaimStockReceiveController@trade_claim_stock_receive_items_view_details_pdf_SH')->name('trade_claim_stock_receive_items_view_details_pdf_SH');
        });
        /****************************************************************************************/
        /***************************** Brand  Routes ***************************/
        /****************************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/add_brand', 'BrandController@add_brand')->name('add_brand');

            Route::post('/submit_brand', 'BrandController@submit_brand')->name('submit_brand');

            Route::post('/submit_brand_excel', 'BrandController@submit_brand_excel')->name('submit_brand_excel');

            Route::get('/brand_list/{array?}/{str?}', 'BrandController@brand_list')->name('brand_list');

            Route::post('/brand_list', 'BrandController@brand_list')->name('brand_list');

            Route::post('/edit_brand', 'BrandController@edit_brand')->name('edit_brand');

            Route::post('/update_brand', 'BrandController@update_brand')->name('update_brand');

            Route::get('/edit_brand', 'BrandController@brand_list')->name('edit_brand');

            Route::post('/delete_brand', 'BrandController@delete_brand')->name('delete_brand');
        });
        /****************************************************************************************/
        /***************************** DeliveryOption  Routes ***************************/
        /****************************************************************************************/
        Route::group(['middleware' => ['premiumPackage', 'dayEnd']], function () {
            Route::get('/delivery_option', 'DeliveryOptionController@delivery_option')->name('delivery_option');

            Route::post('/get_courier_city', 'DeliveryOptionController@get_courier_city')->name('get_courier_city');

            Route::get('/non_tax_invoice_party', 'DeliveryOptionController@non_tax_invoice_party')->name('non_tax_invoice_party');

            Route::get('/tax_invoice_party', 'DeliveryOptionController@tax_invoice_party')->name('tax_invoice_party');

            Route::post('/submit_delivery_option', 'DeliveryOptionController@submit_delivery_option')->name('submit_delivery_option');

            Route::get('/delivery_option_list/{array?}/{str?}', 'DeliveryOptionController@delivery_option_list')->name('delivery_option_list');

            Route::post('/delivery_option_list', 'DeliveryOptionController@delivery_option_list')->name('delivery_option_list');

            Route::post('/delivery_option_view_details', 'DeliveryOptionController@delivery_option_view_details')->name('delivery_option_view_details');

            Route::get('/delivery_option_view_details/view/{id}', 'DeliveryOptionController@delivery_option_view_details_SH')->name('delivery_option_view_details_SH');

            Route::get('/delivery_option_view_details/pdf/{id}', 'DeliveryOptionController@delivery_option_view_details_pdf_SH')->name('delivery_option_view_details_pdf_SH');
        });

        /****************************************************************************************/
        /***************************** Stock Inward Routes ***************************/
        /****************************************************************************************/
        Route::group(['middleware' => ['premiumPackage', 'dayEnd']], function () {
            Route::get('/stock_inward', 'StockInwardController@stock_inward')->name('stock_inward');

            Route::post('/submit_stock_inward', 'StockInwardController@submit_stock_inward')->name('submit_stock_inward');


            //    list 1 start

            Route::get('/stock_inward_list/{array?}/{str?}', 'StockInwardController@stock_inward_list')->name('stock_inward_list');

            Route::post('/stock_inward_list', 'StockInwardController@stock_inward_list')->name('stock_inward_list');

            Route::post('/stock_inward_view_details', 'StockInwardController@stock_inward_view_details')->name('stock_inward_view_details');

            Route::get('/stock_inward_view_details/view/{id}', 'StockInwardController@stock_inward_view_details_SH')->name('stock_inward_view_details_SH');

            Route::get('/stock_inward_view_details/pdf/{id}', 'StockInwardController@stock_inward_view_details_pdf_SH')->name('stock_inward_view_details_pdf_SH');

            //    list 1 end


            //    list 2 start

            Route::get('/stock_inward_detail_list/{array?}/{str?}', 'StockInwardController@stock_inward_detail_list')->name('stock_inward_detail_list');

            Route::post('/stock_inward_detail_list', 'StockInwardController@stock_inward_detail_list')->name('stock_inward_detail_list');
            //
            //Route::post('/stock_inward_detail_view_details', 'StockInwardController@stock_inward_detail_view_details')->name('stock_inward_detail_view_details');
            //
            //Route::get('/stock_inward_detail_view_details/view/{id}', 'StockInwardController@stock_inward_detail_view_details_SH')->name('stock_inward_detail_view_details_SH');
            //
            //Route::get('/stock_inward_detail_view_details/pdf/{id}', 'StockInwardController@stock_inward_detail_view_details_pdf_SH')->name('stock_inward_detail_view_details_pdf_SH');

            //    list 2 end


            /****************************************************************************************/
            /***************************** Stock Outward Routes ***************************/
            /****************************************************************************************/

            Route::get('/stock_outward', 'StockOutwardController@stock_outward')->name('stock_outward');

            Route::post('/get_courier_city', 'StockOutwardController@get_courier_city')->name('get_courier_city');

            Route::get('/non_tax_invoice_party', 'StockOutwardController@non_tax_invoice_party')->name('non_tax_invoice_party');

            Route::get('/tax_invoice_party', 'StockOutwardController@tax_invoice_party')->name('tax_invoice_party');

            Route::post('/submit_stock_outward', 'StockOutwardController@submit_stock_outward')->name('submit_stock_outward');

            //    list 1 start

            Route::get('/stock_outward_list/{array?}/{str?}', 'StockOutwardController@stock_outward_list')->name('stock_outward_list');

            Route::post('/stock_outward_list', 'StockOutwardController@stock_outward_list')->name('stock_outward_list');

            Route::post('/stock_outward_view_details', 'StockOutwardController@stock_outward_view_details')->name('stock_outward_view_details');

            Route::get('/stock_outward_view_details/view/{id}', 'StockOutwardController@stock_outward_view_details_SH')->name('stock_outward_view_details_SH');

            Route::get('/stock_outward_view_details/pdf/{id}', 'StockOutwardController@stock_outward_view_details_pdf_SH')->name('stock_outward_view_details_pdf_SH');

            Route::get('/get_party_invoice', 'StockOutwardController@get_party_invoice')->name('get_party_invoice');

            //    list 1 end

            //    list 2 start

            Route::get('/stock_outward_detail_list/{array?}/{str?}', 'StockOutwardController@stock_outward_detail_list')->name('stock_outward_detail_list');

            Route::post('/stock_outward_detail_list', 'StockOutwardController@stock_outward_detail_list')->name('stock_outward_detail_list');

            //Route::post('/stock_outward_detail_view_details', 'StockOutwardController@stock_outward_detail_view_details')->name('stock_outward_detail_view_details');
            //
            //Route::get('/stock_outward_detail_view_details/view/{id}', 'StockOutwardController@stock_outward_detail_view_details_SH')->name('stock_outward_detail_view_details_SH');
            //
            //Route::get('/stock_outward_detail_view_details/pdf/{id}', 'StockOutwardController@stock_outward_detail_view_details_pdf_SH')->name('stock_outward_detail_view_details_pdf_SH');

            Route::get('/get_party_invoice', 'StockOutwardController@get_party_invoice')->name('get_party_invoice');

            //    list 2 end

        });
        /***************************************************************************/
        /***************************** Courier Routes *****************/
        /***************************************************************************/
        Route::group(['middleware' => ['premiumPackage']], function () {
            Route::get('/add_courier', 'CourierController@add_courier')->name('add_courier');

            Route::post('/submit_courier', 'CourierController@submit_courier')->name('submit_courier');

            Route::get('/courier_list/{array?}/{str?}', 'CourierController@courier_list')->name('courier_list');

            Route::post('/courier_list', 'CourierController@courier_list')->name('courier_list');

            Route::post('/courier_items_view_details', 'CourierController@courier_items_view_details')->name('courier_items_view_details');

            Route::get('/courier_items_view_details/view/{id}', 'CourierController@courier_items_view_details_SH')->name('courier_items_view_details_SH');

            Route::get('/courier_items_view_details/pdf/{id}', 'CourierController@courier_items_view_details_pdf_SH')->name('courier_items_view_details_pdf_SH');

            Route::post('/delete_courier', 'CourierController@delete_courier')->name('delete_courier');

            Route::post('/edit_courier', 'CourierController@edit_courier')->name('edit_courier');

            Route::get('/edit_courier', 'CourierController@courier_list')->name('edit_courier');

            Route::post('/update_courier', 'CourierController@update_courier')->name('update_courier');
        });

        /***************************************************************************/
        /***************************** Day End Config Routes *****************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/day_end_config', 'DayEndConfigController@day_end_config')->name('day_end_config');
            Route::post('/submit_day_end_config', 'DayEndConfigController@submit_day_end_config')->name('submit_day_end_config');
            /***************************************************************************/
            /***************************** Report Config Urdu/English Routes *****************/
            /***************************************************************************/

            Route::get('/report_config', 'ReportConfigController@report_config')->name('report_config');
            Route::post('/submit_report_config', 'ReportConfigController@submit_report_config')->name('submit_report_config');
        });
        /***************************************************************************/
        /***************************** Publisher Routes ******************************/
        /***************************************************************************/

        Route::get('/add_publisher', 'PublisherController@add_publisher')->name('add_publisher');

        Route::post('/submit_publisher', 'PublisherController@submit_publisher')->name('submit_publisher');

        Route::post('/submit_publisher_excel', 'PublisherController@submit_publisher_excel')->name('submit_publisher_excel');

        Route::get('/publisher_list/{array?}/{str?}', 'PublisherController@publisher_list')->name('publisher_list');

        Route::post('/publisher_list', 'PublisherController@publisher_list')->name('publisher_list');

        Route::post('/edit_publisher', 'PublisherController@edit_publisher')->name('edit_publisher');

        Route::post('/update_publisher', 'PublisherController@update_publisher')->name('update_publisher');

        Route::get('/edit_publisher', 'PublisherController@publisher_list')->name('edit_publisher');

        Route::post('/delete_publisher', 'PublisherController@delete_publisher')->name('delete_publisher');

        /***************************************************************************/
        /***************************** Author Routes ******************************/
        /***************************************************************************/

        Route::get('/add_author', 'AuthorController@add_author')->name('add_author');

        Route::post('/submit_author', 'AuthorController@submit_author')->name('submit_author');

        Route::post('/submit_author_excel', 'AuthorController@submit_author_excel')->name('submit_author_excel');

        Route::get('/author_list/{array?}/{str?}', 'AuthorController@author_list')->name('author_list');

        Route::post('/author_list', 'AuthorController@author_list')->name('author_list');

        Route::post('/edit_author', 'AuthorController@edit_author')->name('edit_author');

        Route::post('/update_author', 'AuthorController@update_author')->name('update_author');

        Route::get('/edit_author', 'AuthorController@author_list')->name('edit_author');

        Route::post('/delete_author', 'AuthorController@delete_author')->name('delete_author');


        /***************************************************************************/
        /***************************** Topic Routes ******************************/
        /***************************************************************************/

        Route::get('/add_topic', 'TopicController@add_topic')->name('add_topic');

        Route::post('/submit_topic', 'TopicController@submit_topic')->name('submit_topic');

        Route::post('/submit_topic_excel', 'TopicController@submit_topic_excel')->name('submit_topic_excel');

        Route::get('/topic_list/{array?}/{str?}', 'TopicController@topic_list')->name('topic_list');

        Route::post('/topic_list', 'TopicController@topic_list')->name('topic_list');

        Route::post('/edit_topic', 'TopicController@edit_topic')->name('edit_topic');

        Route::post('/update_topic', 'TopicController@update_topic')->name('update_topic');

        Route::get('/edit_topic', 'TopicController@topic_list')->name('edit_topic');

        Route::post('/delete_topic', 'TopicController@delete_topic')->name('delete_topic');


        /***************************************************************************/
        /***************************** Class Routes ******************************/
        /***************************************************************************/

        //        Route::get('/add_class', 'ClassController@add_class')->name('add_class');
        //
        //        Route::post('/submit_class', 'ClassController@submit_class')->name('submit_class');
        //
        //        Route::post('/submit_class_excel', 'ClassController@submit_class_excel')->name('submit_class_excel');
        //
        //        Route::get('/class_list/{array?}/{str?}', 'ClassController@class_list')->name('class_list');
        //
        //        Route::post('/class_list', 'ClassController@class_list')->name('class_list');
        //
        //        Route::post('/edit_class', 'ClassController@edit_class')->name('edit_class');
        //
        //        Route::post('/update_class', 'ClassController@update_class')->name('update_class');
        //
        //        Route::get('/edit_class', 'ClassController@class_list')->name('edit_class');
        //
        //        Route::post('/delete_class', 'ClassController@delete_class')->name('delete_class');


        /***************************************************************************/
        /***************************** Currency Routes ******************************/
        /***************************************************************************/

        Route::get('/add_currency', 'CurrencyController@add_currency')->name('add_currency');

        Route::post('/submit_currency', 'CurrencyController@submit_currency')->name('submit_currency');

        Route::post('/submit_currency_excel', 'CurrencyController@submit_currency_excel')->name('submit_currency_excel');

        Route::get('/currency_list/{array?}/{str?}', 'CurrencyController@currency_list')->name('currency_list');

        Route::post('/currency_list', 'CurrencyController@currency_list')->name('currency_list');

        Route::post('/edit_currency', 'CurrencyController@edit_currency')->name('edit_currency');

        Route::post('/update_currency', 'CurrencyController@update_currency')->name('update_currency');

        Route::get('/edit_currency', 'CurrencyController@currency_list')->name('edit_currency');

        Route::post('/delete_currency', 'CurrencyController@delete_currency')->name('delete_currency');


        /***************************************************************************/
        /***************************** Language Routes ******************************/
        /***************************************************************************/

        Route::get('/add_language', 'LanguageController@add_language')->name('add_language');

        Route::post('/submit_language', 'LanguageController@submit_language')->name('submit_language');

        Route::post('/submit_language_excel', 'LanguageController@submit_language_excel')->name('submit_language_excel');

        Route::get('/language_list/{array?}/{str?}', 'LanguageController@language_list')->name('language_list');

        Route::post('/language_list', 'LanguageController@language_list')->name('language_list');

        Route::post('/edit_language', 'LanguageController@edit_language')->name('edit_language');

        Route::post('/update_language', 'LanguageController@update_language')->name('update_language');

        Route::get('/edit_language', 'LanguageController@language_list')->name('edit_language');

        Route::post('/delete_language', 'LanguageController@delete_language')->name('delete_language');


        /***************************************************************************/
        /***************************** InPrint Routes ******************************/
        /***************************************************************************/

        Route::get('/add_imPrint', 'ImPrintController@add_imPrint')->name('add_imPrint');

        Route::post('/submit_imPrint', 'ImPrintController@submit_imPrint')->name('submit_imPrint');

        Route::post('/submit_imPrint_excel', 'ImPrintController@submit_imPrint_excel')->name('submit_imPrint_excel');

        Route::get('/imPrint_list/{array?}/{str?}', 'ImPrintController@imPrint_list')->name('imPrint_list');

        Route::post('/imPrint_list', 'ImPrintController@imPrint_list')->name('imPrint_list');

        Route::post('/edit_imPrint', 'ImPrintController@edit_imPrint')->name('edit_imPrint');

        Route::post('/update_imPrint', 'ImPrintController@update_imPrint')->name('update_imPrint');

        Route::get('/edit_imPrint', 'ImPrintController@imPrint_list')->name('edit_imPrint');

        Route::post('/delete_imPrint', 'ImPrintController@delete_imPrint')->name('delete_imPrint');

        /***************************************************************************/
        /***************************** Genre Routes ******************************/
        /***************************************************************************/

        Route::get('/add_genre', 'GenreController@add_genre')->name('add_genre');

        Route::post('/submit_genre_excel', 'GenreController@submit_genre_excel')->name('submit_genre_excel');

        Route::get('/genre_list/{array?}/{str?}', 'GenreController@genre_list')->name('genre_list');

        Route::post('/genre_list', 'GenreController@genre_list')->name('genre_list');

        Route::post('/edit_genre', 'GenreController@edit_genre')->name('edit_genre');

        Route::post('/update_genre', 'GenreController@update_genre')->name('update_genre');

        Route::get('/edit_genre', 'GenreController@genre_list')->name('edit_genre');

        Route::post('/delete_genre', 'GenreController@delete_genre')->name('delete_genre');

        /***************************************************************************/
        /***************************** Illustrated Routes ******************************/
        /***************************************************************************/

        Route::get('/add_illustrated', 'IllustratedController@add_illustrated')->name('add_illustrated');

        Route::post('/submit_illustrated', 'IllustratedController@submit_illustrated')->name('submit_illustrated');

        Route::post('/submit_illustrated_excel', 'IllustratedController@submit_illustrated_excel')->name('submit_illustrated_excel');

        Route::get('/illustrated_list/{array?}/{str?}', 'IllustratedController@illustrated_list')->name('illustrated_list');

        Route::post('/illustrated_list', 'IllustratedController@illustrated_list')->name('illustrated_list');

        Route::post('/edit_illustrated', 'IllustratedController@edit_illustrated')->name('edit_illustrated');

        Route::post('/update_illustrated', 'IllustratedController@update_illustrated')->name('update_illustrated');

        Route::get('/edit_illustrated', 'IllustratedController@illustrated_list')->name('edit_illustrated');

        Route::post('/delete_illustrated', 'IllustratedController@delete_illustrated')->name('delete_illustrated');


        /***************************************************************************/
        /***************************** Product Details Routes ******************************/
        /***************************************************************************/

        Route::get('/add_product_details', 'ProductDetailsController@add_product_details')->name('add_product_details');

        Route::post('/submit_product_details', 'ProductDetailsController@submit_product_details')->name('submit_product_details');

        Route::post('/submit_product_details_excel', 'ProductDetailsController@submit_product_details_excel')->name('submit_product_details_excel');

        Route::get('/product_details_list/{array?}/{str?}', 'ProductDetailsController@product_details_list')->name('product_details_list');

        Route::post('/product_details_list', 'ProductDetailsController@product_details_list')->name('product_details_list');

        Route::post('/edit_product_details', 'ProductDetailsController@edit_product_details')->name('edit_product_details');

        Route::post('/update_product_details', 'ProductDetailsController@update_product_details')->name('update_product_details');

        Route::get('/edit_product_details', 'ProductDetailsController@product_details_list')->name('edit_product_details');

        Route::post('/delete_product_details', 'ProductDetailsController@delete_product_details')->name('delete_product_details');


        /***************************************************************************/
        /******************************** Credit Card Machine Settlement Routes ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/credit_card_machine_settlement', 'CreditCardMachineSettlementController@credit_card_machine_settlement')->name('credit_card_machine_settlement');

            Route::post('/submit_credit_card_machine_settlement', 'CreditCardMachineSettlementController@submit_credit_card_machine_settlement')->name('submit_credit_card_machine_settlement');

            Route::get('/credit_card_machine_settlement_list/{array?}/{str?}', 'CreditCardMachineSettlementController@credit_card_machine_settlement_list')->name('credit_card_machine_settlement_list');

            Route::post('/credit_card_machine_settlement_list', 'CreditCardMachineSettlementController@credit_card_machine_settlement_list')->name('credit_card_machine_settlement_list');

            Route::post('/edit_credit_card_machine_settlement', 'CreditCardMachineSettlementController@edit_credit_card_machine_settlement')->name('edit_credit_card_machine_settlement');

            Route::post('/update_credit_card_machine_settlement', 'CreditCardMachineSettlementController@update_credit_card_machine_settlement')->name('update_credit_card_machine_settlement');

            Route::get('/edit_credit_card_machine_settlement', 'CreditCardMachineSettlementController@credit_card_machine_settlement_list')->name('edit_credit_card_machine_settlement');

            Route::post('/delete_credit_card_machine_settlement', 'CreditCardMachineSettlementController@delete_credit_card_machine_settlement')->name('delete_credit_card_machine_settlement');
        });
        /***************************************************************************/
        /******************************** Ajax products in json ******************************/
        /***************************************************************************/
        Route::get('/ajax_get_json_products', 'Controller@ajax_get_json_products')->name('ajax_get_json_products');

        /***************************************************************************/
        /******************************** Ajax products in json trade delivery order sale invoice by nabeel ******************************/
        /***************************************************************************/
        Route::get('/ajax_get_json_trade_delivery_order_sale_invoice', 'Controller@ajax_get_json_trade_delivery_order_sale_invoice')->name('ajax_get_json_trade_delivery_order_sale_invoice');

        /***************************************************************************/
        /******************************** Ajax products in json trade sale order sale invoice by nabeel ******************************/
        /***************************************************************************/
        Route::get('/ajax_get_json_trade_sale_order_sale_invoice', 'Controller@ajax_get_json_trade_sale_order_sale_invoice')->name('ajax_get_json_trade_sale_order_sale_invoice');


        /***************************************************************************/
        /******************************** Ajax products in json trade sale order sale invoice by nabeel ******************************/
        /***************************************************************************/
        Route::get('/ajax_get_json_trade_sale_order_delivery_order_sale_invoice', 'Controller@ajax_get_json_trade_sale_order_delivery_order_sale_invoice')->name('ajax_get_json_trade_sale_order_delivery_order_sale_invoice');


        /***************************************************************************/
        /******************************** Ajax products in temp purchase invoice by burhan ******************************/
        /***************************************************************************/
        Route::get('/ajax_get_json_temp_purchase_invoice', [Controller::class, 'ajax_get_json_temp_purchase_invoice'])->name('ajax_get_json_temp_purchase_invoice');
        /***************************************************************************/
        /******************************** Ajax products in json grn purchase invoice by nabeel ******************************/
        /***************************************************************************/
        Route::get('/ajax_get_json_trade_grn_purchase_invoice', [Controller::class, 'ajax_get_json_trade_grn_purchase_invoice'])->name('ajax_get_json_trade_grn_purchase_invoice');


        /***************************************************************************/
        /***************************** InPrint Routes ******************************/
        /***************************************************************************/

        Route::get('/add_table', 'TableController@add_table')->name('add_table');

        Route::post('/submit_table', 'TableController@submit_table')->name('submit_table');

        Route::get('/table_list/{array?}/{str?}', 'TableController@table_list')->name('table_list');

        Route::post('/table_list', 'TableController@table_list')->name('table_list');

        Route::post('/edit_table', 'TableController@edit_table')->name('edit_table');

        Route::post('/update_table', 'TableController@update_table')->name('update_table');

        Route::post('/delete_table', 'TableController@delete_table')->name('delete_table');


        /***************************************************************************/
        /******************* Delivery Challan Routes **************************/
        /***************************************************************************/
        Route::group(['middleware' => ['premiumPackage', 'dayEnd']], function () {
            Route::get('/delivery_challan', 'DeliveryChallanController@delivery_challan')->name('delivery_challan');

            Route::post('/submit_delivery_challan', 'DeliveryChallanController@submit_delivery_challan')->name('submit_delivery_challan');

            Route::post('/get_sale_items_for_delivery_challan', 'DeliveryChallanController@get_sale_items_for_delivery_challan')->name('get_sale_items_for_delivery_challan');
            Route::get('test_multi_inputs', 'TestingController@test_multi_inputs')->name('test_multi_inputs');


            Route::get('/delivery_challan_list/{array?}/{str?}', 'DeliveryChallanController@delivery_challan_list')->name('delivery_challan_list');

            Route::post('/delivery_challan_list', 'DeliveryChallanController@delivery_challan_list')->name('delivery_challan_list');

            Route::post('/delivery_challan_items_view_details', 'DeliveryChallanController@delivery_challan_items_view_details')->name('delivery_challan_items_view_details');

            Route::get('/delivery_challan_items_view_details/view/{id}', 'DeliveryChallanController@delivery_challan_items_view_details_SH')->name('delivery_challan_items_view_details_SH');

            Route::get('/delivery_challan_items_view_details/pdf/{id}', 'DeliveryChallanController@delivery_challan_items_view_details_pdf_SH')->name('delivery_challan_items_view_details_pdf_SH');


            /***************************************************************************/
            /******************* Trade Delivery Challan Routes **************************/
            /***************************************************************************/

            Route::get('/trade_delivery_challan', 'TradeInvoices\TradeDeliveryChallanController@trade_delivery_challan')->name('trade_delivery_challan');

            Route::post('/submit_trade_delivery_challan', 'TradeInvoices\TradeDeliveryChallanController@submit_trade_delivery_challan')->name('submit_trade_delivery_challan');


            Route::get('/trade_delivery_challan_list/{array?}/{str?}', 'TradeInvoices\TradeDeliveryChallanController@trade_delivery_challan_list')->name('trade_delivery_challan_list');

            Route::post('/trade_delivery_challan_list', 'TradeInvoices\TradeDeliveryChallanController@trade_delivery_challan_list')->name('trade_delivery_challan_list');

            Route::post('/trade_delivery_challan_items_view_details', 'TradeInvoices\TradeDeliveryChallanController@trade_delivery_challan_items_view_details')->name('trade_delivery_challan_items_view_details');

            Route::get('/trade_delivery_challan_items_view_details/view/{id}', 'TradeInvoices\TradeDeliveryChallanController@trade_delivery_challan_items_view_details_SH')->name('trade_delivery_challan_items_view_details_SH');

            Route::get('/trade_delivery_challan_items_view_details/pdf/{id}', 'TradeInvoices\TradeDeliveryChallanController@trade_delivery_challan_items_view_details_pdf_SH')->name('trade_delivery_challan_items_view_details_pdf_SH');


            /***************************************************************************/
            /***************** Delivery Order Sale Invoice Routes ******************************/
            /***************************************************************************/

            Route::get('/delivery_order_sale_invoice', 'DeliveryOrderSaleInvoice@delivery_order_sale_invoice')->name('delivery_order_sale_invoice');

            Route::post('/submit_delivery_order_sale_invoice', 'DeliveryOrderSaleInvoice@submit_delivery_order_sale_invoice')->name('submit_delivery_order_sale_invoice');


            /***************************************************************************/
            /***************** Trade Delivery Order Sale Invoice Routes ******************************/
            /***************************************************************************/

            Route::get('/trade_delivery_order_sale_invoice', 'TradeInvoices\TradeDeliverOrderSaleInvoiceController@trade_delivery_order_sale_invoice')->name('trade_delivery_order_sale_invoice');

            Route::post('/submit_trade_delivery_order_sale_invoice', 'TradeInvoices\TradeDeliverOrderSaleInvoiceController@submit_trade_delivery_order_sale_invoice')->name('submit_trade_delivery_order_sale_invoice');


            /***************************************************************************/
            /***************** Trade Sale Order To Delivery Order Invoice Routes ******************************/
            /***************************************************************************/

            Route::get('/trade_so_to_do_invoice', 'TradeInvoices\TradeSaleOrderToDeliveryOrderController@trade_so_to_do_invoice')->name('trade_so_to_do_invoice');

            Route::post('/submit_trade_so_to_do_invoice', 'TradeInvoices\TradeSaleOrderToDeliveryOrderController@submit_trade_so_to_do_invoice')->name('submit_trade_so_to_do_invoice');


            /***************************************************************************/
            /***************** Trade Delivery Order Sale Tax Invoice Routes ******************************/
            /***************************************************************************/

            Route::get('/trade_delivery_order_sale_tax_invoice', 'TradeInvoices\TradeDeliveryOrderSaleTaxInvoiceController@trade_delivery_order_sale_tax_invoice')->name('trade_delivery_order_sale_tax_invoice');

            Route::post('/submit_trade_delivery_order_sale_tax_invoice', 'TradeInvoices\TradeDeliveryOrderSaleTaxInvoiceController@submit_trade_delivery_order_sale_tax_invoice')->name('submit_trade_delivery_order_sale_tax_invoice');


            /***************************************************************************/
            /******************* Trade Delivery Order Routes **************************/
            /***************************************************************************/

            Route::get('/trade_delivery_order', 'TradeInvoices\TradeDeliverOrderController@trade_delivery_order')->name('trade_delivery_order');

            Route::post('/submit_trade_delivery_order', 'TradeInvoices\TradeDeliverOrderController@submit_trade_delivery_order')->name('submit_trade_delivery_order');


            Route::get('/trade_delivery_order_invoice_list/{array?}/{str?}', 'TradeInvoices\TradeDeliverOrderController@trade_delivery_order_invoice_list')->name('trade_delivery_order_invoice_list');

            Route::post('/trade_delivery_order_invoice_list', 'TradeInvoices\TradeDeliverOrderController@trade_delivery_order_invoice_list')->name('trade_delivery_order_invoice_list');

            Route::post('/trade_delivery_order_items_view_details', 'TradeInvoices\TradeDeliverOrderController@trade_delivery_order_items_view_details')->name('trade_delivery_order_items_view_details');

            Route::get('/trade_delivery_order_items_view_details/view/{id}', 'TradeInvoices\TradeDeliverOrderController@trade_delivery_order_items_view_details_SH')->name('trade_delivery_order_items_view_details_SH');

            Route::get('/trade_delivery_order_items_view_details/pdf/{id}', 'TradeInvoices\TradeDeliverOrderController@trade_delivery_order_items_view_details_pdf_SH')->name('trade_delivery_order_items_view_details_pdf_SH');

            /***************************************************************************/
            /******************* Delivery Order Routes **************************/
            /***************************************************************************/

            Route::get('/delivery_order', 'DeliveryOrderController@delivery_order')->name('delivery_order');

            Route::post('/submit_delivery_order', 'DeliveryOrderController@submit_delivery_order')->name('submit_delivery_order');

            Route::get('/get_delivery_order_items_for_sale', 'DeliveryOrderController@get_delivery_order_items_for_sale')->name('get_delivery_order_items_for_sale');

            Route::get('/get_sale_order_delivery_order_items_for_sale', 'DeliveryOrderController@get_sale_order_delivery_order_items_for_sale')->name('get_sale_order_delivery_order_items_for_sale');


            Route::get('/delivery_order_invoice_list/{array?}/{str?}', 'DeliveryOrderController@delivery_order_invoice_list')->name('delivery_order_invoice_list');

            Route::post('/delivery_order_invoice_list', 'DeliveryOrderController@delivery_order_invoice_list')->name('delivery_order_invoice_list');

            Route::post('/delivery_order_items_view_details', 'DeliveryOrderController@delivery_order_items_view_details')->name('delivery_order_items_view_details');

            Route::get('/delivery_order_items_view_details/view/{id}', 'DeliveryOrderController@delivery_order_items_view_details_SH')->name('delivery_order_items_view_details_SH');

            Route::get('/delivery_order_items_view_details/pdf/{id}', 'DeliveryOrderController@delivery_order_items_view_details_pdf_SH')->name('delivery_order_items_view_details_pdf_SH');
        });
        /***************************************************************************/
        /******************* Today Report Routes **************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/today_report_list/{array?}/{str?}', 'TodayReportController@today_report_list')->name('today_report_list');

            Route::post('/today_report_list', 'TodayReportController@today_report_list')->name('today_report_list');
        });

        /***************************************************************************/
        /******************* Stock Taking Routes **************************/
        /***************************************************************************/

        Route::get('/stock_taking_industrial/{array?}/{str?}', 'StockTakingController@stock_taking_industrial')->name('stock_taking_industrial');

        Route::post('/stock_taking_industrial', 'StockTakingController@stock_taking_industrial')->name('stock_taking_industrial');
        Route::post('/submit_stock_taking_industrial', 'StockTakingController@submit_stock_taking_industrial')->name('submit_stock_taking_industrial');

        Route::post('/submit_stock_taking', 'StockTakingController@submit_stock_taking')->name('submit_stock_taking');


        Route::get('/stock_taking_list/{array?}/{str?}', 'StockTakingController@stock_taking_list')->name('stock_taking_list');

        Route::post('/stock_taking_list', 'StockTakingController@stock_taking_list')->name('stock_taking_list');

        Route::get('/stock_taking', 'StockTakingController@stock_taking')->name('stock_taking');


        /***************************************************************************/
        /******************* Stock Adjustment Routes **************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/stock_adjustment/{array?}/{str?}', 'StockAdjustmentController@stock_adjustment')->name('stock_adjustment');

            Route::post('/stock_adjustment', 'StockAdjustmentController@stock_adjustment')->name('stock_adjustment');

            Route::post('/submit_stock_adjustment', 'StockAdjustmentController@submit_stock_adjustment')->name('submit_stock_adjustment');
        });

        /***************************************************************************/
        /******************* Trade Goods Receipt Note (GRN) Routes **************************/
        /***************************************************************************/
        Route::group(['middleware' => ['premiumPackage', 'dayEnd']], function () {
            Route::get('/trade_goods_receipt_note', 'TradeInvoices\TradeGoodsReceiptNoteController@trade_goods_receipt_note')->name('trade_goods_receipt_note');

            Route::post('/submit_trade_goods_receipt_note', 'TradeInvoices\TradeGoodsReceiptNoteController@submit_trade_goods_receipt_note')->name('submit_trade_goods_receipt_note');


            Route::get('/trade_goods_receipt_note_list/{array?}/{str?}', 'TradeInvoices\TradeGoodsReceiptNoteController@trade_goods_receipt_note_list')->name('trade_goods_receipt_note_list');

            Route::post('/trade_goods_receipt_note_list', 'TradeInvoices\TradeGoodsReceiptNoteController@trade_goods_receipt_note_list')->name('trade_goods_receipt_note_list');

            Route::post('/trade_goods_receipt_note_items_view_details', 'TradeInvoices\TradeGoodsReceiptNoteController@trade_goods_receipt_note_items_view_details')->name('trade_goods_receipt_note_items_view_details');

            Route::get('/trade_goods_receipt_note_items_view_details/view/{id}', 'TradeInvoices\TradeGoodsReceiptNoteController@trade_goods_receipt_note_items_view_details_SH')->name('trade_goods_receipt_note_items_view_details_SH');

            Route::get('/trade_goods_receipt_note_items_view_details/pdf/{id}', 'TradeInvoices\TradeGoodsReceiptNoteController@trade_goods_receipt_note_items_view_details_pdf_SH')->name('trade_goods_receipt_note_items_view_details_pdf_SH');

            /***************************************************************************/
            /******************* Trade Goods Receipt Note (GRNR) Routes **************************/
            /***************************************************************************/

            Route::get('/trade_goods_receipt_note_return', 'TradeInvoices\TradeGoodsReceiptNoteReturnController@trade_goods_receipt_note_return')->name('trade_goods_receipt_note_return');

            Route::post('/submit_trade_goods_receipt_note_return', 'TradeInvoices\TradeGoodsReceiptNoteReturnController@submit_trade_goods_receipt_note_return')->name('submit_trade_goods_receipt_note_return');


            Route::get('/trade_goods_receipt_note_return_list/{array?}/{str?}', 'TradeInvoices\TradeGoodsReceiptNoteReturnController@trade_goods_receipt_note_return_list')->name('trade_goods_receipt_note_return_list');

            Route::post('/trade_goods_receipt_note_return_list', 'TradeInvoices\TradeGoodsReceiptNoteReturnController@trade_goods_receipt_note_return_list')->name('trade_goods_receipt_note_return_list');

            Route::post('/trade_goods_receipt_note_return_items_view_details', 'TradeInvoices\TradeGoodsReceiptNoteReturnController@trade_goods_receipt_note_return_items_view_details')->name('trade_goods_receipt_note_return_items_view_details');

            Route::get('/trade_goods_receipt_note_return_items_view_details/view/{id}', 'TradeInvoices\TradeGoodsReceiptNoteReturnController@trade_goods_receipt_note_return_items_view_details_SH')
                ->name('trade_goods_receipt_note_return_items_view_details_SH');

            Route::get('/trade_goods_receipt_note_return_items_view_details/pdf/{id}', 'TradeInvoices\TradeGoodsReceiptNoteReturnController@trade_goods_receipt_note_return_items_view_details_pdf_SH')
                ->name('trade_goods_receipt_note_return_items_view_details_pdf_SH');


            /***************************************************************************/
            /******************* Goods Receipt Note (GRN) Routes **************************/
            /***************************************************************************/

            Route::get('/goods_receipt_note', 'GoodsReceiptNoteController@goods_receipt_note')->name('goods_receipt_note');

            Route::post('/submit_goods_receipt_note', 'GoodsReceiptNoteController@submit_goods_receipt_note')->name('submit_goods_receipt_note');


            Route::get('/get_goods_receipt_note_items_for_purchase', 'GoodsReceiptNoteController@get_goods_receipt_note_items_for_purchase')->name('get_goods_receipt_note_items_for_purchase');

            Route::get('/get_goods_receipt_note_items_for_return', 'GoodsReceiptNoteController@get_goods_receipt_note_items_for_return')->name('get_goods_receipt_note_items_for_return');


            Route::get('/goods_receipt_note_list/{array?}/{str?}', 'GoodsReceiptNoteController@goods_receipt_note_list')->name('goods_receipt_note_list');

            Route::post('/goods_receipt_note_list', 'GoodsReceiptNoteController@goods_receipt_note_list')->name('goods_receipt_note_list');

            Route::post('/goods_receipt_note_items_view_details', 'GoodsReceiptNoteController@goods_receipt_note_items_view_details')->name('goods_receipt_note_items_view_details');

            Route::get('/goods_receipt_note_items_view_details/view/{id}', 'GoodsReceiptNoteController@goods_receipt_note_items_view_details_SH')->name('goods_receipt_note_items_view_details_SH');

            Route::get('/goods_receipt_note_items_view_details/pdf/{id}', 'GoodsReceiptNoteController@goods_receipt_note_items_view_details_pdf_SH')->name('goods_receipt_note_items_view_details_pdf_SH');


            /***************************************************************************/
            /******************* Goods Receipt Note Purchase (GRN) Routes **************************/
            /***************************************************************************/

            Route::get('/grn_purchase_invoice', 'GoodsReceiptNotePurchaseController@grn_purchase_invoice')->name('grn_purchase_invoice');

            Route::post('/submit_grn_purchase_invoice', 'GoodsReceiptNotePurchaseController@submit_grn_purchase_invoice')->name('submit_grn_purchase_invoice');

            /***************************************************************************/
            /******************* Trade Goods Receipt Note Purchase (GRN) Routes **************************/
            /***************************************************************************/

            Route::get('/trade_grn_purchase_invoice', 'TradeInvoices\TradeGoodsReceiptNotePurchaseInvoiceController@trade_grn_purchase_invoice')->name('trade_grn_purchase_invoice');

            Route::post('/submit_trade_grn_purchase_invoice', 'TradeInvoices\TradeGoodsReceiptNotePurchaseInvoiceController@submit_trade_grn_purchase_invoice')->name('submit_trade_grn_purchase_invoice');

            /***************************************************************************/
            /******************* Trade Goods Receipt Note Purchase Tax (GRN) Routes **************************/
            /***************************************************************************/

            Route::get('/trade_grn_purchase_tax_invoice', 'TradeInvoices\TradeGoodsReceiptNotePurchaseTaxInvoiceController@trade_grn_purchase_tax_invoice')->name('trade_grn_purchase_tax_invoice');

            Route::post('/submit_trade_grn_purchase_tax_invoice', 'TradeInvoices\TradeGoodsReceiptNotePurchaseTaxInvoiceController@submit_trade_grn_purchase_tax_invoice')->name('submit_trade_grn_purchase_tax_invoice');
        });


        /***************************************************************************/
        /***************************** New Trade Sale Invoice Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/trade_sale_invoice', 'TradeInvoices\TradeSaleInvoiceController@sale_invoice')->name('trade_sale_invoice');
            Route::post('/submit_trade_sale_invoice', 'TradeInvoices\TradeSaleInvoiceController@submit_trade_sale_invoice')->name('submit_trade_sale_invoice');

            Route::get('/trade_sale_invoice_list/{array?}/{str?}', 'TradeInvoices\TradeSaleInvoiceController@trade_sale_invoice_list')->name('trade_sale_invoice_list');

            Route::post('/trade_sale_invoice_list', 'TradeInvoices\TradeSaleInvoiceController@trade_sale_invoice_list')->name('trade_sale_invoice_list');

            Route::post('/trade_sale_items_view_details', 'TradeInvoices\TradeSaleInvoiceController@trade_sale_items_view_details')->name('trade_sale_items_view_details');

            Route::get('/trade_sale_items_view_details/view/{id}', 'TradeInvoices\TradeSaleInvoiceController@trade_sale_items_view_details_SH')->name('trade_sale_items_view_details_sh');

            Route::get('/trade_sale_items_view_details/view/pdf/{id}/{array?}/{str?}', 'TradeInvoices\TradeSaleInvoiceController@trade_sale_items_view_details_pdf_SH')->name('trade_sale_items_view_details_pdf_sh');

            Route::post('/trade_get_credit_limit', 'TradeInvoices\TradeSaleInvoiceController@trade_get_credit_limit')->name('trade_get_credit_limit');
        });

        /***************************************************************************/
        /***************************** Trade Sale TAx Invoice Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/trade_sale_tax_invoice', 'TradeInvoices\TradeSaleTaxInvoiceController@sale_tax_invoice')->name('trade_sale_tax_invoice');

            Route::post('/submit_trade_sale_tax_invoice', 'TradeInvoices\TradeSaleTaxInvoiceController@submit_trade_sale_tax_invoice')->name('submit_trade_sale_tax_invoice');

            Route::get('/trade_sale_tax_sale_invoice_list', 'TradeInvoices\TradeSaleTaxInvoiceController@trade_sale_tax_sale_invoice_list')->name('trade_sale_tax_sale_invoice_list');

            Route::post('/trade_sale_tax_sale_invoice_list', 'TradeInvoices\TradeSaleTaxInvoiceController@trade_sale_tax_sale_invoice_list')->name('trade_sale_tax_sale_invoice_list');

            Route::get('/trade_sale_tax_sale_invoice_list/view/{id}', 'TradeInvoices\TradeSaleTaxInvoiceController@trade_sale_sale_tax_items_view_details_SH')->name('trade_sale_sale_tax_items_view_details_SH');

            Route::get('/trade_sale_tax_sale_invoice_list/view/pdf/{id}/{array?}/{str?}', 'TradeInvoices\TradeSaleTaxInvoiceController@trade_sale_sale_tax_items_view_details_pdf_SH')->name('trade_sale_sale_tax_items_view_details_pdf_SH');
        });


        /***************************************************************************/
        /***************************** New Simple Sale Invoice Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/simple_sale_invoice', 'SimpleInvoices\SimpleSaleInvoiceController@sale_invoice')->name('simple_sale_invoice');
            Route::post('/submit_simple_sale_invoice', 'SimpleInvoices\SimpleSaleInvoiceController@submit_simple_sale_invoice')->name('submit_simple_sale_invoice');

            Route::get('/simple_sale_invoice_list/{array?}/{str?}', 'SimpleInvoices\SimpleSaleInvoiceController@simple_sale_invoice_list')->name('simple_sale_invoice_list');

            Route::post('/simple_sale_invoice_list', 'SimpleInvoices\SimpleSaleInvoiceController@simple_sale_invoice_list')->name('simple_sale_invoice_list');

            Route::post('/simple_sale_items_view_details', 'SimpleInvoices\SimpleSaleInvoiceController@simple_sale_items_view_details')->name('simple_sale_items_view_details');

            Route::get('/simple_sale_items_view_details/view/{id}', 'SimpleInvoices\SimpleSaleInvoiceController@simple_sale_items_view_details_SH')->name('simple_sale_items_view_details_sh');

            Route::get('/simple_sale_items_view_details/view/pdf/{id}/{array?}/{str?}', 'SimpleInvoices\SimpleSaleInvoiceController@simple_sale_items_view_details_pdf_SH')->name('simple_sale_items_view_details_pdf_sh');

            Route::post('/simple_get_credit_limit', 'SimpleInvoices\SimpleSaleInvoiceController@simple_get_credit_limit')->name('simple_get_credit_limit');
        });

        /***************************************************************************/
        /***************************** Simple Sale TAx Invoice Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/sale_tax_invoice', 'SimpleInvoices\SimpleSaleTaxInvoiceController@sale_tax_invoice')->name('simple_sale_tax_invoice');

            Route::post('/submit_simple_sale_tax_invoice', 'SimpleInvoices\SimpleSaleTaxInvoiceController@submit_simple_sale_tax_invoice')->name('submit_simple_sale_tax_invoice');

            Route::get('/simple_sale_tax_sale_invoice_list', 'SimpleInvoices\SimpleSaleTaxInvoiceController@simple_sale_tax_sale_invoice_list')->name('simple_sale_tax_sale_invoice_list');

            Route::post('/simple_sale_tax_sale_invoice_list', 'SimpleInvoices\SimpleSaleTaxInvoiceController@simple_sale_tax_sale_invoice_list')->name('simple_sale_tax_sale_invoice_list');

            Route::get('/simple_sale_tax_sale_invoice_list/view/{id}', 'SimpleInvoices\SimpleSaleTaxInvoiceController@simple_sale_sale_tax_items_view_details_SH')->name('simple_sale_sale_tax_items_view_details_SH');

            Route::get('/simple_sale_tax_sale_invoice_list/view/pdf/{id}/{array?}/{str?}', 'SimpleInvoices\SimpleSaleTaxInvoiceController@simple_sale_sale_tax_items_view_details_pdf_SH')->name('simple_sale_sale_tax_items_view_details_pdf_SH');
        });


        /***************************************************************************/
        /***************************** Loan Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/add_loan', 'LoanController@add_loan')->name('add_loan');
            Route::get('/get_loan_account', 'LoanController@get_loan_account')->name('get_loan_account');
            Route::post('/get_loan_account', 'LoanController@get_loan_account')->name('get_loan_account');
            Route::post('/submit_loan', 'LoanController@submit_loan')->name('submit_loan');

            Route::post('/update_loan', 'LoanController@update_loan')->name('update_loan');

            Route::get('/loan_list/{array?}/{str?}', 'LoanController@loan_list')->name('loan_list');
            Route::post('/loan_list', 'LoanController@loan_list')->name('loan_list');

            Route::get('/loan_pending_list/{array?}/{str?}', 'LoanController@loan_pending_list')->name('loan_pending_list');

            Route::get('/edit_loan/{loan}', 'LoanController@edit_loan')->name('edit_loan');
            Route::get('/loan_approved/{loan}', 'LoanController@loan_approved')->name('loan_approved');
            Route::get('/loan_reject/{loan}', 'LoanController@loan_reject')->name('loan_reject');

            Route::post('/loan_pending_list', 'LoanController@loan_pending_list')->name('loan_pending_list');

            Route::post('/get_salary_generate_account', 'LoanController@get_salary_generate_account')->name('get_salary_generate_account');
        });

        /***************************************************************************/
        /***************************** Trade Purchase Invoice Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/trade_purchase_invoice', 'TradeInvoices\TradePurchaseInvoiceController@trade_purchase_invoice')->name('trade_purchase_invoice');

            Route::post('/submit_trade_purchase_invoice', 'TradeInvoices\TradePurchaseInvoiceController@submit_trade_purchase_invoice')->name('submit_trade_purchase_invoice');


            Route::get('/trade_purchase_invoice_list/{array?}/{str?}', 'TradeInvoices\TradePurchaseInvoiceController@trade_purchase_invoice_list')->name('trade_purchase_invoice_list');

            Route::post('/trade_purchase_invoice_list', 'TradeInvoices\TradePurchaseInvoiceController@trade_purchase_invoice_list')->name('trade_purchase_invoice_list');

            Route::post('/trade_purchase_items_view_details', 'TradeInvoices\TradePurchaseInvoiceController@trade_purchase_items_view_details')->name('trade_purchase_items_view_details');

            Route::get('/trade_purchase_items_view_details/view/{id}', 'TradeInvoices\TradePurchaseInvoiceController@trade_purchase_items_view_details_SH')->name('trade_purchase_items_view_details_sh');

            Route::get('/trade_purchase_items_view_details/view/pdf/{id}/{array?}/{str?}', 'TradeInvoices\TradePurchaseInvoiceController@trade_purchase_items_view_details_pdf_SH')->name('trade_purchase_items_view_details_pdf_sh');
        });
        /***************************************************************************/
        /***************************** Trade Purchase Sale Tax Invoice Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/trade_purchase_tax_invoice', 'TradeInvoices\TradePurchaseTaxInvoiceController@trade_purchase_tax_invoice')->name('trade_purchase_tax_invoice');

            Route::post('/submit_trade_purchase_tax_invoice', 'TradeInvoices\TradePurchaseTaxInvoiceController@submit_trade_purchase_tax_invoice')->name('submit_trade_purchase_tax_invoice');


            Route::get('/trade_sale_tax_purchase_invoice_list', 'TradeInvoices\TradePurchaseTaxInvoiceController@trade_sale_tax_purchase_invoice_list')->name('trade_sale_tax_purchase_invoice_list');

            Route::post('/trade_sale_tax_purchase_invoice_list', 'TradeInvoices\TradePurchaseTaxInvoiceController@trade_sale_tax_purchase_invoice_list')->name('trade_sale_tax_purchase_invoice_list');


            Route::get('/trade_purchase_items_sale_tax_view_details/view/{id}', 'TradeInvoices\TradePurchaseTaxInvoiceController@trade_sale_tax_purchase_items_view_details_SH')->name('trade_sale_tax_purchase_items_view_details_SH');

            Route::get('/trade_purchase_items_sale_tax_view_details/view/pdf/{id}/{array?}/{str?}', 'TradeInvoices\TradePurchaseTaxInvoiceController@trade_sale_tax_purchase_items_view_details_pdf_SH')->name('trade_sale_tax_purchase_items_view_details_pdf_SH');
        });
        /***************************************************************************/
        /***************************** Trade Purchase Return Invoice Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/trade_purchase_return_invoice', 'TradeInvoices\TradePurchaseReturnInvoiceController@trade_purchase_return_invoice')->name('trade_purchase_return_invoice');

            Route::post('/submit_trade_purchase_return_invoice', 'TradeInvoices\TradePurchaseReturnInvoiceController@submit_trade_purchase_return_invoice')->name('submit_trade_purchase_return_invoice');


            Route::get('/trade_purchase_return_invoice_list/{array?}/{str?}', 'TradeInvoices\TradePurchaseReturnInvoiceController@trade_purchase_return_invoice_list')->name('trade_purchase_return_invoice_list');

            Route::get('/trade_purchase_return_items_invoice_list/view/{id}', 'TradeInvoices\TradePurchaseReturnInvoiceController@trade_purchase_return_items_view_details_SH')->name('trade_purchase_return_items_view_details_SH');

            Route::get('/trade_purchase_return_items_invoice_list/view/pdf/{id}/{array?}/{str?}', 'TradeInvoices\TradePurchaseReturnInvoiceController@trade_purchase_return_items_view_details_pdf_SH')->name('trade_purchase_return_items_view_details_pdf_SH');

            Route::post('/trade_purchase_return_invoice_list', 'TradeInvoices\TradePurchaseReturnInvoiceController@trade_purchase_return_invoice_list')->name('trade_purchase_return_invoice_list');

            Route::post('/trade_get_purchased_items_for_return', 'TradeInvoices\TradePurchaseReturnInvoiceController@get_purchased_items_for_return')->name('get_purchased_items_for_return');
        });
        /***************************************************************************/
        /***************************** Trade Purchase Sale Tax Return Invoice Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/trade_purchase_tax_return_invoice', 'TradeInvoices\TradePurchaseTaxReturnInvoiceController@trade_purchase_tax_return_invoice')->name('trade_purchase_tax_return_invoice');

            Route::post('/submit_trade_purchase_tax_return_invoice', 'TradeInvoices\TradePurchaseTaxReturnInvoiceController@submit_trade_purchase_tax_return_invoice')->name('submit_trade_purchase_tax_return_invoice');


            Route::get('/trade_sale_tax_purchase_return_invoice_list', 'TradeInvoices\TradePurchaseTaxReturnInvoiceController@trade_sale_tax_purchase_return_invoice_list')->name('trade_sale_tax_purchase_return_invoice_list');

            Route::post('/trade_sale_tax_purchase_return_invoice_list', 'TradeInvoices\TradePurchaseTaxReturnInvoiceController@trade_sale_tax_purchase_return_invoice_list')->name('trade_sale_tax_purchase_return_invoice_list');

            Route::get('/trade_return_purchase_items_sale_tax_view_details/view/{id}', 'TradeInvoices\TradePurchaseTaxReturnInvoiceController@trade_return_sale_tax_purchase_items_view_details_SH')->name('trade_return_sale_tax_purchase_items_view_details_SH');

            Route::get('/trade_return_purchase_items_sale_tax_view_details/view/pdf/{id}/{array?}/{str?}', 'TradeInvoices\TradePurchaseTaxReturnInvoiceController@trade_return_sale_tax_purchase_items_view_details_pdf_SH')->name('trade_return_sale_tax_purchase_items_view_details_pdf_SH');
        });


        /***************************************************************************/
        /***************************** Simple Purchase Invoice Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/simple_purchase_invoice', 'SimpleInvoices\SimplePurchaseInvoiceController@simple_purchase_invoice')->name('simple_purchase_invoice');

            Route::post('/submit_simple_purchase_invoice', 'SimpleInvoices\SimplePurchaseInvoiceController@submit_simple_purchase_invoice')->name('submit_simple_purchase_invoice');


            Route::get('/simple_purchase_invoice_list/{array?}/{str?}', 'SimpleInvoices\SimplePurchaseInvoiceController@simple_purchase_invoice_list')->name('simple_purchase_invoice_list');

            Route::post('/simple_purchase_invoice_list', 'SimpleInvoices\SimplePurchaseInvoiceController@simple_purchase_invoice_list')->name('simple_purchase_invoice_list');

            Route::post('/simple_purchase_items_view_details', 'SimpleInvoices\SimplePurchaseInvoiceController@simple_purchase_items_view_details')->name('simple_purchase_items_view_details');

            Route::get('/simple_purchase_items_view_details/view/{id}', 'SimpleInvoices\SimplePurchaseInvoiceController@simple_purchase_items_view_details_SH')->name('simple_purchase_items_view_details_sh');

            Route::get('/simple_purchase_items_view_details/view/pdf/{id}/{array?}/{str?}', 'SimpleInvoices\SimplePurchaseInvoiceController@simple_purchase_items_view_details_pdf_SH')->name('simple_purchase_items_view_details_pdf_sh');
        });
        /***************************************************************************/
        /***************************** Simple Purchase Sale Tax Invoice Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/purchase_tax_invoice', 'SimpleInvoices\SimplePurchaseTaxInvoiceController@simple_purchase_tax_invoice')->name('simple_purchase_tax_invoice');

            Route::post('/submit_simple_purchase_tax_invoice', 'SimpleInvoices\SimplePurchaseTaxInvoiceController@submit_simple_purchase_tax_invoice')->name('submit_simple_purchase_tax_invoice');


            Route::get('/simple_sale_tax_purchase_invoice_list', 'SimpleInvoices\SimplePurchaseTaxInvoiceController@simple_sale_tax_purchase_invoice_list')->name('simple_sale_tax_purchase_invoice_list');

            Route::post('/simple_sale_tax_purchase_invoice_list', 'SimpleInvoices\SimplePurchaseTaxInvoiceController@simple_sale_tax_purchase_invoice_list')->name('simple_sale_tax_purchase_invoice_list');


            Route::get('/simple_purchase_items_sale_tax_view_details/view/{id}', 'SimpleInvoices\SimplePurchaseTaxInvoiceController@simple_sale_tax_purchase_items_view_details_SH')->name('simple_sale_tax_purchase_items_view_details_SH');

            Route::get('/simple_purchase_items_sale_tax_view_details/view/pdf/{id}/{array?}/{str?}', 'SimpleInvoices\SimplePurchaseTaxInvoiceController@simple_sale_tax_purchase_items_view_details_pdf_SH')->name('simple_sale_tax_purchase_items_view_details_pdf_SH');
        });
        /***************************************************************************/
        /***************************** Simple Purchase Return Invoice Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage', 'dayEnd']], function () {
            Route::get('/simple_purchase_return_invoice', 'SimpleInvoices\SimplePurchaseReturnInvoiceController@simple_purchase_return_invoice')->name('simple_purchase_return_invoice');

            Route::post('/submit_simple_purchase_return_invoice', 'SimpleInvoices\SimplePurchaseReturnInvoiceController@submit_simple_purchase_return_invoice')->name('submit_simple_purchase_return_invoice');


            Route::get('/simple_purchase_return_invoice_list/{array?}/{str?}', 'SimpleInvoices\SimplePurchaseReturnInvoiceController@simple_purchase_return_invoice_list')->name('simple_purchase_return_invoice_list');

            Route::get('/simple_purchase_return_items_invoice_list/view/{id}', 'SimpleInvoices\SimplePurchaseReturnInvoiceController@simple_purchase_return_items_view_details_SH')->name('simple_purchase_return_items_view_details_SH');

            Route::get('/simple_purchase_return_items_invoice_list/view/pdf/{id}/{array?}/{str?}', 'SimpleInvoices\SimplePurchaseReturnInvoiceController@simple_purchase_return_items_view_details_pdf_SH')->name('simple_purchase_return_items_view_details_pdf_SH');

            Route::post('/simple_purchase_return_invoice_list', 'SimpleInvoices\SimplePurchaseReturnInvoiceController@simple_purchase_return_invoice_list')->name('simple_purchase_return_invoice_list');

            Route::post('/simple_get_purchased_items_for_return', 'SimpleInvoices\SimplePurchaseReturnInvoiceController@get_purchased_items_for_return')->name('get_purchased_items_for_return');
        });
        /***************************************************************************/
        /***************************** Simple Purchase Sale Tax Return Invoice Routes *********************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {
            Route::get('/purchase_tax_return_invoice', 'SimpleInvoices\SimplePurchaseTaxReturnInvoiceController@simple_purchase_tax_return_invoice')->name('simple_purchase_tax_return_invoice');

            Route::post('/submit_simple_purchase_tax_return_invoice', 'SimpleInvoices\SimplePurchaseTaxReturnInvoiceController@submit_simple_purchase_tax_return_invoice')->name('submit_simple_purchase_tax_return_invoice');


            Route::get('/simple_sale_tax_purchase_return_invoice_list', 'SimpleInvoices\SimplePurchaseTaxReturnInvoiceController@simple_sale_tax_purchase_return_invoice_list')->name('simple_sale_tax_purchase_return_invoice_list');

            Route::post('/simple_sale_tax_purchase_return_invoice_list', 'SimpleInvoices\SimplePurchaseTaxReturnInvoiceController@simple_sale_tax_purchase_return_invoice_list')->name('simple_sale_tax_purchase_return_invoice_list');

            Route::get('/simple_return_purchase_items_sale_tax_view_details/view/{id}', 'SimpleInvoices\SimplePurchaseTaxReturnInvoiceController@simple_return_sale_tax_purchase_items_view_details_SH')->name('simple_return_sale_tax_purchase_items_view_details_SH');

            Route::get('/simple_return_purchase_items_sale_tax_view_details/view/pdf/{id}/{array?}/{str?}', 'SimpleInvoices\SimplePurchaseTaxReturnInvoiceController@simple_return_sale_tax_purchase_items_view_details_pdf_SH')->name('simple_return_sale_tax_purchase_items_view_details_pdf_SH');
        });


        /***************************************************************************/
        /***************************** Extra Report Routes *************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/employee_ledger_balance_list/{array?}/{str?}', 'ReportController@employee_ledger_balance_list')->name('employee_ledger_balance_list');

            Route::post('/employee_ledger_balance_list', 'ReportController@employee_ledger_balance_list')->name('employee_ledger_balance_list');

            Route::get('/project_wise_expense_report', 'ReportController@project_wise_expense_report')->name('project_wise_expense_report');

            Route::post('/project_wise_expense_report', 'ReportController@project_wise_expense_report')->name('project_wise_expense_report');

            Route::get('/sale_report/{array?}/{str?}', 'ReportController@sale_report')->name('sale_report');

            Route::post('/sale_report', 'SaleInvoiceController@sale_report')->name('sale_report');
        });

        /***************************************************************************/
        /***************** Trade Sale Order Sale Invoice Routes ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['premiumPackage', 'dayEnd']], function () {
            Route::get('/trade_sale_order_sale_invoice', 'TradeInvoices\TradeSaleOrderSaleInvoiceController@trade_sale_order_sale_invoice')->name('trade_sale_order_sale_invoice');

            Route::post('/submit_trade_sale_order_sale_invoice', 'TradeInvoices\TradeSaleOrderSaleInvoiceController@submit_trade_sale_order_sale_invoice')->name('submit_trade_sale_order_sale_invoice');


            /***************************************************************************/
            /***************** Trade Sale Order Delivery Order Sale Invoice Routes ******************************/
            /***************************************************************************/

            Route::get('/trade_sale_order_delivery_order_sale_invoice', 'TradeInvoices\TradeSaleOrderSaleInvoiceController@trade_sale_order_delivery_order_sale_invoice')->name('trade_sale_order_delivery_order_sale_invoice');


            /***************************************************************************/
            /***************** Trade Sale Order Delivery Order Sale Tax Invoice Routes ******************************/
            /***************************************************************************/

            Route::get('/trade_sale_order_delivery_order_sale_tax_invoice', 'TradeInvoices\TradeSaleOrderSaleTaxInvoiceController@trade_sale_order_delivery_order_sale_tax_invoice')->name('trade_sale_order_delivery_order_sale_tax_invoice');


            /***************************************************************************/
            /***************** Trade Sale Order Sale Tax Invoice Routes ******************************/
            /***************************************************************************/

            Route::get('/trade_sale_order_sale_tax_invoice', 'TradeInvoices\TradeSaleOrderSaleTaxInvoiceController@trade_sale_order_sale_tax_invoice')->name('trade_sale_order_sale_tax_invoice');

            Route::post('/submit_trade_sale_order_sale_tax_invoice', 'TradeInvoices\TradeSaleOrderSaleTaxInvoiceController@submit_trade_sale_order_sale_tax_invoice')->name('submit_trade_sale_order_sale_tax_invoice');
        });
        /***************************************************************************/
        /******************************** City Routes ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['basicPackage']], function () {
            Route::get('/add_city', 'CityController@add_city')->name('add_city');

            Route::post('/submit_city', 'CityController@submit_city')->name('submit_city');

            Route::post('/submit_city_excel', 'CityController@submit_city_excel')->name('submit_city_excel');

            Route::post('/get_city', 'SectorController@get_city')->name('get_city');

            Route::get('/city_list/{array?}/{str?}', 'CityController@city_list')->name('city_list');

            Route::post('/city_list', 'CityController@city_list')->name('city_list');

            Route::post('/edit_city', 'CityController@edit_city')->name('edit_city');

            Route::post('/update_city', 'CityController@update_city')->name('update_city');

            Route::get('/edit_city', 'CityController@city_list')->name('edit_city');

            Route::post('/delete_city', 'CityController@delete_city')->name('delete_city');
        });
        /***************************************************************************/
        /***************************** Production Stock Adjustment Routes ***********************/
        /***************************************************************************/

        //Route::get('/product_recipe', function (){
        //    view('product_recipe');
        //})->name('product_recipe');
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {

            Route::get('/production_stock_adjustment', 'ProductionStockAdjustmentController@production_stock_adjustment')->name('production_stock_adjustment');

            Route::post('/submit_production_stock_adjustment', 'ProductionStockAdjustmentController@submit_production_stock_adjustment')->name('submit_production_stock_adjustment');

            Route::get('/production_stock_adjustment_list/{array?}/{str?}', 'ProductionStockAdjustmentController@production_stock_adjustment_list')->name('production_stock_adjustment_list');

            Route::post('/production_stock_adjustment_list', 'ProductionStockAdjustmentController@production_stock_adjustment_list')->name('production_stock_adjustment_list');

            Route::post('/production_stock_consumed_produced_items_view_details', 'ProductionStockAdjustmentController@production_stock_consumed_produced_items_view_details')->name('production_stock_consumed_produced_items_view_details');

            Route::get('/production_stock_consumed_produced_items_view_details/view/{id}', 'ProductionStockAdjustmentController@production_stock_consumed_produced_items_view_details_SH')->name('production_stock_consumed_produced_items_view_details_SH');

            Route::get('/production_stock_consumed_produced_items_view_details/view/pdf/{id}', 'ProductionStockAdjustmentController@production_stock_consumed_produced_items_view_details_pdf_SH')->name('production_stock_consumed_produced_items_view_details_pdf_SH');


            Route::get('/product_consumed_items_view_details/view/pdf/{id}', 'ProductionStockAdjustmentController@product_consumed_items_view_details_pdf_SH')->name('product_consumed_items_view_details_pdf_SH');
            Route::get('/product_produced_items_view_details/view/pdf/{id}', 'ProductionStockAdjustmentController@product_produced_items_view_details_pdf_SH')->name('product_produced_items_view_details_pdf_SH');
        });
        /***************************************************************************/
        /******************************** Database Fixed Data Route ******************************/
        /***************************************************************************/
        Route::get('/create_fixed_data', 'FixedDataController@create_fixed_data')->name('create_fixed_data');

        /*****************************************************************************************************/
        /***************************** Product Margin Report Routes *******************************/
        /*****************************************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/product_margin_report/{array?}/{str?}', 'ProductMarginReportController@product_margin_report')->name('product_margin_report');

            Route::post('/product_margin_report', 'ProductMarginReportController@product_margin_report')->name('product_margin_report');
        });
        /***************************************************************************/
        /***************************** Software Package Routes *****************/
        /***************************************************************************/
        Route::group(['middleware' => ['superAdmin']], function () {
            Route::get('/software_package', 'PackagesController@software_package')->name('software_package');
            Route::post('/update_software_package', 'PackagesController@update_software_package')->name('update_software_package');

            Route::get('/user_expiry', 'PackagesController@user_expiry')->name('user_expiry');
            Route::post('/update_user_expiry', 'PackagesController@update_user_expiry')->name('update_user_expiry');

            /***************************************************************************/
            /***************************** Change Year end Routes *****************/
            /***************************************************************************/
            Route::get('/year_end', 'YearEndController@index')->name('year_end.index');
            Route::get('/year_end/create', 'YearEndController@create')->name('year_end.create');
            Route::post('/year_end/store', 'YearEndController@store')->name('year_end.store');


            /***************************************************************************/
            /***************************** client Database Routes *****************/
            /***************************************************************************/
            Route::get('database/create', 'Database\DatabaseController@create')->name('database_create');

            Route::post('database/store', 'Database\DatabaseController@store')->name('database_store');

            Route::get('/database/{array?}/{str?}', 'Database\DatabaseController@index')->name('database.index');

            Route::post('/database', 'Database\DatabaseController@index')->name('database.index');

            Route::post('/database/edit', 'Database\DatabaseController@edit')->name('database.edit');

            Route::post('/database/update', 'Database\DatabaseController@update')->name('database.update');

            Route::get('/database/edit', 'Database\DatabaseController@index')->name('database.edit');

            Route::post('/database/delete', 'Database\DatabaseController@delete')->name('database.delete');
            //        Route::resource('info_box', 'DatabaseController');
        });
        /***************************************************************************/
        /***************************** Project Reference Routes ******************************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage']], function () {
            Route::get('/add_posting_reference', 'PostingReferenceController@add_posting_reference')->name('add_posting_reference');

            Route::post('/submit_posting_reference', 'PostingReferenceController@submit_posting_reference')->name('submit_posting_reference');

            Route::get('/posting_reference_list/{array?}/{str?}', 'PostingReferenceController@posting_reference_list')->name('posting_reference_list');

            Route::post('/posting_reference_list', 'PostingReferenceController@posting_reference_list')->name('posting_reference_list');


            Route::post('/edit_posting_reference', 'PostingReferenceController@edit_posting_reference')->name('edit_posting_reference');

            Route::post('/update_posting_reference', 'PostingReferenceController@update_posting_reference')->name('update_posting_reference');

            Route::get('/edit_posting_reference', 'PostingReferenceController@posting_reference_list')->name('edit_posting_reference');
        });
        /***************************************************************************/
        /***************************** Bill Of Labour Voucher Routes *****************/
        /***************************************************************************/
        Route::group(['middleware' => ['advancePackage', 'dayEnd']], function () {

            Route::get('/bill_of_labour_voucher', 'BillOfLabourController@bill_of_labour_voucher')->name('bill_of_labour_voucher');
            Route::post('/submit_bill_of_labour_voucher', 'BillOfLabourController@submit_bill_of_labour_voucher')->name('submit_bill_of_labour_voucher');
            Route::get('/bill_of_labour_voucher_list/{array?}/{str?}', 'BillOfLabourController@bill_of_labour_voucher_list')->name('bill_of_labour_voucher_list');

            Route::post('/bill_of_labour_voucher_list', 'BillOfLabourController@bill_of_labour_voucher_list')->name('bill_of_labour_voucher_list');
            Route::post('/bill_of_labour_items_view_details', 'BillOfLabourController@bill_of_labour_items_view_details')->name('bill_of_labour_items_view_details');

            Route::get('/bill_of_labour_items_view_details/view/{id}', 'BillOfLabourController@bill_of_labour_items_view_details_SH')->name('bill_of_labour_items_view_details_SH');
            Route::get('/bill_of_labour_items_view_details/pdf/{id}', 'BillOfLabourController@bill_of_labour_items_view_details_pdf_SH')->name('bill_of_labour_items_view_details_pdf_SH');
            Route::get('/edit_bill_of_labour/{id}', 'BillOfLabourController@edit_bill_of_labour')->name('edit_bill_of_labour');
            //            update voucher route
            Route::post('/update_bill_of_labour_voucher/{id}', 'BillOfLabourController@update_bill_of_labour_voucher')->name('update_bill_of_labour_voucher');
            //post voucher list
            Route::get('/bill_of_labour_post_voucher_list/{array?}/{str?}', 'BillOfLabourController@bill_of_labour_post_voucher_list')->name('bill_of_labour_post_voucher_list');

            Route::post('/bill_of_labour_post_voucher_list', 'BillOfLabourController@bill_of_labour_post_voucher_list')->name('bill_of_labour_post_voucher_list');
            // post voucher route
            Route::post('/post_bill_of_labour_voucher/{id}', 'BillOfLabourController@post_bill_of_labour_voucher')->name('post_bill_of_labour_voucher');
            // post voucher route end

            Route::get('/bill_of_labour_voucher_posting_ref_list/{array?}/{str?}', 'BillOfLabourController@bill_of_labour_voucher_posting_ref_list')->name('bill_of_labour_voucher_posting_ref_list');

            Route::post('/bill_of_labour_voucher_posting_ref_list', 'BillOfLabourController@bill_of_labour_voucher_posting_ref_list')->name('bill_of_labour_voucher_posting_ref_list');
        });

        /***************************************************************************/
        /***************************** Sale Invoice To Purchase Temp table Routes *****************/
        /***************************************************************************/

        Route::get('/sale_invoice_post_list/{array?}/{str?}', 'SaleToPurchaseInvoiceController@sale_invoice_list')->name('sale_invoice_post_list');

        Route::post('/sale_invoice_post_list', 'SaleToPurchaseInvoiceController@sale_invoice_list')->name('sale_invoice_post_list');

        Route::post('/purchase_temp', 'SaleToPurchaseInvoiceController@purchase_temp')->name('purchase_temp');
    });
    /***************************************************************************/
    /***************************** Cart Routes *****************/
    /***************************************************************************/
    Route::group(['middleware' => ['checkUser']], function () {
        Route::get('/product_cart/{array?}/{str?}', [CardController::class, 'index'])->name('product_cart');
        Route::post('/product_cart', [CardController::class, 'index'])->name('product_cart');
        Route::get('cart', [CardController::class, 'cart'])->name('cart');
        Route::get('add-to-cart/{id}', [CardController::class, 'addToCart'])->name('add.to.cart');
        Route::patch('update-cart', [CardController::class, 'update'])->name('update.cart');
        //        Route::get('/checkout', [CardController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [CardController::class, 'checkout'])->name('checkout');
        Route::get('remove-from-cart/{id}', [CardController::class, 'remove'])->name('remove_from_cart');

        Route::get('/personal_account_ledger/{array?}/{str?}', 'AccountLedgerController@personal_account_ledger')->name('personal_account_ledger');

        Route::post('/personal_account_ledger', 'AccountLedgerController@personal_account_ledger')->name('personal_account_ledger');

        Route::get('/dispatch_list/{array?}/{str?}', 'StockOutwardController@dispatch_list')->name('dispatch_list');

        Route::post('/dispatch_list', 'StockOutwardController@dispatch_list')->name('dispatch_list');
    });
    /***************************************************************************/
    /***************************** Sale Order Routes ***************************/
    /***************************************************************************/
    Route::group(['middleware' => ['premiumPackage', 'dayEnd']], function () {
        Route::get('/sale_order', 'SaleOrderController@sale_order')->name('sale_order');

        Route::post('/submit_sale_order', 'SaleOrderController@submit_sale_order')->name('submit_sale_order');

        Route::get('/sale_order_list', 'SaleOrderController@sale_order_list')->name('sale_order_list');
        Route::post('/sale_order_list', 'SaleOrderController@sale_order_list')->name('sale_order_list');

        Route::get('/get_sale_order_items_for_sale', 'SaleOrderController@get_sale_order_items_for_sale')->name('get_sale_order_items_for_sale');

        /***************************************************************************/
        /***************************** Trade Sale Order Routes ***************************/
        /***************************************************************************/

        Route::get('/trade_sale_order', 'TradeInvoices\TradeSaleOrderController@trade_sale_order')->name('trade_sale_order');

        Route::post('/submit_trade_sale_order', 'TradeInvoices\TradeSaleOrderController@submit_trade_sale_order')->name('submit_trade_sale_order');

        Route::get('/trade_sale_order_list', 'TradeInvoices\TradeSaleOrderController@trade_sale_order_list')->name('trade_sale_order_list');
        Route::post('/trade_sale_order_list', 'TradeInvoices\TradeSaleOrderController@trade_sale_order_list')->name('trade_sale_order_list');


        Route::post('/stock_outward_view_details', 'StockOutwardController@stock_outward_view_details')->name('stock_outward_view_details');

        Route::get('/stock_outward_view_details/view/{id}', 'StockOutwardController@stock_outward_view_details_SH')->name('stock_outward_view_details_SH');

        Route::get('/stock_outward_view_details/pdf/{id}', 'StockOutwardController@stock_outward_view_details_pdf_SH')->name('stock_outward_view_details_pdf_SH');
    });
    /***************************************************************************************************/
    /**************************************** Change Password Routes************************************/
    /***************************************************************************************************/

    Route::get('/change_password', 'UserController@change_password')->name('change_password');

    Route::post('/submit_change_password', 'UserController@submit_change_password')->name('submit_change_password');

    /***************************************************************************************************/
    /**************************************** Change Profile Routes************************************/
    /***************************************************************************************************/
    Route::get('/edit_profile', 'UserController@edit_profile')->name('edit_profile');
    Route::post('/submit_update_profile', 'UserController@update_profile')->name('submit_update_profile');

    Route::get('/auto_submit_db_backup', 'DatabaseBackUpController@auto_submit_db_backup')->name('auto_submit_db_backup');
    /***************************************************************************************************/
    /****************************************IMEI Routes************************************/
    /***************************************************************************************************/
    Route::get('/create_imei', [IMEIRegisterConroller::class, 'create_imei'])->name('create_imei');
    Route::post('/store_imei', [IMEIRegisterConroller::class, 'store_imei'])->name('store_imei');
    Route::get('/imei_list/{array?}/{str?}', [IMEIRegisterConroller::class, 'imei_list'])->name('imei_list');
    Route::post('/imei_list', [IMEIRegisterConroller::class, 'imei_list'])->name('imei_list');
    Route::post('/delete_imei', [IMEIRegisterConroller::class, 'delete_imei'])->name('delete_imei');


    Route::group(['middleware' => ['basicPackage']], function () {
        Route::post('/get_area', 'SectorController@get_area')->name('get_area');
        Route::post('/get_sector', 'SectorController@get_sector')->name('get_sector');
        Route::post('/get_town', 'TownController@get_town')->name('get_town');
    });
    Route::get('/branch_session/{id}', [PackagesController::class, 'branch_session'])->name('branch.branch_session');

    /***************************************************************************/
    /***************************** Fee Voucher Routes *****************/
    /***************************************************************************/

    Route::get('/fee_voucher', [FeeVoucherController::class, 'fee_voucher'])->name('fee_voucher');

    Route::post('/submit_fee_voucher', [FeeVoucherController::class, 'submit_fee_voucher'])->name('submit_fee_voucher');

    Route::post('/submit_single_fee_voucher', [FeeVoucherController::class, 'submit_single_fee_voucher'])->name('submit_single_fee_voucher');

    Route::get('/fee_voucher_list/{array?}/{str?}', [FeeVoucherController::class, 'fee_voucher_list'])->name('fee_voucher_list');

    Route::post('/fee_voucher_list', [FeeVoucherController::class, 'fee_voucher_list'])->name('fee_voucher_list');

    Route::post('/fee_items_view_details', [FeeVoucherController::class, 'fee_items_view_details'])->name('fee_items_view_details');


    Route::get('/fee_items_view_details/view/{id}/{reg_no}', [FeeVoucherController::class, 'fee_items_view_details_SH'])->name('fee_items_view_details_SH');

    Route::get('/fee_items_view_details/pdf/{id}/{reg_no}', [FeeVoucherController::class, 'fee_items_view_details_pdf_SH'])->name('fee_items_view_details_pdf_SH');

    Route::get('/get_students_for_fee', [FeeVoucherController::class, 'get_students_for_fee'])->name('get_students_for_fee');


    Route::get('/month_wise_fee_voucher_list/{array?}/{str?}', [FeeVoucherController::class, 'month_wise_fee_voucher_list'])->name('month_wise_fee_voucher_list');

    Route::post('/month_wise_fee_voucher_list', [FeeVoucherController::class, 'month_wise_fee_voucher_list'])->name('month_wise_fee_voucher_list');

    Route::post('/month_fee_items_view_details', [FeeVoucherController::class, 'month_fee_items_view_details'])->name('month_fee_items_view_details');


    Route::get('/month_fee_items_view_details/view/{id}/{class_id}/{month}/{issue_date}', [FeeVoucherController::class, 'month_fee_items_view_details_SH'])->name('fee_items_view_details_SH');

    Route::get('/month_fee_items_view_details/pdf/{id}/{class_id}/{month}/{issue_date}', [FeeVoucherController::class, 'month_fee_items_view_details_pdf_SH'])->name('month_fee_items_view_details_pdf_SH');


    Route::get('/update_fee_voucher_no/{array?}/{str?}', [FeeVoucherController::class, 'update_fee_voucher_no'])->name('update_fee_voucher_no');

    Route::post('/update_fee_voucher_no', [FeeVoucherController::class, 'update_fee_voucher_no'])->name('update_fee_voucher_no');

    Route::post('/submit_fee_voucher_no', [FeeVoucherController::class, 'submit_fee_voucher_no'])->name('submit_fee_voucher_no');

    Route::post('/update_due_date/{id}', [FeeVoucherController::class, 'update_due_date'])->name('update_due_date');

    /*fee voucher pending list*/
    Route::get('/fee_voucher_pending_list/{array?}/{str?}', [FeeVoucherController::class, 'fee_voucher_pending_list'])->name('fee_voucher_pending_list');

    Route::post('/fee_voucher_pending_list', [FeeVoucherController::class, 'fee_voucher_pending_list'])->name('fee_voucher_pending_list');

    Route::post('/paid_single_fee_voucher/{id}', [PaidFeeVoucherController::class, 'paid_single_fee_voucher'])->name('paid_single_fee_voucher');

    /***************************************************************************/
    /***************************** Paid Fee Voucher Routes *****************/
    /***************************************************************************/

    Route::get('/fee_paid_voucher', [PaidFeeVoucherController::class, 'fee_paid_voucher'])->name('fee_paid_voucher');

    Route::post('/submit_fee_paid_voucher_excel', [PaidFeeVoucherController::class, 'submit_fee_paid_voucher_excel'])->name('submit_fee_paid_voucher_excel');

    Route::get('/fee_paid_voucher_list/{array?}/{str?}', [PaidFeeVoucherController::class, 'fee_paid_voucher_list'])->name('fee_paid_voucher_list');

    Route::post('/fee_paid_voucher_list', [PaidFeeVoucherController::class, 'fee_paid_voucher_list'])->name('fee_paid_voucher_list');

    Route::post('/fee_paid_items_view_details', [PaidFeeVoucherController::class, 'fee_paid_items_view_details'])->name('fee_paid_items_view_details');


    Route::get('/fee_paid_items_view_details/view/{id}', [PaidFeeVoucherController::class, 'fee_paid_items_view_details_SH'])->name('fee_paid_items_view_details_SH');

    Route::get('/fee_paid_items_view_details/pdf/{id}', [PaidFeeVoucherController::class, 'fee_paid_items_view_details_pdf_SH'])->name('fee_paid_items_view_details_pdf_SH');

    /***************************************************************************/
    /***************************** Custom Voucher Routes *****************/
    /***************************************************************************/

    Route::get('/custom_voucher', [CustomVoucherController::class, 'custom_voucher'])->name('custom_voucher');
    Route::post('/submit_custom_voucher', [CustomVoucherController::class, 'submit_custom_voucher'])->name('submit_custom_voucher');

    Route::post('/submit_student_wise_custom_voucher', [CustomVoucherController::class, 'submit_student_wise_custom_voucher'])->name('submit_student_wise_custom_voucher');

    Route::get('/custom_voucher_list/{array?}/{str?}', [CustomVoucherController::class, 'custom_voucher_list'])->name('custom_voucher_list');

    Route::post('/custom_voucher_list', [CustomVoucherController::class, 'custom_voucher_list'])->name('custom_voucher_list');

    Route::get('/custom_voucher_reverse_list/{array?}/{str?}', [CustomVoucherController::class, 'custom_voucher_reverse_list'])->name('custom_voucher_reverse_list');

    Route::post('/custom_voucher_reverse_list', [CustomVoucherController::class, 'custom_voucher_reverse_list'])->name('custom_voucher_reverse_list');

    Route::get('/custom_voucher_pending_list/{array?}/{str?}', [CustomVoucherController::class, 'custom_voucher_pending_list'])->name('custom_voucher_pending_list');

    Route::post('/custom_voucher_pending_list', [CustomVoucherController::class, 'custom_voucher_pending_list'])->name('custom_voucher_pending_list');

    Route::post('/custom_voucher_items_view_details', [CustomVoucherController::class, 'custom_voucher_items_view_details'])->name('custom_voucher_items_view_details');

    Route::get('/custom_voucher_items_view_details/view/{id}/{reg_no}', [CustomVoucherController::class, 'custom_voucher_items_view_details_SH'])->name('custom_voucher_items_view_details_SH');

    Route::get('/custom_voucher_items_view_details/pdf/{id}/{reg_no}', [CustomVoucherController::class, 'custom_voucher_items_view_details_pdf_SH'])->name('custom_voucher_items_view_details_pdf_SH');

    Route::get('/get_students_for_custom', [CustomVoucherController::class, 'get_students_for_custom'])->name('get_students_for_custom');

    // monthly voucher
    Route::get('/month_custom_voucher_list/{array?}/{str?}', [CustomVoucherController::class, 'month_custom_voucher_list'])->name('month_custom_voucher_list');

    Route::post('/month_custom_voucher_list', [CustomVoucherController::class, 'month_custom_voucher_list'])->name('month_custom_voucher_list');

    Route::post('/month_custom_voucher_items_view_details', [CustomVoucherController::class, 'month_custom_voucher_items_view_details'])->name('month_custom_voucher_items_view_details');

    Route::post('/reverse_custom_voucher', [CustomVoucherController::class, 'reverse_custom_voucher'])->name('reverse_custom_voucher');

    Route::get('/month_custom_voucher_items_view_details/view/{id}/{class_id}/{month}/{year}/{issue_date}', [CustomVoucherController::class, 'month_custom_voucher_items_view_details_SH'])->name('month_custom_voucher_items_view_details_SH');

    Route::get('/month_custom_voucher_items_view_details/pdf/{id}/{class_id}/{month}/{year}/{issue_date}', [CustomVoucherController::class, 'month_custom_voucher_items_view_details_pdf_SH'])->name('month_custom_voucher_items_view_details_pdf_SH');

    /***************************************************************************/
    /******************************** Bank Account Information Routes ******************************/
    /***************************************************************************/

    Route::get('/add_bank_account_info', [BankAccountInformationController::class, 'add_bank_account_info'])->name('add_bank_account_info');

    Route::post('/submit_bank_account_info', [BankAccountInformationController::class, 'submit_bank_account_info'])->name('submit_bank_account_info');

    Route::get('/bank_account_info_list/{array?}/{str?}', [BankAccountInformationController::class, 'bank_account_info_list'])->name('bank_account_info_list');

    Route::post('/bank_account_info_list', [BankAccountInformationController::class, 'bank_account_info_list'])->name('bank_account_info_list');

    Route::get('/bank_account_info_list', [BankAccountInformationController::class, 'bank_account_info_list'])->name('bank_account_info_list');

    Route::post('/edit_bank_account_info', [BankAccountInformationController::class, 'edit_bank_account_info'])->name('edit_bank_account_info');

    Route::get('/edit_bank_account_info', [BankAccountInformationController::class, 'edit_bank_account_info'])->name('edit_bank_account_info');

    Route::post('/update_bank_account_info', [BankAccountInformationController::class, 'update_bank_account_info'])->name('update_bank_account_info');

    Route::post('/delete_bank_account_info', [BankAccountInformationController::class, 'delete_bank_account_info'])->name('delete_bank_account_info');

    Route::get('/enable_disable_bank_info', [EnabledDisabledController::class, 'enable_disable_bank_info'])->name('enable_disable_bank_info');

    /***************************************************************************/
    /*********************** Transport Voucher Routes *********************/
    /***************************************************************************/

    Route::get('/transport_voucher', [TransportVoucherController::class, 'transport_voucher'])->name('transport_voucher');

    Route::post('/submit_transport_voucher', [TransportVoucherController::class, 'submit_transport_voucher'])->name('submit_transport_voucher');

    Route::post('/submit_student_wise_transport_voucher', [TransportVoucherController::class, 'submit_student_wise_transport_voucher'])->name('submit_student_wise_transport_voucher');

    Route::get('/transport_voucher_list/{array?}/{str?}', [TransportVoucherController::class, 'transport_voucher_list'])->name('transport_voucher_list');

    Route::post('/transport_voucher_list', [TransportVoucherController::class, 'transport_voucher_list'])->name('transport_voucher_list');

    Route::get('/transport_voucher_pending_list/{array?}/{str?}', [TransportVoucherController::class, 'transport_voucher_pending_list'])->name('transport_voucher_pending_list');

    Route::post('/transport_voucher_pending_list', [TransportVoucherController::class, 'transport_voucher_pending_list'])->name('transport_voucher_pending_list');

    Route::get('/transport_voucher_reverse_list/{array?}/{str?}', [TransportVoucherController::class, 'transport_voucher_reverse_list'])->name('transport_voucher_reverse_list');

    Route::post('/transport_voucher_reverse_list', [TransportVoucherController::class, 'transport_voucher_reverse_list'])->name('transport_voucher_reverse_list');

    Route::post('/reverse_transport_voucher', [TransportVoucherController::class, 'reverse_transport_voucher'])->name('reverse_transport_voucher');

    Route::post('/transport_items_view_details', [TransportVoucherController::class, 'transport_items_view_details'])->name('transport_items_view_details');


    Route::get('/transport_items_view_details/view/{id}/{reg_no}/{status}', [TransportVoucherController::class, 'transport_items_view_details_SH'])->name('transport_items_view_details_SH');

    Route::get('/transport_items_view_details/pdf/{id}/{reg_no}/{status}', [TransportVoucherController::class, 'transport_items_view_details_pdf_SH'])->name('transport_items_view_details_pdf_SH');

    // monthly voucher
    Route::get('/month_transport_voucher_list/{array?}/{str?}', [TransportVoucherController::class, 'month_transport_voucher_list'])->name('month_transport_voucher_list');

    Route::post('/month_transport_voucher_list', [TransportVoucherController::class, 'month_transport_voucher_list'])->name('month_transport_voucher_list');

    Route::post('/month_transport_voucher_items_view_details', [TransportVoucherController::class, 'month_transport_voucher_items_view_details'])->name('month_transport_voucher_items_view_details');

    Route::get('/month_transport_voucher_items_view_details/view/{month}/{year}/{issue_date}', [TransportVoucherController::class, 'month_transport_voucher_items_view_details_SH'])
        ->name('month_transport_voucher_items_view_details_SH');

    Route::get('/month_transport_voucher_items_view_details/pdf/{month}/{year}/{issue_date}', [TransportVoucherController::class, 'month_transport_voucher_items_view_details_pdf_SH'])->name('month_transport_voucher_items_view_details_pdf_SH');

    /***************************************************************************/
    /******************************** Cron JOb Income Entry Routes ******************************/
    /***************************************************************************/
    Route::get('/every_month_auto_income_entry/{id}', [CronJobController::class, 'every_month_auto_income_entry'])->name('every_month_auto_income_entry');
    /***************************************************************************/
    /******************************** Single Entry Routes ******************************/
    /***************************************************************************/
    Route::get('/single_entry', [SingleEntryController::class, 'single_entry'])->name('single_entry');
    Route::post('/store_single_entry', [SingleEntryController::class, 'store_single_entry'])->name('store_single_entry');

    /***************************************************************************/
    /******************************** Bank Integration Routes *****************************/
    /***************************************************************************/

    Route::get('/bank_integration_list', [BankIntegrationController::class, 'bank_integration_list'])->name('bank_integration_list');
    Route::post('/update_bank_integration', [BankIntegrationController::class, 'update_bank_integration'])->name('update_bank_integration');

    /***************************************************************************/
    /******************************** ZKTECO Routes *****************************/
    /***************************************************************************/

    Route::get('/zkteco', [MachineController::class, 'index'])->name('machine.home');
    Route::get('/test-sound', [MachineController::class, 'test_sound'])->name('machine.testsound');
    Route::get('/device-information', [MachineController::class, 'device_information'])->name('machine.deviceinformation');
    Route::get('/device-data', [MachineController::class, 'device_data'])->name('machine.devicedata');
    Route::get('/device-data/clear-attendance', [MachineController::class, 'device_data_clear_attendance'])->name('machine.devicedata.clear.attendance');
    Route::get('/device-restart', [MachineController::class, 'device_restart'])->name('machine.devicerestart');
    Route::get('/device-shutdown', [MachineController::class, 'device_shutdown'])->name('machine.deviceshutdown');
    Route::get('/device-sleep', [MachineController::class, 'device_sleep'])->name('machine.devicesleep');
    Route::get('/device-resume', [MachineController::class, 'device_resume'])->name('machine.deviceresume');
    Route::get('/device-settime', [MachineController::class, 'device_settime'])->name('machine.devicesettime');


    Route::post('/device-setip', [MachineController::class, 'device_setip'])->name('machine.devicesetip');
    Route::get('/device-adduser', [MachineController::class, 'device_adduser'])->name('machine.deviceadduser');
    Route::post('/device-setuser', [MachineController::class, 'device_setuser'])->name('machine.devicesetuser');
    Route::get('/device-removeuser-all', [MachineController::class, 'device_removeuser_all'])->name('machine.deviceremoveuserall');
    Route::get('/device-removeuser-single/{id}', [MachineController::class, 'device_removeuser_single'])->name('machine.deviceremoveusersingle');
    Route::get('/device-viewuser-single/[id]', [MachineController::class, 'device_viewuser_single'])->name('machine.deviceviewusersingle');
// Route::get('/', function () {
//     return view('welcome');
// });
    Route::get('/get_User_Attendance', [MachineController::class, 'get_User_Attendance'])->name('get_User_Attendance');

    Route::resource('reg_device',RegisterZKTecoController::class);

    Route::get('/add_machine', 'EmployeeController@add_machine')->name('add_machine');

    Route::post('/submit_machine', 'EmployeeController@submit_machine')->name('submit_machine');

    Route::get('/machine_list', 'EmployeeController@machine_list')->name('machine_list');

    Route::get('/change_machine_password', 'EmployeeController@change_machine_password')->name('change_machine_password');

    Route::post('/change_machine_password', 'EmployeeController@change_machine_password')->name('change_machine_password');

    Route::post('/submit_machine_password', 'EmployeeController@submit_machine_password')->name('submit_machine_password');
});
