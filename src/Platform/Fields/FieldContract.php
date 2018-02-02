<?php

declare(strict_types=1);

namespace Orchid\Platform\Fields;

interface FieldContract
{
    /**
     * Get the name of the template.
     *
     * @return string
     */
    public function getView() : string;

    /**
     * Get the name of the template.
     *
     * @return array
     */
    public function getRequired() : array;

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
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function get($key, $value = null);

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function set($key, $value);

    /**
     * @return array
     */
    public function getAttributes() : array;
}
