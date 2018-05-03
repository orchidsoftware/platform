<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Base64Url\Base64Url;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\Role;
use Illuminate\Support\Facades\Route;
use Orchid\Widget\WidgetContractInterface;
use Orchid\Platform\Http\Middleware\AccessMiddleware;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Orchid\Platform\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @internal param Router $router
     */
    public function boot()
    {
        Route::middlewareGroup('dashboard', [
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
        Route::bind('role', function ($value) {
            $role = Dashboard::model(Role::class);

            if (is_numeric($value)) {
                return $role->where('id', $value)->firstOrFail();
            }

            return $role->where('slug', $value)->firstOrFail();
        });

        Route::bind('widget', function ($value) {
            try {
                $widget = app()->make(Base64Url::decode($value));
            } catch (\Exception $exception) {
                return abort(404);
            }

            if (! is_a($widget, WidgetContractInterface::class)) {
                return abort(404);
            }

            return $widget;
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->loadRoutesFrom(realpath(DASHBOARD_PATH.'/routes/dashboard.php'));
        $this->loadRoutesFrom(realpath(DASHBOARD_PATH.'/routes/auth.php'));
        $this->loadRoutesFrom(realpath(DASHBOARD_PATH.'/routes/systems.php'));

        if (file_exists(base_path('routes/dashboard.php'))) {
            Route::domain((string) config('platform.domain'))
                ->prefix(Dashboard::prefix('/'))
                ->middleware(config('platform.middleware.private'))
                ->namespace('App\Http\Controllers')
                ->group(base_path('routes/dashboard.php'));
        }
    }
}
