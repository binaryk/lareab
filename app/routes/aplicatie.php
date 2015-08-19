<?php

Route::group(array('after' => 'auth'), function () 
{
   	/*GET*/    
    Route::get('/aplicatii_list', array('as'=>'aplicatii_list', 'uses' => 'AplicatieController@getAplicatii'));
    Route::get('/aplicatie_add', array('as'=>'aplicatie_add', 'uses' => 'AplicatieController@getAddAplicatie'));
    Route::get('/aplicatie_edit/{id}', array('as'=>'aplicatie_edit', 'uses' => 'AplicatieController@getEditAplicatie'));
	Route::get('/aplicatie_role/{id}/{denumire}', array('as' => 'aplicatie_role', 'uses' => 'AplicatieController@getAplicatieGrup'));			        

	/*POST*/
	Route::post('/aplicatie_add', array('as'=>'oaplicatie_add', 'uses' => 'AplicatieController@postAddAplicatie'));
    Route::post('/aplicatie_edit/{id}', array('as'=>'aplicatie_edit', 'uses' => 'AplicatieController@postEditAplicatie'));
    Route::post('/aplicatie_delete', array('as'=>'aplicatie_delete', 'uses' => 'AplicatieController@postDeleteAplicatie'));
	Route::post('/dezasociaza_role', array('as' => 'dezasociaza_role', 'uses' => 'AplicatieController@postDezasociazaRole'));		
	Route::post('/asociaza_role', array('as' => 'asociaza_role', 'uses' => 'AplicatieController@postAsociazaRole'));	
});