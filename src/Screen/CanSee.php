<?php

declare(strict_types=1);

namespace Orchid\Screen;

/**
 * Trait CanSee.
 */
trait CanSee
{
    /**
     * Serves as a presentation indicator.
     * If the value is false, the template will not be output.
     *
     * @var bool
     */
    private $display = true;

    /**
     * @return $this
     */
    public function canSee(bool $value): self
    {
        $this->display = $value;

        return $this;
    }

    public function isSee(): bool
    {
        return $this->display;
    }
}
