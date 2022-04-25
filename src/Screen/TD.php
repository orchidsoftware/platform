<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\NumberRange;
use Orchid\Screen\Fields\Select;

class TD extends Cell
{
    /**
     * Align the cell to the left.
     */
    public const ALIGN_LEFT = 'start';
    /**
     * Align the cell to the center.
     */
    public const ALIGN_CENTER = 'center';
    /**
     * Align the cell to the right.
     */
    public const ALIGN_RIGHT = 'end';
    public const FILTER_TEXT = 'text';
    public const FILTER_NUMERIC = 'number';
    public const FILTER_DATE = 'date';
    public const FILTER_DATE_RANGE = 'dateRange';
    public const FILTER_NUMBER_RANGE = 'numberRange';
    public const FILTER_SELECT = 'select';
    /**
     * @var string|null|int
     */
    protected $width;
    /**
     * @var string
     */
    protected $filter;
    /**
     * @var bool
     */
    protected $sort;
    /**
     * @var string
     */
    protected $align = self::ALIGN_LEFT;
    /**
     * @var int
     */
    protected $colspan = 1;
    /**
     * Displays whether the user can hide
     * or show the column in the browser.
     *
     * @var bool
     */
    protected $allowUserHidden = true;
    /**
     * Should the user independently enable
     * the display of the column.
     *
     * @var bool
     */
    protected $defaultHidden = false;
    /**
     * Possible options for filters if it's a select
     *
     * @var array
     */
    protected $filterOptions = [];

    /**
     * @param string|int $width
     *
     * @return TD
     */
    public function width($width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @param string|\Orchid\Screen\Field $filter
     *
     * @return TD
     */
    public function filterOptions(iterable $filterOptions): self
    {
        $this->filterOptions = $filterOptions;

        return $this;
    }

    /**
     * @param string|\Orchid\Screen\Field $filter
     *
     * @return TD
     */
    public function filter($filter = self::FILTER_TEXT, iterable $options = null): self
    {
        if ($options) {
            $this->filterOptions($options);
        }

        $this->filter = $filter;

        return $this;
    }

    /**
     * @param bool $sort
     *
     * @return TD
     */
    public function sort(bool $sort = true): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @param string $align
     *
     * @return $this
     */
    public function align(string $align): self
    {
        $this->align = $align;

        return $this;
    }

    /**
     * @return $this
     */
    public function alignLeft(): self
    {
        $this->align = self::ALIGN_LEFT;

        return $this;
    }

    /**
     * @return $this
     */
    public function alignRight(): self
    {
        $this->align = self::ALIGN_RIGHT;

        return $this;
    }

    /**
     * @return $this
     */
    public function alignCenter(): self
    {
        $this->align = self::ALIGN_CENTER;

        return $this;
    }

    /**
     * @param int $colspan
     *
     * @return $this
     */
    public function colspan(int $colspan): self
    {
        $this->colspan = $colspan;

        return $this;
    }

    /**
     * Builds a column heading.
     *
     * @return Factory|View
     */
    public function buildTh()
    {
        return view('platform::partials.layouts.th', [
            'width'        => $this->width,
            'align'        => $this->align,
            'sort'         => $this->sort,
            'sortUrl'      => $this->buildSortUrl(),
            'column'       => $this->column,
            'title'        => $this->title,
            'filter'       => $this->buildFilter(),
            'filterString' => $this->buildFilterString(),
            'slug'         => $this->sluggable(),
            'popover'      => $this->popover,
        ]);
    }

    /**
     * @return \Orchid\Screen\Field|null
     */
    protected function buildFilter(): ?Field
    {
        /** @var \Orchid\Screen\Field $filter */
        $filter = $this->filter;

        if ($filter === null) {
            return null;
        }

        if (is_string($filter)) {
            $filter = $this->detectConstantFilter($filter);
        }

        return $filter->name("filter[$this->column]")
            ->placeholder(__('Filter'))
            ->form('filters')
            ->value(
                $this->isComplexFieldType($filter) ? get_filter_string($this->column) : get_filter($this->column)
            )
            ->autofocus();
    }

    /**
     * @param string $filter
     *
     * @return \Orchid\Screen\Field
     */
    protected function detectConstantFilter(string $filter): Field
    {
        switch ($filter) {
            case self::FILTER_DATE_RANGE:
                $input = DateRange::make();
                break;
            case self::FILTER_NUMBER_RANGE:
                $input = NumberRange::make();
                break;
            case self::FILTER_SELECT:
                $input = Select::make()->options($this->filterOptions)->multiple();
                break;
            case self::FILTER_DATE:
                $input = DateTimer::make()->inline()->format('Y-m-d');
                break;
            default:
                $input = Input::make()->type($filter);
                break;
        }

        return $input;
    }

    /**
     * Builds content for the column.
     *
     * @param Repository|Model $repository
     *
     * @return Factory|View
     */
    public function buildTd($repository, ?object $loop = null)
    {
        $value = $this->render ? $this->handler($repository, $loop) : $repository->getContent($this->name);

        return view('platform::partials.layouts.td', [
            'align'   => $this->align,
            'value'   => $value,
            'render'  => $this->render,
            'slug'    => $this->sluggable(),
            'width'   => $this->width,
            'colspan' => $this->colspan,
        ]);
    }

    /**
     * @return bool
     */
    public function isAllowUserHidden(): bool
    {
        return $this->allowUserHidden;
    }

    /**
     * Builds item menu for show/hiden column.
     *
     * @return Factory|View|null
     */
    public function buildItemMenu()
    {
        if (! $this->isAllowUserHidden()) {
            return;
        }

        return view('platform::partials.layouts.selectedTd', [
            'title'         => $this->title,
            'slug'          => $this->sluggable(),
            'defaultHidden' => var_export($this->defaultHidden, true),
        ]);
    }

    /**
     * @return string
     */
    protected function sluggable(): string
    {
        return Str::slug($this->name);
    }

    /**
     * Prevents the user from hiding a column in the interface.
     *
     * @param bool $hidden
     *
     * @return TD
     */
    public function cantHide(bool $hidden = false): self
    {
        $this->allowUserHidden = $hidden;

        return $this;
    }

    /**
     * @param bool $hidden
     *
     * @return $this
     */
    public function defaultHidden(bool $hidden = true): self
    {
        $this->defaultHidden = $hidden;

        return $this;
    }

    /**
     * @return string
     */
    public function buildSortUrl(): string
    {
        $query = request()->collect()->put('sort', revert_sort($this->column))->toArray();

        return url()->current() . '?' . http_build_query($query);
    }

    /**
     * @param TD[] $columns
     *
     * @return bool
     */
    public static function isShowVisibleColumns($columns): bool
    {
        return collect($columns)->filter(function ($column) {
            return $column->isAllowUserHidden();
        })->isNotEmpty();
    }

    /**
     * Decides whether a filter can be provided with complex (array-like) value, or it needs a scalar one.
     *
     * @param \Orchid\Screen\Field $field
     *
     * @return bool
     */
    protected function isComplexFieldType(Field $field): bool
    {
        return $field instanceof ComplexFieldConcern;
    }

    protected function buildFilterString(): ?string
    {
        $filter = get_filter($this->column);
        if (is_array($filter)) {
            if (isset($filter['start']) || isset($filter['end'])) {
                return ($filter['start'] ?? "") . ' - ' . ($filter['end'] ?? "");
            }

            if ($this->filterOptions) {
                $filter = array_map(function ($val) {
                    return $this->filterOptions[$val] ?? $val;
                }, $filter);
            }

            return implode(', ', $filter);
        }

        return $filter;
    }
}
