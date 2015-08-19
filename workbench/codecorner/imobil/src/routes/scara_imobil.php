<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Imobil\\Controllers\\';    

	/*GET*/
    Route::get('/scari_list/{id_imobil}', array('as' => 'scari_list', 'uses' => $ruta_controller . 'ScaraImobilController@getScari'));
    Route::get('/scara_add/{id_imobil}', array('as' => 'scara_add', 'uses' => $ruta_controller . 'ScaraImobilController@getAddScara'));
    Route::get('/scara_edit/{id}/{id_imobil}', array('as' => 'scara_edit', 'uses' => $ruta_controller . 'ScaraImobilController@getEditScara'));

   	/*POST*/
    Route::post('/scara_add/{id_imobil}', array('as' => 'scara_add', 'uses' => $ruta_controller . 'ScaraImobilController@postAddScara'));
    Route::post('/scara_edit/{id}/{id_imobil}', array('as' => 'scara_edit', 'uses' => $ruta_controller . 'ScaraImobilController@postEditScara'));
    Route::post('/scara_delete', array('as' => 'scara_delete', 'uses' => $ruta_controller . 'ScaraImobilController@postDeleteScara'));
});