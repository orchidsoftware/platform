<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 01.02.17
 * Time: 11:30
 */

namespace Orchid\Foundation\Filters;


use Illuminate\Database\Eloquent\Builder;

class LikeFilters extends Filters
{

    function run() {
        $result = $this->model->where($this->fieldName, 'LIKE', "%$this->parameters%");

        return $result;
    }
}