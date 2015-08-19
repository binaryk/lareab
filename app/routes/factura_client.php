<?php

Route::group(array('after' => 'auth'), function () 
{
    /*POST*/
    Route::post('/factura_client_edit/{id}', array('as'=>'factura_client_edit', 'uses' => 'FacturaClientController@postEditFactura'));
    Route::post('/factura_client_delete', array('as'=>'factura_client_delete', 'uses' => 'FacturaClientController@postDeleteFactura'));
    Route::post('/factura_client_detaliu_add', array('as'=>'factura_client_detaliu_add', 'uses' => 'FacturaClientController@postAddDetaliuFactura'));
    Route::post('/factura_client_detaliu_delete', array('as'=>'factura_client_detaliu_delete', 'uses' => 'FacturaClientController@postDeleteDetaliuFactura'));
    Route::post('/factura_client_detaliu_edit', array('as'=>'factura_client_detaliu_edit', 'uses' => 'FacturaClientController@postEditDetalii'));

    /*GET*/
    Route::get('/facturi_client_list', array('as'=>'facturi_client', 'uses' => 'FacturaClientController@getFacturi'));
    Route::get('/factura_client_optiuni/{id}', array('as'=>'factura_client_optiuni', 'uses' => 'FacturaClientController@getOptiuniFactura'));
    Route::get('/factura_client_edit/{id}', array('as'=>'factura_client_edit', 'uses' => 'FacturaClientController@getEditFactura'));
    Route::get('/detalii_factura_client/{id}', array('as'=>'detalii_factura_client', 'uses' => 'FacturaClientController@getDetaliiFactura'));
});