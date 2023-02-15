<?php

declare(strict_types=1);

namespace Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Orchid\Screen\Field;

abstract class Filter
{
    /**
     * The request instance.
     *
     * @var Request
     */
    public $request;

    /**
     * The array of matched parameters.
     *
     * @var null|array
     */
    public $parameters;

    /**
     * Sets the value to hide/show the filter in the selection.
     *
     * @var bool
     */
    public $display = true;

    /**
     * Current app language.
     *
     * @var string
     */
    public $lang;

    /**
     * The value delimiter.
     *
     * @var string
     */
    protected static $delimiter = ',';

    /**
     * Filter constructor.
     */
    public function __construct()
    {
        $this->request = request();
        $this->lang = app()->getLocale();
    }

    /**
     * Apply filter if the request parameters were satisfied.
     */
    public function filter(Builder $builder): Builder
    {
        $when = empty($this->parameters()) || $this->request->hasAny($this->parameters());

        return $builder->when($when, fn (Builder $builder) => $this->run($builder));
    }

    /**
     * The array of matched parameters.
     */
    public function parameters(): ?array
    {
        return $this->parameters;
    }

    /**
     * Apply to a given Eloquent query builder.
     */
    abstract public function run(Builder $builder): Builder;

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [];
    }

    /**
     * The displayable name of the filter.
     */
    public function name(): string
    {
        return class_basename(static::class);
    }

    public function render(): string
    {
        return collect($this->display())->reduce(static fn ($html, Field $field) => $html.$field->form('filters')->render());
    }

    /**
     * Count fields in the filter.
     */
    public function count(): int
    {
        return count($this->display());
    }

    /**
     * Whether there are suitable parameters in the query to apply the filter.
     */
    public function isApply(): bool
    {
        return count($this->request->only($this->parameters(), [])) > 0;
    }

    /**
     * Value to be displayed
     */
    public function value(): string
    {
        $params = $this->request->only($this->parameters(), []);
        $values = collect($params)->flatten()->implode(static::$delimiter);

        return $this->name().': '.$values;
    }

    /**
     * Link without filters applied
     */
    public function resetLink(): string
    {
        $params = http_build_query($this->request->except($this->parameters()));

        return url($this->request->url().'?'.$params);
    }
}
