<?php

declare(strict_types=1);

use Orchid\Platform\Http\Controllers\Systems\IndexController;
use Orchid\Platform\Http\Screens\NotificationScreen;
use Orchid\Platform\Http\Screens\SearchScreen;
use Orchid\Platform\Http\Controllers\Systems\AsyncController;
/*
|--------------------------------------------------------------------------
| Dashboard Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

// Index and default...
$this->router->get('/', [IndexController::class, 'index'])->name('index');
$this->router->post('/async/{screen}/{method?}/{template?}', [AsyncController::class, 'load'])->name('async');

$this->router->fallback([IndexController::class, 'fallback']);

$this->router->screen('search/{query}', SearchScreen::class)->name('search');
$this->router->screen('notifications/{id?}', NotificationScreen::class)->name('notifications');

$this->router->post('/api/notifications', [NotificationScreen::class, 'unreadNotification'])
    ->name('api.notifications');
