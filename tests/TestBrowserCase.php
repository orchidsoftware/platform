<?php

declare(strict_types=1);

namespace Orchid\Tests;

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager;
use Orchestra\Testbench\Dusk\TestCase;
use Orchid\Database\Seeds\OrchidDatabaseSeeder;
use Orchid\Platform\Models\User;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Support\Facades\Dashboard;

/**
 * Class TestConsoleCase.
 */
abstract class TestBrowserCase extends TestCase
{
    use Environment;

    /**
     * Setup the test environment.
     * Run test: php vendor/bin/phpunit --coverage-html ./logs/coverage ./tests
     * Run 1 test:  php vendor/bin/phpunit  --filter= UserTest tests\\Unit\\Platform\\UserTest --debug.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(realpath('./database/migrations'));
        $this->artisan('migrate', ['--database' => 'orchid']);


        $this->artisan('vendor:publish',
        [
            '--force' => true,
            '--tag'   => 'migrations',
        ]);

       $this->artisan('vendor:publish', [
            '--provider' => FoundationServiceProvider::class,
            '--force'    => true,
            '--tag'      => [
                'config',
                'migrations',
                'orchid-stubs',
            ], ]);

        $this->artisan('migrate', ['--database' => 'orchid']);


        $this->withFactories(Dashboard::path('database/factories'));

        $this->artisan('db:seed', [
            '--class' => OrchidDatabaseSeeder::class,
        ]);

        $this->artisan('orchid:admin', [
            'name'     => 'admin',
            'email'    => 'admin@admin.com',
            'password' => 'password',
        ]);
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $config = config();

        $config->set('app.debug', true);
        $config->set('auth.providers.users.model', User::class);
        $config->set('database.default', 'sqlite');
        $config->set('database.connections.orchid', [
            'driver'                  => 'sqlite',
            'url'                     => env('DATABASE_URL'),
            'database'                => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix'                  => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ]);

        $config->set('scout.driver', null);

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
}
