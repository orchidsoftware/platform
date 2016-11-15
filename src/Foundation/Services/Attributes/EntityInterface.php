<?php

namespace Orchid\Foundation\Attributes\Access;

interface EntityInterface
{
    /**
     * @return mixed
     */
    public function attributes();

    /**
     * @return mixed
     */
    public function getAttributes();
}
