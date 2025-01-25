<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
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
    protected string|int|null $width = null;
    /**
     * @var string|null
     */
    protected ?string $style = null;
    /**
     * @var string|null
     */
    protected ?string $class = null;

    protected string $filter = '';
    /**
     * @var bool
     */
    protected bool $sort = false;
    /**
     * @var string
     */
    protected string $align = self::ALIGN_LEFT;
    /**
     * @var int
     */
    protected int $colspan = 1;
    /**
     * Displays whether the user can hide
     * or show the column in the browser.
     *
     * @var bool
     */
    protected bool $allowUserHidden = true;
    /**
     * Should the user independently enable
     * the display of the column.
     *
     * @var bool
     */
    protected bool $defaultHidden = false;
    /**
     * Possible options for filters if it's select
     *
     * @var array
     */
    protected iterable $filterOptions = [];

    /**
     * Callable return filter value in column
     *
     * @var callable
     */
    protected $callbackFilterValue;

    /**
     * @param int|string $width
     * @return TD
     */
    public function width(int|string $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @param string $style
     */
    public function style($style): self
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @param string $class
     * @return TD
     */
    public function class(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @param iterable $filterOptions
     * @return TD
     */
    public function filterOptions(iterable $filterOptions): self
    {
        $this->filterOptions = $filterOptions;

        return $this;
    }

    public function filterValue(callable $callable): self
    {
        $this->callbackFilterValue = $callable;

        return $this;
    }

    /**
     * @param string $filter
     * @param null $options
     * @return TD
     */
    public function filter(string $filter = self::FILTER_TEXT, $options = null): self
    {
        if (is_iterable($options)) {
            $this->filterOptions($options);
        }

        if (is_callable($options)) {
            $this->callbackFilterValue = $options;
        }

        $this->filter = $filter;

        return $this;
    }

    public function sort(bool $sort = true): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
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
     * @return View
     */
    public function buildTh(): View
    {
        return view('platform::partials.layouts.th', [
            'width'        => is_numeric($this->width) ? $this->width.'px' : $this->width,
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
     * @return Field|null
     */
    protected function buildFilter(): ?Field
    {
        /** @var Field $filter|string */
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
            ->value(get_filter($this->column))
            ->autofocus();
    }

    /**
     * @param string $filter
     * @return Field
     */
    protected function detectConstantFilter(string $filter): Field
    {
        return match ($filter) {
            self::FILTER_DATE_RANGE   => DateRange::make()->disableMobile(),
            self::FILTER_NUMBER_RANGE => NumberRange::make(),
            self::FILTER_SELECT       => Select::make()->options($this->filterOptions)->multiple(),
            self::FILTER_DATE         => DateTimer::make()->inline()->format('Y-m-d'),
            default                   => Input::make()->type($filter),
        };
    }

    /**
     * Builds content for the column.
     *
     * @param Model|Repository $repository
     * @param object|null $loop
     * @return Factory|View
     */
    public function buildTd(Model|Repository $repository, ?object $loop = null): Factory|View
    {
        $value = $this->render ? $this->handler($repository, $loop) : $repository->getContent($this->name);

        return view('platform::partials.layouts.td', [
            'align'   => $this->align,
            'value'   => $value,
            'render'  => $this->render,
            'slug'    => $this->sluggable(),
            'width'   => is_numeric($this->width) ? $this->width.'px' : $this->width,
            'style'   => $this->style,
            'class'   => $this->class,
            'colspan' => $this->colspan,
        ]);
    }

    public function isAllowUserHidden(): bool
    {
        return $this->allowUserHidden;
    }

    /**
     * Builds an item menu for show/hiden column.
     *
     * @return View|null
     */
    public function buildItemMenu(): ?View
    {
        if (! $this->isAllowUserHidden()) {
            return null;
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
     */
    public function cantHide(bool $hidden = false): self
    {
        $this->allowUserHidden = $hidden;

        return $this;
    }

    /**
     * @return $this
     */
    public function defaultHidden(bool $hidden = true): self
    {
        $this->defaultHidden = $hidden;

        return $this;
    }

    public function buildSortUrl(): string
    {
        $query = request()->collect()->put('sort', revert_sort($this->column))->toArray();

        return url()->current().'?'.http_build_query($query);
    }

    /**
     * @param TD[] $columns
     */
    public static function isShowVisibleColumns(iterable $columns): bool
    {
        return collect($columns)->filter(fn ($column) => $column->isAllowUserHidden())->isNotEmpty();
    }

    /**
     * @param Field $field
     * @return bool
     * @deprecated is not usage
     *
     * Decides whether a filter can be provided with a complex (array-like) value, or it needs a scalar one.
     */
    protected function isComplexFieldType(Field $field): bool
    {
        return $field instanceof ComplexFieldConcern;
    }

    protected function buildFilterString(): ?string
    {
        $filter = get_filter($this->column);

        if ($filter === null) {
            return null;
        }

        if ($this->callbackFilterValue !== null) {
            return call_user_func($this->callbackFilterValue, $filter);
        }

        if (is_array($filter)) {
            if (isset($filter['start']) || isset($filter['end'])) {
                return ($filter['start'] ?? '').' - '.($filter['end'] ?? '');
            }

            if ($this->filterOptions) {
                $filter = array_map(fn ($val) => $this->filterOptions[$val] ?? $val, $filter);
            }

            return implode(', ', $filter);
        }

        return $filter;
    }
}
