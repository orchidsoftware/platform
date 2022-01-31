<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Orchid\Alert\Alert;
use Orchid\Filters\HttpFilter;
use Orchid\Support\Color;
use Orchid\Support\Facades\Dashboard;
use Symfony\Component\Finder\Finder;

if (! function_exists('alert')) {
    /**
     * Helper function to send an alert.
     *
     * @param string|null $message
     * @param string|null $level
     *
     * @return Alert
     */
    function alert(string $message = null, string $level = null): Alert
    {
        $notifier = app(Alert::class);

        if ($level !== null) {
            $level = (string) Color::INFO();
        }

        if ($message !== null) {
            return $notifier->message($message, $level);
        }

        return $notifier;
    }
}

if (! function_exists('is_sort')) {

    /**
     * @param string $property
     *
     * @return bool
     */
    function is_sort(string $property): bool
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
    function get_sort(?string $property): string
    {
        $filter = new HttpFilter();

        return $filter->getSort($property);
    }
}

if (! function_exists('get_filter')) {

    /**
     * @param string $property
     *
     * @return string|array
     */
    function get_filter(string $property)
    {
        $filter = new HttpFilter();

        return $filter->getFilter($property);
    }
}

if (! function_exists('get_filter_string')) {

    /**
     * @param string $property
     *
     * @return string
     */
    function get_filter_string(string $property): ?string
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
     * @param string $property
     *
     * @return string
     */
    function revert_sort(string $property): string
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
     * @throws \Throwable
     *
     * @return string
     */
    function orchid_mix(string $file, string $package, string $dir = ''): string
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

        throw_if($manifest === null, 'mix-manifest.json file not found');

        $manifest = json_decode($manifest->getContents(), true);

        $mixPath = $manifest[$file];

        if (Str::startsWith($mixPath, '/')) {
            $mixPath = ltrim($mixPath, '/');
        }

        if ($mixUrl = config('app.mix_url', false)) {
            return $mixUrl."/resources/$package/$mixPath";
        }

        if (file_exists(public_path('/resources'))) {
            return url()->asset("/resources/$package/$mixPath");
        }

        return route('platform.resource', [$package, $mixPath]);
    }
}
