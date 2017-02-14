<?php

namespace Orchid\Foundation\Filters;

class PlaceContentFilter extends ContentFilter
{
    /**
     * @var string
     */
    protected $chainBase = 'place';

    /**
     * @param $model
     * @param $values
     * @param $prefix
     * @param $chain
     * @param string $method
     *
     * @return mixed
     */
    public function name($model, $values, $prefix, $chain, $method = 'where')
    {
        $like_token = $values['like'];

        $result = $model->$method($prefix.implode($chain, '->'), 'LIKE', "%$like_token%");

        return $result;
    }

    /**
     * @param $model
     * @param $values
     * @param $prefix
     * @param $chain
     * @param string $method
     *
     * @return mixed
     */
    public function latLng($model, $values, $prefix, $chain, $method = 'where')
    {
        return $this->model;
    }
}
