<?php

/*
|--------------------------------------------------------------------------
| Auth Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group(['middleware' => ['web'], 'prefix' => 'dashboard', 'namespace' => 'Orchid\Foundation\Http\Controllers\Auth'],
    function ($router) {
        // Authentication Routes...
        $router->get('login', 'LoginController@showLoginForm')->name('login');
        $router->post('login', 'LoginController@login');
        $router->post('logout', 'LoginController@logout');

        // Password Reset Routes...
        $router->get('password/reset', 'ForgotPasswordController@showLinkRequestForm');
        $router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
        $router->get('password/reset/{token}', 'ResetPasswordController@showResetForm');
        $router->post('password/reset', 'ResetPasswordController@reset');
    });