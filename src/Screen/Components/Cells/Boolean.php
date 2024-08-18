<?php

namespace Orchid\Screen\Components\Cells;

use Illuminate\View\Component;

class Boolean extends Component
{
    /**
     * @var float
     */
    public ?bool $value;
    public ?string $false;
    public ?string $true;

    /**
     * Create a new component instance.
     *
     * @param bool        $value
     * @param string|null $true
     * @param string|null $falseLabel
     */
    public function __construct(?bool $value, ?string $true = null, ?string $false = null)
    {
        $this->value = $value;
        $this->true = $true;
        $this->false = $false;
    }

    /**
     * Get the view/contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $class = 'me-1 '.($this->value ? 'text-success' : 'text-danger');
        $label = $this->value ? $this->true : $this->false;

        return "<span class='$class'>●</span>".$label;
    }
}
