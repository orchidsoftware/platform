<?php

declare(strict_types=1);

namespace Orchid\Screen;

/**
 * Class Repository.
 */
class Repository extends \Illuminate\Config\Repository
{

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function getContent($key, $default = null)
    {
        return array_get($this->items, $key, $default);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }
}
