<?php

declare(strict_types=1);

use Orchid\Platform\Http\Controllers\Systems\AsyncController;
use Orchid\Platform\Http\Controllers\Systems\IndexController;
use Orchid\Platform\Http\Screens\NotificationScreen;
use Orchid\Platform\Http\Screens\SearchScreen;
use Tabuna\Breadcrumbs\Trail;

// Index and default...
$this->router->get('/', [IndexController::class, 'index'])
    ->name('index')
    ->breadcrumbs(function (Trail $trail) {
        return $trail->push(__('Main'), route('platform.index'));
    });

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

$this->router->post('api/notifications', [NotificationScreen::class, 'unreadNotification'])
    ->name('api.notifications');

$this->router->post('async/{screen}/{method?}/{template?}', [AsyncController::class, 'load'])->name('async');
$this->router->fallback([IndexController::class, 'fallback']);
