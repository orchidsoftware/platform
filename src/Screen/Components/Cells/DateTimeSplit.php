<?php

namespace Orchid\Screen\Components\Cells;

use Closure;
use DateTimeZone;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class DateTimeSplit extends Component
{
    /**
     * Create a new component instance.
     *
     * @param float                     $value
     * @param string                    $upperFormat
     * @param string                    $lowerFormat
     * @param \DateTimeZone|string|null $tz
     */
    public function __construct(
        protected mixed $value,
        protected string $upperFormat = 'M j, Y',
        protected string $lowerFormat = 'D, H:i',
        protected DateTimeZone|null|string $tz = null,
    ) {}

    /**
     * Get the view/contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        $date = Carbon::parse($this->value, $this->tz);

        return sprintf('<time class="mb-0 text-capitalize">%s<span class="text-muted d-block">%s</span></time>',
            $date->translatedFormat($this->upperFormat),
            $date->translatedFormat($this->lowerFormat),
        );
    }
}
