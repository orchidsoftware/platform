<?php

declare(strict_types=1);

namespace Orchid\Screen\Concerns;

trait Makeable
{
    /**
     * Create a new Field element.
     *
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static)->name($name);
    }
}
