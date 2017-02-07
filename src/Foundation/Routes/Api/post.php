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
    Route::get('type/{type?}', 'PostApiController@index');
    Route::get('type/{type}/{slug}', 'PostApiController@show');
    Route::post('type/{type}', 'PostApiController@store');

    Route::get('category', 'CategoryApiController@store');
    Route::get('category/{slug}', 'CategoryApiController@show');

    Route::get('tags', 'TagsApiController@index');
});
