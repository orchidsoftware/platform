<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\ScoutServiceProvider;
use Laravel\Ui\UiCommand;
use Laravel\Ui\UiServiceProvider;
use Orchid\Icons\IconServiceProvider;
use Orchid\Platform\Commands\AdminCommand;
use Orchid\Platform\Commands\ChartCommand;
use Orchid\Platform\Commands\FilterCommand;
use Orchid\Platform\Commands\InstallCommand;
use Orchid\Platform\Commands\LinkCommand;
use Orchid\Platform\Commands\ListenerCommand;
use Orchid\Platform\Commands\MetricsCommand;
use Orchid\Platform\Commands\PresenterCommand;
use Orchid\Platform\Commands\RowsCommand;
use Orchid\Platform\Commands\ScreenCommand;
use Orchid\Platform\Commands\SelectionCommand;
use Orchid\Platform\Commands\TableCommand;
use Orchid\Platform\Dashboard;
use Orchid\Presets\Orchid;
use Orchid\Presets\Source;
use Watson\Active\ActiveServiceProvider;

/**
 * Class FoundationServiceProvider.
 * After update run:  php artisan vendor:publish --provider="Orchid\Platform\Providers\FoundationServiceProvider".
 */
class FoundationServiceProvider extends ServiceProvider
{
    /**
     * The available command shortname.
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        LinkCommand::class,
        AdminCommand::class,
        FilterCommand::class,
        RowsCommand::class,
        ScreenCommand::class,
        TableCommand::class,
        ChartCommand::class,
        MetricsCommand::class,
        SelectionCommand::class,
        ListenerCommand::class,
        PresenterCommand::class,
    ];

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this
            ->registerOrchid()
            ->registerAssets()
            ->registerDatabase()
            ->registerConfig()
            ->registerTranslations()
            ->registerBlade()
            ->registerViews()
            ->registerProviders();
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase(): self
    {
        $this->publishes([
            Dashboard::path('database/migrations') => database_path('migrations'),
        ], 'migrations');

        return $this;
    }

    /**
     * Register translations.
     *
     * @return $this
     */
    public function registerTranslations(): self
    {
        $this->loadJsonTranslationsFrom(Dashboard::path('resources/lang/'));

        return $this;
    }

    /**
     * Register config.
     *
     * @return $this
     */
    protected function registerConfig(): self
    {
        $this->publishes([
            Dashboard::path('config/platform.php') => config_path('platform.php'),
        ], 'config');

        return $this;
    }

    /**
     * Register orchid.
     *
     * @return $this
     */
    protected function registerOrchid(): self
    {
        $this->publishes([
            Dashboard::path('stubs/app/routes/') => base_path('routes'),
            Dashboard::path('stubs/app/Orchid/') => app_path('Orchid'),
        ], 'orchid-stubs');

        return $this;
    }

    /**
     * Register assets.
     *
     * @return $this
     */
    protected function registerAssets(): self
    {
        $this->publishes([
            Dashboard::path('resources/js')   => resource_path('js/orchid'),
            Dashboard::path('resources/sass') => resource_path('sass/orchid'),
        ], 'orchid-assets');

        return $this;
    }

    /**
     * @return $this
     */
    public function registerBlade(): self
    {
        Blade::directive('attributes', function (string $attributes) {
            $part = 'function ($attributes) {
                foreach ($attributes as $name => $value) {
                    if (is_null($value)) {
                        continue;
                    }

                    if (is_bool($value) && $value === false) {
                        continue;
                    }
                    if (is_bool($value)) {
                        echo e($name)." ";
                        continue;
                    }

                    if (is_array($value)) {
                        echo json_decode($value)." ";
                        continue;
                    }

                    echo e($name) . \'="\' . e($value) . \'"\'." ";
                }
            }';

            return "<?php call_user_func($part, $attributes); ?>";
        });

        return $this;
    }

    /**
     * Register views & Publish views.
     *
     * @return $this
     */
    public function registerViews(): self
    {
        $path = Dashboard::path('resources/views');

        $this->loadViewsFrom($path, 'platform');

        $this->publishes([
            $path => resource_path('views/vendor/platform'),
        ], 'views');

        return $this;
    }

    /**
     * Register provider.
     */
    public function registerProviders(): void
    {
        foreach ($this->provides() as $provide) {
            $this->app->register($provide);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            UiServiceProvider::class,
            ScoutServiceProvider::class,
            ActiveServiceProvider::class,
            IconServiceProvider::class,
            RouteServiceProvider::class,
            EventServiceProvider::class,
            PlatformServiceProvider::class,
        ];
    }

    /**
     * Register bindings the service provider.
     */
    public function register(): void
    {
        $this->commands($this->commands);

        $this->app->singleton(Dashboard::class, static function () {
            return new Dashboard();
        });

        if (! Route::hasMacro('screen')) {
            Route::macro('screen', function ($url, $screen) {
                /* @var Router $this */
                $route = $this->any($url.'/{method?}', [$screen, 'handle']);

                $methods = $screen::getAvailableMethods();

                if (! empty($methods)) {
                    $route->where('method', implode('|', $methods));
                }

                return $route;
            });
        }

        $this->mergeConfigFrom(
            Dashboard::path('config/platform.php'), 'platform'
        );

        /*
         * Adds Orchid source preset to Laravel's default preset command.
         */

        UiCommand::macro('orchid-source', static function (UiCommand $command) {
            $command->call('vendor:publish', [
                '--provider' => self::class,
                '--tag'      => 'orchid-assets',
                '--force'    => true,
            ]);

            Source::install();
            $command->warn('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
            $command->info('Orchid scaffolding installed successfully.');
        });

        /*
         * Adds Orchid preset to Laravel's default preset command.
         */
        UiCommand::macro('orchid', static function (UiCommand $command) {
            Orchid::install();
            $command->warn('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
            $command->warn("After that, You need to add this line to AppServiceProvider's register method:");
            $command->warn("app(\Orchid\Platform\Dashboard::class)->registerResource('scripts','/js/dashboard.js');");
            $command->info('Orchid scaffolding installed successfully.');
        });
    }
}
