<?php

namespace Orchid\Foundation\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Orchid\Foundation\Core\Models\Post;
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
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function map(Router $router)
    {
        $router->middleware('dashboard', AccessMiddleware::class);
        $router->group(['middleware' => ['web', 'dashboard'], 'prefix' => 'dashboard', 'namespace' => $this->namespace],
            function ($router) {
                require __DIR__.'/../Http/Routes/dashboard.php';
            });

        $router->group(['middleware' => ['web'], 'prefix' => 'dashboard', 'namespace' => $this->namespace],
            function ($router) {
                // Authentication Routes...
                $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
                $this->post('login', 'Auth\LoginController@login');
                $this->post('logout', 'Auth\LoginController@logout');

                // Password Reset Routes...
                $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
                $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
                $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
                $this->post('password/reset', 'Auth\ResetPasswordController@reset');
            });


        $this->binding($router);
    }

    /**
     * @param Router $router
     */
    public function binding(Router $router)
    {
        $router->bind('type', function ($value) {
            $post = new Post();

            return $post->getType($value);
        });
        $router->bind('slug', function ($value) {
            return Post::where('slug', $value)->firstOrFail();
        });
    }
}
