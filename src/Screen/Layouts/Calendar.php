<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\CarbonImmutable;

class Calendar
{
    /**
     * @var \Illuminate\Support\Carbon
     */
    protected $currentDay;

    /**
     * @var Carbon|\Illuminate\Support\Carbon
     */
    protected $selectDay;

    /**
     * @var CarbonPeriod[]
     */
    protected $dates = [];

    /**
     * Calendar constructor.
     *
     * @param CarbonImmutable|null $selectDay
     * @param int                  $steps
     */
    public function __construct(CarbonImmutable $selectDay = null, int $steps = 3)
    {
        setlocale(LC_ALL, 'ru_RU.UTF-8');
        Carbon::setLocale('ru');
        //Carbon::setWeekStartsAt(Carbon::SUNDAY);
        //Carbon::setWeekEndsAt(Carbon::SATURDAY);

        $this->currentDay = CarbonImmutable::now();
        $this->selectDay = $selectDay ?? $this->currentDay;

        $this->generateDates($steps);
    }

    /**
     * @param int $steps
     */
    protected function generateDates(int $steps)
    {
        $start = round($steps) % 2;
        $startMonth = $this->selectDay->subMonths($start);

        for ($i = 0; $i < $steps; $i++) {
            $month = $startMonth->addMonths($i);
            $nameMonth = $month->monthName;

            $this->dates[$nameMonth] = $this->getPeriodMonth($month);
        }
    }

    /**
     * @param Carbon $date
     *
     * @return array
     */
    protected function getPeriodMonth(CarbonImmutable $date) : array
    {
        $start = $date->startOfMonth();
        $stop = $date->endOfMonth();

        $period = new CarbonPeriod($start, $stop);

        $weeks = [];

        /** @var Carbon $day */
        foreach ($period as $day) {
            $weeks[$day->weekNumberInMonth][] = $day;
        }

        return $weeks;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function build()
    {
        return view('platform::layouts.calendar', [
            'weeks'   => $this->weekDaysList(),
            'dates'   => $this->dates,
            'current' => $this->currentDay,
        ]);
    }

    /**
     * @return array
     */
    public function weekDaysList()
    {
        $timestamp = now()->startOfWeek();
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $days[] = $timestamp->formatLocalized('%a');
            $timestamp->addDay();
        }

        return $days;
    }
}
