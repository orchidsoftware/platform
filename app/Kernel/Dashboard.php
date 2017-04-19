<?php

namespace Orchid\Kernel;

use Illuminate\Support\Collection;
use Orchid\Access\Permissions;
use Orchid\Field\FieldStorage;
use Orchid\Menu\Menu;
use Orchid\Menu\RouteMenu;
use Orchid\Type\PageStorage;
use Orchid\Type\TypeStorage;

class Dashboard
{
    /**
     * Orchid Version.
     */
    const VERSION = '0.0.14';

    /**
     * Dashboard configuration options.
     *
     * @var array
     */
    protected static $options = [];

    /**
     * @var
     */
    public $menu = null;

    /**
     * Permission for applications.
     *
     * @var null
     */
    public $permission = null;

    /**
     * Content type for applications.
     *
     * @var array
     */
    public $types = [];

    /**
     *  List register pages
     *
     * @var array|PageStorage
     */
    public $pages = [];

    /**
     * Dashboard constructor.
     */
    public function __construct()
    {
        $this->menu = new Menu();
        $this->permission = new Permissions();
        $this->pages = new PageStorage();
        $this->types = new TypeStorage();
        $this->fields = new FieldStorage();
        $this->routeMenu = new RouteMenu();
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public static function version() : string
    {
        return static::VERSION;
    }

    /**
     * Configure Dashboard application.
     *
     * @param array $options
     *
     * @return void
     */
    public static function configure(array $options)
    {
        static::$options = $options;
    }

    /**
     * Get a Dashboard configuration option.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function option($key, $default)
    {
        return array_get(static::$options, $key, $default);
    }

    /**
     * Get the class name for a given Dashboard model.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function model($key, $default = null)
    {
        return array_get(static::$options, 'models.' . $key, $default);
    }

    /**
     * @return null|Menu
     */
    public function menu() : Menu
    {
        return $this->menu;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getPermission() : Collection
    {
        return $this->permission->get();
    }

    /**
     * @return TypeStorage
     */
    public function getTypes() : TypeStorage
    {
        return $this->types;
    }

    /**
     * @param bool $sort
     *
     * @return array
     */
    public function types($sort = false) : array
    {
        return $this->types->all($sort);
    }

    /**
     * @return PageStorage
     */
    public function getPages() : PageStorage
    {
        return $this->pages;
    }

    /**
     * @param bool $sort
     *
     * @return array
     */
    public function pages($sort = false) : array
    {
        return $this->pages->all($sort);
    }


    /**
     * @return mixed
     */
    public function fields() : array
    {
        return $this->fields->all();
    }

    /**
     * @return RouteMenu
     */
    public function routeMenu() : RouteMenu
    {
        return $this->routeMenu;
    }
}
