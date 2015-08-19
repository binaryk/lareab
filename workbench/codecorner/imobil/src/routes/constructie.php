<?php

Route::group(array('after' => 'auth'), function () {    
    $ruta_controller = 'Codecorner\\Imobil\\Controllers\\'; 
    
    /*Categorie constructie - get*/
    Route::get('/categorie_constructie_list', array('as' => 'categorie_constructie_list', 'uses' => $ruta_controller . 'CategorieConstructieController@getCategoriiConstructie'));
    Route::get('/categorie_constructie_add', array('as' => 'categorie_constructie_add', 'uses' => $ruta_controller . 'CategorieConstructieController@getAddCategorieConstructie'));
    Route::get('/categorie_constructie_edit/{id}', array('as' => 'categorie_constructie_edit', 'uses' => $ruta_controller . 'CategorieConstructieController@getEditCategorieConstructie'));

    /*Categorie constructie - post*/
    Route::post('/categorie_constructie_delete', array('as' => 'categorie_constructie_delete', 'uses' => $ruta_controller . 'CategorieConstructieController@postDeleteCategorieConstructie'));
    Route::post('/categorie_constructie_add', array('as' => 'categorie_constructie_add', 'uses' => $ruta_controller . 'CategorieConstructieController@postAddCategorieConstructie'));
    Route::post('/categorie_constructie_edit/{id}', array('as' => 'categorie_constructie_edit', 'uses' => $ruta_controller . 'CategorieConstructieController@postEditCategorieConstructie'));

    /*Tip constructie - get*/
    Route::get('/destinatie_constructie_list', array('as' => 'destinatie_constructie_list', 'uses' => $ruta_controller . 'DestinatieConstructieController@getTipuriConstructie'));
    Route::get('/destinatie_constructie_list/{id_categorie}', array('as' => 'destinatie_constructie_list_categorie', 'uses' => $ruta_controller . 'DestinatieConstructieController@getTipuriConstructieCategorie'));
    Route::get('/destinatie_constructie_add', array('as' => 'destinatie_constructie_add', 'uses' => $ruta_controller . 'DestinatieConstructieController@getAddTipConstructie'));
    Route::get('/destinatie_constructie_edit/{id}', array('as' => 'destinatie_constructie_edit', 'uses' => $ruta_controller . 'DestinatieConstructieController@getEditTipConstructie'));

    /*Tip constructie - post*/
    Route::post('destinatie_constructie_delete', array('as' => 'destinatie_constructie_delete', 'uses' => $ruta_controller . 'DestinatieConstructieController@postDeleteTipConstructie'));
    Route::post('destinatie_constructie_add', array('as' => 'destinatie_constructie_add', 'uses' => $ruta_controller . 'DestinatieConstructieController@postAddTipConstructie'));
    Route::post('destinatie_constructie_edit/{id}', array('as' => 'destinatie_constructie_edit', 'uses' => $ruta_controller . 'DestinatieConstructieController@postEditTipConstructie'));
     
});