<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use JsonSerializable;
use Illuminate\Support\Arr;
use Orchid\Screen\Repository;

/**
 * Class Base.
 */
abstract class Base implements JsonSerializable
{
    /**
     * Main template to display the layer
     * Represents the view() argument.
     *
     * @var string
     */
    protected $template;

    /**
     * Nested layers that should be
     * displayed along with it.
     *
     * @var array
     */
    protected $layouts = [];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * @var string
     */
    protected $asyncMethod;

    /**
     * The call is asynchronous and should return
     * only the template of the specific layer.
     *
     * @var bool
     */
    protected $async = false;

    /**
     * The following request must be asynchronous.
     *
     * @var bool
     */
    protected $asyncNext = false;

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * @param Repository $repository
     *
     * @return mixed
     */
    abstract public function build(Repository $repository);

    /**
     * @param string $method
     *
     * @return self
     */
    public function async(string $method): self
    {
        $this->asyncMethod = $method;
        $this->asyncNext = true;

        return $this;
    }

    /**
     * @return Base
     */
    public function currentAsync() : self
    {
        $this->async = true;

        return $this;
    }

    /**
     * @param Repository $query
     *
     * @return bool
     */
    public function canSee(/* @noinspection PhpUnusedParameterInspection */ Repository $query): bool
    {
        return true;
    }

    /**
     * @param Repository $repository
     *
     * @return mixed
     */
    protected function buildAsDeep(Repository $repository)
    {
        $build = [];

        if (! $this->checkPermission($this, $repository)) {
            return;
        }

        foreach ($this->layouts as $key => $layouts) {
            $layouts = Arr::wrap($layouts);

            $build += $this->buildChild($layouts, $key, $repository);
        }

        $variables = array_merge($this->variables, [
            'manyForms'           => $build,
            'templateSlug'        => $this->getSlug(),
            'templateAsync'       => $this->asyncNext,
            'templateAsyncMethod' => $this->asyncMethod,
        ]);

        return view($this->async ? 'platform::layouts.blank' : $this->template, $variables);
    }

    /**
     * @param self       $layout
     * @param Repository $repository
     *
     * @return bool
     */
    protected function checkPermission(self $layout, Repository $repository): bool
    {
        return method_exists($layout, 'canSee') && $layout->canSee($repository);
    }

    /**
     * @param array      $layouts
     * @param int|string $key
     * @param Repository $repository
     *
     * @return array
     */
    protected function buildChild(array $layouts, $key, Repository $repository)
    {
        $build = [];

        foreach ($layouts as $layout) {

            /** @var Base|string $layout */
            $layout = is_object($layout) ? $layout : app()->make($layout);

            if (! $this->checkPermission($layout, $repository)) {
                continue;
            }

            $build[$key][] = $layout->build($repository);
        }

        return $build;
    }

    /**
     * Returns the system layer name.
     * Required to define an asynchronous layer.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return sha1(json_encode($this));
    }

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        $props = collect(get_object_vars($this));

        return $props->except(['query'])->toArray();
    }
}
