<?php

namespace Orchid\Platform\Kernel;

interface StorageInterface
{
    /**
     * @param $class
     */
    public function add($class);

    /**
     * @return array
     */
    public function all() : array;

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
