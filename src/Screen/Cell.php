<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Closure;
use Illuminate\Database\Eloquent\Model;
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
     * @param string      $component
     * @param string|null $name
     * @param array       $params
     *
     * @return $this
     */
    public function component(string $component, string $name = null, array $params = []): self
    {
        return $this->render(function ($value) use ($component, $name, $params) {
            if ($name === null) {
                return Blade::renderComponent($component, $value);
            }

            $params[$name] = $value;

            return Blade::renderComponent($component, $params);
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
