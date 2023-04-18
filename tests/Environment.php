<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchid\Platform\Database\Seeders\OrchidDatabaseSeeder;
use Orchid\Platform\Models\User;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Dashboard;
use Orchid\Tests\App\ExemplarServiceProvider;
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
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\BreadcrumbsServiceProvider;
use Watson\Active\Active;

/**
 * Trait Environment.
 */
trait Environment
{
    /**
     * Setup the test environment.
     * Run test: php vendor/bin/phpunit --coverage-html ./logs/coverage ./tests
     * Run 1 test:  php vendor/bin/phpunit  --filter= UserTest tests\\Unit\\Platform\\UserTest --debug.
     */
    protected function setUp(): void
    {
        parent::setUp();

        /* Refresh application for route/breadcrumbs/orchid provider */
        if (! $this->app['router']->has('platform.main')) {
            $this->refreshApplication();
            $this->defineDatabaseMigrations();
        }

        Factory::guessFactoryNamesUsing(function ($factory) {
            $factoryBasename = class_basename($factory);

            return "Orchid\Platform\Database\Factories\\$factoryBasename".'Factory';
        });

        $this->artisan('db:seed', [
            '--class' => OrchidDatabaseSeeder::class,
        ]);
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(realpath('./database/migrations'));
        $this->artisan('orchid:install');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        $config = config();

        $config->set('app.debug', true);
        $config->set('auth.providers.users.model', User::class);
        $config->set('platform.state.crypt', false);

        // set up database configuration
        $config->set('database.connections.orchid', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $config->set('scout.driver', 'collection');
        $config->set('database.default', 'orchid');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            BreadcrumbsServiceProvider::class,
            FoundationServiceProvider::class,
            ExemplarServiceProvider::class,
        ];
    }

    /**
     * Define routes setup.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function defineRoutes($router)
    {
        $router->domain((string) config('platform.domain'))
            ->prefix(\Orchid\Platform\Dashboard::prefix('/'))
            ->middleware(config('platform.middleware.private'))
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

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Alert'       => Alert::class,
            'Active'      => Active::class,
            'Breadcrumbs' => Breadcrumbs::class,
            'Dashboard'   => Dashboard::class,
        ];
    }
}
