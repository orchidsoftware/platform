<?php

declare(strict_types=1);

use Orchid\Platform\Http\Screens\BackupScreen;
use Orchid\Platform\Http\Screens\HistoryScreen;
use Orchid\Platform\Http\Screens\AnnouncementScreen;
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
$this->get('/', function () {
    return redirect()->route(config('platform.index'));
})->name('platform.index');

$this->fallback(function () {
    return view('platform::errors.404');
});

$this->post('/search/{query}', [SearchController::class, 'index'])->name('platform.search');

$this->screen('/backups', BackupScreen::class, 'platform.systems.backups');
$this->screen('/announcement', AnnouncementScreen::class, 'platform.systems.announcement');
$this->screen('/history', HistoryScreen::class, 'platform.systems.history');
