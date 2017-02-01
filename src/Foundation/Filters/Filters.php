<?php namespace Orchid\Foundation\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Filters {

    public $model;

    public $request;

    public $fieldName;

    public $parameters;

    public function __construct($model, $fieldName, $parameters = null) {
        $this->model = $model;
        $this->fieldName = $fieldName;
        $this->parameters = $parameters;
    }

    abstract function run();
}