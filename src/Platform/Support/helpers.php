<?php

if (!function_exists('alert')) {
    /**
     * Helper function to send an alert.
     *
     * @param string|null $message
     * @param string      $level
     *
     * @return \Orchid\Platform\Alert\Alert
     */
    function alert($message = null, $level = 'info')
    {
        $notifier = app('alert');

        if (!is_null($message)) {
            return $notifier->message($message, $level);
        }

        return $notifier;
    }
}

if (!function_exists('setting')) {
    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return \Orchid\Platform\Facades\Setting::get($key, $default);
    }
}

if (!function_exists('generate_form')) {
    /**
     * @param array       $fields
     * @param             $data
     * @param string|null $language
     * @param string|null $prefix
     *
     * @return mixed
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    function generate_form(array $fields, $data, string $language = null, string $prefix = null)
    {
        if (is_array($data)) {
            $data = new \Orchid\Platform\Screen\Repository($data);
        }

        $form = new \Orchid\Platform\Fields\Builder($fields, $data, $language, $prefix);

        try {
            return $form->generateForm();
        } catch (\Orchid\Platform\Exceptions\TypeException $e) {
        }
    }
}
