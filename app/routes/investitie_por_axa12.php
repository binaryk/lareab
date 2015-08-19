<?php

Route::group(array('after' => 'auth'), function () {
    /*GET*/
    Route::get('/investitie_por_axa12_list', array('as'=>'investitie_por_axa12_list', 'uses' => 'InvestitiePORAxa12Controller@getInvestitii'));
    Route::get('/investitie_por_axa12_add', array('as'=>'investitie_por_axa12_add', 'uses' => 'InvestitiePORAxa12Controller@getAddInvestitie'));
    Route::get('/investitie_por_axa12_edit/{id}', array('as'=>'investitie_por_axa12_edit', 'uses' => 'InvestitiePORAxa12Controller@getEditInvestitie'));
    Route::get('/investitie_por_axa12_optiuni/{id_investitie}/{id_imobil}', array('as'=>'investitie_por_axa12_optiuni', 'uses' => 'InvestitiePORAxa12Controller@getOptiuniInvestitie'));	

	/*POST*/
	Route::post('/investitie_por_axa12_add', array('as'=>'investitie_por_axa12_add', 'uses' => 'InvestitiePORAxa12Controller@postAddInvestitie'));
	Route::post('/investitie_por_axa12_edit/{id}', array('as'=>'investitie_por_axa12_edit', 'uses' => 'InvestitiePORAxa12Controller@postEditInvestitiez'));
	Route::post('/investitie_por_axa12_delete', array('as'=>'investitie_por_axa12_delete', 'uses' => 'InvestitiePORAxa12Controller@postDeleteInvestitie'));       

	/*Obiecte GET*/
	Route::get('/investitie_por_axa12_obiecte_list/{id_investitie}', array('as'=>'investitie_por_axa12_obiecte_list', 'uses' => 'InvestitiePORAxa12Controller@getObiecte'));
	Route::get('/investitie_por_axa12_obiect_add/{id_investitie}', array('as'=>'investitie_por_axa12_obiect_add', 'uses' => 'InvestitiePORAxa12Controller@getAddObiect'));
	Route::get('/investitie_por_axa12_obiect_edit/{id}/{id_investitie}', array('as'=>'investitie_por_axa12_obiect_edit', 'uses' => 'InvestitiePORAxa12Controller@getEditObiect'));	

	/*Obiecte POST*/
	Route::post('/investitie_por_axa12_obiect_add/{id_investitie}', array('as'=>'investitie_por_axa12_obiect_add', 'uses' => 'InvestitiePORAxa12Controller@postAddObiect'));
	Route::post('/investitie_por_axa12_obiect_edit/{id}/{id_investitie}', array('as'=>'investitie_por_axa12_obiect_edit', 'uses' => 'InvestitiePORAxa12Controller@postEditObiect'));

	/*Articole de deviz GET*/
	Route::get('/investitie_por_axa12_articol_edit/{id_investitie}/{id}', array('as'=>'investitie_por_axa12_articol_edit', 'uses' => 'InvestitiePORAxa12Controller@getEditArticol'));
	Route::get('/investitie_por_axa12_articol_add/{id_investitie}/{id_obiect}/{obiect}', array('as'=>'investitie_por_axa12_articol_add', 'uses' => 'InvestitiePORAxa12Controller@getAddArticol'));	
	
	/*Articole de deviz POST*/
	Route::post('/investitie_por_axa12_articol_edit/{id_investitie}/{id}', array('as'=>'investitie_por_axa12_articol_add', 'uses' => 'InvestitiePORAxa12Controller@postEditArticol'));
	Route::post('/investitie_por_axa12_articol_add/{id_investitie}/{id_obiect}/{obiect}', array('as'=>'investitie_por_axa12_articol_add', 'uses' => 'InvestitiePORAxa12Controller@postAddArticol'));
	
	/*Centralizatorul valorilor pe lucrari GET*/
	Route::get('/investitie_por_axa12_articol_valori_list/{id_investitie}', array('as'=>'investitie_por_axa12_articol_valori_list', 'uses' => 'InvestitiePORAxa12Controller@getArticoleValori'));
	Route::get('/investitie_por_axa12_articol_valori_create_edit/{id_investitie}/{id}', array('as'=>'investitie_por_axa12_articol_valori_create_edit', 'uses' => 'InvestitiePORAxa12Controller@getCreateEditArticoleValori'));

	/*Centralizatorul valorilor pe lucrari POST*/
	Route::post('/investitie_por_axa12_articol_valori_create_edit/{id_investitie}/{id}', array('as'=>'investitie_por_axa12_articol_valori_create_edit', 'uses' => 'InvestitiePORAxa12Controller@postCreateEditArticoleValori'));

	/*GET - Lucrari individuale*/
	Route::get('/investitie_por_axa12_lucrari_individuale_list/{id_investitie}/{id_imobil}', array('as'=>'investitie_por_axa12_lucrari_individuale_list', 'uses' => 'InvestitiePORAxa12Controller@getLocatariImobil'));		
});