<?php

namespace Orchid\Log\Contracts\Utilities;

use Illuminate\Contracts\Config\Repository as ConfigContract;
use Orchid\Log\Entities\Log;

interface LogMenu
{
    /**
     * Set the config instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     *
     * @return self
     */
    public function setConfig(ConfigContract $config);

    /**
     * Set the log styler instance.
     *
     * @param \Orchid\Log\Contracts\Utilities\LogStyler $styler
     *
     * @return self
     */
    public function setLogStyler(LogStyler $styler);

    /**
     * Make log menu.
     *
     * @param \Orchid\Log\Entities\Log $log
     * @param bool                     $trans
     *
     * @return array
     */
    public function make(Log $log, $trans = true);
}
