<?php

namespace Orchid\Foundation\Services\Field;

interface FieldInterface
{
    /**
     * Create function Field.
     *
     * @param null $attributes
     * @param null $data
     * @return mixed
     */
    public function create($attributes, $data = null);
}
