<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\Support\Arrayable;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class View.
 */
abstract class View extends Layout
{
    /**
     * View constructor.
     *
     * @param view-string                                   $template
     * @param Arrayable<string, mixed>|array<string, mixed> $data
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

        $defaults = $this->data instanceof Arrayable ? $this->data->toArray() : $this->data;

        return view($this->template, $repository->toArray(), $defaults);
    }
}
