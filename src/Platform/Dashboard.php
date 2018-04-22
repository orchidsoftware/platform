<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Orchid\Platform\Menu\Menu;
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
    private $behaviors;

    /**
     * JS and CSS resources for implementation in the panel.
     *
     * @var Collection
     */
    public $resources;

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
        $this->behaviors = collect();
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

        return $prefix.$path;
    }

    /**
     * @param array $permission
     *
     * @return $this
     */
    public function registerPermissions(array $permission)
    {
        $old = $this->permission->get('all')->get(key($permission), []);
        $this->permission
            ->get('all')
            ->put(key($permission), array_merge_recursive($old, $permission));

        return $this;
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    public function registerBehaviors(array $value)
    {
        $this->behaviors = $this->behaviors->merge($value);

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
     * Return Storage.
     *
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function getStorage($key, $default = null)
    {
        return $this->storage->get($key, $default);
    }

    /**
     * @return Collection
     */
    public function getBehaviors(): Collection
    {
        $this->behaviors->transform(function ($value) {
            if (! is_object($value)) {
                $value = new $value();
            }

            return $value;
        });

        return $this->behaviors;
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
}
