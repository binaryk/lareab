<?php

Route::group(array('after' => 'auth'), function () 
{
   	/*GET*/
    Route::get('/obiectiv/{id}', array('as' => 'obiectiv_single', 'uses' => 'ContractController@getObiectivSingle'));    
    Route::get('/obiectiv_list', array('as'=>'obiectiv_list', 'uses' => 'ObiectivController@getObiective'));
    Route::get('/obiectiv_list/{id}', array('as'=>'obiectiv_list_contract', 'uses' => 'ObiectivController@getObiective'));
    Route::get('/obiectiv_add', array('as'=>'obiectiv_add', 'uses' => 'ObiectivController@getAddObiectiv'));
    Route::get('/obiectiv_add/{id}', array('as'=>'obiectiv_add_contract', 'uses' => 'ObiectivController@getAddObiectiv'));
    Route::get('/obiectiv_edit/{id}', array('as'=>'obiectiv_edit', 'uses' => 'ObiectivController@getEditObiectiv'));

	/*POST*/
	Route::post('/obiectiv_add', array('as'=>'obiectiv_add', 'uses' => 'ObiectivController@postAddObiectiv'));
    Route::post('/obiectiv_add/{id}', array('as' => 'obiectiv_add_contract', 'uses' => 'ObiectivController@postAddObiectiv'));
    Route::post('/obiectiv_edit/{id}', array('as'=>'obiectiv_edit', 'uses' => 'ObiectivController@postEditObiectiv'));
    Route::post('/obiectiv_delete', array('as'=>'obiectiv_delete', 'uses' => 'ObiectivController@postDeleteObiectiv'));
});