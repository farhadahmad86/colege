<?php

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


/***************************************************************************/
/***************************** Dashboard Routes ******************************/
/***************************************************************************/

Route::get('/teller/dashboard', 'Teller\TellerController@dashboard')->name('teller/dashboard');



/***************************************************************************/
/***************************** Change Password Routes ******************************/
/***************************************************************************/

Route::get('/teller/change_password', 'Teller\TellerController@change_password')->name('teller/change_password');

Route::post('/teller/submit_change_password', 'Teller\TellerController@submit_change_password')->name('teller/submit_change_password');



/***************************************************************************/
/***************************** Change Profile Routes ******************************/
/***************************************************************************/

Route::get('/teller/edit_profile', 'Teller\TellerController@edit_profile')->name('teller/edit_profile');

Route::post('/teller/submit_update_profile', 'Teller\TellerController@update_profile')->name('teller/submit_update_profile');



/***************************************************************************/
/***************************** Cash Receive Routes ******************************/
/***************************************************************************/

Route::get('/teller/pending_cash_receive_list', 'Teller\CashReceiveController@pending_cash_receive_list')->name('teller/pending_cash_receive_list');

Route::post('/teller/pending_cash_receive_list', 'Teller\CashReceiveController@pending_cash_receive_list')->name('teller/pending_cash_receive_list');

Route::post('/teller/approve_cash_receive', 'Teller\CashReceiveController@approve_cash_receive')->name('teller/approve_cash_receive');

Route::get('/teller/approve_cash_receive_list', 'Teller\CashReceiveController@approve_cash_receive_list')->name('teller/approve_cash_receive_list');

Route::post('/teller/approve_cash_receive_list', 'Teller\CashReceiveController@approve_cash_receive_list')->name('teller/approve_cash_receive_list');

Route::post('/teller/reject_cash_receive', 'Teller\CashReceiveController@reject_cash_receive')->name('teller/reject_cash_receive');

Route::get('/teller/reject_cash_receive_list', 'Teller\CashReceiveController@reject_cash_receive_list')->name('teller/reject_cash_receive_list');

Route::post('/teller/reject_cash_receive_list', 'Teller\CashReceiveController@reject_cash_receive_list')->name('teller/reject_cash_receive_list');




/***************************************************************************/
/***************************** Cash Receive Routes ******************************/
/***************************************************************************/

Route::get('/teller/cash_transfer', 'Teller\CashTransferController@cash_transfer')->name('teller/cash_transfer');

Route::post('/teller/submit_cash_transfer', 'Teller\CashTransferController@submit_cash_transfer')->name('teller/submit_cash_transfer');

Route::get('/teller/pending_cash_transfer_list', 'Teller\CashTransferController@pending_cash_transfer_list')->name('teller/pending_cash_transfer_list');

Route::post('/teller/pending_cash_transfer_list', 'Teller\CashTransferController@pending_cash_transfer_list')->name('teller/pending_cash_transfer_list');

Route::get('/teller/approve_cash_transfer_list', 'Teller\CashTransferController@approve_cash_transfer_list')->name('teller/approve_cash_transfer_list');

Route::post('/teller/approve_cash_transfer_list', 'Teller\CashTransferController@approve_cash_transfer_list')->name('teller/approve_cash_transfer_list');

Route::get('/teller/reject_cash_transfer_list', 'Teller\CashTransferController@reject_cash_transfer_list')->name('teller/reject_cash_transfer_list');

Route::post('/teller/reject_cash_transfer_list', 'Teller\CashTransferController@reject_cash_transfer_list')->name('teller/reject_cash_transfer_list');




/***************************************************************************/
/***************************** On Net Sale Invoice Routes ******************************/
/***************************************************************************/

//Route::get('/teller/sale_invoice_on_net', 'Teller\SaleInvoiceOnCashController@sale_invoice_on_net')->name('teller/sale_invoice_on_net');
//
//Route::post('/teller/submit_sale_invoice_on_net', 'SaleInvoiceController@submit_sale_invoice')->name('teller/submit_sale_invoice_on_net');
//
//Route::post('/teller/get_sale_items_for_return', 'SaleInvoiceController@get_sale_items_for_return')->name('teller/get_sale_items_for_return');

//Route::get('/teller/sale_invoice_list', 'Teller\SaleInvoiceOnCashController@sale_invoice_list')->name('teller/sale_invoice_list');
//
//Route::post('/teller/sale_invoice_list', 'Teller\SaleInvoiceOnCashController@sale_invoice_list')->name('teller/sale_invoice_list');
//
//Route::post('/teller/sale_items_view_details', 'SaleInvoiceController@sale_items_view_details')->name('teller/sale_items_view_details');



