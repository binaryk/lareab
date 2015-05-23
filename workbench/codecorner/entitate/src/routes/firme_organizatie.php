<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
    /*GET*/
    Route::get('/firme_organizatie_list', array('as' => 'firme_organizatie_list', 'uses' => $ruta_controller . 'FirmeOrganizatieController@getFirme'));
    Route::get('/firme_organizatie_add', array('as' => 'firme_organizatie_add', 'uses' => $ruta_controller . 'FirmeOrganizatieController@getAddFirma'));        
    Route::get('/firme_organizatie_edit/{id}', array('as' => 'firme_organizatie_edit', 'uses' => $ruta_controller . 'FirmeOrganizatieController@getEditFirma'));

    /*POST*/
	Route::post('/firme_organizatie_add', array('as' => 'firme_organizatie_add', 'uses' => $ruta_controller . 'FirmeOrganizatieController@postAddFirma'));
    Route::post('/firme_organizatie_edit/{id}', array('as'=>'firme_organizatie_edit', 'uses' => $ruta_controller . 'FirmeOrganizatieController@postEditFirma'));
    Route::post('/firme_organizatie_delete', array('as' => 'firme_organizatie_delete', 'uses' => $ruta_controller . 'FirmeOrganizatieController@postDeleteFirma'));
});