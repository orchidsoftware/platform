<?php

namespace Orchid\Type;

interface PageInterface
{
    /**
     * @return array
     */
    public function rules() : array;

    /**
     * @return bool
     */
    public function isValid() : bool;

    /**
     * @return mixed
     */
    public function render();
}
