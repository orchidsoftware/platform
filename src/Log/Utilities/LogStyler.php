<?php

namespace Orchid\Log\Utilities;

use Illuminate\Contracts\Config\Repository as ConfigContract;
use Orchid\Log\Contracts\Utilities\LogStyler as LogStylerContract;

class LogStyler implements LogStylerContract
{
    /**
     * The config repository instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var array
     */
    protected $icons = [
        'all'       => 'fa fa-fw fa-list',
        'emergency' => 'fa fa-fw fa-bug',
        'alert'     => 'fa fa-fw fa-bullhorn',
        'critical'  => 'fa fa-fw fa-heartbeat',
        'error'     => 'fa fa-fw fa-times-circle',
        'warning'   => 'fa fa-fw fa-exclamation-triangle',
        'notice'    => 'fa fa-fw fa-exclamation-circle',
        'info'      => 'fa fa-fw fa-info-circle',
        'debug'     => 'fa fa-fw fa-life-ring',
    ];

    /**
     * Create a new instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(ConfigContract $config)
    {
        $this->config = $config;
    }

    /**
     * Make level icon.
     *
     * @param string      $level
     * @param string|null $default
     *
     * @return string
     */
    public function icon($level, $default = null)
    {
        if (array_key_exists($level, $this->icons)) {
            return $this->icons[$level];
        }

        return $default;
    }

    /**
     * Get level color.
     *
     * @param string      $level
     * @param string|null $default
     *
     * @return string
     */
    public function color($level, $default = null)
    {
        return $this->get("colors.levels.$level", $default);
    }

    /**
     * Get config.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    private function get($key, $default = null)
    {
        return $this->config->get("log-viewer.$key", $default);
    }
}
