<?php

/*
|--------------------------------------------------------------------------
| Dashboard Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->get('/', [
    'as'   => 'platform.index',
    'uses' => 'DashboardController@index',
]);

$this->fallback(function () {
    return view('platform::errors.404');
});