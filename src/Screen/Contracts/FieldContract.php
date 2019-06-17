<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

use Illuminate\Contracts\Support\Renderable;

interface FieldContract extends Renderable
{
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
