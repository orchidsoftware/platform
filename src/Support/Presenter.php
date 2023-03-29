<?php

declare(strict_types=1);

namespace Orchid\Support;

/**
 * This presenter class provides methods for presenting data from the Eloquent model.
 *
 * A presenter is responsible for encapsulating the logic for presenting data in a particular format.
 * By using a presenter, you can keep your model and view logic separate and maintainable.
 */
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
     * @return bool
     */
    public function __isset($property)
    {
        return property_exists($this, $property) || property_exists($this->entity, $property);
    }
}
