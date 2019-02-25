<?php

declare(strict_types=1);

if (! function_exists('alert')) {
    /**
     * Helper function to send an alert.
     *
     * @param string|null $message
     * @param string $level
     *
     * @return \Orchid\Alert\Alert
     */
    function alert($message = null, $level = 'info')
    {
        $notifier = app('alert');

        if (! is_null($message)) {
            return $notifier->message($message, $level);
        }

        return $notifier;
    }
}

if (! function_exists('setting')) {
    /**
     * @param string|array $key
     * @param null $default
     *
     * @return \Orchid\Support\Facades\Setting
     */
    function setting($key, $default = null)
    {
        return \Orchid\Support\Facades\Setting::get($key, $default);
    }
}

if (! function_exists('generate_form')) {
    /**
     * Generate a ready-made html form for display to the user.
     *
     * @param array $fields
     * @param array|\Orchid\Screen\Repository|null $data
     * @param string|null $language
     * @param string|null $prefix
     *
     * @throws \Throwable
     *
     * @return string
     */
    function generate_form(array $fields, $data = [], string $language = null, string $prefix = null)
    {
        if (is_array($data)) {
            $data = new \Orchid\Screen\Repository($data);
        }

        return (new \Orchid\Screen\Builder($fields, $data))
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
        $filter = new \Orchid\Platform\Filters\HttpFilter;

        return $filter->isSort($property);
    }
}

if (! function_exists('get_sort')) {

    /**
     * @param null $property
     *
     * @return string
     */
    function get_sort($property)
    {
        $filter = new \Orchid\Platform\Filters\HttpFilter;

        return $filter->getSort($property);
    }
}

if (! function_exists('get_filter')) {

    /**
     * @param null $property
     *
     * @return string|array
     */
    function get_filter($property)
    {
        $filter = new \Orchid\Platform\Filters\HttpFilter;

        return $filter->getFilter($property);
    }
}

if (! function_exists('get_filter_string')) {

    /**
     * @param null $property
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
     * @param null $property
     *
     * @return string
     */
    function revert_sort($property)
    {
        $filter = new \Orchid\Platform\Filters\HttpFilter;

        return $filter->revertSort($property);
    }
}

if (! function_exists('orchid_mix')) {
    /**
     * @param string $file
     * @param string $package
     * @param string $dir
     *
     * @return string
     * @throws Exception
     */
    function orchid_mix(string $file, string $package, string $dir = '') : string
    {
        $manifest = null;

        $in = \Orchid\Support\Facades\Dashboard::getPublicDirectory()
            ->get($package);

        $resources = (new \Symfony\Component\Finder\Finder())
            ->ignoreUnreadableDirs()
            ->in($in)
            ->files()
            ->path($dir.'mix-manifest.json');

        foreach ($resources as $resource) {
            $manifest = $resource;
        }

        if (is_null($manifest)) {
            throw new Exception('mix-manifest.json file not found');
        }

        $manifest = json_decode($manifest->getContents(), true);

        $mixPath = $manifest[$file];

        if (\Illuminate\Support\Str::startsWith($mixPath, '/')) {
            $mixPath = ltrim($mixPath, '/');
        }

        if (file_exists(public_path('/resources'))) {
            return url("/resources/$package/$mixPath");
        }

        return route('platform.resource', [$package, $mixPath]);
    }
}
