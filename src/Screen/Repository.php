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

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function set($key, $value = null): self
    {
        parent::set($key, $value);

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public static function elements(array $items): array
    {
        return collect($items)
            ->map(fn ($item) => new self($item))
            ->all();
    }
}
