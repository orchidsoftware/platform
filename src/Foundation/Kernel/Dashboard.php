<?php

namespace Orchid\Foundation\Kernel;

use Orchid\Foundation\Services\Access\Permissions;
use Orchid\Foundation\Services\Menu\Menu;

class Dashboard
{
    /**
     * @var
     */
    public $menu = null;

    /**
     * @var null
     */
    public $permission = null;


    public function __construct()
    {
        $this->menu = new Menu();
        $this->permission = new Permissions();
    }


    public function menu()
    {
        return $this->menu;
    }


    public function getPermission()
    {
        return $this->permission->get();
    }
}
