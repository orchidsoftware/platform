<?php

namespace Orchid\Access;

use Illuminate\Support\Collection;

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
    public function registerPermissions(array $permission)
    {
        $this->container->push($permission);
    }

    /**
     * Get Permissions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get() : Collection
    {
        return $this->container->collapse();
    }
}
