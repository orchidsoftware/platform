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
        if ($this->isRelation($field) && !$this->relationLoaded($field)) {
            return null;
        }
        return $this->getAttribute($field);
    }
}
