<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 10.02.17
 * Time: 13:11
 */

namespace Orchid\Foundation\Filters;


class NameContentFilter extends ContentFilter
{
    /**
     * @var string
     */
    protected $chainBase = 'name';

    /**
     * @param $model
     * @param $values
     * @param $prefix
     * @param $chain
     * @param string $method
     * @return mixed
     */
    public function like($model, $values, $prefix, $chain, $method = 'where')
    {
        $result = $model->$method($prefix . $chain[0], 'LIKE', "%$values%");

        return $result;
    }
}