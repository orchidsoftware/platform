<?php

declare(strict_types=1);

namespace Orchid\Filters;

trait Autofill
{
    abstract public function parameters(): ?iterable;
    
    public function query(): iterable
    {
        return $this->request->only($this->parameters(), []);
    }
}
