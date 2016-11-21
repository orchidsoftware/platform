<?php

namespace Orchid\Foundation\Services\Type;

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

        $types = config('types', []);

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
     * @param bool $sort
     * @return array
     */
    public function all($sort = false)
    {
        $this->container->transform(function ($value) {
            if (! is_object($value)) {
                $value = new $value;
            }

            return $value;
        });


        if (! $sort) {
            return [
                'pages' => $this->container->where('page', true)->toArray(),
                'blocks' => $this->container->where('page', false)->toArray(),
            ];
        }

        return $this->container->all();
    }

    /**
     * @param $arg
     * @return mixed
     */
    public function get($arg)
    {
        return $this->container->get($arg);
    }
}
