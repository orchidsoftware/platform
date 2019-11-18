<?php

declare(strict_types=1);

use Orchid\Platform\Http\Controllers\Systems\IndexController;
use Orchid\Platform\Http\Screens\NotificationScreen;
use Orchid\Platform\Http\Screens\SearchScreen;

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
$this->router->fallback([IndexController::class, 'fallback']);


$this->router->screen('search/{query}', SearchScreen::class)->name('search');
$this->router->screen('notifications/{id?}', NotificationScreen::class)->name('notifications');

$this->router->post('notice', [NotificationScreen::class, 'updateProfile'])->name('profile.notifications');
