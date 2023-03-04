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
     *
     * @return void
     */
    public function __construct(iterable $items = [])
    {
        $this->items = collect($items)->all();
    }

    /**
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function getContent(string $key, $default = null)
    {
        return Arr::get($this->items, $key, $default);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }
}
