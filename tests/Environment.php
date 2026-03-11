<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Orchestra\Testbench\Concerns\WithLaravelMigrations;
use Orchid\Platform\Database\Seeders\OrchidDatabaseSeeder;
use Orchid\Platform\Models\User;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Orchid;
use Orchid\Tests\App\ExemplarServiceProvider;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\BreadcrumbsServiceProvider;
use Watson\Active\Active;

/**
 * Trait Environment.
 */
trait Environment
{
    use WithLaravelMigrations;

    /**
     * Setup the test environment.
     * Run test: php vendor/bin/phpunit --coverage-html ./logs/coverage ./tests
     * Run 1 test:  php vendor/bin/phpunit  --filter= UserTest tests\\Unit\\Platform\\UserTest --debug.
     */
    protected function setUp(): void
    {
        parent::setUp();

        /* Refresh application for route/breadcrumbs/orchid provider */
        if (! $this->app['router']->has('orchid.main')) {
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
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        config()->set('auth.providers.users.model', User::class);
    }

    /**
     * @param Application $app
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
     * @param Router $router
     *
     * @return void
     */
    protected function defineRoutes($router)
    {
        // Define routes.
    }

    /**
     * @param Application $app
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Alert'       => Alert::class,
            'Active'      => Active::class,
            'Breadcrumbs' => Breadcrumbs::class,
            'Orchid'      => Orchid::class,
        ];
    }
}
