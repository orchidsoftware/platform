<?php

namespace Orchid\Foundation\Http\Composers;

use Cache;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\View;
use Orchid\Foundation\Kernel\Dashboard;

class DashboardMenuComposer
{
    /**
     * The user repository implementation.
     *
     * @var
     */
    public $menu;

    /**
     * @var
     */
    protected $guard;

    /**
     * DashboardMenuComposer constructor.
     *
     * @param \Orchid\Foundation\Services\Menu\DashboardMenu $dashboardMenu
     * @param \Illuminate\Contracts\Auth\Guard               $guard
     */
    public function __construct(Dashboard $dashboard = null, Guard $guard)
    {
        // Зависимости разрешаются автоматически службой контейнера...
        $this->menu = $dashboard->menu;
        $this->guard = $guard;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        if ($this->guard->check()) {
            $viewMenu = Cache::remember('dashboard-menu-user-'.$this->guard->user()->id, 10, function () {

                /*
                 * Тут надо перебрать всю меню на наличие прав, и удалить
                 * элементы к которым их нет
                 */
                $user = $this->guard->user();
                $accessCollection = $this->menu->container->filter(function ($item) use ($user) {
                    return true; //(isset($item['arg']['route'])) ? $user->hasAccess($item['arg']['route']) : true;
                });

                return $accessCollection;
            });


            $view->with('DashboardMenu', $viewMenu);
        }
    }
}
