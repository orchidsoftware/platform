<?php

declare(strict_types=1);

use Orchid\Platform\Http\Controllers\AsyncController;
use Orchid\Platform\Http\Controllers\IndexController;
use Orchid\Platform\Http\Screens\NotificationScreen;
use Orchid\Platform\Http\Screens\SearchScreen;
use Orchid\Platform\Http\Controllers\AttachmentController;
use Orchid\Platform\Http\Controllers\RelationController;
use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;

// Index and default...
Route::get('/', [IndexController::class, 'index'])
    ->name('index')
    ->breadcrumbs(function (Trail $trail) {
        return $trail->push(__('Home'), route('platform.index'));
    });

Route::screen('search/{query}', SearchScreen::class)
    ->name('search')
    ->breadcrumbs(function (Trail $trail, string $query) {
        return $trail->parent('platform.index')
            ->push(__('Search'))
            ->push($query);
    });

Route::post('async/{screen}/{method?}/{template?}', [AsyncController::class, 'load'])
    ->name('async');

// TODO: Remove group
Route::prefix('systems')->group(function () {
    Route::post('files', [AttachmentController::class, 'upload'])
        ->name('systems.files.upload');

    Route::post('media', [AttachmentController::class, 'media'])
        ->name('systems.files.media');

    Route::post('files/sort', [AttachmentController::class, 'sort'])
        ->name('systems.files.sort');

    Route::delete('files/{id}', [AttachmentController::class, 'destroy'])
        ->name('systems.files.destroy');

    Route::put('files/post/{id}', [AttachmentController::class, 'update'])
        ->name('systems.files.update');

    Route::post('relation', [RelationController::class, 'view'])
        ->name('systems.relation');
});


if (config('platform.notifications.enabled', true)) {
    Route::screen('notifications/{id?}', NotificationScreen::class)
        ->name('notifications')
        ->breadcrumbs(function (Trail $trail) {
            return $trail->parent('platform.index')
                ->push(__('Notifications'));
        });

    Route::post('api/notifications', [NotificationScreen::class, 'unreadNotification'])
        ->name('api.notifications');
}

if (config('platform.fallback', true)) {
    Route::fallback([IndexController::class, 'fallback']);
}
