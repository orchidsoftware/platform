<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

interface Fieldable
{
    /**
     * The process of creating.
     *
     * @return mixed
     */
    public function render();

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function get(string $key, $value = null);

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function set(string $key, $value);

    /**
     * Return the attributes configured for rendering.
     */
    public function getAttributes(): array;
}
