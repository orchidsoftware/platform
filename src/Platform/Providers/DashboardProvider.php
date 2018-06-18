<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Http\Composers\SystemMenuComposer;
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
        View::composer('platform::layouts.dashboard', PlatformMenuComposer::class);
        View::composer('platform::container.systems.index', SystemMenuComposer::class);

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
            trans('platform::permission.main.main') => [
                [
                    'slug'        => 'platform.index',
                    'description' => trans('platform::permission.main.main'),
                ],
                [
                    'slug'        => 'platform.systems',
                    'description' => trans('platform::permission.main.systems'),
                ],
                [
                    'slug'        => 'platform.systems.index',
                    'description' => trans('platform::permission.systems.settings'),
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
            trans('platform::permission.main.systems') => [
                [
                    'slug'        => 'platform.systems.roles',
                    'description' => trans('platform::permission.systems.roles'),
                ],
                [
                    'slug'        => 'platform.systems.users',
                    'description' => trans('platform::permission.systems.users'),
                ],
                [
                    'slug'        => 'platform.systems.attachment',
                    'description' => trans('platform::permission.systems.attachment'),
                ],
                [
                    'slug'        => 'platform.systems.media',
                    'description' => trans('platform::permission.systems.media'),
                ],
                [
                    'slug'        => 'platform.systems.cache',
                    'description' => trans('platform::permission.systems.cache'),
                ],
            ],
        ];
    }
}
