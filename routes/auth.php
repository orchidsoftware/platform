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
        'prefix'     => \Orchid\Platform\Dashboard::prefix(),
        'namespace'  => 'Orchid\Platform\Http\Controllers\Auth',
    ], function (\Illuminate\Routing\Router $router) {
        if (config('platform.auth.display', true)) {
            // Authentication Routes...
            $router->get('login', 'LoginController@showLoginForm')->name('platform.login');
            $router->post('login', 'LoginController@login')->name('platform.login.auth');

            // Password Reset Routes...
            $this->get('password/reset',
                'ForgotPasswordController@showLinkRequestForm')->name('platform.password.request');
            $this->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('platform.password.email');
            $this->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('platform.password.reset');
            $this->post('password/reset', 'ResetPasswordController@reset');
        }

        $router->post('logout', 'LoginController@logout')->name('platform.logout');
    });
});
