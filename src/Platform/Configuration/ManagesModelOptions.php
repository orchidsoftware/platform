<?php

namespace Orchid\Platform\Configuration;

use Illuminate\Support\Arr;

trait ManagesModelOptions
{
    /**
     * Registered replacements for Orchid model classes.
     *
     * @var array<string, class-string>
     */
    protected array $registeredReplaceModels = [];

    /**
     * Get the model instance for a given key or class name.
     */
    public function modelClass(string $key, ?string $default = null): mixed
    {
        $model = $this->model($key, $default);

        return class_exists($model) ? new $model : $model;
    }

    /**
     * Get the class name for a given Dashboard model.
     *
     * @template TFallback of string
     *
     * @param TFallback      $key
     * @param TFallback|null $default
     *
     * @return class-string|TFallback
     */
    public function model(string $key, ?string $default = null): string
    {
        return Arr::get($this->registeredReplaceModels, $key, $default ?? $key);
    }

    /**
     * Register a replacement model.
     *
     * @param class-string $custom
     */
    public function useModel(string $key, string $custom): static
    {
        $this->registeredReplaceModels[$key] = $custom;

        return $this;
    }
}
