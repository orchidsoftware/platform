<?php

namespace Orchid\Platform\Configuration;

use Illuminate\Support\Arr;

trait ManagesModelOptions
{
    /**
     * Get the model instance for a given key or class name.
     *
     * @return mixed
     */
    public static function modelClass(string $key, ?string $default = null)
    {
        $model = static::model($key, $default);

        return class_exists($model) ? new $model : $model;
    }

    /**
     * Get the class name for a given Dashboard model.
     */
    public static function model(string $key, ?string $default = null): string
    {
        return Arr::get(static::$options, 'models.'.$key, $default ?? $key);
    }

    /**
     * Get the user model class name.
     */
    public static function useModel(string $key, string $custom): void
    {
        static::$options['models'][$key] = $custom;
    }
}
