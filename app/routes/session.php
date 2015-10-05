<?php

Route::group(array('after' => 'auth'), function () {
	Route::post('/session/change_session_user', 'UserController@postChangeSessionUser');
    Route::post('/session/change_session_admin', 'UserController@postChangeSessionAdmin');
});