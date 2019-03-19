<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Layouts;

use Orchid\Screen\Layouts\Selection;

class EntitiesSelection extends Selection
{
    /**
     * @var array
     */
    public $filters = [];

    /**
     * EntitiesSelection constructor.
     *
     * @param array $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        return $this->filters;
    }
}
