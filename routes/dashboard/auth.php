<?php

/*
|--------------------------------------------------------------------------
| Auth Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->domain(config('platform.domain'))->group(function () {

    $this->group([
        'middleware' => config('platform.middleware.public'),
        'prefix'     => \Orchid\Platform\Kernel\Dashboard::prefix(),
        'namespace'  => 'Orchid\Platform\Http\Controllers\Auth',
    ], function (\Illuminate\Routing\Router $router) {
        if (config('platform.auth.display', true)) {
            // Authentication Routes...
            $router->get('login', 'LoginController@showLoginForm')->name('dashboard.login');
            $router->post('login', 'LoginController@login')->name('dashboard.login.auth');

            // Password Reset Routes...
            $this->get('password/reset',
                'ForgotPasswordController@showLinkRequestForm')->name('dashboard.password.request');
            $this->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('dashboard.password.email');
            $this->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('dashboard.password.reset');
            $this->post('password/reset', 'ResetPasswordController@reset');
        }

        $router->post('logout', 'LoginController@logout')->name('dashboard.logout');
    });

});
