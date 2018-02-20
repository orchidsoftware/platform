<?php

namespace Orchid\Platform\Tests;

use Orchid\Platform\Facades\Alert;
use Orchid\Platform\Core\Models\User;
use Illuminate\Support\Facades\Schema;
use Orchid\Platform\Facades\Dashboard;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Watson\Active\Active;
use Watson\Active\ActiveServiceProvider;

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
            '--all' => true,
        ]);

        $this->artisan('migrate:fresh', [
            '--database' => 'orchid',
        ]);

        $this->artisan('orchid:link');

        $this->withFactories(realpath(DASHBOARD_PATH.'/database/factories'));

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
            'driver'   => 'pgsql',
            'host'     => '127.0.0.1',
            'port'     => '5432',
            'database' => 'platform',
            'username' => 'orchid',
            'password' => 'orchid',
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
            'sslmode'  => 'prefer',
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
            ActiveServiceProvider::class,
            FoundationServiceProvider::class,
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
        ];
    }
}
