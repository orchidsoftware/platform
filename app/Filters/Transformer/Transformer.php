<?php

namespace Orchid\Filters\Transformer;

/**
 * Created by PhpStorm.
 * User: joker
 * Date: 07.02.17
 * Time: 13:11.
 */
abstract class Transformer
{
    /**
     * @param $collect
     *
     * @return mixed
     */
    abstract public static function transform($collect);
}
