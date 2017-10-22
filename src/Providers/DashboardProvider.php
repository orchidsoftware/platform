<?php

namespace Orchid\Platform\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Behaviors\Storage\ManyBehaviorStorage;
use Orchid\Platform\Behaviors\Storage\SingleBehaviorStorage;
use Orchid\Platform\Field\FieldStorage;
use Orchid\Platform\Kernel\Dashboard;

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
    }
}
