<?php

namespace Orchid\Screen\Components\Cells;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Boolean extends Component
{
    /**
     * Create a new component instance.
     *
     * @param bool        $value
     * @param string|null $falseLabel
     */
    public function __construct(
        public ?bool $value,
        public ?string $true = null,
        /**
         * Optional label displayed for a false value.
         */
        public ?string $false = null
    ) {}

    /**
     * Get the view/contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        $class = 'me-1 '.($this->value ? 'text-success' : 'text-danger');
        $label = $this->value ? $this->true : $this->false;

        return "<span class='$class'>●</span>".$label;
    }
}
