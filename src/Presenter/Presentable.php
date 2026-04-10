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
    private ?string $presenterClass = null;

    /**
     * Return a presenter instance, optionally overriding the presenter class for this instance.
     *
     * @param  class-string<Presenter>|null  $class
     */
    public function presenter(?string $class = null): Presenter
    {
        if ($class !== null) {
            $this->presenterClass = $class;
        }

        return new ($this->resolvePresenterClass())($this);
    }

    /**
     * @return class-string<Presenter>
     *
     * @throws RuntimeException
     */
    private function resolvePresenterClass(): string
    {
        if ($this->presenterClass !== null) {
            return $this->presenterClass;
        }

        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(UsePresenter::class);

        if ($attributes !== []) {
            return $attributes[0]->newInstance()->presenter;
        }

        throw new RuntimeException(sprintf(
            'No presenter found for [%s]. Add #[UsePresenter(YourPresenter::class)] to the class or call presenter($class) at runtime.',
            static::class,
        ));
    }
}
