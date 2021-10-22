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
        if($this->isRelation($field)){
            if($this->relationLoaded($field)){
                return $field;
            }
            return null;
        }
        
        return $this->getAttribute($field);
    }
}
