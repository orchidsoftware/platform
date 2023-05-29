<?php

declare(strict_types=1);

namespace Orchid\Support;

use Illuminate\Support\Collection;

class Assert
{
    /**
     * Check if the given array is a numeric array.
     *
     * @param mixed $array
     */
    public static function isIntArray($array): bool
    {
        return self::isArrayClosure($array, 'is_numeric');
    }

    /**
     * Check if the given array is an object array.
     *
     * @param mixed $array
     */
    public static function isObjectArray($array): bool
    {
        return self::isArrayClosure($array, 'is_object');
    }

    /**
     * Check if the given array passes the callback test.
     *
     * @param mixed           $array
     * @param string|\Closure $callback
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
