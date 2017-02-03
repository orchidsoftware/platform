<?php

namespace Orchid\Log\Contracts\Utilities;

use Illuminate\Translation\Translator;

interface LogLevels
{
    /**
     * Get PSR log levels.
     *
     * @param bool $flip
     *
     * @return array
     */
    public static function all($flip = false);

    /**
     * Set the Translator instance.
     *
     * @param \Illuminate\Translation\Translator $translator
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

    /**
     * Set the selected locale.
     *
     * @param string $locale
     *
     * @return self
     */
    public function setLocale($locale);

    /**
     * Get the log levels.
     *
     * @param bool $flip
     *
     * @return array
     */
    public function lists($flip = false);

    /**
     * Get translated levels.
     *
     * @param string|null $locale
     *
     * @return array
     */
    public function names($locale = null);

    /**
     * Get the translated level.
     *
     * @param string $key
     *
     * @return string
     */
    public function get($key);
}
