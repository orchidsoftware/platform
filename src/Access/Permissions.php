<?php

namespace Orchid\Access;

class Permissions
{
    /**
     * @var
     */
    protected $container;

    /**
     * Permissions constructor.
     */
    public function __construct()
    {
        $this->container = collect();
    }

    /**
     * @param $permission
     */
    public function registerPermissions($permission)
    {
        $this->container->push($permission);
    }

    /**
     * Get Permissions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return $this->container->collapse();
    }
}
