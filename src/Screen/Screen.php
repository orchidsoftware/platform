<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Screen\Layouts\Base;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Throwable;

/**
 * Class Screen.
 */
abstract class Screen extends Controller
{
    use Commander;

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
    private $source;

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
     * @return Action[]
     */
    abstract public function commandBar(): array;

    /**
     * Views.
     *
     * @return Layout[]
     */
    abstract public function layout(): array;

    /**
     * @throws Throwable
     *
     * @return View
     */
    public function build()
    {
        return Layout::blank([
            $this->layout(),
        ])->build($this->source);
    }

    /**
     * @param mixed $method
     * @param mixed $slugLayouts
     *
     * @throws Throwable
     *
     * @return View
     */
    protected function asyncBuild($method, $slugLayouts)
    {
        $this->arguments = $this->request->json()->all();

        $this->reflectionParams($method);

        $query = call_user_func_array([$this, $method], $this->arguments);
        $source = new Repository($query);

        /** @var Base $layout */
        $layout = collect($this->layout())
            ->map(function ($layout) {
                return is_object($layout) ? $layout : app()->make($layout);
            })
            ->filter(function (Base $layout) use ($slugLayouts) {
                return $layout->getSlug() === $slugLayouts;
            })
            ->whenEmpty(function () use ($method) {
                abort(404, "Async method: {$method} not found");
            })
            ->first();

        return $layout->currentAsync()->build($source);
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
        $this->source = new Repository($query);
        $commandBar = $this->buildCommandBar($this->source);

        return view('platform::layouts.base', [
            'screen'     => $this,
            'commandBar' => $commandBar,
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
     * @throws ReflectionException
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

        $this->arguments = collect($parameters)
            ->map(function ($parameter, $key) {
                return $this->bind($key, $parameter);
            })->all();
    }

    /**
     * It takes the serial number of the argument and the required parameter.
     * To convert to object.
     *
     * @param int                 $key
     * @param ReflectionParameter $parameter
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    private function bind(int $key, ReflectionParameter $parameter)
    {
        $class = optional($parameter->getClass())->name;
        $original = array_values($this->arguments)[$key] ?? null;

        if ($class === null) {
            return $original;
        }

        if (is_object($original)) {
            return $original;
        }

        $object = app()->make($class);

        if ($original !== null && is_a($object, UrlRoutable::class)) {
            return $object->resolveRouteBinding($original);
        }

        return $object;
    }

    /**
     * @return bool
     */
    private function checkAccess(): bool
    {
        return collect($this->permission)
            ->map(static function ($item) {
                return Auth::user()->hasAccess($item);
            })
            ->whenEmpty(function (Collection $permission) {
                return $permission->push(true);
            })
            ->contains(true);
    }

    /**
     * @return string
     */
    public function formValidateMessage(): string
    {
        return __('Please check the entered data, it may be necessary to specify in other languages.');
    }
}
