<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;

class ExemplarServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(Dashboard $dashboard): void
    {
        $dashboard->registerSearch([
            User::class,
        ]);

        $this->loadViewsFrom($dashboard->path('tests/App/Views'), 'exemplar');
    }
}
