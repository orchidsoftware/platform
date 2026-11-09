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

        $data = array_merge($this->data, $repository->toArray());

        return view($this->template, $data);
    }
}
