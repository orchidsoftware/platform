<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\Support\Arrayable;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class View.
 *
 * @phpstan-consistent-constructor
 */
class View extends Layout
{
    public static function make(string $template, array|Arrayable $data = []): static
    {
        return new static($template, $data);
    }

    /**
     * View constructor.
     *
     * @param Arrayable|array $data
     */
    public function __construct(string $template, private $data = [])
    {
        $this->template = $template;
    }

    /**
     * @return mixed
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $data = array_merge($this->data instanceof Arrayable ? $this->data->toArray() : $this->data, $repository->toArray());

        return view($this->template, $data);
    }
}
