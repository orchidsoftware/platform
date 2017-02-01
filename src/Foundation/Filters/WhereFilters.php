<?php

namespace Orchid\Foundation\Filters;

use Illuminate\Database\Eloquent\Model;

class WhereFilters extends Filters
{
    public function run()
    {
        $result = $this->model->where($this->fieldName, $this->parameters);

        return $result;
    }
}
