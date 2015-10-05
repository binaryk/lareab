<?php

Route::group(array('after' => 'auth'), function () 
{
	Route::get('/modifica_utilizator_actual', array('as' => 'modifica_utilizator_actual','uses' => 'UserController@getIndex'));
	Route::get('/profil_utilizator_actual', array('as' => 'profil_utilizator_actual','uses' => 'UserController@getSettings'));
});