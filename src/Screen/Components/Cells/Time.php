<?php

namespace Orchid\Screen\Components\Cells;

use Closure;
use DateTimeZone;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class Time extends Component
{
    /**
     * Create a new component instance.
     *
     * @param float                     $value
     * @param \DateTimeZone|string|null $tz
     * @param string                    $unitPrecision
     */
    public function __construct(
        protected mixed $value,
        protected DateTimeZone|null|string $tz = null,
        protected string $unitPrecision = 'minute'
    ) {}

    /**
     * Get the view/contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return Carbon::parse($this->value, $this->tz)->toTimeString($this->unitPrecision);
    }
}
