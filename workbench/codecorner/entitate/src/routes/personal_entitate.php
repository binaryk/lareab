<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
	/*Personal entitate*/              
	Route::get('/personal_list', array('as' => 'personal_list', 'uses' => $ruta_controller . 'PersonalEntitateController@getPersonalOrganizatie'));
    Route::get('/personal_list/{id_entitate}/{entitate}', array('as' => 'personal_list_entitate', 'uses' => $ruta_controller . 'PersonalEntitateController@getPersonalEntitate'));
    Route::get('/personal_add', array('as' => 'personal_add', 'uses' => $ruta_controller . 'PersonalEntitateController@getAddPersoanaOrganizatie'));
    Route::get('/personal_edit/{id_personal}', array('as' => 'personal_edit', 'uses' => $ruta_controller . 'PersonalEntitateController@getEditPersoana'));

	/*Personal entitate*/    
	Route::post('/personal_add', array('as' => 'personal_add', 'uses' => $ruta_controller . 'PersonalEntitateController@postAddPersoana'));
	Route::post('/personal_edit/{id}', array('as' => 'personal_edit', 'uses' => $ruta_controller . 'PersonalEntitateController@postEditPersoana'));
	Route::post('/personal_delete', array('as' => 'personal_delete', 'uses' => $ruta_controller . 'PersonalEntitateController@postDeletePersoana'));
	Route::post('/dezasociaza_personal', array('as' => 'dezasociaza_personal', 'uses' => $ruta_controller . 'PersonalEntitateController@postDezasociazaPersonal'));		
	Route::post('/asociaza_personal', array('as' => 'asociaza_personal', 'uses' => $ruta_controller . 'PersonalEntitateController@postAsociazaPersonal'));			
});