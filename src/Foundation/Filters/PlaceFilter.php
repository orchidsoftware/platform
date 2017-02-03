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
    public function name()
    {
        dd($this->parameters);
        $result = $this->model->where('content->en->place->name', 'LIKE', "%$this->parameters%");

        return $result;
    }

    public function latLng()
    {
        return $this->model;
    }
}
