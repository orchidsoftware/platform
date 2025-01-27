<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

abstract class Content extends Layout
{
    protected Repository $query;

    /**
     * Key property for a query.
     */
    protected mixed $target;

    /**
     * Card constructor.
     */
    public function __construct(mixed $target)
    {
        $this->target = $target;
    }

    public function build(Repository $repository): string
    {
        $this->query = $repository;

        if (is_string($this->target) || is_array($this->target)) {
            $this->target = $repository->get($this->target, $this->target);
        }

        return (string) $this;
    }

    public function __toString(): string
    {
        if (method_exists($this, 'render')) {
            return (string) $this->render($this->target);
        }

        throw new \RuntimeException('Method render not found');
    }
}
