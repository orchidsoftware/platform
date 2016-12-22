<?php namespace Orchid\LogViewer\Contracts;

use Orchid\LogViewer\Contracts\Utilities\Filesystem;

/**
 * Interface  Patternable
 *
 * @package   Orchid\LogViewer\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Patternable
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the log pattern.
     *
     * @return string
     */
    public function getPattern();

    /**
     * Set the log pattern.
     *
     * @param  string $date
     * @param  string $prefix
     * @param  string $extension
     *
     * @return self
     */
    public function setPattern(
        $prefix = Filesystem::PATTERN_PREFIX,
        $date = Filesystem::PATTERN_DATE,
        $extension = Filesystem::PATTERN_EXTENSION
    );
}
