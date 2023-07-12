<?php

namespace Orchid\Support;

class BootstrapIconsPath
{
    /**
     * Get the folder path of the Bootstrap Icons.
     */
    public static function getFolder(): string
    {
        return base_path('/vendor/twbs/bootstrap-icons/icons');
    }
}
