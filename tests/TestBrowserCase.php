<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Faker\Factory as Faker;
use Faker\Generator;
use Orchestra\Testbench\Dusk\TestCase;
use Orchid\Platform\Models\User;

/**
 * Class TestConsoleCase.
 */
abstract class TestBrowserCase extends TestCase
{
    /**
     * @var string
     */
    protected static $baseServeHost = '127.0.0.1';

    /**
     * @var int
     */
    protected static $baseServePort = 9292;


    use Environment {
        Environment::getEnvironmentSetUp as getEnvSetUp;
    }

    /**
     * @var User
     */
    private $user;

    /**
     * @var Generator
     */
    private $faker;

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

    /**
     * @return User
     */
    protected function createAdminUser()
    {
        if ($this->user === null) {
            $this->user = factory(User::class)->create();
        }

        return $this->user;
    }

    /**
     * @return Generator
     */
    protected function faker()
    {
        if ($this->faker === null) {
            $this->faker = Faker::create();
        }

        return $this->faker;
    }
}
