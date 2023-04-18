<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Laravel\SerializableClosure\SerializableClosure;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Screen\Resolvers\ScreenDependencyResolver;
use Orchid\Support\Facades\Dashboard;
use Throwable;

/**
 * Class Screen.
 *
 * This is the main class for creating screens in the Orchid. A screen is a web page
 * that displays content and allows for user interaction.
 */
abstract class Screen extends Controller
{
    use Commander;

    /**
     * The base view that will be rendered.
     */
    protected function screenBaseView(): string
    {
        return 'platform::layouts.base';
    }

    /**
     * The name of the screen to be displayed in the header.
     */
    public function name(): ?string
    {
        return $this->name ?? null;
    }

    /**
     * A description of the screen to be displayed in the header.
     */
    public function description(): ?string
    {
        return $this->description ?? null;
    }

    /**
     * The permissions required to access this screen.
     */
    public function permission(): ?iterable
    {
        return isset($this->permission)
            ? Arr::wrap($this->permission)
            : null;
    }

    /**
     * The command buttons for this screen.
     *
     * @return Action[]
     */
    public function commandBar()
    {
        return [];
    }

    /**
     * The layout for this screen, consisting of a collection of views.
     *
     * @return Layout[]
     */
    abstract public function layout(): iterable;

    /**
     * @param ...$parameters
     *
     * @throws \Throwable
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function __invoke(...$parameters)
    {
        return $this->handle($parameters);
    }

    /**
     * Builds the screen using the given data repository.
     *
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
     * Builds the screen asynchronously using the given method and template slug.
     *
     * @throws \ReflectionException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return \Illuminate\Http\Response
     */
    public function asyncBuild(string $method, string $slug)
    {
        Dashboard::setCurrentScreen($this, true);

        abort_unless(static::isMethodAvailable($method), 404, "Async method: {$method} not found");
        abort_unless($this->checkAccess(request()), static::unaccessed());

        $state = $this->extractState();

        $this->fillPublicProperty($state);

        $parameters = request()->collect()->merge([
            'state' => $state,
        ])->toArray();

        $repository = call_user_func_array([$this, $method],
            $this->resolveDependencies($method, $parameters)
        );

        if (is_array($repository)) {
            $repository = new Repository($repository);
        }

        $view = $this->view($repository)
            ->fragments(collect($slug)->push('screen-state')->toArray());

        return response($view)
            ->header('Content-Type', 'text/vnd.turbo-stream.html');
    }

    /**
     * This method extracts the state from a request parameter.
     * If the '_state' parameter is missing, an empty Repository object is returned.
     * Otherwise, the state is extracted from the encrypted '_state' parameter, deserialized and returned.
     *
     * @throws \Psr\Container\NotFoundExceptionInterface  - If the container cannot find a required dependency injection for a class.
     * @throws \Psr\Container\ContainerExceptionInterface - If the container cannot provide the dependency injection for a class.
     *
     * @return \Orchid\Screen\Repository - The extracted state.
     */
    protected function extractState(): Repository
    {
        // Check if the '_state' parameter is missing
        if (request()->missing('_state')) {
            // Return an empty Repository object
            return new Repository();
        }

        // Extract the encrypted state from the '_state' parameter, and deserialize it
        $data = config('platform.state.crypt', false) === true
            ? Crypt::decryptString(request()->get('_state'))
            : base64_decode(request()->get('_state'));

        $state = unserialize($data);

        // Return the deserialized state
        return $state();
    }

    /**
     * @param \Orchid\Screen\Repository $repository
     *
     * @throws \Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(Repository $repository): View
    {
        return view($this->screenBaseView(), [
            'name'                    => $this->name(),
            'description'             => $this->description(),
            'commandBar'              => $this->buildCommandBar($repository),
            'layouts'                 => $this->build($repository),
            'formValidateMessage'     => $this->formValidateMessage(),
            'needPreventsAbandonment' => $this->needPreventsAbandonment(),
            'state'                   => $this->serializableState($repository),
        ]);
    }

    /**
     * @param $values
     *
     * @throws \Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException
     *
     * @return string
     */
    protected function serializableState($values): string
    {
        $state = serialize(new SerializableClosure(fn () => $values));

        return config('platform.state.crypt', false) === true
            ? Crypt::encryptString($state)
            : base64_encode($state);
    }

