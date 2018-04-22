<?php

declare(strict_types=1);

namespace Orchid\Press;

use Orchid\Press\Models\Page;
use Orchid\Press\Models\Post;
use Orchid\Platform\Dashboard;
use Orchid\Press\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class RoutePressServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Orchid\Press\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @internal param Router $router
     */
    public function boot()
    {
        $this->binding();

        parent::boot();
    }

    /**
     * Route binding.
     */
    public function binding()
    {
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
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/press'))
            ->middleware(config('platform.middleware.private'))
            ->namespace('Orchid\Press\Http\Controllers')
            ->group(realpath(DASHBOARD_PATH.'/routes/press.php'));
    }
}
