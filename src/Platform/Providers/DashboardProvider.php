<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Orchid\Platform\Kernel\Dashboard;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Fields\FieldStorage;
use Orchid\Platform\Behaviors\Storage\ManyBehaviorStorage;
use Orchid\Platform\Behaviors\Storage\SingleBehaviorStorage;

class DashboardProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $dashboard->registerStorage('fields', new FieldStorage);
        $dashboard->registerStorage('pages', new SingleBehaviorStorage);
        $dashboard->registerStorage('posts', new ManyBehaviorStorage);

        foreach (config('platform.resource.stylesheets', []) as $stylesheet) {
            $dashboard->registerResource('stylesheets', $stylesheet);
        }

        foreach (config('platform.resource.scripts', []) as $script) {
            $dashboard->registerResource('scripts', $script);
        }
    }
}
