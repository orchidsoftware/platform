<?php

declare(strict_types=1);

use Orchid\Platform\Http\Controllers\Auth\LoginController;
use Orchid\Platform\Http\Controllers\Auth\ResetPasswordController;
use Orchid\Platform\Http\Controllers\Auth\ForgotPasswordController;

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
    $this->get('login', [LoginController::class, 'showLoginForm'])->name('platform.login');
    $this->post('login', [LoginController::class, 'login'])->name('platform.login.auth');

    // Password Reset Routes...
    $this->get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('platform.password.request');
    $this->post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('platform.password.email');
    $this->get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('platform.password.reset');
    $this->post('password/reset', [ResetPasswordController::class, 'reset']);
}

$this->post('logout', [LoginController::class, 'logout'])->name('platform.logout');
