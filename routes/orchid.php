<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Controllers\AsyncController;
use Orchid\Platform\Http\Controllers\AttachmentController;
use Orchid\Platform\Http\Controllers\IndexController;
use Orchid\Platform\Http\Controllers\RelationController;
use Orchid\Platform\Http\Controllers\SearchController;
use Orchid\Platform\Http\Controllers\SortableController;
use Orchid\Platform\Http\Controllers\NotificationController;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Main Entry Point & Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/', [IndexController::class, 'index'])
    ->name('index')
    ->breadcrumbs(fn (Trail $trail) => $trail->push(__('Home'), route('orchid.index')));

/*
|--------------------------------------------------------------------------
| Global Search
|--------------------------------------------------------------------------
*/
Route::post('search/{query}', [SearchController::class, 'search'])
    ->where('query', '.*')
    ->name('search');

/*
|--------------------------------------------------------------------------
| Async / AJAX Handlers
|--------------------------------------------------------------------------
*/
Route::post('async', [AsyncController::class, 'load'])
    ->name('async');

Route::post('listener/{screen}/{layout}', [AsyncController::class, 'listener'])
    ->name('async.listener');

/*
|--------------------------------------------------------------------------
| File & Media Management
|--------------------------------------------------------------------------
*/
Route::post('files', [AttachmentController::class, 'upload'])
    ->name('files.upload');

Route::post('media', [AttachmentController::class, 'media'])
    ->name('files.media');

Route::post('files/sort', [AttachmentController::class, 'sort'])
    ->name('files.sort');

Route::delete('files/{id}', [AttachmentController::class, 'destroy'])
    ->name('files.destroy');

Route::put('files/post/{id}', [AttachmentController::class, 'update'])
    ->name('files.update');

/*
|--------------------------------------------------------------------------
| Relation Field Rendering
|--------------------------------------------------------------------------
*/
Route::post('relation', RelationController::class)
    ->name('relation');

/*
|--------------------------------------------------------------------------
| Sortable / Drag-and-Drop Ordering
|--------------------------------------------------------------------------
*/
Route::post('sorting', [SortableController::class, 'saveSortOrder'])
    ->name('sorting');

/*
|--------------------------------------------------------------------------
| Notifications (optional)
|--------------------------------------------------------------------------
*/
if (config('orchid.notifications.enabled', true)) {

    Route::post('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.markAsRead');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.markAllAsRead');

    Route::post('/notifications/unread-count', [NotificationController::class, 'unreadCount'])
        ->name('notifications.unreadCount');
}

/*
|--------------------------------------------------------------------------
| Fallback Route (catch-all)
|--------------------------------------------------------------------------
*/
if (config('orchid.fallback', true)) {
    Route::fallback([IndexController::class, 'fallback']);
}
