<?php

namespace Orchid\Platform\Tests;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class TestServiceProvider extends LaravelServiceProvider
{

    /**
     * @inheritdoc
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(
            __DIR__ . '/database/migrations'
        );
    }
}
