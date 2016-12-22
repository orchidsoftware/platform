<?php

namespace Orchid\LogViewer\Tables;

use Orchid\LogViewer\Contracts\Table as TableContract;
use Orchid\LogViewer\Contracts\Utilities\LogLevels as LogLevelsContract;

/**
 * Class     AbstractTable.
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractTable implements TableContract
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var \Orchid\LogViewer\Contracts\Utilities\LogLevels */
    protected $levels;
    /** @var string|null */
    protected $locale;
    /** @var array */
    private $header = [];
    /** @var array */
    private $rows = [];
    /** @var array */
    private $footer = [];
    /** @var array */
    private $data = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Create a table instance.
     *
     * @param  array $data
     * @param  \Orchid\LogViewer\Contracts\Utilities\LogLevels $levels
     * @param  string|null $locale
     */
    public function __construct(array $data, LogLevelsContract $levels, $locale = null)
    {
        $this->setLevels($levels);
        $this->setLocale(is_null($locale) ? config('log-viewer.locale') : $locale);
        $this->setData($data);
        $this->init();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Set LogLevels instance.
     *
     * @param  \Orchid\LogViewer\Contracts\Utilities\LogLevels $levels
     *
     * @return \Orchid\LogViewer\Tables\AbstractTable
     */
    protected function setLevels(LogLevelsContract $levels)
    {
        $this->levels = $levels;

        return $this;
    }

    /**
     * Set table locale.
     *
     * @param  string|null $locale
     *
     * @return \Orchid\LogViewer\Tables\AbstractTable
     */
    protected function setLocale($locale)
    {
        if (is_null($locale) || $locale === 'auto') {
            $locale = app()->getLocale();
        }

        $this->locale = $locale;

        return $this;
    }

    /**
     * Set table data.
     *
     * @param  array $data
     *
     * @return self
     */
    private function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Prepare the table.
     */
    private function init()
    {
        $this->header = $this->prepareHeader($this->data);
        $this->rows = $this->prepareRows($this->data);
        $this->footer = $this->prepareFooter($this->data);
    }

    /**
     * Prepare table header.
     *
     * @param  array $data
     *
     * @return array
     */
    abstract protected function prepareHeader(array $data);

    /**
     * Prepare table rows.
     *
     * @param  array $data
     *
     * @return array
     */
    abstract protected function prepareRows(array $data);

    /**
     * Prepare table footer.
     *
     * @param  array $data
     *
     * @return array
     */
    abstract protected function prepareFooter(array $data);

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Get table header.
     *
     * @return array
     */
    public function header()
    {
        return $this->header;
    }

    /**
     * Get table rows.
     *
     * @return array
     */
    public function rows()
    {
        return $this->rows;
    }

    /**
     * Get table footer.
     *
     * @return array
     */
    public function footer()
    {
        return $this->footer;
    }

    /**
     * Get raw data.
     *
     * @return array
     */
    public function data()
    {
        return $this->data;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Translate.
     *
     * @param  string $key
     *
     * @return string
     */
    protected function translate($key)
    {
        /** @var \Illuminate\Translation\Translator $translator */
        $translator = trans();

        return $translator->get('log-viewer::'.$key, [], $this->locale);
    }

    /**
     * Get log level color.
     *
     * @param  string $level
     *
     * @return string
     */
    protected function color($level)
    {
        return log_styler()->color($level);
    }
}
