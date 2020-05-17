<?php

declare(strict_types=1);

namespace Orchid\Support;

use Illuminate\Support\Collection;

class Assert
{
    /**
     * @param mixed $array
     *
     * @return bool
     */
    public static function isIntArray($array): bool
    {
        return self::isArrayClosure($array, 'is_numeric');
    }

    /**
     * @param mixed $array
     *
     * @return bool
     */
    public static function isObjectArray($array): bool
    {
        return self::isArrayClosure($array, 'is_object');
    }

    /**
     * @param mixed           $array
     * @param string|\Closure $callback
     *
     * @return bool
     */
    public static function isArrayClosure($array, $callback): bool
    {
        if (is_a($array, Collection::class)) {
            $array = $array->all();
        }

        if (! is_array($array)) {
            return false;
        }

        return count($array) === count(array_filter($array, $callback));
    }
}
