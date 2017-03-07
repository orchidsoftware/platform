<?php

namespace Orchid\Macros;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Orchid\Facades\Dashboard;

class Page
{
    /**
     * @var
     */
    public $routeMenu;

    /**
     * Rote pages macro register.
     */
    public function register()
    {
        $page = $this;
        Route::macro('page', function ($name, $url, $view, $data = []) use ($page) {
            Dashboard::routeMenu()->add($url, $name);

            if (View::exists($view)) {
                return Route::get($url, '\Orchid\Macros\Page@handle')
                    ->defaults('view', compact('view', 'data'));
            } else {
                return Route::get($url, $view)
                    ->defaults('view', compact('view', 'data'));
            }
        });
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param $view
     * @param $data
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function handle($view, $data)
    {
        return view($view, $data);
    }

    /**
     * Extract the redirect data from the route and call the handler.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters['view']);
    }
}
