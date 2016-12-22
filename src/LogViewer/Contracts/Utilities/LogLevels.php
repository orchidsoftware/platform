<?php

namespace Orchid\LogViewer\Contracts\Utilities;

use Illuminate\Translation\Translator;

/**
 * Interface  LogLevels.
 *
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface LogLevels
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Get PSR log levels.
     *
     * @param  bool $flip
     *
     * @return array
     */
    public static function all($flip = false);

    /**
     * Set the Translator instance.
     *
     * @param  \Illuminate\Translation\Translator $translator
     *
     * @return self
     */
    public function setTranslator(Translator $translator);

    /**
     * Get the selected locale.
     *
     * @return string
     */
    public function getLocale();

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Set the selected locale.
     *
     * @param  string $locale
     *
     * @return self
     */
    public function setLocale($locale);

    /**
     * Get the log levels.
     *
     * @param  bool $flip
     *
     * @return array
     */
    public function lists($flip = false);

    /**
     * Get translated levels.
     *
     * @param  string|null $locale
     *
     * @return array
     */
    public function names($locale = null);

    /**
     * Get the translated level.
     *
     * @param  string $key
     * @param  string|null $locale
     *
     * @return string
     */
    public function get($key, $locale = null);
}
