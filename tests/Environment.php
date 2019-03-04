<?php

declare(strict_types=1);

namespace Orchid\Tests;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;
use Orchid\Platform\Models\User;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Press\Providers\PressServiceProvider;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Dashboard;
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
    protected function setUp() : void
    {
        parent::setUp();

        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(realpath('./database/migrations'));
        $this->artisan('migrate', ['--database' => 'orchid']);

        $this->withFactories(realpath(PLATFORM_PATH.'/database/factories'));

        $this->artisan('db:seed', [
            '--class' => 'Orchid\Database\Seeds\OrchidDatabaseSeeder',
        ]);

        $this->artisan('orchid:admin', [
            'name'     => 'admin',
            'email'    => 'admin@admin.com',
            'password' => 'password',
        ]);

        $this->artisan('config:clear');
        $this->artisan('cache:clear');
        $this->artisan('view:clear');
        $this->artisan('route:clear');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app->make(Factory::class)->load(realpath(PLATFORM_PATH . '/database/factories'));

        $app['config']->set('app.debug', true);
        $app['config']->set('auth.providers.users.model', User::class);

        // set up database configuration
        $app['config']->set('database.connections.orchid', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('scout.driver', null);
        $app['config']->set('database.default', 'orchid');

        $app['config']->set('sluggable', [
            'source'             => null,
            'maxLength'          => null,
            'maxLengthKeepWords' => true,
            'method'             => null,
            'separator'          => '-',
            'unique'             => true,
            'uniqueSuffix'       => null,
            'includeTrashed'     => false,
            'reserved'           => null,
            'onUpdate'           => false,
        ]);
        $app['config']->set('session', [
            'driver'          => 'file',
            'lifetime'        => 10,
            'expire_on_close' => false,
            'encrypt'         => false,
            'files'           => storage_path('framework/sessions'),
            'connection'      => null,
            'table'           => 'sessions',
            'store'           => null,
            'lottery'         => [2, 100],
            'cookie'          => Str::slug(env('APP_NAME', 'laravel'), '_').'_session',
            'path'            => '/',
            'domain'          => null,
            'secure'          => false,
            'http_only'       => true,
            'same_site'       => null,
        ]);

        $app['config']->set('breadcrumbs', [
            'view'                                     => 'breadcrumbs::bootstrap4',
            'files'                                    => base_path('routes/breadcrumbs.php'),
            'unnamed-route-exception'                  => false,
            'missing-route-bound-breadcrumb-exception' => false,
            'invalid-named-breadcrumb-exception'       => false,
            'manager-class'                            => \DaveJamesMiller\Breadcrumbs\BreadcrumbsManager::class,
            'generator-class'                          => \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator::class,
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
            PressServiceProvider::class,
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
