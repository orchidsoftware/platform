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
//    Route::post('route', 'PostApiController@store');
});