<?php

namespace Orchid\Foundation\Filters;

class BetweenFilter extends Filters
{
    /**
     * @return mixed
     */
    public function run()
    {
        $begin = $this->parameters['from'];
        $to = $this->parameters['to'];

        $result = $this->model->where($this->fieldName, '>=', $begin)->where($this->fieldName, '<=', $to);

        return $result;
    }
}