/***************************************************************************/
/***************************** Sale Invoice Routes ******************************/
/***************************************************************************/

Route::get('/teller/sale_invoice', 'Teller\SaleInvoiceController@sale_invoice')->name('teller/sale_invoice');

Route::post('/teller/submit_sale_invoice', 'SaleInvoiceController@submit_sale_invoice')->name('teller/submit_sale_invoice');

Route::get('/teller/sale_invoice_list/{array?}/{str?}', 'Teller\SaleInvoiceController@sale_invoice_list')->name('teller/sale_invoice_list');

Route::post('/teller/sale_invoice_list', 'Teller\SaleInvoiceController@sale_invoice_list')->name('teller/sale_invoice_list');

Route::post('/teller/sale_items_view_details', 'Teller\SaleInvoiceController@sale_items_view_details')->name('teller/sale_items_view_details');

Route::get('/teller/sale_items_view_details/view/{id}', 'SaleInvoiceController@sale_items_view_details_SH')->name('teller/sale_items_view_details_sh');




/***************************************************************************/
/***************************** Sale Sale Tax Invoice Routes ******************************/
/***************************************************************************/

Route::get('/teller/sale_tax_sale_invoice_list', 'Teller\SaleInvoiceController@sale_tax_sale_invoice_list')->name('teller/sale_tax_sale_invoice_list');

Route::post('/teller/sale_tax_sale_invoice_list', 'Teller\SaleInvoiceController@sale_tax_sale_invoice_list')->name('teller/sale_tax_sale_invoice_list');

Route::get('/teller/sale_tax_sale_invoice_list/view/{id}', 'SaleInvoiceController@sale_sale_tax_items_view_details_SH')->name('teller/sale_sale_tax_items_view_details_SH');




/***************************************************************************/
/***************************** Inventory Routes ******************************/
/***************************************************************************/

Route::post('/teller/get_inventory', 'InventoryController@get_inventory')->name('teller/get_inventory');




/***************************************************************************/
/***************************** Get Account Info Routes ******************************/
/***************************************************************************/

Route::post('/teller/get_account_info', 'AccountRegisterationsController@get_account_info')->name('teller/get_account_info');



/***************************************************************************/
/***************************** Sale Return Invoice Routes ******************************/
/***************************************************************************/

Route::get('/teller/sale_return_invoice', 'Teller\SaleReturnInvoiceController@sale_return_invoice')->name('teller/sale_return_invoice');

Route::post('/teller/submit_sale_return_invoice', 'SaleReturnInvoiceController@submit_sale_return_invoice')->name('teller/submit_sale_return_invoice');

Route::get('/teller/sale_return_invoice_list', 'Teller\SaleReturnInvoiceController@sale_return_invoice_list')->name('teller/sale_return_invoice_list');

Route::post('/teller/sale_return_invoice_list', 'Teller\SaleReturnInvoiceController@sale_return_invoice_list')->name('teller/sale_return_invoice_list');

Route::post('/teller/get_sale_items_for_return', 'SaleReturnInvoiceController@get_sale_items_for_return')->name('teller/get_sale_items_for_return');

Route::get('/teller/sale_return_invoice_list/view/{id}', 'SaleReturnInvoiceController@sale_return_items_view_details_SH')->name('teller/sale_return_items_view_details_SH');



/***************************************************************************/
/***************************** Sale Return Sale Tax Invoice Routes ******************************/
/***************************************************************************/

Route::get('/teller/sale_tax_sale_return_invoice_list', 'Teller\SaleReturnInvoiceController@sale_tax_sale_return_invoice_list')->name('teller/sale_tax_sale_return_invoice_list');

Route::post('/teller/sale_tax_sale_return_invoice_list', 'Teller\SaleReturnInvoiceController@sale_tax_sale_return_invoice_list')->name('teller/sale_tax_sale_return_invoice_list');

Route::get('/teller/sale_tax_sale_return_invoice_list/view/{id}', 'SaleReturnInvoiceController@sale_return_saletax_items_view_details_SH')->name('teller/sale_return_saletax_items_view_details_SH');




/***************************************************************************/
/***************************** Account Ledger Routes ******************************/
/***************************************************************************/

Route::get('/teller/account_ledger', 'Teller\AccountLedgerController@account_ledger')->name('teller/account_ledger');

Route::post('/teller/account_ledger', 'Teller\AccountLedgerController@account_ledger')->name('teller/account_ledger');

Route::get('/teller/transaction_view_details_SH/{id}', 'AccountLedgerController@transaction_view_details_SH')->name('teller/transaction_view_details_SH');