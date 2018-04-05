<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Orchid\Platform\Kernel\Dashboard;
use Illuminate\Support\ServiceProvider;

class DashboardProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $dashboard
            ->registerFields(config('platform.fields'))
            ->registerManyBehavior(config('platform.many'))
            ->registerSingleBehavior(config('platform.single'))
            ->registerResource(config('platform.resource', []));
    }
}
