<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 03.02.17
 * Time: 10:17.
 */

namespace Orchid\Foundation\Filters;

class PlaceFilter extends ContentFilter
{
    protected $chainBase = 'place';

    public function name($model, $values, $chain, $method = 'where')
    {
        $like_token = $values['like'];

        $result = null;

        $result = $model->$method($chain, 'LIKE', "%$like_token%");

        return $result;
    }

    public function latLng($model, $values, $chain, $method = 'where')
    {
        return $this->model;
    }
}
