<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
	/*Personal entitate*/              
	Route::get('/ocupatii_list', array('as' => 'ocupatii_list', 'uses' => $ruta_controller . 'OcupatiiController@getOcupatii'));
    Route::get('/ocupatie_add', array('as' => 'ocupatie_add', 'uses' => $ruta_controller . 'OcupatiiController@getAddOcupatie'));
    Route::get('/ocupatie_edit/{id}', array('as' => 'ocupatie_edit', 'uses' => $ruta_controller . 'OcupatiiController@getEditOcupatie'));

	/*Personal entitate*/    
	Route::post('/ocupatie_add', array('as' => 'ocupatie_add', 'uses' => $ruta_controller . 'OcupatiiController@postAddOcupatie'));
	Route::post('/ocupatie_edit/{id}', array('as' => 'ocupatie_edit', 'uses' => $ruta_controller . 'OcupatiiController@postEditOcupatie'));
	Route::post('/ocupatie_delete', array('as' => 'ocupatie_delete', 'uses' => $ruta_controller . 'OcupatiiController@postDeleteOcupatie'));
});