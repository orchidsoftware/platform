<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Http\Composers\PlatformMenuComposer;

class DashboardProvider extends ServiceProvider
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
        View::composer('dashboard::layouts.dashboard', PlatformMenuComposer::class);

        $this->dashboard = $dashboard;

        $this->dashboard
            ->registerFields(config('platform.fields', []))
            ->registerResource(config('platform.resource', []))
            ->registerPermissions($this->registerPermissionsMain())
            ->registerPermissions($this->registerPermissionsSystems());
    }

    /**
     * @return array
     */
    protected function registerPermissionsMain(): array
    {
        return [
            trans('dashboard::permission.main.main') => [
                [
                    'slug'        => 'dashboard.index',
                    'description' => trans('dashboard::permission.main.main'),
                ],
                [
                    'slug'        => 'dashboard.systems',
                    'description' => trans('dashboard::permission.main.systems'),
                ],
                [
                    'slug'        => 'dashboard.systems.index',
                    'description' => trans('dashboard::permission.systems.settings'),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsSystems(): array
    {
        return [
            trans('dashboard::permission.main.systems') => [
                [
                    'slug'        => 'dashboard.systems.roles',
                    'description' => trans('dashboard::permission.systems.roles'),
                ],
                [
                    'slug'        => 'dashboard.systems.users',
                    'description' => trans('dashboard::permission.systems.users'),
                ],
                [
                    'slug'        => 'dashboard.systems.attachment',
                    'description' => trans('dashboard::permission.systems.attachment'),
                ],
                [
                    'slug'        => 'dashboard.systems.media',
                    'description' => trans('dashboard::permission.systems.media'),
                ],
            ],
        ];
    }
}
