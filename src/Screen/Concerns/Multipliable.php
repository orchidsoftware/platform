<?php

declare(strict_types=1);

namespace Orchid\Screen\Concerns;

trait Multipliable
{
    /**
     * @return $this
     */
    public function multiple(): self
    {
        $this->set('multiple', 'multiple');
        $this->inlineAttributes[] = 'multiple';

        return $this;
    }
}
