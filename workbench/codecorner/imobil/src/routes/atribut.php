<?php

Route::group(array('after' => 'auth'), function () {    
    $ruta_controller = 'Codecorner\\Imobil\\Controllers\\'; 
    
    /*Tip atribut - GET*/
    Route::get('/tipuri_atribute_imobil_list', array('as' => 'tipuri_atribute_imobil_list', 'uses' => $ruta_controller . 'AtributeController@getTipuriAtribute'));
    Route::get('/tip_atribut_add', array('as' => 'tip_atribut_add', 'uses' => $ruta_controller . 'AtributeController@getAddTipAtribut'));
    Route::get('/tip_atribut_edit/{id}', array('as' => 'tip_atribut_edit', 'uses' => $ruta_controller . 'AtributeController@getEditTipAtribut'));

    /*Tip atribut - POST*/
    Route::post('/tip_atribut_delete', array('as' => 'tip_atribut_delete', 'uses' => $ruta_controller . 'AtributeController@postDeleteTipAtribut'));
    Route::post('/tip_atribut_add', array('as' => 'tip_atribut_add', 'uses' => $ruta_controller . 'AtributeController@postAddTipAtribut'));
    Route::post('/tip_atribut_edit/{id}', array('as' => 'tip_atribut_edit', 'uses' => $ruta_controller . 'AtributeController@postEditTipAtribut'));

    /*Atribut - GET*/
    Route::get('/atribute_imobil_list/{id_tip_atribut}/{tip_atribut}', array('as' => 'atribute_imobil_list', 'uses' => $ruta_controller . 'AtributeController@getAtribute'));
    Route::get('/atribut_add/{id_tip_atribut}/{tip_atribut}', array('as' => 'atribut_add', 'uses' => $ruta_controller . 'AtributeController@getAddAtribut'));
    Route::get('/atribut_edit/{id}/{id_tip_atribut}/{tip_atribut}', array('as' => 'atribut_edit', 'uses' => $ruta_controller . 'AtributeController@getEditAtribut'));

    /*Atribut - POST*/
    Route::post('/atribut_delete', array('as' => 'atribut_delete', 'uses' => $ruta_controller . 'AtributeController@postDeleteAtribut'));
    Route::post('/atribut_add/{id_tip_atribut}/{tip_atribut}', array('as' => 'atribut_add', 'uses' => $ruta_controller . 'AtributeController@postAddAtribut'));
    Route::post('/atribut_edit/{id}/{id_tip_atribut}/{tip_atribut}', array('as' => 'atribut_edit', 'uses' => $ruta_controller . 'AtributeController@postEditAtribut'));     
});