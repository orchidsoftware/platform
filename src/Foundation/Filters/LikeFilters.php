<?php

namespace Orchid\Foundation\Filters;

class LikeFilters extends Filters
{
    /**
     * @return mixed
     */
    public function run()
    {
        $result = $this->model->where($this->fieldName, 'LIKE', "%$this->parameters%");

        return $result;
    }
}
