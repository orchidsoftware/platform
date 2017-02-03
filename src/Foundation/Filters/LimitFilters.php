<?php

namespace Orchid\Foundation\Filters;

class LimitFilters extends Filters
{
    public function run()
    {
        $result = $this->model->limit($this->parameters);

        return $result;
    }
}
