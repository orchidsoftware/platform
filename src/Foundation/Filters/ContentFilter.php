<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 03.02.17
 * Time: 11:00.
 */

namespace Orchid\Foundation\Filters;

class ContentFilter
{
    public $model;

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
