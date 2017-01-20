<?php

namespace Orchid\Type;

class TypeStorage
{
    /**
     * @var
     */
    public $container;

    /**
     * TypeStorage constructor.
     */
    public function __construct()
    {
        $this->container = collect();

        $types = config('content.types', []);

        foreach ($types as $type) {
            $this->add($type);
        }
    }

    /**
     * @param $class
     */
    public function add($class)
    {
        $this->container->push($class);
    }

    /**
     * @return array
     */
    public function all()
    {
        $this->container->transform(function ($value) {
            if (!is_object($value)) {
                $value = new $value();
            }

            return $value;
        });

        return $this->container->all();
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
}
