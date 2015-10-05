<?php

Route::group(array('after' => 'auth'), function () 
{
    /*POST*/
    Route::post('/plata_factura_add/{id}', array('as'=>'plata_factura_add', 'uses' => 'PlatiFacturaController@postAddPlataFactura'));
    Route::post('/plata_factura_edit/{id}', array('as'=>'plata_factura_edit', 'uses' => 'PlatiFacturaController@postEditPlataFactura'));
    Route::post('/plata_factura_delete', array('as'=>'plata_factura_delete', 'uses' => 'PlatiFacturaController@postDeletePlata'));

    /*GET*/
    Route::get('/plati_factura/{id}', array('as'=>'plati_factura', 'uses' => 'PlatiFacturaController@getPlatiFactura'));
    Route::get('/plata_factura_add/{id}', array('as'=>'plata_factura_add', 'uses' => 'PlatiFacturaController@getAddPlataFactura'));
    Route::get('/plata_factura_edit/{id}', array('as'=>'plata_factura_edit', 'uses' => 'PlatiFacturaController@getEditPlataFactura'));
});