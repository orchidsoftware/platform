<?php

declare(strict_types=1);

namespace Orchid\Support;

class Init
{
    /**
     * Kilobyte unit symbol.
     */
    public const KB = 'kB';

    /**
     * Megabyte unit symbol.
     */
    public const MB = 'MB';

    /**
     * Gigabyte unit symbol.
     */
    public const GB = 'GB';

    /**
     * Converts the size string into bytes.
     *
     * @param string $string The size string
     *
     * @return int The size in bytes
     */
    public static function toBytes(string $string): int
    {
        $string = trim($string);

        // Handles a special case when "-1" is given, which leads to PHP_INT_MAX value
        if ($string === '-1') {
            return PHP_INT_MAX;
        }

        $lastSymbol = strtolower($string[strlen($string) - 1]);

        $value = (int) $string;

        switch ($lastSymbol) {
            case 'g':
                $value *= 1024;
                // no break
            case 'm':
                $value *= 1024;
                // no break
            case 'k':
                $value *= 1024;
        }

        return $value;
    }

    /**
     * Returns the maximum file upload size in bytes or
     * formatted to the provided unit.
     *
     * @param string|null $format The unit format
     *
     * @return int|float The maximum file upload size
     */
    public static function maxFileUpload(?string $format = null): int
    {
        $ini = [
            'upload_max_filesize',
            'post_max_size',
            'memory_limit',
        ];

        $ini = array_map(fn ($item) => self::toBytes(ini_get($item)), $ini);

        $value = min($ini);

        if ($format === null) {
            return $value;
        }

        return (int) self::convertBytesTo($format, $value);
    }

    /**
     * Converts the bytes' value to the specified unit.
     *
     * @param string    $to    The unit to convert to
     * @param int|float $bytes The size in bytes
     * @param int       $point The decimal point
     *
     * @return int|float The value in the specified unit
     */
    public static function convertBytesTo(string $to, $bytes, $point = 0)
    {
        return [
            self::KB => number_format($bytes / 1024, $point, '.', ''),
            self::MB => number_format($bytes / 1048576, $point, '.', ''),
            self::GB => number_format($bytes / 1073741824, $point, '.', ''),
        ][$to] ?? 0;
    }
}
