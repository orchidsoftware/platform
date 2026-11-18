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
     * @param iterable<array-key, mixed> $items
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

    /**
     * Return all items stored in the repository.
     *
     * @return array<array-key, mixed>
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * Return the number of stored repository items.
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param array<string, mixed>|string $key
     * @param mixed                       $value
     *
     * @return $this
     */
    public function set($key, $value = null): self
    {
        parent::set($key, $value);

        return $this;
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * Wrap each item in a repository instance.
     *
     * @param array<iterable<array-key, mixed>> $items
     *
     * @return array<self>
     */
    public static function elements(array $items): array
    {
        return collect($items)
            ->map(fn ($item) => new self($item))
            ->all();
    }
}
