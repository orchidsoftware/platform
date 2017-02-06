<?php

namespace Orchid\Foundation\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Core\Models\TermTaxonomy;
use Orchid\Foundation\Http\Middleware\AccessMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Orchid\Foundation\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->binding();

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        //$router->middleware('dashboard', AccessMiddleware::class);

        foreach (glob(__DIR__.'/../Routes/*/*.php') as $file) {
            $this->loadRoutesFrom($file);
        }
    }

    /**
     * Route binding.
     */
    public function binding()
    {
        Route::bind('category', function ($value) {
            return TermTaxonomy::findOrFail($value);
        });

        Route::bind('type', function ($value) {
            $post = new Post();

            return $post->getType($value);
        });

        Route::bind('slug', function ($value) {
            if (is_numeric($value)) {
                return Post::where('id', $value)->firstOrFail();
            }

            return Post::where('slug', $value)->firstOrFail();
        });
    }
}
