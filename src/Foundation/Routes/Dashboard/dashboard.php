<?php

Route::get('/', [
    'as' => 'dashboard.index',
    'uses' => 'DashboardController@index',
]);
