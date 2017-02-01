<?php namespace Orchid\Foundation\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Orchid\Foundation\Core\Models\Post;

class WhereFilters extends Filters {
    function run() {
        $result = $this->model->where($this->fieldName, $this->parameters);

        return $result;
    }
}