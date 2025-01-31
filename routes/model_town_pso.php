<?php

/***************************************************************************/
/***************************** PSO Tank Routes ******************************/
/***************************************************************************/

Route::get('/add_tank', 'PSO\TankController@add_tank')->name('add_tank');

Route::post('/submit_tank', 'PSO\TankController@submit_tank')->name('submit_tank');

Route::get('/tank_list', 'PSO\TankController@tank_list')->name('tank_list');

Route::post('/tank_list', 'PSO\TankController@tank_list')->name('tank_list');

Route::post('/edit_tank', 'PSO\TankController@edit_tank')->name('edit_tank');

Route::get('/edit_tank', 'PSO\TankController@tank_list')->name('edit_tank');

Route::post('/update_tank', 'PSO\TankController@update_tank')->name('update_tank');

/***************************************************************************/
/***************************** Nozzle Routes ******************************/
/***************************************************************************/

Route::get('/add_nozzle', 'PSO\NozzleController@add_nozzle')->name('add_nozzle');

Route::post('/submit_nozzle', 'PSO\NozzleController@submit_nozzle')->name('submit_nozzle');

Route::get('/nozzle_list', 'PSO\NozzleController@nozzle_list')->name('nozzle_list');

Route::post('/nozzle_list', 'PSO\NozzleController@nozzle_list')->name('nozzle_list');

Route::post('/edit_nozzle', 'PSO\NozzleController@edit_nozzle')->name('edit_nozzle');

Route::post('/update_nozzle', 'PSO\NozzleController@update_nozzle')->name('update_nozzle');

Route::get('/edit_nozzle', 'PSO\NozzleController@nozzle_list')->name('edit_nozzle');

/***************************************************************************/
/***************************** Dip Reading Routes ******************************/
/***************************************************************************/

Route::get('/add_dip_reading', 'PSO\DipReadingController@add_dip_reading')->name('add_dip_reading');

Route::post('/submit_dip_reading', 'PSO\DipReadingController@submit_dip_reading')->name('submit_dip_reading');

Route::get('/dip_reading_list', 'PSO\DipReadingController@dip_reading_list')->name('dip_reading_list');

Route::post('/dip_reading_list', 'PSO\DipReadingController@dip_reading_list')->name('dip_reading_list');

Route::post('/dip_reading_mm_to_litre', 'PSO\DipReadingController@dip_reading_mm_to_litre')->name('dip_reading_mm_to_litre');

//
///***************************************************************************/
///***************************** Tank Receiving Routes ******************************/
///***************************************************************************/
//
Route::get('/add_tank_receiving', 'PSO\TankReceivingController@add_tank_receiving')->name('add_tank_receiving');
//
//Route::post('/submit_tank_receiving', 'PSO\TankReceivingController@submit_tank_receiving')->name('submit_tank_receiving');
//
//Route::get('/tank_receiving_list', 'PSO\TankReceivingController@tank_receiving_list')->name('tank_receiving_list');
//
//Route::post('/tank_receiving_list', 'PSO\TankReceivingController@tank_receiving_list')->name('tank_receiving_list');


/***************************************************************************/
/***************************** Tank Receiving Routes ******************************/
/***************************************************************************/

Route::get('/add_tank_receiving_clone', 'PSO\TankReceivingController@add_tank_receiving_clone')->name('add_tank_receiving_clone');

Route::post('/submit_tank_receiving', 'PSO\TankReceivingController@submit_tank_receiving')->name('submit_tank_receiving');

Route::get('/tank_receiving_list', 'PSO\TankReceivingController@tank_receiving_list')->name('tank_receiving_list');

Route::post('/tank_receiving_list', 'PSO\TankReceivingController@tank_receiving_list')->name('tank_receiving_list');


/***************************************************************************/
/***************************** Nozzle Reading Routes ******************************/
/***************************************************************************/

