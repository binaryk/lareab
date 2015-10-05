<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
	/*GET*/    
	Route::get('/departament_list', array('as' => 'departament_list_organizatie', 'uses' => $ruta_controller . 'DepartamentController@getDepartamenteOrganizatie'));
	Route::get('/departament_list/{id}/{entitate}', array('as' => 'departament_list_entitate', 'uses' => $ruta_controller . 'DepartamentController@getDepartamenteEntitate'));
    Route::get('/departament_add', array('as' => 'departament_add_organizatie', 'uses' => $ruta_controller . 'DepartamentController@getAddDepartamentOrganizatie'));
    Route::get('/departament_add/{id_entitate}/{entitate}', array('as' => 'departament_add_entitate', 'uses' => $ruta_controller . 'DepartamentController@getAddDepartamentEntitate'));
    Route::get('/departament_edit/{id}', array('as' => 'departament_edit', 'uses' => $ruta_controller . 'DepartamentController@getEditDepartament'));

   /*POST*/    
	Route::post('/departament_add', array('uses' => $ruta_controller . 'DepartamentController@postAddDepartament'));
	Route::post('/departament_add/{id}/{entitate}', array('uses' => $ruta_controller . 'DepartamentController@postAddDepartament'));
	Route::post('/departament_edit/{id}', array('as' => 'departament_edit', 'uses' => $ruta_controller . 'DepartamentController@postEditDepartament'));
	Route::post('/departament_delete', array('as'=>'departament_delete','uses' => $ruta_controller . 'DepartamentController@postDeleteDepartament'));

});