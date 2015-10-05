<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Banca\\Controllers\\';

	/*GET*/    
	Route::get('/banci_list', array('as' => 'banci_list', 'uses' => $ruta_controller . 'BancaController@getBanci'));
    Route::get('/banca_add', array('as' => 'banca_add', 'uses' => $ruta_controller . 'BancaController@getAddBanca'));
    Route::get('/banca_edit/{id}', array('as' => 'banca_edit', 'uses' => $ruta_controller . 'BancaController@getEditBanca'));

    /*POST*/    
	Route::post('/banca_add', array('as' => 'banca_add', 'uses' => $ruta_controller . 'BancaController@postAddBanca'));	
	Route::post('/banca_edit/{id}', array('as' => 'banca_edit', 'uses' => $ruta_controller . 'BancaController@postEditBanca'));
	Route::post('/banca_delete', array('as' => 'banca_delete', 'uses' => $ruta_controller . 'BancaController@postDeleteBanca'));	
});