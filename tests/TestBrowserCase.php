<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Faker\Factory as Faker;
use Faker\Generator;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Dusk\Options;
use Orchestra\Testbench\Dusk\TestCase;
use Orchid\Platform\Models\User;

abstract class TestBrowserCase extends TestCase
{
    use WithWorkbench;

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
    protected function defineEnvironment($app): void
    {
        $app['config']->set('orchid.prevents_abandonment', false);
    }

    public static function defineWebDriverOptions(): void
    {
        Options::windowSize(1440, 900);

        if (isset($_SERVER['CI'])) {
            Options::withoutUI();
            Options::noSandbox();
            Options::addArgument('--disable-dev-shm-usage');
        }
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->runLaravelMigrations();
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
