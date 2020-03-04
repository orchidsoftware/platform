<?php

declare(strict_types=1);

namespace Orchid\Tests;

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Orchestra\Testbench\Dusk\Options;
use Orchid\Database\Seeds\OrchidDatabaseSeeder;
use Orchid\Platform\Models\User;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Dashboard;
use Orchid\Tests\Exemplar\ExemplarServiceProvider;
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

        /* Install application */
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(realpath('./database/migrations'));
        $this->artisan('orchid:install');

        /* Refresh application for route/breadcrumbs/orchid provider */
        if (!$this->app['router']->has('platform.main')) {
            $this->refreshApplication();
            $this->loadLaravelMigrations();
            $this->loadMigrationsFrom(realpath('./database/migrations'));
        }

        $this->withFactories(Dashboard::path('database/factories'));

        $this->artisan('db:seed', [
            '--class' => OrchidDatabaseSeeder::class,
        ]);

        $this->artisan('orchid:admin', [
            'name'     => 'admin',
            'email'    => 'admin@admin.com',
            'password' => 'password',
        ]);

        if (env('GITHUB_TOKEN') !== null) {
            Options::withoutUI();
        }
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
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
        $config->set('scout.driver', null);
        $config->set('database.default', 'orchid');

        $config->set('breadcrumbs', [
            'view'                                     => 'breadcrumbs::bootstrap4',
            'files'                                    => base_path('routes/breadcrumbs.php'),
            'unnamed-route-exception'                  => false,
            'missing-route-bound-breadcrumb-exception' => false,
            'invalid-named-breadcrumb-exception'       => false,
            'manager-class'                            => BreadcrumbsManager::class,
            'generator-class'                          => BreadcrumbsGenerator::class,
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FoundationServiceProvider::class,
            ExemplarServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Alert'       => Alert::class,
            'Active'      => Active::class,
            'Breadcrumbs' => Breadcrumbs::class,
            'Dashboard'   => Dashboard::class,
        ];
    }
}
