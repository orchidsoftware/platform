<?php

namespace Orchid\Platform\Configuration;

use Composer\InstalledVersions;

trait ManagesPackage
{
    /**
     * Get the version number of the application.
     */
    public static function version(): string
    {
        return InstalledVersions::getVersion('orchid/platform');
    }

    /**
     * The real path to the package files.
     */
    public static function path(string $path = ''): string
    {
        $current = InstalledVersions::getInstallPath('orchid/platform');

        return realpath($current.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }
}
