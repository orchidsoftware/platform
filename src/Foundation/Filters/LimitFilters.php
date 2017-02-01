<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 31.01.17
 * Time: 17:24
 */

namespace Orchid\Foundation\Filters;


class LimitFilters extends Filters
{
    function run() {
        $result = $this->model->limit($this->parameters);

        return $result;
    }
}