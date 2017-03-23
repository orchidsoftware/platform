<?php

namespace Orchid\Filters;

class PlaceContentFilter extends ContentFilter
{
    /**
     * @var string
     */
    protected $chainBase = 'place';

    /**
     * @param        $model
     * @param        $values
     * @param        $prefix
     * @param        $chain
     * @param string $method
     *
     * @return mixed
     */
    public function name($model, $values, $prefix, $chain, $method = 'where')
    {
        $like_token = $values['like'];

        $result = $model->$method($prefix . implode($chain, '->'), 'LIKE', "%$like_token%");

        return $result;
    }

    /**
     * @return mixed
     *
     * @internal param $model
     * @internal param $values
     * @internal param $prefix
     * @internal param $chain
     * @internal param string $method
     */
    public function latLng()
    {
        return $this->model;
    }
}
