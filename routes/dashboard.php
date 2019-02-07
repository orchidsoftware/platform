<?php

declare(strict_types=1);

use Orchid\Platform\Http\Screens\BackupScreen;
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
$this->get('/', [IndexController::class, 'index'])->name('platform.index');
$this->fallback([IndexController::class, 'fallback']);

$this->post('/search/{query}', [SearchController::class, 'index'])->name('platform.search');

$this->screen('/backups', BackupScreen::class)->name('platform.systems.backups');
$this->screen('/announcement', AnnouncementScreen::class)->name('platform.systems.announcement');
