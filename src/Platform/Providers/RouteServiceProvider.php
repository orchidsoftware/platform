<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Http\Middleware\Access;
use Orchid\Platform\Http\Middleware\Turbo;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @internal param Router $router
     */
    public function boot()
    {
        Route::middlewareGroup('platform', [
            Turbo::class,
            Access::class,
        ]);

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        /*
         * Dashboard
         */
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->as('platform.')
            ->middleware(config('platform.middleware.private'))
            ->group(Dashboard::path('routes/dashboard.php'));

        /*
         * Auth
         */
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->as('platform.')
            ->middleware(config('platform.middleware.public'))
            ->group(Dashboard::path('routes/auth.php'));

        /*
         * Application
         */
        if (file_exists(base_path('routes/platform.php'))) {
            Route::domain((string) config('platform.domain'))
                ->prefix(Dashboard::prefix('/'))
                ->middleware(config('platform.middleware.private'))
                ->group(base_path('routes/platform.php'));
        }
    }
}
