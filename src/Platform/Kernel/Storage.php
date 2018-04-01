<?php

declare(strict_types=1);

namespace Orchid\Platform\Kernel;

use Illuminate\Support\Collection;

class Storage implements StorageInterface
{
    /**
     * @var Collection
     */
    public $container;

    /**
     * @var null
     */
    protected $configField = null;

    /**
     * TypeStorage constructor.
     */
    public function __construct()
    {
        $types = config($this->configField, []);

        $this->container = collect($types);
    }

    /**
     * Add to storage.
     *
     * @param $class
     */
    public function add($class)
    {
        $this->container->push($class);
    }

    /**
     * Return all data to the repository.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        $this->container->transform(function ($value) {
            if (! is_object($value)) {
                $value = new $value();
            }

            return $value;
        });

        return $this->container;
    }

    /**
     * @param $arg
     *
     * @return mixed
     */
    public function get($arg)
    {
        return $this->container->get($arg);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function find($name)
    {
        return $this->container->where('slug', $name)->first();
    }

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }

        return call_user_func_array([$this->container, $method], $arguments);
    }
}
