<?php

Route::group(array('after' => 'auth'), function () {
    /*Contracte*/
    Route::get('/contract/{id}', array('as' => 'contract_single', 'uses' => 'ContractController@getContractSingle'));
    Route::get('/contract_list', array('as'=>'contract_list', 'uses' => 'ContractController@getContracte'));
    Route::get('/contract_add', array('as'=>'contract_add', 'uses' => 'ContractController@getAddContract'));
    Route::get('/contract_edit/{id}', array('as'=>'contract_edit', 'uses' => 'ContractController@getEditContract'));
    Route::get('/contract_optiuni/{id}', array('as'=>'contract_optiuni', 'uses' => 'ContractController@getOptiuniContract'));
	Route::get('/centralizator_cc_list', array('as'=>'centralizator_cc_list', 'uses' => 'ContractController@getCentralizatorContracteClient'));

	/*Contracte*/
	Route::post('/contract_add', array('as'=>'contract_add', 'uses' => 'ContractController@postAddContract'));
	Route::post('/contract_edit/{id}', array('as'=>'contract_edit', 'uses' => 'ContractController@postEditContract'));
	Route::post('/contract_delete', array('as'=>'contract_delete', 'uses' => 'ContractController@postDeleteContract'));


	/*Contracte - optiuni*/
    Route::get('/stadii_contract/{id}', array('as'=>'stadii_contract', 'uses' => 'ContractOptiuniController@getStadiiContract'));
    Route::get('/garantie_executie/{id}', array('as' => 'garantie_executie', 'uses' => 'ContractOptiuniController@getAddEditGarantieExecutie'));
    Route::get('/garantie_participare/{id}', array('as' => 'garantie_participare', 'uses' => 'ContractOptiuniController@getAddEditGarantieParticipare'));
    /*ruta catre obiectivele contractului este deja creata in partea de Obiective*/

 
    /*Contracte - optiuni*/
    Route::post('/garantie_executie/{id}', array('as' => 'garantie_executie', 'uses' => 'ContractOptiuniController@postAddEditGarantieExecutie'));
    Route::post('/garantie_participare/{id}', array('as' => 'garantie_participare', 'uses' => 'ContractOptiuniController@postAddEditGarantieParticipare'));
       
});