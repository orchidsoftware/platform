<?php

namespace Orchid\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchid\Defender\Middleware\Firewall;
use Orchid\Http\Middleware\AccessMiddleware;
use Orchid\Http\Middleware\RedirectInstall;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Orchid\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @internal param Router $router
     */
    public function boot()
    {
        Route::middlewareGroup('dashboard', [
            Firewall::class,
            RedirectInstall::class,
        ]);

        Route::middlewareGroup('access', [
            Firewall::class,
            AccessMiddleware::class,
        ]);

        $this->binding();

        parent::boot();
    }

    /**
     * Route binding.
     */
    public function binding()
    {

    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        foreach (glob(DASHBOARD_PATH . '/routes/*/*.php') as $file) {
            $this->loadRoutesFrom($file);
        }
    }
}
