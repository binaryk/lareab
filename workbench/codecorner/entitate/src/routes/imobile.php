<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';    

	/*GET*/
    Route::get('/imobile_list', array('as' => 'imobile_list', 'uses' => 'Codecorner\\Entitate\\Controllers\\ImobileController@getImobile'));
    Route::get('/imobil_add', array('as' => 'imobil_add', 'uses' => $ruta_controller . 'ImobileController@getAddImobil'));
    Route::get('/imobil_edit/{id}', array('as' => 'imobil_edit', 'uses' => $ruta_controller . 'ImobileController@getEditImobil'));

   	/*SET*/
    Route::post('/imobil_add', array('as' => 'imobil_add', 'uses' => $ruta_controller . 'ImobileController@postAddImobil'));
    Route::post('/imobil_edit/{id}', array('as' => 'imobil_edit', 'uses' => $ruta_controller . 'ImobileController@postEditImobil'));
});