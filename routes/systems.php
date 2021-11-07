<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Controllers\AttachmentController;
use Orchid\Platform\Http\Controllers\RelationController;

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
