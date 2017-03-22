<?php

namespace Orchid\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Kernel\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @var
     */
    protected $dashboard;

    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;

        $dashboard->permission->registerPermissions($this->registerPermissionsMain());
        $dashboard->permission->registerPermissions($this->registerPermissionsPost());
        $dashboard->permission->registerPermissions($this->registerPermissionsTools());
        $dashboard->permission->registerPermissions($this->registerPermissionsSystems());
        $dashboard->permission->registerPermissions($this->registerPermissionsMarketing());
    }

    /**
     * @return array
     */
    protected function registerPermissionsMain()
    {
        return [
            'Главное меню' => [
                [
                    'slug' => 'dashboard.index',
                    'description' => 'Главное меню',
                ],
                [
                    'slug' => 'dashboard.posts',
                    'description' => 'Доступ к постам',
                ],
                [
                    'slug' => 'dashboard.tools',
                    'description' => 'Доступ к инструментам',
                ],
                [
                    'slug' => 'dashboard.systems',
                    'description' => 'Доступ к параметрам системы',
                ],
                [
                    'slug' => 'dashboard.marketing',
                    'description' => 'Доступ к инстументам маркетинга',
                ],
            ],

        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsPost()
    {
        $allPost = $this->dashboard->types();
        $showPost = collect();
        foreach ($allPost as $page) {
            if ($page->display) {
                $showPost->push([
                    'slug' => 'dashboard.posts.type.' . $page->slug,
                    'description' => $page->name,
                ]);
            }
        }

        return [
            'Posts' => $showPost->toArray(),
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsTools()
    {
        return [
            'Tools' => [
                [
                    'slug' => 'dashboard.tools.menu',
                    'description' => 'Доступ к меню',
                ],
                [
                    'slug' => 'dashboard.tools.category',
                    'description' => 'Доступ к категориям',
                ],
                [
                    'slug' => 'dashboard.tools.attachment',
                    'description' => 'Доступ к загрузке файлов',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsSystems()
    {
        return [

            'Systems' => [
                [
                    'slug' => 'dashboard.systems.backup',
                    'description' => 'Доступ к резервнымым копиям',
                ],
                [
                    'slug' => 'dashboard.systems.defender',
                    'description' => 'Доступ к защитнику',
                ],
                [
                    'slug' => 'dashboard.systems.monitor',
                    'description' => 'Доступ к системному монитору',
                ],
                [
                    'slug' => 'dashboard.systems.logs',
                    'description' => 'Доступ к журналу событий',
                ],
                [
                    'slug' => 'dashboard.systems.roles',
                    'description' => 'Доступ к ролям',
                ],
                [
                    'slug' => 'dashboard.systems.schema',
                    'description' => 'Доступ к таблица',
                ],
                [
                    'slug' => 'dashboard.systems.settings',
                    'description' => 'Доступ к настройкам',
                ],
                [
                    'slug' => 'dashboard.systems.users',
                    'description' => 'Доступ к пользователям',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsMarketing()
    {
        return [

            'Marketing' => [
                [
                    'slug' => 'dashboard.marketing.comment',
                    'description' => 'Доступ к комментариям',
                ],
                [
                    'slug' => 'dashboard.marketing.advertising',
                    'description' => 'Доступ к рекламе',
                ],
            ],

        ];
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
