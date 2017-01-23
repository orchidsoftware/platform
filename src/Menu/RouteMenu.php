<?php

namespace Orchid\Menu;

class RouteMenu
{
    /**
     * The contents of the menu.
     *
     * @var
     */
    public $container;

    /**
     * RouteMenu constructor.
     */
    public function __construct()
    {
        $this->container = collect();
    }

    /**
     * Add list element menu.
     *
     * @param $name
     * @param $slug
     */
    public function add($slug, $name)
    {
        $this->container->put($slug, $name);
    }

    /**
     * Get list.
     */
    public function all()
    {
        return $this->container->all();
    }
}
