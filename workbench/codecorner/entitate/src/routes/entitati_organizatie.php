<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
    /*GET*/
    Route::get('/entitati_organizatie_list/{tip_entitate}', array('as' => 'entitati_organizatie_list', 'uses' => $ruta_controller . 'EntitatiOrganizatieController@getEntitati'));
    Route::get('/entitate_organizatie_add/{tip_entitate}', array('as' => 'entitate_organizatie_add', 'uses' => $ruta_controller . 'EntitatiOrganizatieController@getAddEntitate'));        
    Route::get('/entitate_organizatie_edit/{id}/{tip_entitate}', array('as' => 'entitate_organizatie_edit', 'uses' => $ruta_controller . 'EntitatiOrganizatieController@getEditEntitate'));

    /*POST*/
	Route::post('/entitate_organizatie_add/{tip_entitate}', array('as' => 'entitate_organizatie_add', 'uses' => $ruta_controller . 'EntitatiOrganizatieController@postAddEntitate'));
    Route::post('/entitate_organizatie_edit/{id}/{tip_entitate}', array('as'=>'entitate_organizatie_edit', 'uses' => $ruta_controller . 'EntitatiOrganizatieController@postEditEntitate'));
    Route::post('/entitate_organizatie_delete', array('as' => 'firme_organizatie_delete', 'uses' => $ruta_controller . 'EntitatiOrganizatieController@postDeleteEntitate'));
});