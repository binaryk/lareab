<?php

Route::group(array('after' => 'auth'), function () {
	/*Contracte*/
	Route::post('/contract_add', array('as'=>'contract_add', 'uses' => 'ContractController@postAddContract'));
	Route::post('/contract_edit/{id}', array('as'=>'contract_edit', 'uses' => 'ContractController@postEditContract'));
	Route::post('/contract_delete', array('as'=>'contract_delete', 'uses' => 'ContractController@postDeleteContract'));
});