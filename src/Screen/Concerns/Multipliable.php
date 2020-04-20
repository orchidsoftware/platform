<?php

declare(strict_types=1);

namespace Orchid\Screen\Concerns;

use Illuminate\Support\Str;

trait Multipliable
{
    /**
     * @return self
     */
    public function multiple(): self
    {
        $name = Str::finish($this->get('name'), '.');

        $this->set('multiple', 'multiple')
            ->set('name', $name);

        return $this;
    }
}