Route::get('/add_nozzle_reading', 'PSO\NozzleReadingController@add_nozzle_reading')->name('add_nozzle_reading');

Route::post('/submit_nozzle_reading', 'PSO\NozzleReadingController@submit_nozzle_reading')->name('submit_nozzle_reading');

Route::get('/nozzle_reading_list', 'PSO\NozzleReadingController@nozzle_reading_list')->name('nozzle_reading_list');

Route::post('/nozzle_reading_list', 'PSO\NozzleReadingController@nozzle_reading_list')->name('nozzle_reading_list');


/***************************************************************************/
/***************************** PSO Sale Invoice Routes ******************************/
/***************************************************************************/

Route::get('/pso_sale_invoice', 'PSO\SaleInvoiceController@pso_sale_invoice')->name('pso_sale_invoice');

Route::post('/submit_pso_sale_invoice', 'PSO\SaleInvoiceController@submit_pso_sale_invoice')->name('submit_pso_sale_invoice');

Route::get('/pso_sale_invoice_list', 'PSO\SaleInvoiceController@pso_sale_invoice_list')->name('pso_sale_invoice_list');
Route::post('/pso_sale_invoice_list', 'PSO\SaleInvoiceController@pso_sale_invoice_list')->name('pso_sale_invoice_list');


/***************************************************************************/
/***************************** PSO Sale Invoice Credit Routes ******************************/
/***************************************************************************/

Route::get('/pso_sale_invoice_credit', 'PSO\SaleInvoiceCreditController@pso_sale_invoice_credit')->name('pso_sale_invoice_credit');

Route::post('/submit_pso_sale_invoice_credit', 'PSO\SaleInvoiceCreditController@submit_pso_sale_invoice_credit')->name('submit_pso_sale_invoice_credit');


/***************************************************************************/
/***************************** PSO Sale Invoice Credit Card Routes ******************************/
/***************************************************************************/

Route::get('/pso_sale_invoice_credit_card', 'PSO\SaleInvoiceCreditController@pso_sale_invoice_credit_card')->name('pso_sale_invoice_credit_card');



/***************************************************************************/
/***************************** Unit Testing Routes ******************************/
/***************************************************************************/

Route::get('/unit_testing', 'PSO\UnitTestingController@unit_testing')->name('unit_testing');

Route::post('/submit_unit_testing', 'PSO\UnitTestingController@submit_unit_testing')->name('submit_unit_testing');

Route::get('/unit_testing_list', 'PSO\UnitTestingController@unit_testing_list')->name('unit_testing_list');

Route::post('/unit_testing_list', 'PSO\UnitTestingController@unit_testing_list')->name('unit_testing_list');




/***************************************************************************/
/***************************** Meter Replacement Routes ******************************/
/***************************************************************************/

Route::get('/meter_replacement', 'PSO\MeterReplacementController@meter_replacement')->name('meter_replacement');

Route::post('/submit_meter_replacement', 'PSO\MeterReplacementController@submit_meter_replacement')->name('submit_meter_replacement');

Route::get('/meter_replacement_list', 'PSO\MeterReplacementController@meter_replacement_list')->name('meter_replacement_list');

Route::post('/meter_replacement_list', 'PSO\MeterReplacementController@meter_replacement_list')->name('meter_replacement_list');

/***************************************************************************/
/***************************** Enable Disable Routes ******************************/
/***************************************************************************/

Route::get('/enable_disable_nozzle', 'PSO\EnabledDisabledController@enable_disable_nozzle')->name('enable_disable_nozzle');

/***************************************************************************/
/***************************** Refresh Ajax Routes ******************************/
/***************************************************************************/

Route::post('/refresh_sale_person', 'PSO\RefreshAjaxController@refresh_sale_person')->name('refresh_sale_person');

Route::post('/refresh_nozzle', 'PSO\RefreshAjaxController@refresh_nozzle')->name('refresh_nozzle');













