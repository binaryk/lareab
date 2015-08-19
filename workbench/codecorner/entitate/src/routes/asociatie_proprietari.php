<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
	/* GET */
    Route::get('/asociatie_proprietari_list', array('as' => 'asociatii_proprietari_list', 'uses' => $ruta_controller . 'AsociatieProprietariController@getAsociatiiProprietari'));
    Route::get('/asociatie_proprietari_add', array('as' => 'asociatie_proprietari_add', 'uses' => $ruta_controller . 'AsociatieProprietariController@getAddAsociatieProprietari'));
    Route::get('/asociatie_proprietari_edit/{id}', array('as' => 'asociatie_proprietari_edit', 'uses' => $ruta_controller . 'AsociatieProprietariController@getEditAsociatieProprietari'));
    

    /* POST */
    Route::post('/asociatie_proprietari_add', array('as' => 'asociatie_proprietari_add', 'uses' => $ruta_controller . 'AsociatieProprietariController@postAddAsociatieProprietari'));
    Route::post('/asociatie_proprietari_edit/{id}', array('as' => 'asociatie_proprietari_edit', 'uses' => $ruta_controller . 'AsociatieProprietariController@postEditAsociatieProprietari'));
});