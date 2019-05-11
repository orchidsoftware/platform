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
    static public function isIntArray(array $array) : bool
    {
        return count($array) === count(array_filter($array, 'ctype_digit'));
    }
}