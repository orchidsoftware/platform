<?php

namespace Orchid\Foundation\Filters;

class LikeFilters extends Filters
{
    public function run()
    {
        $result = $this->model->where($this->fieldName, 'LIKE', "%$this->parameters%");

        return $result;
    }
}
