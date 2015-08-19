<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Imobil\\Controllers\\';    

	/*GET*/
    Route::get('/imobile_list', array('as' => 'imobile_list', 'uses' => $ruta_controller . 'ImobileController@getImobile'));
    Route::get('/imobile_list/{id_asociatie}', array('as' => 'imobile_asociatie_list', 'uses' => $ruta_controller . 'ImobileController@getImobileAsociatie'));
    Route::get('/imobil_add', array('as' => 'imobil_add', 'uses' => $ruta_controller . 'ImobileController@getAddImobil'));
    Route::get('/imobil_edit/{id}', array('as' => 'imobil_edit', 'uses' => $ruta_controller . 'ImobileController@getEditImobil'));
    Route::get('/imobil_optiuni/{id}', array('as'=>'imobil_optiuni', 'uses' => $ruta_controller . 'ImobileController@getOptiuniImobil'));

   	/*POST*/
    Route::post('/imobil_add', array('as' => 'imobil_add', 'uses' => $ruta_controller . 'ImobileController@postAddImobil'));
    Route::post('/imobil_edit/{id}', array('as' => 'imobil_edit', 'uses' => $ruta_controller . 'ImobileController@postEditImobil'));
    Route::post('/imobil_delete', array('as' => 'imobil_delete', 'uses' => $ruta_controller . 'ImobileController@postDeleteImobil'));
});