<?php
Route::group(array('after' => 'auth'), function () {
	
	Binaryk\Models\Sys\Route::make()->define(); 

});