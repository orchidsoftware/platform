<?php namespace Orchid\LogViewer\Contracts\Utilities;

/**
 * Interface  LogStyler
 *
 * @package   Orchid\LogViewer\Contracts\Utilities
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface LogStyler
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make level icon.
     *
     * @param  string $level
     * @param  string|null $default
     *
     * @return string
     */
    public function icon($level, $default = null);

    /**
     * Get level color.
     *
     * @param  string $level
     * @param  string|null $default
     *
     * @return string
     */
    public function color($level, $default = null);
}
