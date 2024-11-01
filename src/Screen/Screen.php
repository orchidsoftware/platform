<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Support\Facades\Dashboard;

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
     * @param \Illuminate\Http\Request $request
     * @param mixed                    ...$arguments
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     *
     * @return mixed
     *
     * @see static::handle()
     */
    public function __invoke(Request $request, ...$arguments)
    {
        return $this->handle($request, ...$arguments);
    }

    /**
     * The base view that will be rendered.
     */
    public function screenBaseView(): string
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     *
     * @return \Illuminate\Http\Response
     */
    public function asyncBuild(string $method, string $slug)
    {
        Dashboard::setCurrentScreen($this, true);

        abort_unless(
            static::getAvailableMethods()->contains($method),
            Response::HTTP_BAD_REQUEST,
            "Async method '{$method}' is unavailable."
        );

        abort_unless($this->checkAccess(request()), static::unaccessed());

        $state = $this->extractState();
        $this->fillPublicProperty($state);

        $parameters = request()->collect()->merge([
            'state'   => $state,
        ])->all();

        $repository = $this->callMethod($method, $parameters);

        if (is_array($repository)) {
            $repository = new Repository(array_merge($state->all(), $repository));
        }

        $view = $this->view($repository)
            ->fragments(collect($slug)->push('screen-state')->all());

        return response($view)
            ->header('Content-Type', 'text/vnd.turbo-stream.html');
    }

    /**
     * Builds the screen asynchronously using listeners
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     *
     * @return \Illuminate\Http\Response
     */
    public function asyncParticalLayout(Layout $layout, Request $request)
    {
        Dashboard::setCurrentScreen($this, true);

        abort_unless($this->checkAccess(request()), static::unaccessed());

        $state = $this->extractState();
        $this->fillPublicProperty($state);

        $repository = $layout->handle($state, $request);

        $view = $layout->build($repository).view('platform::partials.state', [
            'state' => $this->serializableState(),
        ]);

        return response($view)
            ->header('Content-Type', 'text/vnd.turbo-stream.html');
    }

    /**
     * This method extracts the state from a request parameter.
     * If the '_state' parameter is missing, an empty Repository object is returned.
     * Otherwise, the state is extracted from the encrypted '_state' parameter, deserialized and returned.
     *
     * @throws \Psr\Container\ContainerExceptionInterface - If the container cannot provide the dependency injection for a class.
     * @throws \Psr\Container\NotFoundExceptionInterface  - If the container cannot find a required dependency injection for a class.
     *
     * @return \Orchid\Screen\Repository - The extracted state.
     */
    protected function extractState(): Repository
    {
        $state = request()->post('_state', session()->get('_state'));
        // Check if the '_state' parameter is missing
        if ($state === null) {
            // Return an empty Repository object
            return new Repository;
        }

        //deserialize '_state' parameter
        $screen = Crypt::decrypt($state);

        return new Repository(get_object_vars($screen));
    }

    /**
     * @throws \Throwable
     *
     * @return Factory|\Illuminate\View\View
     */
    public function view(array|Repository $httpQueryArguments = [])
    {
        $repository = is_a($httpQueryArguments, Repository::class)
            ? $httpQueryArguments
            : $this->buildQueryRepository($httpQueryArguments);

        return view($this->screenBaseView(), [
            'name'                    => $this->name(),
            'description'             => $this->description(),
            'commandBar'              => $this->buildCommandBar($repository),
            'layouts'                 => $this->build($repository),
            'formValidateMessage'     => $this->formValidateMessage(),
            'needPreventsAbandonment' => $this->needPreventsAbandonment(),
            'state'                   => $this->serializableState(),
            'controller'              => $this->frontendController(),
        ]);
    }

    /**
     * Serializes the current state of the screen into a string.
     *
     * @throws \Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException If the PHP version is not supported for serialization.
     *
     * @return string The serialized state.
     */
    protected function serializableState(): string
    {
        return Crypt::encrypt($this);
    }

    /**
     * @param array $httpQueryArguments
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     *
     * @return \Orchid\Screen\Repository
     */
    protected function buildQueryRepository(array $httpQueryArguments = []): Repository
    {
        $query = $this->callMethod('query', $httpQueryArguments);

        return tap(new Repository($query), fn (Repository $repository) =>  $this->fillPublicProperty($repository));
    }

    /**
     * Fills the public properties of the object with values from the given repository.
     *
     * @param \Orchid\Screen\Repository $repository The repository containing the values to fill the properties with.
     *
     * @return void
     */
    protected function fillPublicProperty(Repository $repository): void
    {
        $this->getPublicPropertyNames()
            ->map(fn (string $property) => $this->$property = $repository->get($property, $this->$property));
    }

    /**
     * Retrieves the names of all public properties of the object.
     *
     * @return \Illuminate\Support\Collection The names of the public properties.
     */
    protected function getPublicPropertyNames(): Collection
    {
        $properties = (new \ReflectionClass(static::class))->getProperties(\ReflectionProperty::IS_PUBLIC);
        $baseProperties = (new \ReflectionClass(Screen::class))->getProperties(\ReflectionProperty::IS_PUBLIC);

        return collect($properties)
            ->mapWithKeys(fn (\ReflectionProperty $property) => [$property->getName() => $property])
            ->filter(fn (\ReflectionProperty $property) => ! $property->isStatic())
            ->except(array_map(fn (\ReflectionProperty $property) => $property->getName(), $baseProperties))
            ->keys();
    }

    /**
     * Response or HTTP code that will be returned if user does not have access to the screen.
     *
     * @return int | \Symfony\Component\HttpFoundation\Response
     */
    public static function unaccessed()
    {
        return Response::HTTP_FORBIDDEN;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          ...$arguments
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \ReflectionException
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, ...$arguments)
    {
        Dashboard::setCurrentScreen($this);

        $method = $request->route()->parameter('method', 'view');

        if (! $request->isMethodSafe()) {
            $method = Arr::last($request->route()->parameters(), null, 'view');
        }

        $state = $this->extractState();
        $this->fillPublicProperty($state);

        // Deny access without rights
        abort_unless($this->checkAccess($request), static::unaccessed());

        // Redirect for correct residual behavior
        if ($request->isMethodSafe() && $method !== 'view') {
            return redirect()->action([static::class], $request->all());
        }

        return $this->callMethod($method, $arguments) ?? $this->backWithCurrentState();
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
        return config('platform.prevents_abandonment', true);
    }

    /**
     * Calls the specified method with the given parameters.
     *
     * @throws \ReflectionException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    private function callMethod(string $method, array $parameters = [])
    {
        $uses = static::class.'@'.$method;

        $preparedParameters = self::prepareForExecuteMethod($uses);

        return App::call($uses, $preparedParameters ?? $parameters);
    }

    /**
     * Prepare the method execution by binding route parameters and substituting implicit bindings.
     *
     * @param string $uses
     *
     * @return array|null
     */
    public static function prepareForExecuteMethod(string $uses): ?array
    {
        $route = request()->route();

        if ($route === null) {
            return null;
        }

        collect(request()->query())->each(function ($value, string $key) use ($route) {
            $route->setParameter($key, $value);
        });

        $original = $route->action['uses'];

        $route = $route->uses($uses);

        Route::substituteImplicitBindings($route);

        $parameters = $route->parameters();

        $route->uses($original);

        return $parameters;
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
     * Return to the previous state with the current object properties.
     *
     * @throws \Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function backWithCurrentState(): RedirectResponse
    {
        $properties = collect((new \ReflectionClass(static::class))
            ->getProperties(\ReflectionProperty::IS_PUBLIC))
            ->map(fn (\ReflectionProperty $property) => $property->getName())
            ->toArray();

        $currentState = collect(get_object_vars($this))
            ->only($properties);

        if ($currentState->isEmpty()) {
            return back();
        }

        return back()->with('_state', $this->serializableState());
    }

    /**
     * @deprecated
     *
     * @param array $data
     *
     * @throws \Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function backWith(array $data): RedirectResponse
    {
        $this->fillPublicProperty(new Repository($data));

        return back()->with('_state', $this->serializableState());
    }

    /**
     * Returns the name of the base Stimulus controller for the frontend.
     *
     * This method is used to determine the base Stimulus controller that will be
     * utilized on the frontend of the application. The controller manages the
     * behavior of UI elements, interacting with other components via Hotwire.
     *
     * @return string The name of the base controller.
     */
    public function frontendController(): string
    {
        return 'base';
    }

    /**
     * Reinitialized uninitialized properties with their default values.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    public function __wakeup(): void
    {
        // Create a fresh instance to retrieve default property values
        $defaultInstance = app()->make(static::class);

        $defaultProperties = $this->getPropertiesWithValues($defaultInstance);
        $currentProperties = (new \ReflectionClass($this))->getProperties();

        foreach ($currentProperties as $property) {
            // Skip if the property is already initialized
            if ($property->isInitialized($this)) {
                continue;
            }

            $propertyName = $property->getName();

            // Skip if there's no default value for the property
            if (! $defaultProperties->has($propertyName)) {
                continue;
            }

            // Set the property to its default value
            $property->setValue($this, $defaultProperties->get($propertyName));
        }
    }

    /**
     * Returns an associative array of property names and their values for the given object.
     *
     * @param object $object
     *
     * @throws \ReflectionException
     *
     * @return Collection
     */
    private function getPropertiesWithValues(object $object): Collection
    {
        $reflection = new \ReflectionClass($object);

        return collect($reflection->getProperties())
            ->mapWithKeys(function (\ReflectionProperty $property) use ($object) {
                $property->setAccessible(true); // Ensure we can access private/protected properties

                return [$property->getName() => $property->getValue($object)];
            });
    }

    /**
     * Returns an array of public property names for serialization.
     *
     * @return array
     */
    public function __sleep(): array
    {
        return $this->getPublicPropertyNames()->all();
    }
}
