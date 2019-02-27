<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Support\Arr;
use Iterator;
use Countable;

/**
 * Class Repository.
 */
class Repository extends \Illuminate\Config\Repository implements Iterator, Countable
{
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function getContent(string $key, $default = null)
    {
        return Arr::get($this->items, $key, $default);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->items[$this->position];
    }

    /**
     * @return int|mixed
     */
    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->items[$this->position]);
    }
}
