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
    use Macroable, CanSee;

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
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->column = $name;
    }

    /**
     * @param string      $name
     * @param string|null $title
     *
     * @return static
     */
    public static function make(string $name = '', string $title = null): self
    {
        $td = new static($name);
        $td->column = $name;
        $td->title = $title ?? Str::title($name);

        return $td;
    }

    /**
     * @param Closure $closure
     *
     * @return self
     */
    public function render(\Closure $closure): self
    {
        $this->render = $closure;

        return $this;
    }

    /**
     * @param string $text
     *
     * @return self
     */
    public function popover(string $text): self
    {
        $this->popover = $text;

        return $this;
    }

    /**
     * @param string $component
     * @param array  $params
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    protected function getNameParameterExpected(string $component, array $params = []): string
    {
        $class = new \ReflectionClass($component);
        $parameters = optional($class->getConstructor())->getParameters() ?? [];

        $paramsKeys = Arr::isAssoc($params) ? array_keys($params) : array_values($params);

        return collect($parameters)
            ->filter(function (\ReflectionParameter $parameter) {
                return ! $parameter->isOptional();
            })
            ->whenEmpty(function () use ($parameters) {
                return collect($parameters);
            })
            ->map(function (\ReflectionParameter $parameter) {
                return $parameter->getName();
            })
            ->diff($paramsKeys)
            ->whenEmpty(function () use ($component) {
                throw new \RuntimeException("Class $component doesn't expect any value in the constructor");
            })
            ->last();
    }

    /**
     * @param string $component
     * @param        $value
     * @param array  $params
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     *
     * @return string|null
     */
    protected function renderComponent(string $component, $value, array $params = []): ?string
    {
        $nameArgument = $this->getNameParameterExpected($component, $params);

        $arguments = array_merge($params, [
            $nameArgument => $value,
        ]);

        return Blade::renderComponent($component, $arguments);
    }

    /**
     * Pass the entire string to the component
     *
     * @param string      $component
     * @param string|null $name
     * @param array       $params
     *
     * @return $this
     */
    public function component(string $component, array $params = []): self
    {
        return $this->render(function ($value) use ($component, $params) {
            return $this->renderComponent($component, $value, $params);
        });
    }

    /**
     * Pass only the cell value to the component
     *
     * @param string $component
     * @param array  $params
     *
     * @throws \ReflectionException
     *
     * @return $this
     */
    public function asComponent(string $component, array $params = []): self
    {
        return $this->render(function ($value) use ($component, $params) {
            return $this->renderComponent($component, $value->getContent($this->name), $params);
        });
    }

    /**
     * @param Repository|Model $source
     *
     * @return mixed
     */
    protected function handler($source)
    {
        return with($source, $this->render);
    }
}
