<?php

declare(strict_types=1);

namespace Orchid\Support;

class Init
{
    /**
     * Kilobyte.
     */
    public const KB = 'kB';

    /**
     * Megabyte.
     */
    public const MB = 'MB';

    /**
     * Gigabyte.
     */
    public const GB = 'GB';

    /**
     * @param string $string
     *
     * @return int
     */
    public static function toBytes(string $string): int
    {
        $string = trim($string);

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
     * The smallest of them, this defines the real limit.
     *
     * @param string|null $format
     *
     * @return int
     */
    public static function maxFileUpload(string $format = null): int
    {
        $ini = [
            'upload_max_filesize',
            'post_max_size',
            'memory_limit',
        ];

        $ini = array_map(function ($item) {
            return self::toBytes(ini_get($item));
        }, $ini);

        $value = min($ini);

        if ($format === null) {
            return $value;
        }

        return (int) self::convertBytesTo($format, $value);
    }

    /**
     * @param string $to
     * @param        $bytes
     * @param int    $point
     *
     * @return int|float|mixed
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
