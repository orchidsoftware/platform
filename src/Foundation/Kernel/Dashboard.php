<?php

namespace Orchid\Foundation\Kernel;

use Orchid\Access\Permissions;
use Orchid\Field\FieldStorage;
use Orchid\Menu\Menu;
use Orchid\Type\TypeStorage;

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
        $this->fields = new FieldStorage();
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
     * @param bool $sort
     *
     * @return array
     */
    public function types($sort = false)
    {
        return $this->types->all($sort);
    }

    /**
     * @return mixed
     */
    public function fields()
    {
        return $this->fields->all();
    }
}
