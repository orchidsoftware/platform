<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;
use Orchid\Tests\App\Screens\DependentListenerScreen;
use Orchid\Tests\App\Screens\ModalValidationScreen;

class ExemplarServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(Dashboard $dashboard, Router $router): void
    {
        $dashboard->registerSearch([
            SearchUser::class,
        ]);

        $this->loadViewsFrom($dashboard->path('tests/App/Views'), 'exemplar');

        $router->domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->middleware(config('platform.middleware.private'))
            ->as('test.')
            ->group(function ($route) {
                $route->screen('modal-validation', ModalValidationScreen::class)->name('modal-validation');
                $route->screen('dependent-listener', DependentListenerScreen::class)->name('dependent-listener');
            });
    }
}
