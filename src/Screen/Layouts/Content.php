<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

abstract class Content extends Layout
{
    /**
     * @var Repository|null
     */
    protected $query;

    /**
     * Key property for a query.
     *
     * @var mixed
     */
    protected $target;

    /**
     * Card constructor.
     *
     * @param mixed $target
     */
    public function __construct($target)
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
        return (string) $this->render($this->target);
    }
}
