<?php

namespace Orchid\Log\Contracts\Utilities;

interface LogStyler
{
    /**
     * Make level icon.
     *
     * @param string      $level
     * @param string|null $default
     *
     * @return string
     */
    public function icon($level, $default = null);

    /**
     * Get level color.
     *
     * @param string      $level
     * @param string|null $default
     *
     * @return string
     */
    public function color($level, $default = null);
}
