<?php

namespace Orchid\Foundation\Filters;

class PlaceFilter extends ContentFilter
{
    /**
     * @var string
     */
    protected $chainBase = 'place';

    /**
     * @param $model
     * @param $values
     * @param $chain
     * @param string $method
     * @return mixed
     */
    public function name($model, $values, $chain, $method = 'where')
    {
        $like_token = $values['like'];

        $result = $model->$method($chain, 'LIKE', "%$like_token%");

        return $result;
    }

    /**
     * @param $model
     * @param $values
     * @param $chain
     * @param string $method
     * @return mixed
     */
    public function latLng($model, $values, $chain, $method = 'where')
    {
        return $this->model;
    }
}
