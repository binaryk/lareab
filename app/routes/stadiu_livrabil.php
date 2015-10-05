<?php

Route::group(array('after' => 'auth'), function () 
{
   	/*GET*/
	Route::get('/stadiu_livrabil/{id}', array('as' => 'stadiu_livrabil', 'uses' => 'StadiuLivrabilController@getStadii'));
	
	/*POST*/
	Route::post('/stadiu_livrabil/{id}', array('as' => 'stadiu_livrabil', 'uses' => 'StadiuLivrabilController@postSchimbaStadiu'));
});