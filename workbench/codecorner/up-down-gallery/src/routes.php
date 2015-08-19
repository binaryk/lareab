<?php

Route::group(array('after' => 'auth'), function () {
	$ruta_controller = 'Codecorner\\UpDownGallery\\Controllers\\';	
	
    /*POST*/        
    Route::post('/document_upload/{id}', array('as' => 'document_upload', 'uses' => $ruta_controller . 'DosarContractController@postUploadDocument'));
    Route::post('/document_delete', array('as' => 'document_delete', 'uses' => $ruta_controller . 'DosarContractController@postDeleteDocument'));

    /*GET*/
    Route::get('/document_list/{id}', array('as' => 'document_list', 'uses' => $ruta_controller . 'DosarContractController@getDocumente'));
    Route::get('/document_upload/{id}', array('as' => 'document_upload', 'uses' => $ruta_controller . 'DosarContractController@getUploadDocument'));
    Route::get('/document_download/{filename}/{guid}/{id}', array('as' => 'document_download', 'uses' => $ruta_controller . 'DosarContractController@postDownloadDocument'));

});