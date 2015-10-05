<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Imobil\\Controllers\\';    

	/*GET*/
    Route::get('/locatari_list/{id_imobil}', array('as' => 'locatari_list_imobil', 'uses' => $ruta_controller . 'LocatarController@getLocatariImobil'));
    Route::get('/locatar_add/{id_imobil}', array('as' => 'locatar_add', 'uses' => $ruta_controller . 'LocatarController@getAddLocatar'));
    Route::get('/locatar_edit/{id}/{id_imobil}', array('as' => 'locatar_edit', 'uses' => $ruta_controller . 'LocatarController@getEditLocatar'));

   	/*POST*/
    Route::post('/locatar_add/{id_imobil}', array('as' => 'locatar_add', 'uses' => $ruta_controller . 'LocatarController@postAddLocatar'));
    Route::post('/locatar_edit/{id}/{id_imobil}', array('as' => 'locatar_edit', 'uses' => $ruta_controller . 'LocatarController@postEditLocatar'));
    Route::post('/locatar_delete', array('as' => 'locatar_delete', 'uses' => $ruta_controller . 'LocatarController@postDeleteLocatar'));
});