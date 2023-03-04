<?php

declare(strict_types=1);

namespace Orchid\Support;

abstract class Presenter
{
    /**
     * @var object
     */
    protected $entity;

    public function __construct(object $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Allow for property-style retrieval.
     *
     *
     * @return mixed
     */
    public function __get(string $property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }

        return $this->entity->{$property};
    }

    /**
     * Provide compatibility for the checking.
     *
     *
     * @return bool
     */
    public function __isset($property)
    {
        return property_exists($this, $property) || property_exists($this->entity, $property);
    }
}
