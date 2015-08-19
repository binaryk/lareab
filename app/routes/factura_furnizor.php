<?php

Route::group(array('after' => 'auth'), function () 
{
    /*Facturi furnizor*/
    Route::get('/facturi_furnizor_list', array('as'=>'facturi_furnizor', 'uses' => 'FacturaFurnizorController@getFacturi'));
    Route::get('/factura_furnizor_optiuni/{id}', array('as'=>'factura_furnizor_optiuni', 'uses' => 'FacturaFurnizorController@getOptiuniFactura'));
    Route::get('/factura_furnizor_edit/{id}', array('as'=>'factura_furnizor_edit', 'uses' => 'FacturaFurnizorController@getEditFactura'));
    Route::get('/detalii_factura_furnizor/{id}', array('as'=>'detalii_factura_furnizor', 'uses' => 'FacturaFurnizorController@getDetaliiFactura'));
    Route::get('/factura_furnizor_add', array('as'=>'factura_furnizor_add', 'uses' => 'FacturaFurnizorController@getAddFactura'));

    /*Facturi furnizor*/
    Route::post('/factura_furnizor_add', array('as'=>'factura_furnizor_add', 'uses' => 'FacturaFurnizorController@postAddFactura'));
    Route::post('/factura_furnizor_edit/{id}', array('as'=>'factura_furnizor_edit', 'uses' => 'FacturaFurnizorController@postEditFactura'));
    Route::post('/factura_furnizor_delete', array('as'=>'factura_furnizor_delete', 'uses' => 'FacturaFurnizorController@postDeleteFactura'));
    Route::post('/factura_furnizor_detaliu_add', array('as'=>'factura_furnizor_detaliu_add', 'uses' => 'FacturaFurnizorController@postAddDetaliuFactura'));
    Route::post('/factura_furnizor_detaliu_delete', array('as'=>'factura_furnizor_detaliu_delete', 'uses' => 'FacturaFurnizorController@postDeleteDetaliuFactura'));
    Route::post('/factura_furnizor_detaliu_edit', array('as'=>'factura_furnizor_detaliu_edit', 'uses' => 'FacturaFurnizorController@postEditDetalii'));
});