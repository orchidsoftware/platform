<?php

namespace Orchid\Screen\Concerns;

use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Queue\SerializesAndRestoresModelIdentifiers;

/**
 * This trait is designed for managing the state of Eloquent models. It uses
 * the SerializesModels functionality to ensure proper serialization of the model
 * when working with queues and allows loading the state of the model from the database.
 *
 * Use this trait in classes where you need to load the model's state
 * from the database, such as in screens or other components that work with models.
 */
trait ModelStateRetrievable
{
    use SerializesAndRestoresModelIdentifiers;

    /**
     * Prepare the instance values for serialization.
     *
     * @return array
     */
    public function __serialize()
    {
        $values = [];

        $reflectionClass = new \ReflectionClass($this);

        [$properties, $classLevelWithoutRelations] = [
            $reflectionClass->getProperties(),
            ! empty($reflectionClass->getAttributes(WithoutRelations::class)),
        ];

        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }

            if (! $property->isInitialized($this)) {
                continue;
            }

            $value = $this->getPropertyValue($property);

            if ($property->hasDefaultValue() && $value === $property->getDefaultValue()) {
                continue;
            }

            $name = $property->getName();

            if ($property->isPrivate() || $property->isProtected()) {
                continue;
            }

            $values[$name] = $this->getSerializedPropertyValue(
                $value,
                ! $classLevelWithoutRelations &&
                empty($property->getAttributes(WithoutRelations::class))
            );
        }

        return $values;
    }

    /**
     * Restore the model after serialization.
     *
     * @param array $values
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function __unserialize(array $values)
    {
        $default = $this->getDefaultPropertyWithConstructor();

        $values = array_merge($default, $values);

        $properties = (new \ReflectionClass($this))->getProperties();

        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $name = $property->getName();

            if (! array_key_exists($name, $values)) {
                continue;
            }

            $property->setValue(
                $this, $this->getRestoredPropertyValue($values[$name])
            );
        }
    }

    /**
     * Get the property value for the given property.
     *
     * @param \ReflectionProperty $property
     *
     * @return mixed
     */
    protected function getPropertyValue(\ReflectionProperty $property)
    {
        return $property->getValue($this);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     *
     * @return array
     */
    protected function getDefaultPropertyWithConstructor(): array
    {
        $default = app()->make(static::class);

        $defaultReflection = (new \ReflectionClass($default))->getProperties();

        return collect($defaultReflection)
            ->mapWithKeys(fn (\ReflectionProperty $property) => [$property->getName() => $property->getValue($default)])
            ->all();
    }
}
