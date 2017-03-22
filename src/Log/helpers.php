<?php

use Orchid\Log\Contracts;

if (!defined('REGEX_DATE_PATTERN')) {
    define('REGEX_DATE_PATTERN', '\d{4}(-\d{2}){2}'); // YYYY-MM-DD
}

if (!defined('REGEX_TIME_PATTERN')) {
    define('REGEX_TIME_PATTERN', '\d{2}(:\d{2}){2}'); // HH:MM:SS
}

if (!defined('REGEX_DATETIME_PATTERN')) {
    define(
        'REGEX_DATETIME_PATTERN',
        REGEX_DATE_PATTERN.' '.REGEX_TIME_PATTERN // YYYY-MM-DD HH:MM:SS
    );
}

if (!function_exists('log_viewer')) {
    /**
     * Get the Log instance.
     *
     * @return Orchid\Log\Contracts\Log
     */
    function log_viewer()
    {
        return app(Contracts\Log::class);
    }
}

if (!function_exists('log_levels')) {
    /**
     * Get the LogLevels instance.
     *
     * @return Orchid\Log\Contracts\Utilities\LogLevels
     */
    function log_levels()
    {
        return app(Contracts\Utilities\LogLevels::class);
    }
}

if (!function_exists('log_menu')) {
    /**
     * Get the LogMenu instance.
     *
     * @return Orchid\Log\Contracts\Utilities\LogMenu
     */
    function log_menu()
    {
        return app(Contracts\Utilities\LogMenu::class);
    }
}

if (!function_exists('log_styler')) {
    /**
     * Get the LogStyler instance.
     *
     * @return Orchid\Log\Contracts\Utilities\LogStyler
     */
    function log_styler()
    {
        return app(Contracts\Utilities\LogStyler::class);
    }
}

if (!function_exists('extract_date')) {
    /**
     * Extract date from string (format : YYYY-MM-DD).
     *
     * @param string $string
     *
     * @return string
     */
    function extract_date($string)
    {
        return preg_replace('/.*('.REGEX_DATE_PATTERN.').*/', '$1', $string);
    }
}
