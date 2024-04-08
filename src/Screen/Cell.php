<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Orchid\Support\Blade;

abstract class Cell
{
    use CanSee, Macroable;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var Closure|null
     */
    protected $render;

    /**
     * @var string
     */
    protected $column;

    /**
     * @var string
     */
    protected $popover;

    /**
     * Cell constructor.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->column = $name;
    }

    /**
     * @return static
     */
    public static function make(string $name = '', ?string $title = null): static
    {
        $td = new static($name);
        $td->column = $name;
        $td->title = $title ?? Str::title($name);

        return $td;
    }

    public function render(Closure $closure): static
    {
        $this->render = $closure;

        return $this;
    }

    public function popover(string $text): static
    {
        $this->popover = $text;

        return $this;
    }

    /**
     * @throws \ReflectionException
     *
     * @return string
     */
    protected function getNameParameterExpected(string $component, array $params = []): ?string
    {
        $class = new \ReflectionClass($component);
        $parameters = optional($class->getConstructor())->getParameters() ?? [];

        $paramsKeys = Arr::isAssoc($params) ? array_keys($params) : array_values($params);

        return collect($parameters)
            ->filter(fn (\ReflectionParameter $parameter) => ! $parameter->isOptional())
            ->whenEmpty(fn () => collect($parameters))
            ->map(fn (\ReflectionParameter $parameter) => $parameter->getName())
            ->diff($paramsKeys)
            ->last();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    protected function renderComponent(string $component, $value, array $params = []): ?string
    {
        [$class, $view] = Blade::componentInfo($component);

        if ($view === null) {
            // for class based components, try to detect argument name
            $nameArgument = $this->getNameParameterExpected($class, $params);
            if ($nameArgument !== null) {
                $params[$nameArgument] = $value;
            }
        }

        $params = array_map(fn ($item) => value($item, $value), $params);

        return Blade::renderComponent($component, $params);
    }

    /**
     * Renders the component with optional parameters.
     *
     * @param string $component The component to render.
     * @param mixed  ...$params Optional parameters for the component.
     *
     * @return $this
     */
    public function component(string $component, ...$params): static
    {
        /** Backward compatibility workaround.
         *
         *  This block enables backward compatibility with previous versions
         *  where passing parameters as an array was supported.
         *
         *  Example usage:
         *  TD::make()->component(Any::class, ['param' => 'value'])
         */
        if (Arr::isList($params) && count($params) > 0) {
            $params = Arr::first($params);
        }

        return $this->render(fn ($value) => $this->renderComponent($component, $value, $params));
    }

    /**
     * Pass only the cell value to the component
     *
     * @throws \ReflectionException
     *
     * @return $this
     */
    public function asComponent(string $component, array $params = []): static
    {
        return $this->render(fn ($value) => $this->renderComponent($component, $value->getContent($this->name), $params));
    }

    /**
     * Pass only the cell value to the component
     *
     * @param string $component
     * @param mixed  ...$params
     *
     * @throws \ReflectionException
     *
     * @return $this
     */
    public function usingComponent(string $component, ...$params): static
    {
        return $this->asComponent($component, $params);
    }

    /**
     * @param Repository|Model $source
     *
     * @return mixed
     */
    protected function handler($source, ?object $loop = null)
    {
        $callback = $this->render;

        return is_null($callback) ? $source : $callback($source, $loop);
    }
}
