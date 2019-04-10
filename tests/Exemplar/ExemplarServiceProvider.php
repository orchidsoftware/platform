<?php

declare(strict_types=1);

namespace Orchid\Tests\Exemplar;

use Illuminate\Support\ServiceProvider;

class ExemplarServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(PLATFORM_PATH . '/tests/Exemplar/views', 'exemplar');
    }

}
