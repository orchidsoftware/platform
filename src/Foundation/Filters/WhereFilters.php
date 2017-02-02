<?php

namespace Orchid\Foundation\Filters;



class WhereFilters extends Filters
{
    public function run()
    {
        $result = $this->model->where($this->fieldName, $this->parameters);

        return $result;
    }
}
