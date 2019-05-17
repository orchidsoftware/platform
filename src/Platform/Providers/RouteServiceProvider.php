<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\Role;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Middleware\AccessMiddleware;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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
            AccessMiddleware::class,
        ]);

        $this->binding();

        require PLATFORM_PATH.'/routes/breadcrumbs.php';

        parent::boot();
    }

    /**
     * Route binding.
     */
    public function binding()
    {
        Route::bind('roles', function ($value) {
            $role = Dashboard::modelClass(Role::class);

            return is_numeric($value)
                ? $role->where('id', $value)->firstOrFail()
                : $role->where('slug', $value)->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        /*
         * Public
         */
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->as('platform.')
            ->group(realpath(PLATFORM_PATH.'/routes/public.php'));

        /*
         * Dashboard
         */
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->as('platform.')
            ->middleware(config('platform.middleware.private'))
            ->group(realpath(PLATFORM_PATH.'/routes/dashboard.php'));

        /*
         * Auth
         */
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->as('platform.')
            ->middleware(config('platform.middleware.public'))
            ->group(realpath(PLATFORM_PATH.'/routes/auth.php'));

        /*
         * Systems
         */
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/systems'))
            ->as('platform.')
            ->middleware(config('platform.middleware.private'))
            ->group(realpath(PLATFORM_PATH.'/routes/systems.php'));

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
