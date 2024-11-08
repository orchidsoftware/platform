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
    public function getContent(string $field): mixed
    {
        // When field does not contain a dot, it is a simple field name.
        // And we not need to use cast model to array for this case.
        if (!str_contains($field, '.')) {
            return $this->getAttribute($field);
        }

        return $this->getAttribute($field) // Try to get the field value from the object's attributes.
            ?? Arr::get($this->getRelations(), $field) // Try to get the field value from the object's relations.
            ?? Arr::get($this, $field); // Try to get the field value from the object's array representation.
    }
}
