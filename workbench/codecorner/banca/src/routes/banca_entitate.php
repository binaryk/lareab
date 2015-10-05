<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Banca\\Controllers\\';

	/*GET*/    
	Route::get('/banci_list_entitate/{id_entitate}/{entitate}', array('as' => 'banci_list_entitate', 'uses' => $ruta_controller . 'BancaEntitateController@getBanciEntitate'));
    Route::get('/banca_entitate_add/{id_entitate}/{entitate}', array('as' => 'banca_entitate_add', 'uses' => $ruta_controller . 'BancaEntitateController@getAddBancaEntitate'));
    Route::get('/banca_entitate_edit/{id}/{id_entitate}/{entitate}', array('as' => 'banca_entitate_edit', 'uses' => $ruta_controller . 'BancaEntitateController@getEditBancaEntitate'));

    /*POST*/    
	Route::post('/banca_entitate_add/{id_entitate}/{entitate}', array('as' => 'banca_entitate_add', 'uses' => $ruta_controller . 'BancaEntitateController@postAddBancaEntitate'));	
	Route::post('/banca_entitate_edit/{id}/{id_entitate}/{entitate}', array('as' => 'banca_entitate_edit', 'uses' => $ruta_controller . 'BancaEntitateController@postEditBancaEntitate'));
	Route::post('/banca_delete', array('as' => 'banca_delete', 'uses' => $ruta_controller . 'BancaEntitateController@postDeleteBancaEntitate'));	
});