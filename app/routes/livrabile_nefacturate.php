<?php

Route::group(array('after' => 'auth'), function () 
{    
    /*POST*/
    Route::post('/livrabile_nefacturate_client', array('as' => 'genereaza_desfasurator_client', 'uses' => 'LivrabileController@postGenereazaDesfasuratorClient'));
    Route::post('/livrabile_nefacturate_furnizor', array('as' => 'genereaza_desfasurator_furnizor', 'uses' => 'LivrabileController@postGenereazaDesfasuratorFurnizor'));       

    /*GET*/
    Route::get('/livrabile_nefacturate_client', array('as' => 'livrabile_nefacturate_client', 'uses' => 'LivrabileController@getLivrabileNefacturateClient'));
    Route::get('/livrabile_nefacturate_furnizor', array('as' => 'livrabile_nefacturate_furnizor', 'uses' => 'LivrabileController@getLivrabileNefacturateFurnizor'));
    
});