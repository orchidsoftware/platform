<?php

namespace Orchid\Support;

class BootstrapIconsPath
{
    public static function getFolder(): string
    {
        $current = dirname(__DIR__, 3);

        return realpath($current.'/twbs/bootstrap-icons/icons');
    }
}
