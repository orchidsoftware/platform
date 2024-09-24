<?php

declare(strict_types=1);

namespace Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Contracts\Fieldable;
use Orchid\Screen\Repository;

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
    }

    public function query(): iterable
    {
        return $this->request->only($this->parameters(), []);
    }

    /**
     * Apply filter if the request parameters were satisfied.
     */
    public function filter(Builder $builder): Builder
    {
        return $builder->when($this->isApply(), fn (Builder $builder) => $this->run($builder));
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
     * @return Fieldable[]
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
        $fields = collect($this->display())->map(fn (Fieldable $field) => $field->form('filters'));
        $params = $this->query();

        $builder = new \Orchid\Screen\Builder($fields, new Repository($params));

        return $builder->generateForm();
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
        $parameters = $this->parameters();

        $when = empty($parameters)
            || $this->request->hasAny($parameters)
            || $this->request->collect()->dot()->keys()->filter(fn (string $name) => Str::of($name)->is($parameters))->isNotEmpty();

        return $when;
    }

    /**
     * Hide/show the filter in the selection
     *
     * @return bool
     */
    public function isDisplay(): bool
    {
        return ! empty($this->display());
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
