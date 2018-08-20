<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Watson\Active\Active;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Alert;
use Intervention\Image\Facades\Image;
use Orchid\Support\Facades\Dashboard;
use Illuminate\Support\Facades\Schema;
use Orchid\Press\Providers\PressServiceProvider;
use Orchid\Bulldozer\Providers\BulldozerServiceProvider;
use Orchid\Platform\Providers\FoundationServiceProvider;

/**
 * Trait Environment.
 */
trait Environment
{
    /**
     * Setup the test environment.
     */
    protected function setUp()
    {
        parent::setUp();

        Schema::defaultStringLength(191);

        $this->artisan('vendor:publish', [
            '--provider' => 'Orchid\Platform\Providers\FoundationServiceProvider',
        ]);

        $this->artisan('vendor:publish', [
            '--provider' => 'Orchid\Press\Providers\PressServiceProvider',
        ]);

        $this->artisan('vendor:publish', [
            '--all' => true,
        ]);

        $this->artisan('migrate:fresh', [
            '--database' => 'orchid',
        ]);

        $this->artisan('orchid:link');

        $this->withFactories(realpath(PLATFORM_PATH.'/database/factories'));

        $this->artisan('db:seed', [
            '--class' => 'Orchid\Database\Seeds\OrchidDatabaseSeeder',
        ]);

        $this->artisan('make:admin', [
            'name'     => 'admin',
            'email'    => 'admin@admin.com',
            'password' => 'password',
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.debug', true);
        $app['config']->set('auth.providers.users.model', User::class);

        // set up database configuration
        $app['config']->set('database.connections.orchid', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('database.default', 'orchid');
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
            PressServiceProvider::class,
            BulldozerServiceProvider::class,
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
            'Alert'     => Alert::class,
            'Active'    => Active::class,
            'Dashboard' => Dashboard::class,
            'Image'     => Image::class,
        ];
    }
}
