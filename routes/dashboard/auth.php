<?php

/*
|--------------------------------------------------------------------------
| Auth Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['web','dashboard'],
    'prefix'     => 'dashboard',
    'namespace'  => 'Orchid\Http\Controllers\Auth',
],
    function (\Illuminate\Routing\Router $router) {
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
