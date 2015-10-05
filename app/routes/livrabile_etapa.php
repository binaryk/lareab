<?php

Route::group(array('after' => 'auth'), function () 
{
    /*GET*/   
    Route::get('/livrabile_etapa_list/{id}', array('as'=>'livrabile_etapa_list', 'uses' => 'LivrabileEtapaController@getLivrabile'));
    Route::get('/livrabile_etapa_add/{id}', array('as'=>'livrabile_etapa_add', 'uses' => 'LivrabileEtapaController@getAddLivrabilEtapa'));	       
    
    /*POST*/   
    Route::post('/livrabile_etapa_add/{id}', array('as'=>'livrabile_etapa_add', 'uses' => 'LivrabileEtapaController@postAddLivrabilEtapa'));        
    Route::post('/livrabile_etapa_delete', array('as'=>'livrabile_etapa_delete', 'uses' => 'LivrabileEtapaController@postDeleteLivrabilEtapa'));           
});