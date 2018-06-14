<?php

declare(strict_types=1);

namespace Orchid\Press\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
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
            ->registerEntities(config('press.entities', []))
            ->registerPermissions($this->registerPermissionsEntities())
            ->registerPermissions($this->registerPermissions());

        $this->registerDatabase()
            ->registerConfig()
            ->registerProviders();

        View::composer('platform::layouts.dashboard', PressMenuComposer::class);
        View::composer('platform::container.systems.index', SystemMenuComposer::class);
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
            ->map(function($post) {
                return [
                    'slug'        => 'platform.posts.type.'.$post->slug,
                    'description' => $post->name,
                ];
            });

        if ($posts->count() > 0) {
            $permissions[trans('platform::permission.main.posts')] = $posts->toArray();
        }

        return $permissions ?? [];
    }

    /**
     * @return array
     */
    protected function registerPermissions(): array
    {
        return [
            trans('platform::permission.main.main') => [
                [
                    'slug'        => 'platform.posts',
                    'description' => trans('platform::permission.main.posts'),
                ],
            ],
            trans('platform::permission.main.systems') => [
                [
                    'slug'        => 'platform.systems.menu',
                    'description' => trans('platform::permission.systems.menu'),
                ],
                [
                    'slug'        => 'platform.systems.category',
                    'description' => trans('platform::permission.systems.category'),
                ],
                [
                    'slug'        => 'platform.systems.comment',
                    'description' => trans('platform::permission.systems.comment'),
                ],
                [
                    'slug'        => 'platform.systems.media',
                    'description' => trans('platform::permission.systems.media'),
                ],
            ],
        ];
    }
}
