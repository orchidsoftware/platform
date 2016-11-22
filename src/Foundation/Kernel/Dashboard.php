<?php

namespace Orchid\Foundation\Kernel;

use Orchid\Foundation\Services\Access\Permissions;
use Orchid\Foundation\Services\Menu\Menu;
use Orchid\Foundation\Services\Type\TypeStorage;

class Dashboard
{
    /**
     * Orchid Version.
     */
    const VERSION = '0.0.1';

    /**
     * @var
     */
    public $menu = null;

    /**
     * @var null
     */
    public $permission = null;


    /**
     * @var array
     */
    public $types = [];

    /**
     * Dashboard constructor.
     */
    public function __construct()
    {
        $this->menu = new Menu();
        $this->permission = new Permissions();
        $this->types = new TypeStorage();
    }

    /**
     * @return null|Menu
     */
    public function menu()
    {
        return $this->menu;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getPermission()
    {
        return $this->permission->get();
    }

    /**
     * @return mixed
     */
    public function types($sort = false)
    {
        return $this->types->all($sort);
    }
}
