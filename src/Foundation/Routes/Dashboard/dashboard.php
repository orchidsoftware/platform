<?php


/*
|--------------------------------------------------------------------------
| Dashboard Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

Route::get('/', [
    'as' => 'dashboard.index',
    'uses' => 'DashboardController@index',
]);
