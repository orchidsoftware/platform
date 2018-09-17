<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Http\Controllers\Controller;

/**
 * Class Screen.
 */
abstract class Screen extends Controller
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
     * @var Repository
     */
    private $post;

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
    abstract public function commandBar(): array;

    /**
     * Views.
     *
     * @return array
     */
    abstract public function layout(): array;

    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Throwable
     */
    public function build(): View
    {
        $layout = Layouts::blank([
            $this->layout(),
        ]);

        return $layout->build($this->post);
    }

    /**
     * @param $method
     * @param $slugLayouts
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Throwable
     */
    public function asyncBuild($method, $slugLayouts)
    {
        $query = call_user_func_array([$this, $method], $this->arguments);
        $post = new Repository($query);

        foreach ($this->layout() as $layout) {
            if (property_exists($layout, 'slug') && $layout->slug == $slugLayouts) {
                return $layout->build($post, true);
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function view()
    {
        $this->reflectionParams('query');
        $query = call_user_func_array([$this, 'query'], $this->arguments);
        $this->post = new Repository($query);

        return view('platform::container.layouts.base', [
            'arguments' => $this->arguments,
            'screen'    => $this,
        ]);
    }

    /**
     * @param mixed ...$paramentrs
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public function handle(...$parameters)
    {
        abort_if(! $this->checkAccess(), 403);

        if ($this->request->method() === 'GET' || (! count($parameters))) {
            $this->arguments = $parameters;

            return $this->view();
        }

        $method = array_pop($parameters);
        $this->arguments = $parameters;

        $this->reflectionParams($method);

        if (starts_with($method, 'async')) {
            return $this->asyncBuild($method, $this->arguments);
        }

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

        if (! is_string($method)) {
            return;
        } elseif (! $class->hasMethod($method)) {
            return;
        }

        $parameters = $class->getMethod($method)->getParameters();

        foreach ($parameters as $key => $parameter) {
            if ($this->checkClassInArray($key) || is_null($parameter->getClass())) {
                continue;
            }

            $object = app()->make($parameter->getClass()->name);


            $this->arguments[$key] = is_subclass_of($object, Model::class)
            && isset($this->arguments[$key]) ? $object->find($this->arguments[$key]) : $object;

        }
    }

    /**
     * @param int $class
     *
     * @return bool
     */
    private function checkClassInArray($class): bool
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
    private function checkAccess(): bool
    {
        if (is_null($this->permission)) {
            return true;
        }

        if (is_string($this->permission)) {
            $this->permission = [$this->permission];
        }

        foreach ($this->permission as $item) {
            if (! Auth::user()->hasAccess($item)) {
                return false;
            }
        }

        return true;
    }
}
