<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 31.01.17
 * Time: 17:23
 */

namespace Orchid\Foundation\Filters;


class BetweenFilter extends Filters {
    function run() {
        $begin = $this->parameters['from'];
        $to = $this->parameters['to'];

        $result = $this->model->where($this->fieldName, '>=', $begin)->where($this->fieldName, '<=', $to);

        return $result;
    }
}