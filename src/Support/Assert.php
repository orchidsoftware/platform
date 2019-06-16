<?php

declare(strict_types=1);

namespace Orchid\Support;

class Assert
{
    /**
     * @param array $array
     *
     * @return bool
     */
    public static function isIntArray($array) : bool
    {
        if (! is_array($array)) {
            return false;
        }

        return count($array) === count(array_filter($array, 'is_numeric'));
    }
}
