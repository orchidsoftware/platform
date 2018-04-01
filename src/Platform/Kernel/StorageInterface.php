<?php

declare(strict_types=1);

namespace Orchid\Platform\Kernel;

use Illuminate\Support\Collection;

interface StorageInterface
{
    /**
     * @param $class
     */
    public function add($class);

    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param $arg
     *
     * @return mixed
     */
    public function get($arg);

    /**
     * @param $name
     *
     * @return mixed
     */
    public function find($name);
}
