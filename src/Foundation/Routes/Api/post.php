<?php

/*
|--------------------------------------------------------------------------
| Post API Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

Route::group(['middleware' => ['api'], 'prefix'=> 'api', 'namespace' => 'Orchid\Foundation\Http\Controllers\Api'], function ($router) {
    Route::resource('type', 'PostApiController');
});
