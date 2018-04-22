<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Base64Url\Base64Url;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Core\Models\Page;
use Orchid\Press\Models\Post;
use Orchid\Platform\Models\Role;
use Orchid\Press\Models\Category;
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
            if (is_numeric($value)) {
                return Role::where('id', $value)->firstOrFail();
            }

            return Role::where('slug', $value)->firstOrFail();
        });

        Route::bind('category', function ($value) {
            if (is_numeric($value)) {
                return Category::where('id', $value)->firstOrFail();
            }

            return Category::findOrFail($value);
        });

        Route::bind('type', function ($value) {
            $post = new Post();
            $type = $post->getBehavior($value)->getBehaviorObject();

            return $type;
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

        Route::bind('post', function ($value) {
            if (is_numeric($value)) {
                return Post::where('id', $value)->firstOrFail();
            }

            return Post::where('slug', $value)->firstOrFail();
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
            return;
        }

        foreach (glob(DASHBOARD_PATH.'/routes/*.php') as $file) {
            $this->loadRoutesFrom($file);
        }

        if (file_exists(base_path('routes/dashboard.php'))) {
            Route::prefix('dashboard')
                ->middleware('api')
                ->namespace('App\Http\Controllers')
                ->group(base_path('routes/dashboard.php'));
        }
    }
}
