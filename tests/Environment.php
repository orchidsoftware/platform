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
     * @param  \Illuminate\Routing\Router  $router
     *
     * @return void
     */
    protected function defineRoutes($router)
    {
        // Define routes.
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
