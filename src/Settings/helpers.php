<?php

use Orchid\Foundation\Facades\Setting;

if (!function_exists('settings')) {
    /**
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    function settings($key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('settings_set')) {
    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    function settings_set(string $key, $value)
    {
        return Setting::set($key, $value);
    }
}

if (!function_exists('settings_forget')) {
    /**
     * @param $key
     *
     * @return mixed
     */
    function settings_forget(string $key)
    {
        return Setting::forget($key);
    }
}
