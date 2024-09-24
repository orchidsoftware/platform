<?php

declare(strict_types=1);

namespace Orchid\Screen;

/**
 * Trait CanSee
 *
 * This trait provides a mechanism to control the visibility of an element in a template.
 * It allows developers to conditionally display or hide components based on a boolean flag.
 */
trait CanSee
{
    /**
     * Determines whether the element should be displayed.
     *
     * If set to `false`, the element will be hidden and not rendered in the output.
     *
     * @var bool
     */
    private $display = true;

    /**
     * Set the visibility of the element.
     *
     * This method allows toggling the visibility of the component.
     * If set to `false`, the component will not be included in the rendered template.
     *
     * @param bool $value The visibility status. `true` to display, `false` to hide.
     *
     * @return $this
     */
    public function canSee(bool $value): self
    {
        $this->display = $value;

        return $this;
    }

    /**
     * Check if the element is visible.
     *
     * This method returns the current visibility status of the component.
     *
     * @return bool `true` if the element is visible, `false` if it is hidden.
     */
    public function isSee(): bool
    {
        return $this->display;
    }
}
