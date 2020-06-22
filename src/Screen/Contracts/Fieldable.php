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
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function get(string $key, $value = null);

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
