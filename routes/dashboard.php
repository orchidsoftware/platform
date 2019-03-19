<?php

declare(strict_types=1);

use Orchid\Platform\Http\Screens\AnnouncementScreen;
use Orchid\Platform\Http\Controllers\Systems\IndexController;
use Orchid\Platform\Http\Controllers\Systems\SearchController;

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

$this->router->post('/search/{query}', [SearchController::class, 'index'])->name('search');

$this->router->screen('/announcement', AnnouncementScreen::class)->name('systems.announcement');
