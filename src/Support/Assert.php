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
    public static function isIntArray(array $array) : bool
    {
        return count($array) === count(array_filter($array, 'is_numeric'));
    }
}
