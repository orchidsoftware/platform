<?php

declare(strict_types=1);

namespace Orchid\Support;

use Carbon\Carbon;

class Formats
{
    /**
     * @param int $time
     *
     * @return string
     */
    public static function toDateTimeString(int $time): string
    {
        return Carbon::createFromTimestamp($time)->toDateTimeString();
    }

    /**
     * Format bytes to kb, mb, gb, tb.
     *
     * @param int $size
     * @param int $precision
     *
     * @return string
     */
    public static function formatBytes(int $size, int $precision = 2): string
    {
        if ($size <= 0) {
            return (string) $size;
        }

        $base = log($size) / log(1024);
        $suffixes = [' bytes', ' KB', ' MB', ' GB', ' TB'];

        return round(1024 ** ($base - floor($base)), $precision).$suffixes[(int) floor($base)];
    }
}
