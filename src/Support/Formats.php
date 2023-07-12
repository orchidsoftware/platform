<?php

declare(strict_types=1);

namespace Orchid\Support;

use Carbon\Carbon;

class Formats
{
    /**
     * Convert a UNIX timestamp to a formatted datetime string.
     *
     * @param int $time UNIX timestamp
     *
     * @return string Formatted Datetime string
     */
    public static function toDateTimeString(int $time): string
    {
        return Carbon::createFromTimestamp($time)->toDateTimeString();
    }

    /**
     * Format bytes to KB, MB, GB, TB.
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
