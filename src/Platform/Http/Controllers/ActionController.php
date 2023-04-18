<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Screen;

class ActionController extends Controller
{
    /**
     * @param string $screen
     * @param string $method
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    public function __invoke(string $screen, string $method)
    {
        $screen = config('platform.state.crypt', false) === true
            ? Crypt::decryptString($screen)
            : base64_decode($screen);

        /** @var Screen $screen */
        $screen = app($screen);

        abort_unless($screen::isMethodAvailable($method), 404);

        $route = Route::getRoutes()->match(request()->create(url()->previous())) ?? Route::current();

        Route::substituteBindings($route);
        Route::substituteImplicitBindings($route);

        return $screen->callMethod($method, [
            ...request()->query->all(),
            ...$route->parameters(),
        ]);
    }
}
