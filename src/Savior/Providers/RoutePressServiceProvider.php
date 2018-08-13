<?php

declare(strict_types=1);

namespace Orchid\Savior\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RoutePressServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Orchid\Savior\Http';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @internal param Router $router
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/savior'))
            ->middleware(config('platform.middleware.private'))
            ->namespace($this->namespace)
            ->group(realpath(PLATFORM_PATH.'/routes/savior.php'));
    }
}
