<?php

declare(strict_types=1);

namespace Orchid\Press\Providers;

use Illuminate\Support\Str;
use Orchid\Platform\Dashboard;
use Orchid\Press\Entities\Many;
use Orchid\Press\Entities\Single;
use Illuminate\Support\Facades\View;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\ServiceProvider;
use Orchid\Press\Http\Composers\PressMenuComposer;
use Orchid\Press\Http\Composers\SystemMenuComposer;

class PressServiceProvider extends ServiceProvider
{
    /**
     * @var Dashboard
     */
    protected $dashboard;

    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;

        $this->dashboard
            ->registerEntities($this->findEntities())
            ->registerPermissions($this->registerPermissionsEntities())
            ->registerPermissions($this->registerPermissions());

        View::composer('platform::layouts.dashboard', PressMenuComposer::class);
        View::composer('platform::container.systems.index', SystemMenuComposer::class);
    }

    /**
     * @return array
     */
    public function findEntities() : array
    {
        $namespace = app()->getNamespace();
        $directory = app_path('Orchid/Entities');
        $resources = [];

        if (! is_dir($directory)) {
            return [];
        }

        foreach ((new Finder)->in($directory)->files() as $resource) {
            $resource = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($resource->getPathname(), app_path().DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($resource, Many::class) ||
                is_subclass_of($resource, Single::class)) {
                $resources[] = $resource;
            }
        }

        return collect($resources)->sort()->all();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerDatabase()
            ->registerConfig()
            ->registerProviders();
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase()
    {
        $this->loadMigrationsFrom(realpath(PLATFORM_PATH.'/database/migrations/press'));

        return $this;
    }

    /**
     * Register config.
     *
     * @return $this
     */
    protected function registerConfig()
    {
        $this->publishes([
            realpath(PLATFORM_PATH.'/config/press.php') => config_path('press.php'),
        ]);

        return $this;
    }

    /**
     * Register provider.
     */
    public function registerProviders()
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
    public function provides()
    {
        return [
            ConsoleServiceProvider::class,
            RoutePressServiceProvider::class,
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsEntities(): array
    {
        $posts = $this->dashboard
            ->getEntities()
            ->where('display', true)
            ->map(function ($post) {
                return [
                    'slug'        => 'platform.posts.type.'.$post->slug,
                    'description' => $post->name,
                ];
            });

        if ($posts->count() > 0) {
            $permissions[__('Posts')] = $posts->toArray();
        }

        return $permissions ?? [];
    }

    /**
     * @return array
     */
    protected function registerPermissions(): array
    {
        return [
            __('Systems') => [
                [
                    'slug'        => 'platform.systems.menu',
                    'description' => __('Menu'),
                ],
                [
                    'slug'        => 'platform.systems.media',
                    'description' => __('Media'),
                ],
            ],
        ];
    }
}
