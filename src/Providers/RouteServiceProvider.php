<?php

namespace Orchid\Platform\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchid\Defender\Middleware\Firewall;
use Orchid\Platform\Core\Models\Role;
use Orchid\Platform\Http\Middleware\AccessMiddleware;
use Orchid\Platform\Http\Middleware\RedirectInstall;
use Orchid\Platform\Core\Models\Page;
use Orchid\Platform\Core\Models\Post;
use Orchid\Platform\Core\Models\TermTaxonomy;
use Orchid\Platform\Http\Middleware\CanInstall;

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
        Route::middlewareGroup('install', [
            CanInstall::class,
        ]);

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
        Route::bind('role', function ($value) {
            return Role::where('slug', $value)->firstOrFail();
        });

        Route::bind('orchid_public', function ($path) {
            $path = str_replace("..", "", $path);
            $path = realpath(DASHBOARD_PATH . '/public/' . $path);

            if ($path !== false) {
                return $path;
            }

            abort(404);
        });

        Route::bind('category', function ($value) {
            return TermTaxonomy::findOrFail($value);
        });

        Route::bind('type', function ($value) {
            $post = new Post();
            $type = $post->getBehavior($value)->getBehaviorObject();

            return $type;
        });

        Route::bind('slug', function ($value) {
            if (is_numeric($value)) {
                return Post::where('id', $value)->firstOrFail();
            }

            return Post::findOrFail($value);
        });

        Route::bind('page', function ($value) {
            if (is_numeric($value)) {
                $page = Page::where('id', $value)->first();
            } else {
                $page = Page::where('slug', $value)->first();
            }
            if (is_null($page)) {
                return new Page([
                    'slug' => $value,
                ]);
            }

            return $page;
        });

    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        if (config('platform.headless')) {
            return null;
        }


        foreach (glob(DASHBOARD_PATH . '/routes/*/*.php') as $file) {
            $this->loadRoutesFrom($file);
        }
    }
}
