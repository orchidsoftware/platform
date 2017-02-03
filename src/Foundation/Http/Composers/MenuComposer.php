<?php

namespace Orchid\Foundation\Http\Composers;

use Orchid\Foundation\Kernel\Dashboard;

class MenuComposer
{

    /**
     * MenuComposer constructor.
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }


    public function compose(){
        $this->registerMenu($this->dashboard);
    }


    /**
     * @param Dashboard|null $dashboard
     */
    protected function registerMenu(Dashboard $dashboard = null)
    {
        $panelMenu = [
            'slug' => 'Dashboard',
            'icon' => 'icon-speedometer',
            'route' => route('dashboard.index'),
            'label' => trans('dashboard::menu.Dashboard'),
            'main' => true,
            'childs' => true,
            'active' => 'dashboard.index',
            'permission' => 'dashboard.index',
        ];
        $postMenu = [
            'slug' => 'Posts',
            'icon' => 'icon-note',
            'route' => '#',
            'label' => trans('dashboard::menu.Posts'),
            'childs' => true,
            'main' => true,
            'active' => 'dashboard.posts.*',
            'permission' => 'dashboard.posts',
        ];
        $toolsMenu = [
            'slug' => 'Tools',
            'icon' => 'icon-wrench',
            'route' => '#',
            'label' => trans('dashboard::menu.Tools'),
            'childs' => true,
            'main' => true,
            'active' => 'dashboard.tools.*',
            'permission' => 'dashboard.tools',
        ];
        $systemsMenu = [
            'slug' => 'Systems',
            'icon' => 'icon-organization',
            'route' => '#',
            'label' => trans('dashboard::menu.Systems'),
            'childs' => true,
            'main' => true,
            'active' => 'dashboard.systems.*',
            'permission' => 'dashboard.systems',
        ];

        $marketingMenu = [
            'slug' => 'Marketing',
            'icon' => 'icon-chart',
            'route' => '#',
            'label' => trans('Маркетинг'),
            'childs' => true,
            'main' => true,
            'active' => 'dashboard.marketing.*',
            'permission' => 'dashboard.marketing',
        ];

        $dashboard->menu->add('Main', 'dashboard::partials.leftMainMenu', $panelMenu, 1);
        $dashboard->menu->add('Main', 'dashboard::partials.leftMainMenu', $postMenu, 100);
        $dashboard->menu->add('Main', 'dashboard::partials.leftMainMenu', $toolsMenu, 500);
        $dashboard->menu->add('Main', 'dashboard::partials.leftMainMenu', $systemsMenu, 1000);

        $dashboard->menu->add('Main', 'dashboard::partials.leftMainMenu', $marketingMenu, 1500);

        $analyticsMenu = [
            'slug' => 'analytics',
            'icon' => 'fa fa-bar-chart',
            'route' => '#',
            'label' => 'Google Analytics',
            'groupname' => 'Analytics',
            'childs' => false,
            'divider' => false,
        ];

        $settingsMenu = [
            'slug' => 'settings',
            'icon' => 'fa fa-cog',
            'route' => route('dashboard.systems.settings'),
            'label' => trans('dashboard::menu.Constants'),
            'groupname' => trans('dashboard::menu.General settings'),
            'childs' => false,
            'divider' => false,
        ];

        $backupMenu = [
            'slug' => 'backup',
            'icon' => 'fa fa-history',
            'route' => route('dashboard.systems.backup'),
            'label' => 'Резервные копии',
            'childs' => false,
            'divider' => false,
        ];

        $errorMenu = [
            'slug' => 'logs',
            'icon' => 'fa fa-bug',
            'route' => route('dashboard.systems.logs.index'),
            'label' => trans('dashboard::menu.Logs'),
            'groupname' => trans('dashboard::menu.Errors'),
            'childs' => false,
            'divider' => false,
        ];

        $defenderMenu = [
            'slug' => 'defender',
            'icon' => 'fa fa-shield',
            'route' => route('dashboard.systems.defender.index'),
            'label' => trans('Защитник'),
        ];

        $schemaMenu = [
            'slug' => 'schema',
            'icon' => 'fa fa-database',
            'route' => route('dashboard.systems.schema.index'),
            'label' => trans('dashboard::menu.Schema'),
            'childs' => false,
            'divider' => true,
        ];

        $seoMenu = [
            'slug' => 'static-pages',
            'icon' => 'icon-book-open',
            'route' => route('dashboard.index'),
            'label' => trans('dashboard::menu.Static pages'),
            'groupname' => trans('dashboard::menu.Search Engine Optimization'),
            'childs' => false,
            'divider' => false,
        ];

        $redirectMenu = [
            'slug' => 'redirect',
            'icon' => 'icon-direction',
            'route' => route('dashboard.index'),
            'label' => trans('Переадресация'),
        ];

        $siteMapMenu = [
            'slug' => 'site-map',
            'icon' => 'icon-map',
            'route' => route('dashboard.index'),
            'label' => trans('dashboard::menu.Site Map'),
            'childs' => false,
            'divider' => true,
        ];

        $sectionMenu = [
            'slug' => 'section',
            'icon' => 'icon-briefcase',
            'route' => route('dashboard.tools.section'),
            'label' => trans('dashboard::menu.Sections'),
            'childs' => false,
            'divider' => true,
        ];

        $menuMenu = [
            'slug' => 'menu',
            'icon' => 'icon-menu',
            'route' => route('dashboard.tools.menu.index'),
            'label' => trans('dashboard::menu.Menu'),
            'groupname' => trans('dashboard::menu.Posts Managements'),
            'childs' => false,
            'divider' => false,
        ];

        $usersMenu = [
            'slug' => 'users',
            'icon' => 'icon-user',
            'route' => route('dashboard.systems.users'),
            'label' => trans('dashboard::menu.Users'),
            'groupname' => trans('dashboard::menu.Users'),
            'childs' => false,
            'divider' => false,
        ];

        $groupsMenu = [
            'slug' => 'groups',
            'icon' => 'fa fa-lock',
            'route' => route('dashboard.systems.roles'),
            'label' => trans('dashboard::menu.Groups'),
            'childs' => false,
            'divider' => true,
        ];

        $emailMenu = [
            'slug' => 'email',
            'icon' => 'icon-envelope-open',
            'route' => route('dashboard.tools.menu.index'),
            'label' => trans('Email - рассылка'),
            'groupname' => trans('dashboard::menu.Users'),
        ];

        $advertisingMenu = [
            'slug' => 'advertising',
            'icon' => 'icon-target',
            'route' => route('dashboard.tools.menu.index'),
            'label' => trans('Управление рекламой'),
        ];

        $feedback = [
            'slug' => 'advertising',
            'icon' => 'icon-call-in',
            'route' => route('dashboard.tools.menu.index'),
            'label' => trans('Обратная связь'),
        ];

        $polls = [
            'slug' => 'pools',
            'icon' => 'fa fa-id-card-o',
            'route' => route('dashboard.tools.menu.index'),
            'label' => trans('Опросы'),
        ];

        $allPost = $dashboard->types();
        foreach ($allPost as $page) {
            if ($page->display) {
                $postObject = [
                    'slug' => $page->slug,
                    'icon' => $page->icon,
                    'route' => route('dashboard.posts.type', [$page->slug]),
                    'label' => $page->name,
                    'childs' => false,
                ];

                if (reset($allPost) == $page) {
                    $postObject['groupname'] = 'Страницы!';
                } elseif (end($allPost) == $page) {
                    $postObject['divider'] = true;
                }

                $dashboard->menu->add('Posts', 'dashboard::partials.leftMenu', $postObject, 1);
            }
        }

        $dashboard->menu->add('Dashboard', 'dashboard::partials.leftMenu', $analyticsMenu, 1);

        $dashboard->menu->add('Tools', 'dashboard::partials.leftMenu', $menuMenu, 1);
        $dashboard->menu->add('Tools', 'dashboard::partials.leftMenu', $sectionMenu, 3);

        $dashboard->menu->add('Tools', 'dashboard::partials.leftMenu', $seoMenu, 10);
        $dashboard->menu->add('Tools', 'dashboard::partials.leftMenu', $redirectMenu, 11);

        $dashboard->menu->add('Tools', 'dashboard::partials.leftMenu', $siteMapMenu, 30);

        $dashboard->menu->add('Systems', 'dashboard::partials.leftMenu', $errorMenu, 500);
        $dashboard->menu->add('Systems', 'dashboard::partials.leftMenu', $defenderMenu, 501);

        $dashboard->menu->add('Systems', 'dashboard::partials.leftMenu', $settingsMenu, 1);

        $dashboard->menu->add('Systems', 'dashboard::partials.leftMenu', $backupMenu, 2);

        $dashboard->menu->add('Systems', 'dashboard::partials.leftMenu', $schemaMenu, 3);

        $dashboard->menu->add('Systems', 'dashboard::partials.leftMenu', $usersMenu, 501);
        $dashboard->menu->add('Systems', 'dashboard::partials.leftMenu', $groupsMenu, 601);

        $dashboard->menu->add('Marketing', 'dashboard::partials.leftMenu', $emailMenu, 1);
        $dashboard->menu->add('Marketing', 'dashboard::partials.leftMenu', $advertisingMenu, 5);

        $dashboard->menu->add('Marketing', 'dashboard::partials.leftMenu', $feedback, 10);

        $dashboard->menu->add('Marketing', 'dashboard::partials.leftMenu', $polls, 10);
    }


}