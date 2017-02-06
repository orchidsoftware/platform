<?php

namespace Orchid\Foundation\Filters;

class ContentFilter
{
    /**
     * @var
     */
    public $model;

    /**
     * @var null
     */
    public $parameters;

    /**
     * ContentFilter constructor.
     *
     * @param $model
     * @param null $parameters
     */
    public function __construct($model, $parameters = null)
    {
        $this->model = $model;
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function run()
    {
        foreach ($this->parameters as $methodName => $values) {
            if (method_exists($this, $methodName)) {
                $this->model = $this->$methodName($this->model, $values);
            }
        }

        return $this->model;
    }
}
