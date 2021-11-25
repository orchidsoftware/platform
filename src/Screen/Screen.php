<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\ImplicitRouteBinding;
use Illuminate\Routing\RouteDependencyResolverTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Support\Facades\Dashboard;
use ReflectionClass;
use ReflectionException;
use Throwable;

/**
 * Class Screen.
 */
abstract class Screen extends Controller
{
    use Commander, RouteDependencyResolverTrait;

    /**
     * The number of predefined arguments in the route.
     *
     * Example: dashboard/my-screen/{method?}
     */
    private const COUNT_ROUTE_VARIABLES = 1;

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
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar()
    {
        return [];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    abstract public function layout(): iterable;

    /**
     * @throws Throwable
     *
     * @return View
     */
    public function build()
    {
        return LayoutFactory::blank([
            $this->layout(),
        ])->build($this->source);
    }

    /**
     * @param string $method
     * @param string $slug
     *
     * @throws Throwable
     *
     * @return View
     */
    public function asyncBuild(string $method, string $slug)
    {
        Dashboard::setCurrentScreen($this);

        abort_unless(method_exists($this, $method), 404, "Async method: {$method} not found");

        $query = $this->callMethod($method, request()->all());
        $source = new Repository($query);

        /** @var Layout $layout */
        $layout = collect($this->layout())
            ->map(function ($layout) {
                return is_object($layout) ? $layout : resolve($layout);
            })
            ->map(function (Layout $layout) use ($slug) {
                return $layout->findBySlug($slug);
            })
            ->filter()
            ->whenEmpty(function () use ($slug) {
                abort(404, "Async template: {$slug} not found");
            })
            ->first();

        return $layout->currentAsync()->build($source);
    }

    /**
     * @param array $httpQueryArguments
     *
     * @throws ReflectionException
     *
     * @return Factory|\Illuminate\View\View
     */
    public function view(array $httpQueryArguments = [])
    {
        $query = $this->callMethod('query', $httpQueryArguments);
        $this->source = new Repository($query);
        $commandBar = $this->buildCommandBar($this->source);

        return view('platform::layouts.base', [
            'name'                => $this->name,
            'description'         => $this->description,
            'commandBar'          => $commandBar,
            'layouts'             => $this->build(),
            'formValidateMessage' => $this->formValidateMessage(),
        ]);
    }

    /**
     * @param mixed ...$parameters
     *
     * @throws Throwable
     * @throws ReflectionException
     *
     * @return Factory|View|\Illuminate\View\View|mixed
     */
    public function handle(...$parameters)
    {
        Dashboard::setCurrentScreen($this);
        abort_unless($this->checkAccess(), 403);

        if (request()->isMethod('GET')) {
            return $this->redirectOnGetMethodCallOrShowView($parameters);
        }

        $method = Route::current()->parameter('method', Arr::last($parameters));

        $parameters = array_diff(
            $parameters,
            [$method]
        );

        $query = request()->query();
        $query = ! is_array($query) ? [] : $query;

        $parameters = array_filter($parameters);
        $parameters = array_merge($query, $parameters);

        $response = $this->callMethod($method, $parameters);

        return $response ?? back();
    }

    /**
     * @param string $method
     * @param array  $httpQueryArguments
     *
     * @throws ReflectionException
     *
     * @return array
     */
    private function reflectionParams(string $method, array $httpQueryArguments = []): array
    {
        if (! is_string($method)) {
            return [];
        }

        $class = new ReflectionClass($this);

        if (!$class->hasMethod($method) || !$class->getMethod($method)->isPublic()) {
            return [];
        }

        $this->container = app();

        $route = Route::current();

        if($route === null){
            return [];
        }

        collect($httpQueryArguments)->except([])
            ->each(function ($value, $key) use ($route) {
                $route->setParameter($key, $value);
            });

        // This is normally handled in the "SubstituteBindings" middleware, but
        // because that middleware has already ran, we need to run them again.
        $this->container['router']->substituteImplicitBindings($route);

        // We'll set the route action to be from the parameter method from the chosen
        // Screen to get the proper implicit bindings.
        $route->uses(get_class($this).'@'.$method);

        ImplicitRouteBinding::resolveForRoute($this->container, Route::current());

        $parameters = $this->resolveClassMethodDependencies($route->parameters, $this, $method);

        return collect($parameters)->except([
            'screen',
            'method',
            'template',
        ])->values()->all();
    }

    /**
     * @return bool
     */
    private function checkAccess(): bool
    {
        $user = Auth::user();

        if ($user === null) {
            return true;
        }

        return $user->hasAnyAccess($this->permission);
    }

    /**
     * @return string
     */
    public function formValidateMessage(): string
    {
        return __('Please check the entered data, it may be necessary to specify in other languages.');
    }

    /**
     * Defines the URL to represent
     * the page based on the calculation of link arguments.
     *
     * @param array $httpQueryArguments
     *
     *@throws ReflectionException
     *
     * @return Factory|RedirectResponse|\Illuminate\View\View
     */
    protected function redirectOnGetMethodCallOrShowView(array $httpQueryArguments)
    {
        $expectedArg = count(Route::current()->getCompiled()->getVariables()) - self::COUNT_ROUTE_VARIABLES;
        $realArg = count($httpQueryArguments);

        if ($realArg <= $expectedArg) {
            return $this->view($httpQueryArguments);
        }

        array_pop($httpQueryArguments);

        return redirect()->action([static::class, 'handle'], $httpQueryArguments);
    }

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @throws ReflectionException
     *
     * @return mixed
     */
    private function callMethod(string $method, array $parameters = [])
    {
        return call_user_func_array([$this, $method],
            $this->reflectionParams($method, $parameters)
        );
    }

    /**
     * Get can transfer to the screen only
     * user-created methods available in it.
     *
     * @array
     */
    public static function getAvailableMethods(): array
    {
        return array_diff(
            get_class_methods(static::class), // Custom methods
            get_class_methods(self::class),   // Basic methods
            ['query']                                   // Except methods
        );
    }
}
