<?php

declare(strict_types=1);

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

$this->post('/search/{query}', 'Controllers\Systems\SearchController@index')->name('platform.search');

$this->screen('/backups', 'Screens\BackupScreen', 'platform.systems.backups');
$this->screen('/announcement', 'Screens\AnnouncementScreen', 'platform.systems.announcement');
$this->screen('/history', 'Screens\HistoryScreen', 'platform.systems.history');
