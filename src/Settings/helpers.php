<?php

use Orchid\Settings\Facades\Setting;

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

if (!function_exists('setting_set')) {
    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    function setting_set(string $key, $value)
    {
        return Setting::set($key, $value);
    }
}

if (!function_exists('setting_forget')) {
    /**
     * @param $key
     *
     * @return mixed
     */
    function setting_forget(string $key)
    {
        return Setting::forget($key);
    }
}
