<?php

declare(strict_types=1);

namespace Orchid\Presenter;

use ReflectionClass;
use RuntimeException;

/**
 * Adds presenter resolution to any class.
 *
 * Resolution priority:
 *   1. Runtime override set via presenter($class)
 *   2. #[UsePresenter(…)] attribute on the class
 *   3. RuntimeException if neither is defined
 */
trait Presentable
{
    /**
     * Return a presenter instance, optionally overriding the presenter class for this instance.
     *
     * @param class-string<Presenter>|null $class
     */
    public function presenter(?string $class = null): Presenter
    {
        if ($class !== null) {
            return new $class($this);
        }


        $attribute = $this->findPresenterAttribute();

        if ($attribute !== null) {
            $class = $attribute->newInstance()->presenter;

            return new $class($this);
        }

        throw new RuntimeException(sprintf(
            'No presenter found for [%s]. Add #[UsePresenter(YourPresenter::class)] to the class or call presenter($class) at runtime.',
            static::class,
        ));
    }


    /**
     * @param ReflectionClass $ref
     * @return \ReflectionAttribute|null
     */
    private function findPresenterAttribute(ReflectionClass $reflectionClass = null): ?\ReflectionAttribute
    {
        if ($reflectionClass === null) {
            $reflectionClass = new ReflectionClass($this);
        }

        $attributes = $reflectionClass
            ->getAttributes(UsePresenter::class, \ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            return $attribute;
        }

        $parent = $reflectionClass->getParentClass();

        return $parent ? $this->findPresenterAttribute($parent) : null;
    }
}
