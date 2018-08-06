<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

/**
 * Class RouteBootServiceProvider.
 */
class RouteBulldozerServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Orchid\Bulldozer\Http\Controllers';

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
            ->prefix(Dashboard::prefix('/bulldozer'))
            ->middleware(config('platform.middleware.private'))
            ->namespace($this->namespace)
            ->group(realpath(PLATFORM_PATH.'/routes/bulldozer.php'));
    }
}
