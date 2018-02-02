<?php

declare(strict_types=1);

namespace Orchid\Platform\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter implements FilterInterface
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var null
     */
    public $parameters = null;

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
    public $behavior = null;

    /**
     * Filter constructor.
     *
     * @param $behavior
     */
    public function __construct($behavior = null)
    {
        $this->behavior = $behavior;
        $this->request = request();
        $this->lang = App::getLocale();
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function filter(Builder $builder) : Builder
    {
        if (is_null($this->parameters) || $this->request->filled($this->parameters)) {
            return $this->run($builder);
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     *
     * @return mixed
     */
    abstract public function run(Builder $builder) : Builder;

    /**
     * User mapping method.
     */
    public function display()
    {
        //
    }
}
