<?php

namespace Orchid\LogViewer\Utilities;

use Orchid\LogViewer\Entities\Log;
use Illuminate\Contracts\Config\Repository as ConfigContract;
use Orchid\LogViewer\Contracts\Utilities\LogMenu as LogMenuContract;
use Orchid\LogViewer\Contracts\Utilities\LogStyler as LogStylerContract;

/**
 * Class     LogMenu.
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LogMenu implements LogMenuContract
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The config repository instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The log styler instance.
     *
     * @var \Orchid\LogViewer\Contracts\Utilities\LogStyler
     */
    private $styler;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * LogMenu constructor.
     *
     * @param  \Illuminate\Contracts\Config\Repository $config
     * @param  \Orchid\LogViewer\Contracts\Utilities\LogStyler $styler
     */
    public function __construct(ConfigContract $config, LogStylerContract $styler)
    {
        $this->setConfig($config);
        $this->setLogStyler($styler);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Set the config instance.
     *
     * @param  \Illuminate\Contracts\Config\Repository $config
     *
     * @return \Orchid\LogViewer\Utilities\LogMenu
     */
    public function setConfig(ConfigContract $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Set the log styler instance.
     *
     * @param  \Orchid\LogViewer\Contracts\Utilities\LogStyler $styler
     *
     * @return \Orchid\LogViewer\Utilities\LogMenu
     */
    public function setLogStyler(LogStylerContract $styler)
    {
        $this->styler = $styler;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Make log menu.
     *
     * @param  \Orchid\LogViewer\Entities\Log $log
     * @param  bool $trans
     *
     * @return array
     */
    public function make(Log $log, $trans = true)
    {
        $items = [];
        $route = 'dashboard.systems.logs.show'; //$this->config('menu.filter-route');

        foreach ($log->tree($trans) as $level => $item) {
            $items[$level] = array_merge($item, [
                'url' => route($route, [$log->date, $level]),
                'icon' => $this->styler->icon($level) ?: '',
            ]);
        }

        return $items;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Get config.
     *
     * @param  string $key
     * @param  mixed $default
     *
     * @return mixed
     */
    private function config($key, $default = null)
    {
        return $this->config->get("log-viewer.$key", $default);
    }
}
