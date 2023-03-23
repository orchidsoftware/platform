<?php

namespace Orchid\Support;

class BootstrapIconsPath
{
    public static function getFolder(): string
    {
        return base_path('/vendor/twbs/bootstrap-icons/icons');
    }
}
