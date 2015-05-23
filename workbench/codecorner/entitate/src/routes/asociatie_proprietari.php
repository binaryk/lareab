<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
	/* Asociatii proprietari */
    Route::get('/asociatie_proprietari_list', array('as' => 'asociatii_proprietari_list', 'uses' => $ruta_controller . 'AsociatieProprietariController@getAsociatiiProprietari'));
    Route::get('/asociatie_proprietari_add', array('as' => 'asociatie_proprietari_add', 'uses' => $ruta_controller . 'AsociatieProprietariController@getAddAsociatieProprietari'));
});