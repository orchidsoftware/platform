<?php

declare(strict_types=1);

namespace Orchid\Filters;

abstract class BaseHttpEloquentFilter extends Filter
{
    /**
     * @var string
     */
    protected $column;

    public function __construct(string $column)
    {
        parent::__construct();
        $this->column = $column;
    }

    /**
     * The array of matched parameters.
     */
    public function parameters(): ?array
    {
        return ['filter.'.$this->column];
    }

    /**
     * @return mixed
     */
    public function getHttpValue()
    {
        return $this->request->input('filter.'.$this->column);
    }
}
