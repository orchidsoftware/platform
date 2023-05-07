<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Faker\Factory as Faker;
use Faker\Generator;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\Dusk\Options;
use Orchestra\Testbench\Dusk\TestCase;
use Orchid\Platform\Models\User;

/**
 * Class TestConsoleCase.
 */
abstract class TestBrowserCase extends TestCase
{
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
     * @param Application $app
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

        config()->set('platform.prevents_abandonment', false);

        if (isset($_SERVER['CI'])) {
            Options::withoutUI();
        }
    }

    protected function createAdminUser(array $attributes = []): User
    {
        if ($this->user === null) {
            $this->user = User::factory()->create($attributes);
        }

        return $this->user;
    }

    protected function faker(): Generator
    {
        if ($this->faker === null) {
            $this->faker = Faker::create();
        }

        return $this->faker;
    }
}