    /**
     * @param \Orchid\Screen\Repository $repository
     *
     * @return void
     */
    protected function fillPublicProperty(Repository $repository): void
    {
        $reflections = (new \ReflectionClass($this))->getProperties(\ReflectionProperty::IS_PUBLIC);

        collect($reflections)
            ->map(fn (\ReflectionProperty $property) => $property->getName())
            ->each(fn (string $key) => $this->$key = $repository->get($key, $this->$key));
    }

    /**
     * Response or HTTP code that will be returned if user does not have access to screen.
     *
     * @return int | \Symfony\Component\HttpFoundation\Response
     */
    public static function unaccessed()
    {
        return Response::HTTP_FORBIDDEN;
    }

    /**
     * @param mixed ...$parameters
     *
     * @throws Throwable
     *
     * @return Factory|View|\Illuminate\View\View|mixed
     */
    public function handle(...$parameters)
    {
        $state = new Repository($this->callMethod('query', $parameters));

        $this->fillPublicProperty($state);

        return $this->view($state);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    protected function resolveDependencies(string $method, array $httpQueryArguments = []): array
    {
        return app()->make(ScreenDependencyResolver::class)->resolveScreen($this, $method, $httpQueryArguments);
    }

    /**
     * Determine if the user is authorized and has the required rights to complete this request.
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
     * This method returns a localized string message indicating that the user should check the entered data,
     * and that it may be necessary to specify the data in other languages.
     */
    public function formValidateMessage(): string
    {
        return __('Please check the entered data, it may be necessary to specify in other languages.');
    }

    /**
     * The boolean value returned is true, indicating that the form is preventing abandonment.
     */
    public function needPreventsAbandonment(): bool
    {
        return true;
    }

    /**
     * @throws \ReflectionException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    public function callMethod(string $method, array $parameters = [])
    {
        Dashboard::setCurrentScreen($this);

        $state = $this->extractState();
        $this->fillPublicProperty($state);

        abort_unless($this->checkAccess(\request()), static::unaccessed());

        $uses = static::class.'@'.$method;

        $route = request()->route();

        if ($route !== null) {
            $route = $route->uses($uses);
            Route::substituteBindings($route);
            Route::substituteImplicitBindings($route);

            $parameters = array_merge($parameters, $route->parameters());
        }

        if (\request()->isMethodSafe()) {
            return App::call(static::class.'@'.$method, $parameters) ?? back();
        }

        return call_user_func_array([$this, $method],
            $this->resolveDependencies($method, $parameters)
        ) ?? back();

        return App::call(static::class.'@'.$method, $parameters) ?? back();
    }

    /**
     * Get can transfer to the screen only
     * user-created methods available in it.
     */
    public static function getAvailableMethods(): Collection
    {
        $class = (new \ReflectionClass(static::class))
            ->getMethods(\ReflectionMethod::IS_PUBLIC);

        return collect($class)
            ->mapWithKeys(fn (\ReflectionMethod $method) => [$method->name => $method])
            ->except(get_class_methods(Screen::class))
            ->except(['query'])
            /*
             * Route filtering requires at least one element to be present.
             * We set __invoke by default, since it must be public.
             */
            ->whenEmpty(fn () => collect('__invoke'))
            ->keys();
    }

    /**
     * @param string $method
     *
     * @return bool
     */
    public static function isMethodAvailable(string $method): bool
    {
        return static::getAvailableMethods()->contains($method);
    }

    /**
     * @return string
     */
    public static function routeName(): string
    {
        return config('platform.state.crypt', false) === true
            ? Crypt::encryptString(static::class)
            : base64_encode(static::class);
    }
}
