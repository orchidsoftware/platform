<?php

namespace Orchid\Tests;

use Illuminate\Support\Facades\Schema;
use Intervention\Image\Facades\Image;
use Orchid\Boot\Providers\BootServiceProvider;
use Orchid\Platform\Models\User;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Press\Providers\PressServiceProvider;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Dashboard;
use Watson\Active\Active;

trait Environment
{
    /**
     * Setup the test environment.
     */
    public function setUp()
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
            '--class' => 'OrchidDatabaseSeeder',
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
            BootServiceProvider::class,
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
