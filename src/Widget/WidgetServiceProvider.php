<?php

declare(strict_types=1);

namespace Orchid\Widget;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class WidgetServiceProvider.
 */
class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot()
    {
        Blade::directive('widget', function ($expression) {
            $segments = explode(',', preg_replace("/[\(\)\\\]/", '', $expression));

            if (!array_key_exists(1, $segments)) {
                return '<?php echo (new \Orchid\Widget\Widget)->get(' . $segments[0] . '); ?>';
            }

            return '<?php echo (new \Orchid\Widget\Widget)->get(' . $segments[0] . ',' . $segments[1] . '); ?>';
        });
    }
}
