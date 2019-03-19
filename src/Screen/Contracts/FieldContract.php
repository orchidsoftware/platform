<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

interface FieldContract
{
    /**
     * Get the name of the template.
     *
     * @return string
     */
    public function getView(): string;

    /**
     * Get the name of the template.
     *
     * @return array
     */
    public function getRequired(): array;

    /**
     * The process of creating.
     *
     * @return mixed
     */
    public function render();

    /**
     * @return mixed
     */
    public function checkRequired();

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function get($key, $value = null);

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function set(string $key, $value);

    /**
     * @return array
     */
    public function getAttributes(): array;
}
