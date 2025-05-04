<?php

declare(strict_types=1);

use Orchid\Alert\Alert;
use Orchid\Filters\HttpFilter;
use Orchid\Support\Color;

if (! function_exists('alert')) {
    /**
     * Helper function to send an alert.
     */
    function alert(?string $message = null, Color $color = Color::INFO): Alert
    {
        $notifier = app(Alert::class);

        if ($message !== null) {
            return $notifier->message($message, $color);
        }

        return $notifier;
    }
}

if (! function_exists('is_sort')) {
    function is_sort(string $property): bool
    {
        return (new HttpFilter)->isSort($property);
    }
}

if (! function_exists('get_sort')) {
    function get_sort(?string $property): string
    {
        return (new HttpFilter)->getSort($property);
    }
}

if (! function_exists('get_filter')) {
    /**
     * @return string|array|null
     */
    function get_filter(string $property)
    {
        return (new HttpFilter)->getFilter($property);
    }
}

if (! function_exists('revert_sort')) {
    function revert_sort(string $property): string
    {
        return (new HttpFilter)->revertSort($property);
    }
}
