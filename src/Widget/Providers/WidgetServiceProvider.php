<?php

namespace Orchid\Widget\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;
use Orchid\Widget\Console\MakeWidget;

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
        $this->registerConfig();
        Blade::directive('widget', function ($key) {
            return "<?php echo (new \\Orchid\\Widget\\Service\\Widget)->get({$key}); ?>";
        });
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/widget.php' => config_path('widget.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/widget.php', 'widget'
        );
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands(MakeWidget::class);
    }
}
