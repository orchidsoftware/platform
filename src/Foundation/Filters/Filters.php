<?php

namespace Orchid\Foundation\Filters;

use Illuminate\Database\Eloquent\Model;

abstract class Filters
{
    /**
     * @var Model
     */
    public $model;

    /**
     * @var
     */
    public $request;

    /**
     * @var
     */
    public $fieldName;

    /**
     * @var null
     */
    public $parameters;

    /**
     * Filters constructor.
     * @param $model
     * @param $fieldName
     * @param null $parameters
     */
    public function __construct($model, $fieldName, $parameters = null)
    {
        $this->model = $model;
        $this->fieldName = $fieldName;
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    abstract public function run();
}
