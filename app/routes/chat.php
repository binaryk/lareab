<?php

Route::group(array('after' => 'auth'), function () {
    /* POST */
    Route::post('/chat/sendMessage', 'ChatController@sendMessage');
    Route::post('/chat/checkForMessages', 'ChatController@checkForMessages');
    Route::post('/chat/getConversation', 'ChatController@getConversation');

    /* GET */
    Route::get('/chat/checkForMessages', 'ChatController@checkForMessages');
    Route::get('/chat/updateActivity', 'ChatController@updateActivity');
    Route::get('/chat/checkActivity', 'ChatController@checkActivity');

});