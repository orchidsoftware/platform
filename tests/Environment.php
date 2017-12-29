<?php

namespace Orchid\Platform\Tests;

use Illuminate\Support\Facades\Schema;
use Orchid\Platform\Facades\Alert;
use Orchid\Platform\Facades\Dashboard;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Watson\Active\Facades\Active;

trait Environment
{

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        Schema::defaultStringLength(191);

        $this->loadLaravelMigrations('orchid');

        $this->artisan('migrate', [
           '--database' => 'orchid',
       ]);
        $this->withFactories(__DIR__ . '/../database/factories');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
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
            'Dashboard' => Dashboard::class,
            'Alert'     => Alert::class,
            'Active'    => Active::class,
        ];
    }


    public static function setUpBeforeClass()
    {
        static::serve();
    }

    public static function tearDownAfterClass()
    {
        static::stopServing();
    }
}
