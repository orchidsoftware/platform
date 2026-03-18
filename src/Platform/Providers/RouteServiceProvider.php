<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Middleware\Access;
use Orchid\Platform\Http\Middleware\BladeIcons;
use Orchid\Platform\Http\Middleware\Turbo;
use Orchid\Support\Facades\Orchid;

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
            BladeIcons::class,
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
         * The dashboard routes have a subdomain of the orchid.domain config value,
         * a prefix consisting of the Orchid::prefix() method return value,
         * an alias of 'orchid.', middleware from the orchid.middleware.private config value,
         * and are defined in the Orchid::path('routes/orchid.php') file.
         */
        Route::domain((string) config('orchid.domain'))
            ->prefix(Orchid::prefix('/'))
            ->as('orchid.')
            ->middleware(config('orchid.middleware.private'))
            ->group(Orchid::path('routes/orchid.php'));

        /*
         * Auth routes.
         *
         * The auth routes have a subdomain of the orchid.domain config value,
         * a prefix consisting of the Orchid::prefix() method return value,
         * an alias of 'orchid.', middleware from the orchid.middleware.public config value,
         * and are defined in the Orchid::path('routes/auth.php') file.
         */
        Route::domain((string) config('orchid.domain'))
            ->prefix(Orchid::prefix('/'))
            ->as('orchid.')
            ->middleware(config('orchid.middleware.public'))
            ->group(Orchid::path('routes/auth.php'));

        /*
         * Application routes.
         *
         * If the 'routes/orchid.php' file exists, its routes have a subdomain of the orchid.domain config value,
         * a prefix consisting of the Orchid::prefix() method return value,
         * and middleware from the orchid.middleware.private config value.
         */
        if (file_exists(base_path('routes/orchid.php'))) {
            Route::domain((string) config('orchid.domain'))
                ->prefix(Orchid::prefix('/'))
                ->middleware(config('orchid.middleware.private'))
                ->group(base_path('routes/orchid.php'));
        }
    }
}
