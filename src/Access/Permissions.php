<?php

namespace Orchid\Platform\Access;

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
        $old = $this->container->get(key($permission), []);

        $this->container->put(key($permission), array_merge_recursive($old, $permission));


        return $this->container;
        //$this->container = array_merge_recursive($permission,$this->container->toArray()));


        //if($this->container->has(key($permission)) || key_exists(key($permission),$this->container)){
        //    dd('test');
        //}else {
        //    $this->container->push($permission);
        //}
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
