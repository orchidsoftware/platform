<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
     * @return View
     * @throws Throwable
     *
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
     * @return View
     * @throws Throwable
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
     * @return Factory|\Illuminate\View\View
     * @throws \Throwable
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
     * @return Factory|View|\Illuminate\View\View|mixed
     * @throws Throwable
     *
     */
    public function handle(...$parameters)
    {
        Dashboard::setCurrentScreen($this);
        abort_unless($this->checkAccess(), 403);

        if (request()->isMethod('GET')) {
            return $this->redirectOnGetMethodCallOrShowView($parameters);
        }

        $method = Route::current()->parameter('method', Arr::last($parameters));

        $prepare = collect($parameters)
            ->merge(request()->query())
            ->diff($method)
            ->all();

        return $this->callMethod($method, $prepare) ?? back();
    }

    /**
     * @param string $method
     * @param array  $httpQueryArguments
     *
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    protected function resolveDependencies(string $method, array $httpQueryArguments = []): array
    {
        return app()->make(ScreenDependencyResolver::class)->resolveScreen($this, $method, $httpQueryArguments);
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
     * @return Factory|RedirectResponse|\Illuminate\View\View
     * @throws \ReflectionException
     * @throws \Throwable
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
