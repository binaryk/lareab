<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
	/*GET*/    
	Route::get('/reprezentant_legal_list', array('as' => 'reprezentant_legal_list', 'uses' => $ruta_controller . 'ReprezentantLegalController@getReprezentantiOrganizatie'));
	Route::get('/reprezentant_legal_list/{id}/{entitate}', array('as' => 'reprezentant_legal_list_entitate', 'uses' => $ruta_controller . 'ReprezentantLegalController@getReprezentantiEntitate'));
    Route::get('/reprezentant_legal_add', array('as' => 'reprezentant_legal_add', 'uses' => $ruta_controller . 'ReprezentantLegalController@getAddReprezentantOrganizatie'));
    Route::get('/reprezentant_legal_edit/{id_reprezentant}', array('as' => 'reprezentant_legal_edit', 'uses' => $ruta_controller . 'ReprezentantLegalController@getEditReprezentant'));

    /*POST*/    
	Route::post('/reprezentant_legal_add', array('as'=>'reprezentant_legal_add', 'uses' => $ruta_controller . 'ReprezentantLegalController@postAddReprezentant'));
	Route::post('/reprezentant_legal_edit/{id}', array('as'=>'reprezentant_legal_edit', 'uses' => $ruta_controller . 'ReprezentantLegalController@postEditReprezentant'));
	Route::post('/reprezentant_legal_delete', array('as'=>'reprezentant_legal_delete','uses' => $ruta_controller . 'ReprezentantLegalController@postDeleteReprezentant'));
	Route::post('/dezasociaza_reprezentant', array('as' => 'dezasociaza_reprezentant', 'uses' => $ruta_controller . 'ReprezentantLegalController@postDezasociazaReprezentant'));		
	Route::post('/asociaza_reprezentant', array('as' => 'asociaza_reprezentant', 'uses' => $ruta_controller . 'ReprezentantLegalController@postAsociazaReprezentant'));			

});