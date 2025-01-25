<?php

namespace Orchid\Screen\Components\Cells;

use Closure;
use DateTimeZone;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class DateTime extends Component
{
    /**
     * Create a new component instance.
     *
     * @param float                     $value
     * @param string                    $format
     * @param \DateTimeZone|string|null $tz
     */
    public function __construct(
        protected mixed $value,
        protected string $format = 'Y-m-d H:i',
        protected DateTimeZone|null|string $tz = null,
    ) {}

    /**
     * Get the view/contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return Carbon::parse($this->value, $this->tz)->translatedFormat($this->format);
    }
}
