<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 01.02.17
 * Time: 11:30.
 */

namespace Orchid\Foundation\Filters;

class LikeFilters extends Filters
{
    public function run()
    {
        $result = $this->model->where($this->fieldName, 'LIKE', "%$this->parameters%");

        return $result;
    }
}
