<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

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
     * Permission.
     *
     * @var string
     */
    public $permission;

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
    abstract public function commandBar() : array;

    /**
     * Views.
     *
     * @return array
     */
    abstract public function layout() : array;

    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Throwable
     */
    public function build() : View
    {
        $query = call_user_func_array([$this, 'query'], $this->arguments);
        $post = new Repository($query);

        $layout = Layouts::blank([
            $this->layout(),
        ]);

        return $layout->build($post);
    }

    /**
     * @param $method
     * @param $slugLayouts
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Throwable
     */
    public function asyncBuild(string $method, string $slugLayouts)
    {
        $query = call_user_func_array([$this, $method], $this->arguments);
        $post = new Repository($query);

        foreach ($this->layout() as $layout){

            if(is_object($layout) && property_exists($layout,'slug') && $layout->slug == $slugLayouts){
                return view('platform::container.layouts.async', [
                    'builds'    => $layout->build($post),
                    'arguments' => $this->arguments,
                    'screen'    => $this,
                ]);
            }
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function view()
    {
        return view('platform::container.layouts.base', [
            'builds'    => $this->build(),
            'arguments' => $this->arguments,
            'screen'    => $this,
        ]);
    }

    /**
     * @param null $method
     * @param null $parameters
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public function handle($method = null, $parameters = null)
    {
        abort_if(! $this->checkAccess(), 403);

        if ($this->request->method() === 'GET' || (is_null($method) && is_null($parameters))) {
            $this->arguments = is_array($method) ? $method : [$method];

            return $this->view();
        }

        if(starts_with($method,'async')){
           return $this->asyncBuild($method,$parameters);
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
     *
     * @throws \ReflectionException
     */
    public function reflectionParams($method)
    {
        $class = new \ReflectionClass($this);
        $parameters = $class->getMethod($method)->getParameters();

        foreach ($parameters as $key => $parameter) {
            if (is_null($parameter->getClass()) || $this->checkClassInArray($key)) {
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

    /**
     * @return bool
     */
    private function checkAccess()
    {
        if (is_null($this->permission)) {
            return true;
        }

        if (is_string($this->permission)) {
            $this->permission = [$this->permission];
        }

        if (is_array($this->permission)) {
            foreach ($this->permission as $item) {
                if (! Auth::user()->hasAccess($item)) {
                    return false;
                }
            }
        }

        return true;
    }
}
