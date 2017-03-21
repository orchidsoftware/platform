<?php

namespace Orchid\Log\Utilities;

use Illuminate\Contracts\Config\Repository as ConfigContract;
use Orchid\Log\Contracts\Utilities\LogMenu as LogMenuContract;
use Orchid\Log\Contracts\Utilities\LogStyler as LogStylerContract;
use Orchid\Log\Entities\Log;

class LogMenu implements LogMenuContract
{
    /**
     * The config repository instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The log styler instance.
     *
     * @var \Orchid\Log\Contracts\Utilities\LogStyler
     */
    private $styler;

    /**
     * LogMenu constructor.
     *
     * @param \Illuminate\Contracts\Config\Repository   $config
     * @param \Orchid\Log\Contracts\Utilities\LogStyler $styler
     */
    public function __construct(ConfigContract $config, LogStylerContract $styler)
    {
        $this->setConfig($config);
        $this->setLogStyler($styler);
    }

    /**
     * Set the config instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     *
     * @return \Orchid\Log\Utilities\LogMenu
     */
    public function setConfig(ConfigContract $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Set the log styler instance.
     *
     * @param \Orchid\Log\Contracts\Utilities\LogStyler $styler
     *
     * @return \Orchid\Log\Utilities\LogMenu
     */
    public function setLogStyler(LogStylerContract $styler)
    {
        $this->styler = $styler;

        return $this;
    }

    /**
     * Make log menu.
     *
     * @param \Orchid\Log\Entities\Log $log
     * @param bool                     $trans
     *
     * @return array
     */
    public function make(Log $log, $trans = true)
    {
        $items = [];
        $route = 'dashboard.systems.logs.show'; //$this->config('menu.filter-route');

        foreach ($log->tree($trans) as $level => $item) {
            $items[$level] = array_merge($item, [
                'url'  => route($route, [$log->date, $level]),
                'icon' => $this->styler->icon($level) ?: '',
            ]);
        }

        return $items;
    }
}
