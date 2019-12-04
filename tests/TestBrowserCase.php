<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Orchestra\Testbench\Dusk\TestCase;
use Orchid\Platform\Providers\FoundationServiceProvider;

/**
 * Class TestConsoleCase.
 */
abstract class TestBrowserCase extends TestCase
{
    use Environment {
        Environment::setUp as setEnvUp;
        Environment::getEnvironmentSetUp as getEnvSetUp;
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setEnvUp();

        $this->artisan('orchid:install');

        $this->artisan('vendor:publish', [
            '--provider' => FoundationServiceProvider::class,
            '--force'    => true,
            '--tag'      => [
                'config',
                'migrations',
                'orchid-stubs',
            ], ]);

        $this->artisan('migrate', ['--database' => 'orchid']);
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $this->getEnvSetUp($app);
        config()->set('database.connections.orchid', [
            'driver'                  => 'sqlite',
            'url'                     => env('DATABASE_URL'),
            'database'                => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix'                  => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ]);
    }
}
