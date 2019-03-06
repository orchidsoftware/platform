<?php

declare(strict_types=1);

namespace Orchid\Screen;

use ReflectionClass;
use ReflectionParameter;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
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
     * @return Layouts[]
     */
    abstract public function layout(): array;

    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Throwable
     */
    public function build()
    {
        $layout = Layouts::blank([
            $this->layout(),
        ]);

        return $layout->build($this->post);
    }

    /**
     * @param mixed $method
     * @param mixed $slugLayouts
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Throwable
     */
    protected function asyncBuild($method, $slugLayouts)
    {
        $this->arguments = $this->request->json()->all();

        $this->reflectionParams($method);
        $query = call_user_func_array([$this, $method], $this->arguments);
        $post = new Repository($query);

        foreach ($this->layout() as $layout) {

            /** @var \Orchid\Screen\Layouts\Base $layout */
            $layout = is_object($layout) ? $layout : new $layout();

            if ($layout->getSlug() === $slugLayouts) {
                $layout->async = true;

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
            'screen'    => $this,
        ]);
    }

    /**
     * @param mixed ...$parameters
     *
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View|mixed
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

        if (starts_with($method, 'async')) {
            return $this->asyncBuild($method, array_pop($this->arguments));
        }

        $this->reflectionParams($method);

        return call_user_func_array([$this, $method], $this->arguments);
    }

    /**
     * @param string $method
     *
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
     * @param int|string $key
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

        if (is_null($object)) {
            $object = app()->make($class);

            if (method_exists($object, 'resolveRouteBinding') && isset($this->arguments[$key])) {
                $object = $object->resolveRouteBinding($this->arguments[$key]);
            }
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
            $commands[] = $command->build($this->post, $this->arguments);
        }

        return $commands ?? [];
    }
}
