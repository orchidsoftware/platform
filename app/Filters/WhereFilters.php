<?php

namespace Orchid\Filters;

class WhereFilters extends Filters
{
    /**
     * @return mixed
     */
    public function run()
    {
        $result = $this->model->where($this->fieldName, $this->parameters);

        return $result;
    }
}
