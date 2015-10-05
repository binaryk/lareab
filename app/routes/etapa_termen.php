<?php

Route::group(array('after' => 'auth'), function () 
{
   	/*GET*/
    Route::get('/etapa_list/{id}', array('as'=>'etapa_list', 'uses' => 'EtapeTermeneController@getEtape'));
    Route::get('/etapa_add/{id}', array('as'=>'etapa_add', 'uses' => 'EtapeTermeneController@getAddEtapa'));
    Route::get('/etapa_edit/{id}', array('as'=>'etapa_edit', 'uses' => 'EtapeTermeneController@getEditEtapa'));

	/*POST*/
    Route::post('/etapa_add/{id}', array('as'=>'etapa_add', 'uses' => 'EtapeTermeneController@postAddEtapa'));
    Route::post('/etapa_edit/{id}', array('as'=>'etapa_edit', 'uses' => 'EtapeTermeneController@postEditEtapa'));
    Route::post('/etapa_delete', array('as'=>'etapa_delete', 'uses' => 'EtapeTermeneController@postDeleteEtapa'));        
});