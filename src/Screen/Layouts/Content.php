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

    /**
     * Resolve content from the repository and render it as a string.
     */
    public function build(Repository $repository): string
    {
        $this->query = $repository;

        if (is_string($this->target) || is_array($this->target)) {
            $this->target = $repository->get($this->target, $this->target);
        }

        return (string) $this;
    }

    /**
     * Render the resolved content or fail when no renderer is available.
     */
    public function __toString(): string
    {
        if (method_exists($this, 'render')) {
            return (string) $this->render($this->target);
        }

        throw new \RuntimeException('Method render not found');
    }
}
