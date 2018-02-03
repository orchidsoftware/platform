<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     */
    public function boot()
    {
        Blade::directive('widget', function ($expression) {
            $segments = explode(',', preg_replace("/[\(\)\\\]/", '', $expression));

            if (! array_key_exists(1, $segments)) {
                return '<?php echo (new \Orchid\Platform\Widget\Widget)->get('.$segments[0].'); ?>';
            }

            return '<?php echo (new \Orchid\Platform\Widget\Widget)->get('.$segments[0].','.$segments[1].'); ?>';
        });
    }
}
