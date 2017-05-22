<?php

namespace Orchid\Behaviors\Contract;

interface ManyInterface
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
     * @return array
     */
    public function generateGrid() : array;

    /**
     * @return mixed
     */
    public function render();
}
