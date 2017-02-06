<?php

namespace Orchid\Foundation\Filters;

class LimitFilters extends Filters
{
    /**
     * @return mixed
     */
    public function run()
    {
        $result = $this->model->limit($this->parameters);

        return $result;
    }
}
