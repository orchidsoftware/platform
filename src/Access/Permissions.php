<?php

declare(strict_types=1);

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
     * Get Permissions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get(): Collection
    {
        return $this->container->collapse();
    }
}
