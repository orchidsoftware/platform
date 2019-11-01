<?php

declare(strict_types=1);

namespace Orchid\Tests\Exemplar;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;

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
