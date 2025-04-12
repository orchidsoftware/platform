<?php

namespace Orchid\Screen\Concerns;

use Illuminate\Support\Collection;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;

trait HasFillablePublicProperties
{
    /**
     * Fills the public properties of the object with values from the given repository.
     *
     * @param \Orchid\Screen\Repository $repository The repository containing the values to fill the properties with.
     *
     * @return void
     */
    protected function fillPublicProperty(Repository $repository): void
    {
        $this->getPublicPropertyNames()
            ->map(fn (string $property) => $this->$property = $repository->get($property, $this->$property));
    }

    /**
     * Retrieves the names of all public properties of the object.
     *
     * @return \Illuminate\Support\Collection The names of the public properties.
     */
    protected function getPublicPropertyNames(): Collection
    {
        $properties = (new \ReflectionClass(static::class))->getProperties(\ReflectionProperty::IS_PUBLIC);
        $baseProperties = (new \ReflectionClass(Screen::class))->getProperties(\ReflectionProperty::IS_PUBLIC);

        return collect($properties)
            ->mapWithKeys(fn (\ReflectionProperty $property) => [$property->getName() => $property])
            ->filter(fn (\ReflectionProperty $property) => ! $property->isStatic())
            ->except(array_map(fn (\ReflectionProperty $property) => $property->getName(), $baseProperties))
            ->keys();
    }
}
