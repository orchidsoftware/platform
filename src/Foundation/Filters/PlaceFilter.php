<?php

namespace Orchid\Foundation\Filters;

class PlaceFilter extends ContentFilter
{
    /**
     * @return mixed
     */
    public function name()
    {
        dd($this->parameters);
        $result = $this->model->where('content->en->place->name', 'LIKE', "%$this->parameters%");

        return $result;
    }

    /**
     * @return mixed
     */
    public function latLng()
    {
        return $this->model;
    }
}
