<?php

declare(strict_types=1);

namespace Orchid\Presenter;

/**
 * Base class for presenting data from an Eloquent model or any other object.
 *
 * Encapsulates display logic so models stay free of view-related concerns.
 */
abstract class Presenter
{
    /**
     * Wrap the entity whose values the presenter exposes.
     */
    public function __construct(
        /**
         * The entity instance being presented.
         */
        protected object $entity
    ) {}

    /**
     * Allow property-style access: falls back to a same-named method, then to the entity.
     */
    public function __get(string $property): mixed
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }

        return $this->entity->{$property};
    }

    /**
     * Check whether a property exists on the presenter or the underlying entity.
     */
    public function __isset(string $property): bool
    {
        return property_exists($this, $property)
            || property_exists($this->entity, $property);
    }
}
