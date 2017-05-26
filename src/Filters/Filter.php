<?php namespace Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
     * Current app language
     *
     * @var
     */
    public $lang;

    /**
     * Filters constructor.
     */
    public function __construct()
    {
        $this->request = request();
        $this->lang = App::getLocale();
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function filter(Builder $builder): Builder
    {
        if (!is_null($this->parameters) && $this->request->has($this->parameters)) {
            return $this->run($builder);
        } elseif (is_null($this->parameters)) {
            return $this->run($builder);
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     *
     * @return mixed
     */
    abstract public function run(Builder $builder): Builder;

    /**
     * User mapping method
     */
    public function display()
    {
        //
    }
}
