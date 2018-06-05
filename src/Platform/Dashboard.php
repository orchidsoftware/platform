<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Support\Collection;

class Dashboard
{
    /**
     * ORCHID Version.
     */
    const VERSION = '3.0';

    /**
     * @var Menu
     */
    public $menu;

    /**
     * Permission for applications.
     *
     * @var Collection
     */
    private $permission;

    /**
     * @var Collection
     */
    public $fields;

    /**
     * @var Collection
     */
    private $entities;

    /**
     * JS and CSS resources for implementation in the panel.
     *
     * @var Collection
     */
    public $resources;

    /**
     * The Dashboard configuration options.
     *
     * @var array
     */
    protected static $options = [];

    /**
     * Dashboard constructor.
     */
    public function __construct()
    {
        $this->menu = new Menu();
        $this->permission = collect([
            'all'     => collect(),
            'removed' => collect(),
        ]);
        $this->resources = collect();
        $this->entities = collect();
        $this->fields = collect();
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
     * Get the route with the dashboard prefix.
     *
     * @param $path
     *
     * @return string
     */
    public static function prefix($path = ''): string
    {
        $prefix = config('platform.prefix');

        return str_start($prefix.$path,'/');
    }

    /**
     * @param array $permission
     *
     * @return $this
     */
    public function registerPermissions(array $permission)
    {
        foreach ($permission as $key => $item) {
            $old = $this->permission->get('all')->get($key, []);
            $this->permission->get('all')->put($key, array_merge_recursive($old, $item));
        }

        return $this;
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    public function registerEntities(array $value)
    {
        $this->entities = $this->entities->merge($value);

        return $this;
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    public function registerFields(array $value)
    {
        $this->fields = $this->fields->merge($value);

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    public function registerResource(array $value)
    {
        $this->resources = $this->resources->merge($value);

        return $this;
    }

    /**
     * Return CSS\JS.
     *
     * @param null $key
     *
     * @return array|\Illuminate\Support\Collection|mixed
     */
    public function getResource($key = null)
    {
        if (is_null($key)) {
            return $this->resources;
        }

        return $this->resources->get($key);
    }

    /**
     * @return Collection
     */
    public function getEntities(): Collection
    {
        $this->entities->transform(function ($value) {
            if (! is_object($value)) {
                $value = new $value();
            }

            return $value;
        });

        return $this->entities;
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
        $all = $this->permission->get('all');
        $removed = $this->permission->get('removed');

        if (! $removed->count()) {
            return $all;
        }

        return $all->map(function ($group) use ($removed) {
            foreach ($group[key($group)] as $key => $item) {
                if ($removed->contains($item['slug'])) {
                    unset($group[key($group)][$key]);
                }
            }

            return $group;
        });
    }

    /**
     * @param string $key
     * @return $this
     */
    public function removePermission(string $key)
    {
        $this->permission->get('removed')->push($key);

        return $this;
    }

    /**
     * Configure the Dashboard application.
     *
     * @param  array  $options
     * @return void
     */
    public static function configure(array $options)
    {
        static::$options = $options;
    }

    /**
     * Get a Dashboard configuration option.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function option(string $key, $default)
    {
        return array_get(static::$options, $key, $default);
    }

    /**
     * Get the class name for a given Dashboard model.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function model(string $key, string $default = null)
    {
        return array_get(static::$options, 'models.'.$key, $default ?? $key);

        if (class_exists($model)) {
            return new $model;
        }

        return $model;
    }

    public static function modelClass(string $key, string $default = null)
    {
        $model = self::model($key, $default);

        if (class_exists($model)) {
            return new $model;
        }

        return $model;
    }

    /**
     * @param $key
     * @param $custom
     */
    public static function useModel($key, $custom)
    {
        static::$options['models'][$key] = $custom;
    }
}
