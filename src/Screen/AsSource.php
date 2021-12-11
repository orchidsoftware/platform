<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Support\Arr;

/**
 * Trait AsSource.
 */
trait AsSource
{
    /**
     * @param string $field
     *
     * @return mixed|null
     */
    public function getContent(string $field)
    {
        return Arr::get($this->toArray(), $field)
            ?? Arr::get($this->getRelations(), $field)
            ?? $this->getAttribute($field);
    }
}
