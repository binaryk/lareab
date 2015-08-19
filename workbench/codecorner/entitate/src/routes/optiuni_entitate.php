<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\Entitate\\Controllers\\';
	
    /*GET*/
    Route::get('/optiuni_entitate/{id}', array('as' => 'optiuni_entitate', 'uses' => $ruta_controller . 'OptiuniEntitateController@getOptiuniEntitate'));   
});