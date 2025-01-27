<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\Support\Arrayable;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

abstract class View extends Layout
{
    private array $data;

    /**
     * @param string          $template
     * @param array|Arrayable $data
     */
    public function __construct(string $template, array|Arrayable $data = [])
    {
        $this->template = $template;
        $this->data = $data;
    }

    public function build(Repository $repository): ?\Illuminate\Contracts\View\View
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
        }

        $data = array_merge($this->data, $repository->toArray());

        return view($this->template, $data);
    }
}
