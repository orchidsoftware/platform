<?php

namespace Orchid\Screen\Components\Cells;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Boolean extends Component
{

    public ?bool $value;
    public ?string $false;
    public ?string $true;

    /**
     * Create a new component instance.
     *
     * @param bool        $value
     * @param string|null $true
     * @param string|null $false
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
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        $class = 'me-1 '.($this->value ? 'text-success' : 'text-danger');
        $label = $this->value ? $this->true : $this->false;

        return "<span class='$class'>●</span>".$label;
    }
}
