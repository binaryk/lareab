<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Registruintrareiesire\\Controllers\\';
	
	/*Registru intrare*/
	Route::get('/registru_intrare_list', array('uses' => $ruta_controller . 'RegistruIntrareController@getIntrari'));
	Route::get('/registru_intrare_add', array('uses' => $ruta_controller . 'RegistruIntrareController@getAddIntrare'));

	/*Registru iesire*/
	Route::get('/registru_iesire_list', array('uses' => $ruta_controller . 'RegistruIesireController@getIesiri'));
	Route::get('/registru_iesire_add', array('uses' => $ruta_controller . 'RegistruIesireController@getAddIesire'));

	/*Registru de intrare*/
	Route::post('/registru_intrare_add', array('uses' => $ruta_controller . 'RegistruIntrareController@postAddIntrare'));

	/*Registru de iesire*/
	Route::post('/registru_iesire_add', array('uses' => $ruta_controller . 'RegistruIesireController@postAddIesire'));
});