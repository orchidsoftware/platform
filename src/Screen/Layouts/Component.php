<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\Container\BindingResolutionException;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Support\Blade;

/**
 * Class Component.
 */
abstract class Component extends Layout
{
    /**
     * Additional data passed to the Blade component.
     *
     * @var array<string, mixed>
     */
    private array $data = [];

    /**
     * Component constructor.
     */
    public function __construct(private readonly string $component) {}

    /**
     * @throws BindingResolutionException
     *
     * @return mixed
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $data = array_merge($repository->toArray(), $this->data);

        return Blade::componentView($this->component, $data);
    }

    /**
     * Merge additional data into the component rendering context.
     *
     * @param array<string, mixed> $data
     */
    public function with(array $data): self
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }
}
