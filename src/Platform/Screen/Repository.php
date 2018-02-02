<?php

declare(strict_types=1);

namespace Orchid\Platform\Screen;

class Repository
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * Repository constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function getContent($key, $default = null)
    {
        return array_get($this->attributes, $key, $default);
    }
}
