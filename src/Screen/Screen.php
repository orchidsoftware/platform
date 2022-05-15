<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Screen\Resolvers\ScreenDependencyResolver;
use Orchid\Support\Facades\Dashboard;
use Throwable;

/**
 * Class Screen.
 */
abstract class Screen extends Controller
{
    use Commander;

    /**
     * The number of predefined arguments in the route.
     *
     * Example: dashboard/my-screen/{method?}
     */
    private const COUNT_ROUTE_VARIABLES = 1;

    /**
     * The view rendered
     *
     * @return string
     */
    protected function screenBaseView(): string
    {
        return 'platform::layouts.base';
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name ?? null;
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return $this->description ?? null;
    }

    /**
     * Permission
     *
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return isset($this->permission)
            ? Arr::wrap($this->permission)
            : null;
    }

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
     * @param \Orchid\Screen\Repository $repository
     *
     * @return View
     */
    public function build(Repository $repository)
    {
        return LayoutFactory::blank([
            $this->layout(),
        ])->build($repository);
    }

    /**
     * @param string $method
     * @param string $slug
     *
     * @throws Throwable
     *
     * @return View
     *
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
     * @throws \Throwable
     *
     * @return Factory|\Illuminate\View\View
     */
    public function view(array $httpQueryArguments = [])
    {
        $repository = $this->buildQueryRepository($httpQueryArguments);

        return view($this->screenBaseView(), [
            'name'                => $this->name(),
            'description'         => $this->description(),
            'commandBar'          => $this->buildCommandBar($repository),
            'layouts'             => $this->build($repository),
            'formValidateMessage' => $this->formValidateMessage(),
        ]);
    }

    /**
     * @param array $httpQueryArguments
     *
     * @return \Orchid\Screen\Repository
     */
    protected function buildQueryRepository(array $httpQueryArguments = []): Repository
    {
        $query = $this->callMethod('query', $httpQueryArguments);

        $this->fillPublicProperty($query);

        return new Repository($query);
    }

    /**
     * @param iterable $query
     *
     * @return void
     */
    protected function fillPublicProperty(iterable $query): void
    {
        $reflections = (new \ReflectionClass($this))->getProperties(\ReflectionProperty::IS_PUBLIC);

        $publicProperty = collect($reflections)
            ->map(function (\ReflectionProperty $property) {
                return $property->getName();
            });

        collect($query)->only($publicProperty)->each(function ($value, $key) {
            $this->$key = $value;
        });
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param mixed                    ...$parameters
     *
     * @throws Throwable
     *
     * @return Factory|View|\Illuminate\View\View|mixed
     */
    public function handle(Request $request, ...$parameters)
    {
        Dashboard::setCurrentScreen($this);

        abort_unless($this->checkAccess($request), 403);

        if ($request->isMethod('GET')) {
            return $this->redirectOnGetMethodCallOrShowView($parameters);
        }

        $method = Route::current()->parameter('method', Arr::last($parameters));

        $prepare = collect($parameters)
            ->merge($request->query())
            ->diffAssoc($method)
            ->all();

        return $this->callMethod($method, $prepare) ?? back();
    }

    /**
     * @param string $method
     * @param array  $httpQueryArguments
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     *
     * @return array
     */
    protected function resolveDependencies(string $method, array $httpQueryArguments = []): array
    {
        return app()->make(ScreenDependencyResolver::class)->resolveScreen($this, $method, $httpQueryArguments);
    }

    /**
     * Determine if the user is authorized and has the required rights to complete this request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function checkAccess(Request $request): bool
    {
        $user = $request->user();

        if ($user === null) {
            return true;
        }

        return $user->hasAnyAccess($this->permission());
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
     * @throws \ReflectionException
     * @throws \Throwable
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     *
     * @return mixed
     */
    private function callMethod(string $method, array $parameters = [])
    {
        return call_user_func_array([$this, $method],
            $this->resolveDependencies($method, $parameters)
        );
    }

    /**
     * Get can transfer to the screen only
     * user-created methods available in it.
     *
     * @return Collection
     */
    public static function getAvailableMethods(): Collection
    {
        $class = (new \ReflectionClass(static::class))
            ->getMethods(\ReflectionMethod::IS_PUBLIC);

        return collect($class)
            ->mapWithKeys(function (\ReflectionMethod $method) {
                return [$method->name => $method];
            })
            ->except(get_class_methods(Screen::class))
            ->except(['query'])
            ->whenEmpty(function () {
                /*
                 * Route filtering requires at least one element to be present.
                 * We set __invoke by default, since it must be public.
                 */
                return collect('__invoke');
            })
            ->keys();
    }
}
