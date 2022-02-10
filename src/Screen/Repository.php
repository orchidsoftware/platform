<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Countable;
use Illuminate\Support\Arr;

/**
 * Class Repository.
 */
class Repository extends \Illuminate\Config\Repository implements Countable
{
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * Create a new configuration repository.
     *
     * @param iterable $items
     *
     * @return void
     */
    public function __construct(iterable $items = [])
    {
        $this->items = collect($items)->all();
    }

    /**
     * @param string     $key
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
}
