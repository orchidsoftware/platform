<?php

use Orchid\Setting\Facades\Setting;

if (!function_exists('setting')) {
    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return Setting::get($key, $default);
    }
}
