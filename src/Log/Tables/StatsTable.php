<?php

namespace Orchid\Log\Tables;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Orchid\Log\Contracts\Utilities\LogLevels as LogLevelsContract;

class StatsTable extends AbstractTable
{
    /**
     * Make a stats table instance.
     *
     * @param array                                     $data
     * @param \Orchid\Log\Contracts\Utilities\LogLevels $levels
     * @param string|null                               $locale
     *
     * @return \Orchid\Log\Tables\StatsTable
     */
    public static function make(array $data, LogLevelsContract $levels, $locale = null)
    {
        return new self($data, $levels, $locale);
    }

    /**
     * Get json totals data.
     *
     * @param string|null $locale
     *
     * @return string
     */
    public function totalsJson($locale = null)
    {
        return $this->totals($locale)->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Get totals.
     *
     * @param string|null $locale
     *
     * @return \Illuminate\Support\Collection
     */
    public function totals($locale = null)
    {
        $this->setLocale($locale);

        $totals = Collection::make();

        foreach (Arr::except($this->footer(), 'all') as $level => $count) {
            $totals->put($level, [
                'label'     => trans('dashboard::logs.'.$level),
                'value'     => $count,
                'color'     => $this->color($level),
                'highlight' => $this->color($level),
            ]);
        }

        return $totals;
    }

    /**
     * Prepare table header.
     *
     * @param array $data
     *
     * @return array
     */
    protected function prepareHeader(array $data)
    {
        return array_merge_recursive(
            [
                'date' => trans('dashboard::logs.date'),
                'all'  => trans('dashboard::logs.all'),
            ],
            $this->levels->names($this->locale)
        );
    }

    /**
     * Prepare table rows.
     *
     * @param array $data
     *
     * @return array
     */
    protected function prepareRows(array $data)
    {
        $rows = [];

        foreach ($data as $date => $levels) {
            $rows[$date] = array_merge(compact('date'), $levels);
        }

        return $rows;
    }

    /**
     * Prepare table footer.
     *
     * @param array $data
     *
     * @return array
     */
    protected function prepareFooter(array $data)
    {
        $footer = [];

        foreach ($data as $date => $levels) {
            foreach ($levels as $level => $count) {
                if (!isset($footer[$level])) {
                    $footer[$level] = 0;
                }

                $footer[$level] += $count;
            }
        }

        return $footer;
    }
}
