<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';

    /*Clienti organizatie*/
    Route::get('/clienti_organizatie_list', array('as'=>'clienti_organizatie_list', 'uses' => $ruta_controller . 'ClientiOrganizatieController@getClienti'));    
    Route::get('/clienti_organizatie_add', array('as' => 'clienti_organizatie_add', 'uses' => $ruta_controller . 'ClientiOrganizatieController@getAddClient'));
    Route::get('/clienti_organizatie_edit/{id}', array('as'=>'clienti_organizatie_edit', 'uses' => $ruta_controller . 'ClientiOrganizatieController@getEditClient'));

	/* Clienti(parteneri) organizatie */
	Route::post('/clienti_organizatie_add', array('as' => 'clienti_organizatie_add', 'uses' => $ruta_controller . 'ClientiOrganizatieController@postAddClient'));
	Route::post('/clienti_organizatie_edit/{id}', array('as' => 'clienti_organizatie_edit', 'uses' => $ruta_controller . 'ClientiOrganizatieController@postEditClient'));
	Route::post('/clienti_organizatie_delete', array('as' => 'clienti_organizatie_delete','uses' => $ruta_controller . 'ClientiOrganizatieController@postDeleteClient'));

});