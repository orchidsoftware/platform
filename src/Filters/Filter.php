<?php namespace Orchid\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Orchid\Core\Builders\PostBuilder;

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
     * Filters constructor.
     */
    public function __construct()
    {
        $this->request = request();
        $this->lang = App::getLocale();
    }


    /**
     * @param PostBuilder $builder
     *
     * @return PostBuilder
     */
    public function filter(PostBuilder $builder) : PostBuilder
    {
        if (!is_null($this->parameters) && $this->request->has($this->parameters)) {
            return $this->run($builder);
        } elseif (is_null($this->parameters)) {
            return $this->run($builder);
        }

        return $builder;
    }


    /**
     * @param PostBuilder $builder
     *
     * @return mixed
     */
    abstract public function run(PostBuilder $builder) : PostBuilder;


    /**
     * User mapping method
     */
    public function display()
    {
    }
}
