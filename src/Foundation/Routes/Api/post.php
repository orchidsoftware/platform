<?php

/*
|--------------------------------------------------------------------------
| Post API Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/
Route::group(['namespace' => 'Api'], function () {
    Route::resource('type', 'PostApiController');
});
