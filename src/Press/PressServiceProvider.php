<?php

declare(strict_types=1);

namespace Orchid\Press;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;
use Orchid\Press\Http\Composers\PressMenuComposer;

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
            ->registerBehaviors(config('press.behaviors', []))
            ->registerPermissions($this->registerPermissionsMain())
            ->registerPermissions($this->registerPermissionsBehaviors())
            ->registerPermissions($this->registerPermissionsSystems());

        $this->registerDatabase()
            ->registerConfig()
            ->registerProviders();


        View::composer('dashboard::layouts.dashboard', PressMenuComposer::class);
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase()
    {
        $this->loadMigrationsFrom(realpath(DASHBOARD_PATH . '/database/migrations/press'));

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
            realpath(DASHBOARD_PATH . '/config/press.php') => config_path('press.php'),
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
            RoutePressServiceProvider::class,
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsMain(): array
    {
        return [
            trans('dashboard::permission.main.main') => [
                [
                    'slug'        => 'dashboard.posts',
                    'description' => trans('dashboard::permission.main.posts'),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsBehaviors(): array
    {
        $posts = $this->dashboard
            ->getBehaviors()
            ->where('display', true)
            ->map(function ($post) {
                return [
                    'slug'        => 'dashboard.posts.type.' . $post->slug,
                    'description' => $post->name,
                ];
            });

        if ($posts->count() > 0) {
            $permissions[trans('dashboard::permission.main.posts')] = $posts->toArray();
        }

        return $permissions ?? [];
    }

    /**
     * @return array
     */
    protected function registerPermissionsSystems(): array
    {
        return [
            trans('dashboard::permission.main.systems') => [
                [
                    'slug'        => 'dashboard.systems.menu',
                    'description' => trans('dashboard::permission.systems.menu'),
                ],
                [
                    'slug'        => 'dashboard.systems.category',
                    'description' => trans('dashboard::permission.systems.category'),
                ],
                [
                    'slug'        => 'dashboard.systems.comment',
                    'description' => trans('dashboard::permission.systems.comment'),
                ],
                [
                    'slug'        => 'dashboard.systems.media',
                    'description' => trans('dashboard::permission.systems.media'),
                ],
            ],
        ];
    }
}
