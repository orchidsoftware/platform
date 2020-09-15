<?php

declare(strict_types=1);

use Orchid\Platform\Http\Controllers\Auth\LoginController;

// Auth web routes
if (config('platform.auth', true)) {
    // Authentication Routes...
    $this->router->get('login', [LoginController::class, 'showLoginForm'])->name('login');
    $this->router
        ->middleware('throttle:60,1')
        ->post('login', [LoginController::class, 'login'])
        ->name('login.auth');

    $this->router->get('lock', [LoginController::class, 'resetCookieLockMe'])->name('login.lock');
}

$this->router->get('switch-logout', [LoginController::class, 'switchLogout']);
$this->router->post('switch-logout', [LoginController::class, 'switchLogout'])->name('switch.logout');
$this->router->post('logout', [LoginController::class, 'logout'])->name('logout');
