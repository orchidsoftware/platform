<?php

namespace Orchid\Screen\Components\Cells;

use Carbon\Month;
use Carbon\WeekDay;
use DateTimeInterface;
use DateTimeZone;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class DateTime extends Component
{
    /**
     * @param DateTimeInterface|WeekDay|Month|string|int|float|null $value
     */
    public function __construct(
        protected mixed $value,
        protected string $format = 'Y-m-d H:i',
        protected DateTimeZone|null|string $tz = null,
    ) {}

    /**
     * Get the view/contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        return Carbon::parse($this->value, $this->tz)->translatedFormat($this->format);
    }
}
