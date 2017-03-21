<?php

namespace Orchid\Log\Utilities;

use Illuminate\Translation\Translator;
use Orchid\Log\Contracts\Utilities\LogLevels as LogLevelsContract;
use Psr\Log\LogLevel;
use ReflectionClass;

class LogLevels implements LogLevelsContract
{
    /**
     * The log levels.
     *
     * @var array
     */
    protected static $levels = [];

    /**
     * The Translator instance.
     *
     * @var \Illuminate\Translation\Translator
     */
    private $translator;

    /**
     * The selected locale.
     *
     * @var string
     */
    private $locale;

    /**
     * LogLevels constructor.
     *
     * @param \Illuminate\Translation\Translator $translator
     * @param string                             $locale
     */
    public function __construct(Translator $translator, $locale)
    {
        $this->setTranslator($translator);
        $this->setLocale($locale);
    }

    /**
     * Set the Translator instance.
     *
     * @param \Illuminate\Translation\Translator $translator
     *
     * @return \Orchid\Log\Utilities\LogLevels
     */
    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;

        return $this;
    }

    /**
     * Get the log levels.
     *
     * @param bool $flip
     *
     * @return array
     */
    public function lists($flip = false)
    {
        return self::all($flip);
    }

    /**
     * Get PSR log levels.
     *
     * @param bool $flip
     *
     * @return array
     */
    public static function all($flip = false)
    {
        if (empty(self::$levels)) {
            self::$levels = (new ReflectionClass(LogLevel::class))
                ->getConstants();
        }

        return $flip ? array_flip(self::$levels) : self::$levels;
    }

    /**
     * Get translated levels.
     *
     * @param string|null $locale
     *
     * @return array
     */
    public function names($locale = null)
    {
        $levels = self::all(true);

        array_walk($levels, function (&$name, $level) use ($locale) {
            $name = $this->get($level, $locale);
        });

        return $levels;
    }

    /** @noinspection PhpSignatureMismatchDuringInheritanceInspection */

    /**
     * Get the translated level.
     *
     * @param string $key
     *
     * @return string
     */
    public function get($key)
    {
        return trans('dashboard::logs.'.$key);
    }

    /**
     * Get the selected locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale === 'auto'
            ? $this->translator->getLocale()
            : $this->locale;
    }

    /**
     * Set the selected locale.
     *
     * @param string $locale
     *
     * @return \Orchid\Log\Utilities\LogLevels
     */
    public function setLocale($locale)
    {
        $this->locale = is_null($locale) ? 'auto' : $locale;

        return $this;
    }
}
