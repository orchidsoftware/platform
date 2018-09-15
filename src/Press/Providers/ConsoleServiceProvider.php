<?php

declare(strict_types=1);

namespace Orchid\Press\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Press\Commands\MakeManyBehavior;
use Orchid\Press\Commands\MakeSingleBehavior;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * The available command shortname.
     *
     * @var array
     */
    protected $commands = [
        MakeManyBehavior::class,
        MakeSingleBehavior::class,
    ];

    /**
     * Register the commands.
     */
    public function register()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        foreach ($this->commands as $command) {
            $this->commands($command);
        }
    }
}
