<?php

declare(strict_types=1);

namespace Orchid\Presets;

use Laravel\Ui\Presets\Preset;
use Orchid\Platform\Dashboard;

class Source extends Preset
{
    /**
     * This pattern should be in the file, part of which should be exported.
     */
    public const ORCHID_MIX_CONFIG_PATTERN = "/(\/\* Orchid mix config start \*\/.*\/\* Orchid mix config end \*\/)/s";

    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install()
    {
        static::updatePackages();
        static::updatePackages(false);
        static::updateWebpackConfiguration();
        static::addBabelConfiguration();
        static::removeNodeModules();
    }

    /**
     * Update the given package array.
     *
     * @param array $packages
     * @param $configurationKey
     *
     * @return array
     */
    protected static function updatePackageArray(array $packages, $configurationKey)
    {
        $path = Dashboard::path('package.json');

        $orchidPackages = json_decode(file_get_contents($path), true);

        return $orchidPackages[$configurationKey] + $packages;
    }

    /**
     * Add orchid configurations to webpack.mix.js.
     */
    protected static function updateWebpackConfiguration()
    {
        $config = trim(self::config());
        $orchidConfig = trim(self::orchidConfig());

        $config .= PHP_EOL.PHP_EOL.$orchidConfig;
        file_put_contents(
            base_path('webpack.mix.js'),
            $config
        );
    }

    /**
     * Copy .bablerc file to root directory.
     */
    protected static function addBabelConfiguration()
    {
        copy(Dashboard::path('.babelrc'), base_path('.babelrc'));
    }

    /**
     * Takes config part of orchid's webpack.mix.js using a signature.
     * Using this signature, we prevent duplication of mix import and comments.
     * Then rewrite paths for correct sources and clean & non-conflict destination paths.
     *
     * @return string
     */
    protected static function orchidConfig(): string
    {
        $orchidConfig = file_get_contents(Dashboard::path('webpack.mix.js'));
        preg_match(self::ORCHID_MIX_CONFIG_PATTERN, $orchidConfig, $matches);

        $transformedConfig = count($matches) === 2 ? $matches[1] : '';

        $transformedConfig = str_replace([
            'resources/js',
            'resources/sass',
            'css/orchid.css',
            'js/orchid.js',
            'public/orchid',
            'public/js/',
        ], [
            'resources/js/orchid',
            'resources/sass/orchid',
            'public/resources/orchid/css/orchid.css',
            'public/resources/orchid/js/orchid.js',
            'public/resources/orchid',
            'public/resources/orchid/js/',
        ], $transformedConfig);

        return $transformedConfig;
    }

    /**
     * Takes root webpack.mix.js and removes orchid's config (if exists).
     *
     * @return false|string
     */
    protected static function config()
    {
        $webpack = base_path('webpack.mix.js');
        $config = file_exists($webpack) ? file_get_contents($webpack) : '';

        $config = preg_replace(self::ORCHID_MIX_CONFIG_PATTERN, '', $config);

        return $config;
    }
}
