<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Auth Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

if (config('platform.auth', true)) {
    // Authentication Routes...
    $this->get('login', 'LoginController@showLoginForm')->name('platform.login');
    $this->post('login', 'LoginController@login')->name('platform.login.auth');

    // Password Reset Routes...
    $this->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('platform.password.request');
    $this->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('platform.password.email');
    $this->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('platform.password.reset');
    $this->post('password/reset', 'ResetPasswordController@reset');
}

$this->post('logout', 'LoginController@logout')->name('platform.logout');
