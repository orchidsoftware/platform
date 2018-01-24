<?php

namespace Orchid\Platform\Screen;

use Illuminate\Http\Request;

abstract class Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name;

    /**
     * Display header description.
     *
     * @var string
     */
    public $description;
    /**
     * @var array|Request|string
     */
    public $request;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * Screen constructor.
     */
    public function __construct()
    {
        $this->request = request();
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [];
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query()
    {
        return [];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout() : array
    {
        return [];
    }

    /**
     * @return array
     */
    public function build() : array
    {
        $query = call_user_func_array([$this, 'query'], $this->arguments);
        $post = new Repository($query);

        foreach ($this->layout() as $layout) {
            if (is_object($layout)) {
                $build[] = $layout->build($post);
            } else {
                $build[] = (new $layout)->build($post);
            }
        }

        return $build ?? [];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('dashboard::container.layouts.base', [
            'name'        => $this->name,
            'description' => $this->description,
            'arguments'   => $this->arguments,
            'screen'      => $this,
        ]);
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function handle($method = null, $parameters = null)
    {
        if ($this->request->method() === 'GET' || (is_null($method) && is_null($parameters))) {
            $this->arguments = is_array($method) ? $method : [$method];

            return $this->view();
        }

        if (! is_null($parameters)) {
            $this->arguments = is_array($method) ? $method : [$method];

            $this->reflectionParams($parameters);

            return call_user_func_array([$this, $parameters], $this->arguments);
        }

        $this->arguments = is_array($parameters) ? $parameters : [$parameters];
        $this->reflectionParams($method);

        return call_user_func_array([$this, $method], $this->arguments);
    }

    /**
     * @param $method
     */
    public function reflectionParams($method)
    {
        $class = new \ReflectionClass($this);

        foreach ($class->getMethod($method)->getParameters() as $key => $parameter) {
            if (is_null($parameter->getClass())) {
                continue;
            }

            if ($this->checkClassInArray($key)) {
                continue;
            }

            $this->arguments[$key] = app()->make($parameter->getClass()->name);
        }
    }

    /**
     * @param $class
     *
     * @return bool
     */
    private function checkClassInArray($class)
    {
        foreach ($this->arguments as $value) {
            if (is_object($value) && get_class($value) == $class) {
                return true;
            }
        }

        return false;
    }
}
