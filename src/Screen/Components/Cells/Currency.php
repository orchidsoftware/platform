<?php

namespace Orchid\Screen\Components\Cells;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Currency extends Component
{
    /**
     * Create a new component instance.
     *
     * @param float       $value
     * @param int         $decimals
     * @param string|null $decimal_separator
     * @param string|null $thousands_separator
     * @param string|null $before
     * @param string|null $after
     * @param string|null $empty string value if empty
     */
    public function __construct(
        protected float $value,
        protected int $decimals = 2,
        protected ?string $decimal_separator = '.',
        protected ?string $thousands_separator = ',',
        protected ?string $before = '',
        protected ?string $after = '',
        protected ?string $empty = '',
    ) {
    }

    /**
     * Get the view/contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if(empty($this->value)) {
            $value = $this->empty;
        }
        else {
            $value = number_format($this->value, $this->decimals, $this->decimal_separator, $this->thousands_separator);
        }

        return Str::of($value)
            ->prepend($this->before.' ')
            ->append(' '.$this->after)
            ->trim()
            ->toString();
    }
}
