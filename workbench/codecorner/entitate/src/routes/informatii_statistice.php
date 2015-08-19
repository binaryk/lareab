<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
	/*GET*/    
	Route::get('/informatii_statistice_list/{id_entitate}/{entitate}/{with_view}', array('as' => 'informatii_statistice_list', 'uses' => $ruta_controller . 'InformatiiStatisticeController@getISEntitate')); 	
    Route::get('/informatii_statistice_add/{id_entitate}/{entitate}', array('as' => 'informatii_statistice_add', 'uses' => $ruta_controller . 'InformatiiStatisticeController@getAddIS'));
    Route::get('/informatii_statistice_edit/{id}/{id_entitate}/{entitate}', array('as' => 'informatii_statistice_edit', 'uses' => $ruta_controller . 'InformatiiStatisticeController@getEditIS'));                 
    
    /*POST*/
	Route::post('/informatii_statistice_add/{id_entitate}/{entitate}', array('as' => 'informatii_statistice_add', 'uses' => $ruta_controller . 'InformatiiStatisticeController@postAddIS'));    
	Route::post('/informatii_statistice_edit/{id}/{id_entitate}/{entitate}', array('as' => 'informatii_statistice_edit', 'uses' => $ruta_controller . 'InformatiiStatisticeController@postEditIS'));                 
});