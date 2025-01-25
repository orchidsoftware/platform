<?php

namespace Orchid\Screen\Components\Cells;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Percentage extends Component
{
    /**
     * Create a new component instance.
     *
     * @param float       $value
     * @param int         $decimals
     * @param string|null $decimal_separator
     * @param string|null $thousands_separator
     */
    public function __construct(
        protected float $value,
        protected int $decimals = 0,
        protected ?string $decimal_separator = '.',
        protected ?string $thousands_separator = ','
    ) {}

    /**
     * Get the view/contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return number_format($this->value * 100, $this->decimals, $this->decimal_separator, $this->thousands_separator).'%';
    }
}
