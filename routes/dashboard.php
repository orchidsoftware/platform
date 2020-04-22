<?php

declare(strict_types=1);

use Orchid\Breadcrumbs\Trail;
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
$this->router->get('/', [IndexController::class, 'index'])
    ->name('index')
    ->breadcrumbs(function (Trail $trail){
        return $trail->push(__('Main'), route('platform.index'));
    });

$this->router->fallback([IndexController::class, 'fallback']);

$this->router->screen('search/{query}', SearchScreen::class)
    ->name('search')
    ->breadcrumbs(function (Trail $trail, string $query) {
        return $trail->parent('platform.index')
            ->push(__('Search'))
            ->push($query);
    });

$this->router->screen('notifications/{id?}', NotificationScreen::class)
    ->name('notifications')
    ->breadcrumbs(function (Trail $trail) {
        return $trail->parent('platform.index')
            ->push(__('Notifications'));
    });

$this->router->post('/api/notifications', [NotificationScreen::class, 'unreadNotification'])
    ->name('api.notifications');
