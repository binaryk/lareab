<?php

Route::group(array('after' => 'auth'), function () 
{
    /*POST*/
    Route::post('/incasare_factura_add/{id}', array('as'=>'incasare_factura_add', 'uses' => 'IncasariFacturaController@postAddIncasareFactura'));
    Route::post('/incasare_factura_edit/{id}', array('as'=>'incasare_factura_edit', 'uses' => 'IncasariFacturaController@postEditIncasareFactura'));
    Route::post('/incasare_factura_delete', array('as'=>'incasare_factura_delete', 'uses' => 'IncasariFacturaController@postDeleteIncasare'));

    /*GET*/
    Route::get('/incasari_factura/{id}', array('as'=>'incasari_factura', 'uses' => 'IncasariFacturaController@getIncasariFactura'));
    Route::get('/incasare_factura_add/{id}', array('as'=>'incasare_factura_add', 'uses' => 'IncasariFacturaController@getAddIncasareFactura'));
    Route::get('/incasare_factura_edit/{id}', array('as'=>'incasare_factura_edit', 'uses' => 'IncasariFacturaController@getEditIncasareFactura'));
});