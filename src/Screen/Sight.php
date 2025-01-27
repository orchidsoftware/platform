<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class Sight extends Cell
{
    /**
     * Builds a column heading.
     */
    public function buildDt(): View
    {
        return view('platform::partials.layouts.dt', [
            'column'  => $this->column,
            'title'   => $this->title,
            'popover' => $this->popover,
        ]);
    }

    /**
     * Builds content for the column.
     */
    public function buildDd(Repository|Model $repository): mixed
    {
        $value = $this->render
            ? $this->handler($repository)
            : $repository->getContent($this->name);

        return $this->render === null
            ? e($value)
            : $value;
    }
}
