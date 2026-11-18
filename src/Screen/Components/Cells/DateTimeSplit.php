<?php

namespace Orchid\Screen\Components\Cells;

use Carbon\Month;
use Carbon\WeekDay;
use DateTimeInterface;
use DateTimeZone;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class DateTimeSplit extends Component
{
    /**
     * @param DateTimeInterface|WeekDay|Month|string|int|float|null $value
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
     * @return View|\Closure|string
     */
    public function render()
    {
        $date = Carbon::parse($this->value, $this->tz);

        return sprintf('<time class="mb-0 text-capitalize">%s<span class="text-muted d-block">%s</span></time>',
            $date->translatedFormat($this->upperFormat),
            $date->translatedFormat($this->lowerFormat),
        );
    }
}
