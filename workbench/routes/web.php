<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Orchid\Support\Facades\Orchid;

Route::get('/', fn () => to_route('orchid.index'));

Route::domain((string) config('orchid.domain'))
    ->prefix(Orchid::prefix('/'))
    ->middleware(config('orchid.middleware.private'))
    ->group(Orchid::path('stubs/app/routes/orchid.php'));
