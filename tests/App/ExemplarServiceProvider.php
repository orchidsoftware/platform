<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Orchid;
use Orchid\Tests\App\Fields\BaseSelectScreen;
use Orchid\Tests\App\Screens\AsyncHeaderButtonActionScreen;
use Orchid\Tests\App\Screens\ConfirmScreen;
use Orchid\Tests\App\Screens\DependentListenerModalScreen;
use Orchid\Tests\App\Screens\DependentListenerScreen;
use Orchid\Tests\App\Screens\ItemAddChildScreen;
use Orchid\Tests\App\Screens\ItemListScreen;
use Orchid\Tests\App\Screens\MethodsResponseScreen;
use Orchid\Tests\App\Screens\ModalValidationScreen;
use Orchid\Tests\App\Screens\ModelAutoOpenScreen;
use Orchid\Tests\App\Screens\NestedTargetsDependentSumListenerScreen;
use Orchid\Tests\App\Screens\PropertyAutoWriteScreen;
use Orchid\Tests\App\Screens\UnaccessedScreen;

class ExemplarServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(Orchid $dashboard, Router $router): void
    {
        $dashboard->registerSearch([
            SearchUser::class,
        ]);

        $this->loadViewsFrom($dashboard->path('tests/App/Views'), 'exemplar');

        $router->domain((string) config('orchid.domain'))
            ->prefix(Orchid::prefix('/'))
            ->middleware(config('orchid.middleware.private'))
            ->as('test.')
            ->group(function ($route) {
                $route->screen('modal-validation', ModalValidationScreen::class)->name('modal-validation');
                $route->screen('modal-open', ModelAutoOpenScreen::class)->name('modal-open');
                $route->screen('dependent-listener-nested-targets', NestedTargetsDependentSumListenerScreen::class)->name('dependent-listener-nested-targets');
                $route->screen('dependent-listener', DependentListenerScreen::class)->name('dependent-listener');
                $route->screen('dependent-listener-modal', DependentListenerModalScreen::class)->name('dependent-listener-modal');
                $route->screen('methods-response', MethodsResponseScreen::class)->name('methods-response');
                $route->screen('confirm', ConfirmScreen::class)->name('confirm');
                $route->screen('async-header-button-action', AsyncHeaderButtonActionScreen::class)->name('async-header-button-action');
                $route->screen('write-only-public-property', PropertyAutoWriteScreen::class)->name('write-only-public-property');

                $route->screen('unaccessed', UnaccessedScreen::class)->name('unaccessed');

                // Fields
                $route->screen('fields/base-select-screen', BaseSelectScreen::class)->name('base-select-screen');

                //issue 2517
                $route->screen('item/{parentId}/addChild', ItemAddChildScreen::class)->name('item.addchild');
                $route->screen('items', ItemListScreen::class)->name('items');
            });
    }
}
