<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Controllers\ResourceController;

Route::get('resources/{package}/{patch}', [ResourceController::class, 'show'])
    ->where('patch', '.*')
    ->name('resource');
