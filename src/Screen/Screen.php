<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Throwable;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Orchid\Screen\Layouts\Base;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
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
     * @var Request
     */
    public $request;

    /**
     * Permission.
     *
     * @var string|array
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
     *
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        $this->request = $request ?? request();
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    abstract public function commandBar(): array;

    /**
     * Views.
     *
     * @return Layout[]
     */
    abstract public function layout(): array;

    /**
     *@throws Throwable
     *
     * @return View
     */
    public function build()
    {
        $layout = Layout::blank([
            $this->layout(),
        ]);

        return $layout->build($this->post);
    }

    /**
     * @param mixed $method
     * @param mixed $slugLayouts
     *
     *@throws Throwable
     *
     * @return View
     */
    protected function asyncBuild($method, $slugLayouts)
    {
        $this->arguments = $this->request->json()->all();

        $this->reflectionParams($method);
        $query = call_user_func_array([$this, $method], $this->arguments);
        $post = new Repository($query);

        foreach ($this->layout() as $layout) {

            /** @var Base|string $layout */
            $layout = is_object($layout) ? $layout : new $layout();

            if ($layout->getSlug() === $slugLayouts) {
                $layout->async = true;

                return $layout->build($post);
            }
        }
    }

    /**
     * @throws Throwable
     *
     * @return Factory|\Illuminate\View\View
     */
    public function view()
    {
        $this->reflectionParams('query');
        $query = call_user_func_array([$this, 'query'], $this->arguments);
        $this->post = new Repository($query);

        return view('platform::layouts.base', [
            'screen'    => $this,
        ]);
    }

    /**
     * @param mixed ...$parameters
     *
     * @throws ReflectionException
     * @throws Throwable
     *
     * @return Factory|View|\Illuminate\View\View|mixed
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

        if (Str::startsWith($method, 'async')) {
            return $this->asyncBuild($method, array_pop($this->arguments));
        }

        $this->reflectionParams($method);

        return call_user_func_array([$this, $method], $this->arguments);
    }

    /**
     * @param string $method
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    private function reflectionParams(string $method)
    {
        $class = new ReflectionClass($this);

        if (! is_string($method)) {
            return;
        }

        if (! $class->hasMethod($method)) {
            return;
        }

        $parameters = $class->getMethod($method)->getParameters();

        $arguments = [];

        foreach ($parameters as $key => $parameter) {
            $arguments[] = $this->bind($key, $parameter);
        }

        $this->arguments = $arguments;
    }

    /**
     * @param int|string               $key
     * @param ReflectionParameter|null $parameter
     *
     * @return mixed
     */
    private function bind($key, $parameter)
    {
        if (is_null($parameter->getClass())) {
            return $this->arguments[$key] ?? null;
        }

        $class = $parameter->getClass()->name;

        $object = Arr::first($this->arguments, function ($value) use ($class) {
            return is_subclass_of($value, $class) || is_a($value, $class);
        });

        if (! is_null($object)) {
            return $object;
        }

        $object = app()->make($class);

        if (method_exists($object, 'resolveRouteBinding') && isset($this->arguments[$key])) {
            $object = $object->resolveRouteBinding($this->arguments[$key]);
        }

        return $object;
    }

    /**
     * @return bool
     */
    private function checkAccess(): bool
    {
        if (empty($this->permission)) {
            return true;
        }

        $permissions = Arr::wrap($this->permission);

        foreach ($permissions as $item) {
            if (Auth::user()->hasAccess($item)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function buildCommandBar() : array
    {
        foreach ($this->commandBar() as $command) {
            $commands[] = $command->build($this->post);
        }

        return $commands ?? [];
    }
}
