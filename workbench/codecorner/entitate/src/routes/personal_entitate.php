<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
	/*Personal entitate*/              
    Route::get('/personal_entitate_list/{id_entitate}/{entitate}', array('as' => 'personal_entitate_list', 'uses' => $ruta_controller . 'PersonalEntitateController@getPersonal'));
    Route::get('/personal_entitate_add/{id_entitate}', array('as' => 'personal_entitate_add', 'uses' => $ruta_controller . 'PersonalEntitateController@getAddPersoana'));
    Route::get('/personal_entitate_edit/{id_personal}', array('as' => 'personal_entitate_edit', 'uses' => $ruta_controller . 'PersonalEntitateController@getEditPersoana'));

	/*Personal entitate*/    
	Route::post('/personal_entitate_add/{id}', array('as' => 'personal_entitate_add', 'uses' => $ruta_controller . 'PersonalEntitateController@postAddPersoana'));
	Route::post('/personal_entitate_edit/{id}', array('as' => 'personal_entitate_edit', 'uses' => $ruta_controller . 'PersonalEntitateController@postEditPersoana'));
	Route::post('/personal_entitate_delete', array('as' => 'personal_entitate_delete', 'uses' => $ruta_controller . 'PersonalEntitateController@postDeletePersoana'));

});