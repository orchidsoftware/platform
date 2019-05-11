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
        foreach ($array as $item) {
            if (! filter_var($item, FILTER_VALIDATE_INT)) {
                return false;
            }
        }

        return true;
    }
}