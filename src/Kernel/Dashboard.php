<?php

namespace Orchid\Kernel;

use Illuminate\Support\Collection;
use Orchid\Access\Permissions;
use Orchid\Behaviors\Storage\PageStorage;
use Orchid\Behaviors\Storage\PostStorage;
use Orchid\Field\FieldStorage;
use Orchid\Menu\Menu;

class Dashboard
{
    /**
     * Orchid Version.
     */
    const VERSION = '0.0.24';

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
     * Content post for applications.
     *
     * @var array
     */
    public $posts = [];

    /**
     * List register pages
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
        $this->posts = new PostStorage();
        $this->fields = new FieldStorage();
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public static function version(): string
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
     * Register storage of data
     *
     * @param                  $property
     * @param StorageInterface $storage
     */
    public function registerStorage($property, StorageInterface $storage)
    {
        $this->$property = $storage;
    }

    /**
     * @return null|Menu
     */
    public function menu(): Menu
    {
        return $this->menu;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getPermission(): Collection
    {
        return $this->permission->get();
    }

    /**
     * @return PostStorage
     */
    public function getPosts(): PostStorage
    {
        return $this->posts;
    }

    /**
     * @param bool $sort
     *
     * @return array
     */
    public function posts($sort = false): array
    {
        return $this->posts->all($sort);
    }

    /**
     * @return PageStorage
     */
    public function getPages(): PageStorage
    {
        return $this->pages;
    }

    /**
     * @param bool $sort
     *
     * @return array
     */
    public function pages($sort = false): array
    {
        return $this->pages->all($sort);
    }

    /**
     * @return mixed
     */
    public function fields(): array
    {
        return $this->fields->all();
    }
}
