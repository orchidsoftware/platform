<?php

declare(strict_types=1);

namespace Orchid\Platform\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filter
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var
     */
    public $parameters;

    /**
     * @var bool
     */
    public $display = true;

    /**
     * Current app language.
     *
     * @var
     */
    public $lang;

    /**
     * Apply a filter in the administration panel.
     *
     * @var bool
     */
    public $dashboard = false;

    /**
     * @var null
     */
    public $entity;

    /**
     * Filter constructor.
     *
     * @param $entity
     */
    public function __construct($entity = null)
    {
        $this->entity = $entity;
        $this->request = request();
        $this->lang = app()->getLocale();
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function filter(Builder $builder): Builder
    {
        if (is_null($this->parameters) || $this->request->filled($this->parameters)) {
            return $this->run($builder);
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    abstract public function run(Builder $builder): Builder;

    /**
     * User mapping method.
     */
    public function display()
    {
        //
    }
}
