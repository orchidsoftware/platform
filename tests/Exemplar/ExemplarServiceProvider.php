<?php

declare(strict_types=1);

namespace Orchid\Tests\Exemplar;

use Orchid\Platform\Dashboard;
use Illuminate\Support\ServiceProvider;

class ExemplarServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(Dashboard::path('tests/Exemplar/views'), 'exemplar');
    }
}
