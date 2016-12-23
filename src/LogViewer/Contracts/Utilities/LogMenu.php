<?php

namespace Orchid\LogViewer\Contracts\Utilities;

use Orchid\LogViewer\Entities\Log;
use Illuminate\Contracts\Config\Repository as ConfigContract;

/**
 * Interface  LogMenu.
 *
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface LogMenu
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Set the config instance.
     *
     * @param  \Illuminate\Contracts\Config\Repository $config
     *
     * @return self
     */
    public function setConfig(ConfigContract $config);

    /**
     * Set the log styler instance.
     *
     * @param  \Orchid\LogViewer\Contracts\Utilities\LogStyler $styler
     *
     * @return self
     */
    public function setLogStyler(LogStyler $styler);

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
    public function make(Log $log, $trans = true);
}
