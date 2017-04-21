<?php

namespace Orchid\Behaviors\Contract;

interface SingleInterface
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
