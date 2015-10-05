<?php

Route::group(array('after' => 'auth'), function () {
	/*GET*/
	Route::get('/serii_facturare', array('as'=>'serii_facturare', 'uses' => 'SerieFacturareController@getSeriiFacturare'));
	Route::get('/serie_facturare_add', array('as'=>'serie_facturare_add', 'uses' => 'SerieFacturareController@getAddSerie'));
	Route::get('/serie_facturare_edit/{id}', array('as'=>'serie_facturare_edit', 'uses' => 'SerieFacturareController@getEditSerie'));

	/*POST*/
	Route::post('/serie_facturare_add', array('as'=>'serie_facturare_add', 'uses' => 'SerieFacturareController@postAddSerie'));
	Route::post('/serie_facturare_delete', array('as'=>'serie_facturare_delete', 'uses' => 'SerieFacturareController@postDeleteSerie'));
	Route::post('/serie_facturare_edit/{id}', array('as'=>'serie_facturare_edit', 'uses' => 'SerieFacturareController@postEditSerie'));
});