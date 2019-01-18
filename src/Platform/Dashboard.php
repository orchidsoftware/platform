<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Support\Collection;

class Dashboard
{
    /**
     * ORCHID Version.
     */
    public const VERSION = '3.5.1';

    /**
     * The Dashboard configuration options.
     *
     * @var array
     */
    protected static $options = [];

    /**
     * @var Menu
     */
    public $menu;

    /**
     * JS and CSS resources for implementation in the panel.
     *
     * @var Collection
     */
    public $resources;

    /**
     * Permission for applications.
     *
     * @var Collection
     */
    private $permission;

    /**
     * @var Collection
     */
    private $entities;

    /**
     * @var Collection
     */
    private $globalSearch;

    /**
     * Dashboard constructor.
     */
    public function __construct()
    {
        $this->menu = new Menu;
        $this->permission = collect([
            'all'     => collect(),
            'removed' => collect(),
        ]);
        $this->resources = collect();
        $this->entities = collect();
        $this->globalSearch = collect();
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
     * @param string $path
     *
     * @return string
     */
    public static function prefix(string $path = ''): string
    {
        $prefix = config('platform.prefix');

        return str_start($prefix.$path, '/');
    }

    /**
     * Configure the Dashboard application.
     *
     * @param  array $options
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
     * @param  string $key
     * @param  mixed|null $default
     *
     * @return mixed
     */
    public static function option(string $key, $default = null)
    {
        return array_get(static::$options, $key, $default);
    }

    /**
     * @param string $key
     * @param string|null $default
     *
     * @return mixed
     */
    public static function modelClass(string $key, string $default = null)
    {
        $model = static::model($key, $default);

        return class_exists($model) ? new $model : $model;
    }

    /**
     * Get the class name for a given Dashboard model.
     *
     * @param  string $key
     * @param  null|string $default
     *
     * @return string
     */
    public static function model(string $key, string $default = null)
    {
        return array_get(static::$options, 'models.'.$key, $default ?? $key);
    }

    /**
     * @param string $key
     * @param string $custom
     */
    public static function useModel(string $key, string $custom)
    {
        static::$options['models'][$key] = $custom;
    }

    /**
     * Checks if a new and stable version exists.
     *
     * @return bool
     */
    public static function checkUpdate(): bool
    {
        return (new Updates())->check();
    }

    /**
     * @param array $permission
     *
     * @return $this
     */
    public function registerPermissions(array $permission): self
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
    public function registerEntities(array $value): self
    {
        $this->entities = $this->entities->merge($value);

        return $this;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model[] $value
     *
     * @return $this
     */
    public function registerGlobalSearch(array $value): self
    {
        $this->globalSearch = $this->globalSearch->merge($value);

        return $this;
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    public function registerResource(array $value): self
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
        return $this->entities->transform(function ($value) {
            return is_object($value) ? $value : new $value;
        });
    }

    /**
     * @return Collection
     */
    public function getGlobalSearch(): Collection
    {
        return $this->globalSearch->transform(function ($value) {
            return is_object($value) ? $value : new $value;
        });
    }

    /**
     * @return Menu
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
     *
     * @return $this
     */
    public function removePermission(string $key)
    {
        $this->permission->get('removed')->push($key);

        return $this;
    }
}
