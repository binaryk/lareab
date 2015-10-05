<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
    /*Entitati publice*/
    Route::get('/entitati_publice_list', array('as'=>'entitati_publice_list', 'uses' => $ruta_controller . 'EntitatiPubliceController@getEntitatiPublice'));
    Route::get('/entitati_publice_add', array('as' => 'entitati_publice_add', 'uses' => $ruta_controller . 'EntitatiPubliceController@getAddEntitate'));
    Route::get('/entitati_publice_edit/{id}', array('as' => 'entitati_publice_edit', 'uses' => $ruta_controller . 'EntitatiPubliceController@getEditEntitate'));

	/* Entitati publice */
	Route::post('/entitati_publice_add', array('as' => 'entitati_publice_add', 'uses' => $ruta_controller . 'EntitatiPubliceController@postAddEntitate'));
	Route::post('/entitati_publice_edit/{id}', array('as' => 'entitati_publice_edit', 'uses' => $ruta_controller . 'EntitatiPubliceController@postEditEntitate'));
	Route::post('/entitati_publice_delete', array('as' => 'entitati_publice_delete', 'uses' => $ruta_controller . 'EntitatiPubliceController@postDeleteEntitate'));

});