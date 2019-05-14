<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Support\Arr;
use Orchid\Screen\Repository;

/**
 * Class Base.
 */
abstract class Base
{
    /**
     * Main template to display the layer
     * Represents the view() argument.
     *
     * @var string
     */
    public $template;

    /**
     * Nested layers that should be
     * displayed along with it.
     *
     * @var array
     */
    public $layouts = [];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * @var string
     */
    public $asyncMethod;

    /**
     * The call is asynchronous and should return
     * only the template of the specific layer.
     *
     * @var bool
     */
    public $async = false;

    /**
     * The following request must be asynchronous.
     *
     * @var bool
     */
    public $asyncNext = false;

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * Base constructor.
     *
     * @param Base[] $layouts
     */
    public function __construct(array $layouts = [])
    {
        $this->layouts = $layouts;
    }

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
            $layout = ! is_object($layout) ? new $layout() : $layout;

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
}
