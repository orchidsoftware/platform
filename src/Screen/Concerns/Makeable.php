<?php

declare(strict_types=1);

namespace Orchid\Screen\Concerns;

trait Makeable
{
    /**
     * Create a new Field element.
     */
    public static function make(?string $name = null): static
    {
        return (new static)->name($name);
    }
}
