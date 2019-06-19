<?php

declare(strict_types=1);

use Orchid\Alert\Alert;
use Orchid\Screen\Builder;
use Illuminate\Support\Str;
use Orchid\Screen\Repository;
use Orchid\Filters\HttpFilter;
use Orchid\Support\Facades\Setting;
use Symfony\Component\Finder\Finder;
use Orchid\Support\Facades\Dashboard;

if (! function_exists('alert')) {
    /**
     * Helper function to send an alert.
     *
     * @param string|null $message
     * @param string      $level
     *
     * @return Alert
     */
    function alert($message = null, $level = 'info')
    {
        $notifier = app(Alert::class);

        if (! is_null($message)) {
            return $notifier->message($message, $level);
        }

        return $notifier;
    }
}

if (! function_exists('setting')) {
    /**
     * @param string|array $key
     * @param null         $default
     *
     * @return Setting
     */
    function setting($key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('generate_form')) {
    /**
     * Generate a ready-made html form for display to the user.
     *
     * @param array                 $fields
     * @param array|Repository|null $data
     * @param string|null           $language
     * @param string|null           $prefix
     *
     *@throws \Throwable
     *
     * @return string
     */
    function generate_form(array $fields, $data = [], string $language = null, string $prefix = null)
    {
        if (is_array($data)) {
            $data = new Repository($data);
        }

        return (new Builder($fields, $data))
            ->setLanguage($language)
            ->setPrefix($prefix)
            ->generateForm();
    }
}

if (! function_exists('is_sort')) {

    /**
     * @param null $property
     *
     * @return bool
     */
    function is_sort($property = null)
    {
        $filter = new HttpFilter();

        return $filter->isSort($property);
    }
}

if (! function_exists('get_sort')) {

    /**
     * @param null|string $property
     *
     * @return string
     */
    function get_sort($property)
    {
        $filter = new HttpFilter();

        return $filter->getSort($property);
    }
}

if (! function_exists('get_filter')) {

    /**
     * @param null|string $property
     *
     * @return string|array
     */
    function get_filter($property)
    {
        $filter = new HttpFilter();

        return $filter->getFilter($property);
    }
}

if (! function_exists('get_filter_string')) {

    /**
     * @param null|string $property
     *
     * @return string
     */
    function get_filter_string($property)
    {
        $filter = get_filter($property);

        if (is_array($filter)) {
            return implode(', ', $filter);
        }

        return $filter;
    }
}

if (! function_exists('revert_sort')) {

    /**
     * @param null|string $property
     *
     * @return string
     */
    function revert_sort($property)
    {
        $filter = new HttpFilter();

        return $filter->revertSort($property);
    }
}

if (! function_exists('orchid_mix')) {
    /**
     * @param string $file
     * @param string $package
     * @param string $dir
     *
     * @throws Exception
     *
     * @return string
     */
    function orchid_mix(string $file, string $package, string $dir = '') : string
    {
        $manifest = null;

        $in = Dashboard::getPublicDirectory()
            ->get($package);

        $resources = (new Finder())
            ->ignoreUnreadableDirs()
            ->in($in)
            ->files()
            ->path($dir.'mix-manifest.json');

        foreach ($resources as $resource) {
            $manifest = $resource;
        }

        if (is_null($manifest)) {
            throw new \Exception('mix-manifest.json file not found');
        }

        $manifest = json_decode($manifest->getContents(), true);

        $mixPath = $manifest[$file];

        if (Str::startsWith($mixPath, '/')) {
            $mixPath = ltrim($mixPath, '/');
        }

        if (file_exists(public_path('/resources'))) {
            return url("/resources/$package/$mixPath");
        }

        return route('platform.resource', [$package, $mixPath]);
    }
}
