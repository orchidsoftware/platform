<?php

declare(strict_types=1);

namespace Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Orchid\Screen\Field;

abstract class Filter
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var null|array
     */
    public $parameters;

    /**
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
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function filter(Builder $builder): Builder
    {
        $when = empty($this->parameters) || $this->request->hasAny($this->parameters);

        return $builder->when($when, function (Builder $builder) {
            return $this->run($builder);
        });
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    abstract public function run(Builder $builder): Builder;

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): array
    {
        return [];
    }

    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return class_basename(static::class);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return collect($this->display())->reduce(static function ($html, Field $field) {
            return $html.$field->form('filters')->render();
        });
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->display());
    }

    /**
     * @return bool
     */
    public function isApply(): bool
    {
        return count($this->request->only($this->parameters, [])) > 0;
    }

    /**
     * Value to be displayed
     *
     * @return string
     */
    public function value(): string
    {
        $params = $this->request->only($this->parameters, []);
        $values = collect($params)->flatten()->implode(static::$delimiter);

        return $this->name().': '.$values;
    }

    /**
     * Link without filters applied
     *
     * @return string
     */
    public function resetLink(): string
    {
        $params = http_build_query($this->request->except($this->parameters));

        return url($this->request->url().'?'.$params);
    }
}
