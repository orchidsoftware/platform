<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Middleware\Access;
use Orchid\Platform\Http\Middleware\Turbo;
use Orchid\Platform\Orchid;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @internal param Router $router
     */
    public function boot()
    {
        Route::middlewareGroup('orchid', [
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
         * Dashboard routes.
         *
         * The dashboard routes have a subdomain of the platform.domain config value,
         * a prefix consisting of the Dashboard::prefix() method return value,
         * an alias of 'platform.', middleware from the platform.middleware.private config value,
         * and are defined in the Dashboard::path('routes/orchid.php') file.
         */
        Route::domain((string) config('orchid.domain'))
            ->prefix(Orchid::prefix('/'))
            ->as('orchid.')
            ->middleware(config('orchid.middleware.private'))
            ->group(Orchid::path('routes/orchid.php'));

        /*
         * Auth routes.
         *
         * The auth routes have a subdomain of the platform.domain config value,
         * a prefix consisting of the Dashboard::prefix() method return value,
         * an alias of 'platform.', middleware from the platform.middleware.public config value,
         * and are defined in the Dashboard::path('routes/auth.php') file.
         */
        Route::domain((string) config('orchid.domain'))
            ->prefix(Orchid::prefix('/'))
            ->as('orchid.')
            ->middleware(config('orchid.middleware.public'))
            ->group(Orchid::path('routes/auth.php'));

        /*
         * Application routes.
         *
         * If the 'routes/platform.php' file exists, its routes have a subdomain of the platform.domain config value,
         * a prefix consisting of the Dashboard::prefix() method return value,
         * and middleware from the platform.middleware.private config value.
         */
        if (file_exists(base_path('routes/orchid.php'))) {
            Route::domain((string) config('orchid.domain'))
                ->prefix(Orchid::prefix('/'))
                //->as(config('orchid.routes.name'))
                ->middleware(config('orchid.middleware.private'))
                ->group(base_path('routes/orchid.php'));
        }
    }
}
