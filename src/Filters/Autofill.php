<?php

declare(strict_types=1);

namespace Orchid\Filters;

trait Autofill
{
    public function query(): iterable
    {
        return $this->request->only($this->parameters(), []);
    }
}
