<?php

namespace Orchid\Foundation\Filters\Transformer;

/**
 * Created by PhpStorm.
 * User: joker
 * Date: 07.02.17
 * Time: 13:11.
 */
abstract class Transformer
{
    abstract public static function transform($collect);
}
