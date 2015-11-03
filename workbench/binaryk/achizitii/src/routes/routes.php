<?php

Route::group(array('after' => 'auth'), function () {
	Binaryk\Models\Sys\Route::make()->define(); 
});

Route::post('get-tip-anunt-by-procedura', [
	'as'   => 'get-tip-anunt-by-procedura',
	'uses' => 'Binaryk\Controllers\Nomenclator\TemplateAchizitiiController@getTipAnuntByTipProcedura'
]);

Route::post('get-modal-modalitati-publicare-by-tip-anunt', [
	'as'   => 'get-modal-modalitati-publicare-by-tip-anunt',
	'uses' => 'Binaryk\Controllers\Nomenclator\TemplateAchizitiiController@getModalFormModalitatiPublicareByTipAnunt'
]);

/* -----------------------------------------------------------------------------
 * Dosare achizitii
 * -----------------------------------------------------------------------------*/

/*
 * Index (Pagina principala)
 */
Route::get('dosar-achizitii/{id_template_achizitii}', [
	'as' => 'dosar-achizitii-index',
	'uses' => 'Binaryk\Controllers\Nomenclator\DosarachizitiiController@index'
]);

/*
 * Inserarea unui document in tabela ach_dosare_achizitii
 */
Route::post('insert-document-dosar-achizitie', [
	'as'   => 'insert-document-dosar-achizitie',
	'uses' => 'Binaryk\Controllers\Nomenclator\DosarachizitiiController@insert'
]);

/*
 * Editarea unui document in tabela ach_dosare_achizitii
 */
Route::post('update-document-dosar-achizitie', [
	'as'   => 'update-document-dosar-achizitie',
	'uses' => 'Binaryk\Controllers\Nomenclator\DosarachizitiiController@update'
]);

/*
 * Stergere unui document in tabela ach_dosare_achizitii
 */
Route::post('delete-document-dosar-achizitie', [
	'as'   => 'delete-document-dosar-achizitie',
	'uses' => 'Binaryk\Controllers\Nomenclator\DosarachizitiiController@delete'
]);

/* -----------------------------------------------------------------------------
 * Proiecte
 * -----------------------------------------------------------------------------*/

/*
 * Index (Pagina principala)
 */
Route::get('lista-proiectelor/{id?}', [
	'as' => 'proiecte-index',
	'uses' => 'Binaryk\Controllers\Nomenclator\ProiecteController@index'
]);

Route::get('lista-proiectelor-row-source/{id?}', [
	'as' => 'proiecte-row-source',
	'uses' => 'Binaryk\Controllers\Nomenclator\ProiecteController@rows'
]);

/* -----------------------------------------------------------------------------
 * Planul de achizitii al unui proiect
 * -----------------------------------------------------------------------------*/

/*
 * Index (Pagina principala)
 */
Route::get('plan-achizitii-proiect/{id_proiect}/{id?}', [
	'as' => 'plan-achizitii-proiect-index',
	'uses' => 'Binaryk\Controllers\Nomenclator\PlanachizitiiproiectController@index'
]);

Route::get('plan-achizitii-proiect-row-source/{id_proiect}/{id?}', [
	'as' => 'plan-achizitii-proiect-row-source',
	'uses' => 'Binaryk\Controllers\Nomenclator\PlanachizitiiproiectController@rows'
]);

Route::post('get-curs-valutar', [
	'as' => 'get-curs-valutar',
	'uses' => 'Binaryk\Controllers\Nomenclator\PlanachizitiiproiectController@getCursValutar'
]);

Route::post('get-form-templates', [
	'as' => 'get-form-templates',
	'uses' => 'Binaryk\Controllers\Nomenclator\PlanachizitiiproiectController@getTemplates'
]);

Route::post('get-template-record', [
	'as' => 'get-template-record',
	'uses' => 'Binaryk\Controllers\Nomenclator\PlanachizitiiproiectController@getTemplateRecord'
]);