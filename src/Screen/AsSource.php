<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Support\Arr;

/**
 * Trait AsSource
 *
 * This trait provides a method for retrieving the value of a given field from an object.
 * The field can be a key in the object's array representation, a relation, or an attribute.
 * If the field is not found in any of these locations, the method returns null.
 */
trait AsSource
{
    /**
     * Retrieve the value of a given field from the object.
     *
     * @param string $field The name of the field to retrieve.
     *
     * @return mixed|null The value of the field, or null if the field is not found.
     */
    public function getContent(string $field)
    {
        return Arr::get($this->toArray(), $field) // Try to get the field value from the object's array representation.
            ?? Arr::get($this->getRelations(), $field) // Try to get the field value from the object's relations.
            ?? $this->getAttribute($field);  // Try to get the field value from the object's attributes.
    }
}
