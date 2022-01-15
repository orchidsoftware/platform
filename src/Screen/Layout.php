<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use JsonSerializable;
use Orchid\Support\Facades\Dashboard;

/**
 * Class Layout.
 */
abstract class Layout implements JsonSerializable
{
    use CanSee;

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
     * @var Layout[]
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
     * @var array
     */
    protected $variables = [];

    /**
     * @var Repository
     */
    protected $query;

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
        if (! Str::startsWith($method, 'async')) {
            $method = Str::start(Str::ucfirst($method), 'async');
        }

        $this->asyncMethod = $method;

        return $this;
    }

    /**
     * @return Layout
     */
    public function currentAsync(): self
    {
        $this->async = true;

        return $this;
    }

    /**
     * @param Repository $repository
     *
     * @return mixed
     */
    protected function buildAsDeep(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $build = collect($this->layouts)
            ->map(function ($layouts) {
                return Arr::wrap($layouts);
            })
            ->map(function (iterable $layouts, string $key) use ($repository) {
                return $this->buildChild($layouts, $key, $repository);
            })
            ->collapse()
            ->all();

        $variables = array_merge($this->variables, [
            'manyForms'    => $build,
            'templateSlug' => $this->getSlug(),
            'asyncEnable'  => empty($this->asyncMethod) ? 0 : 1,
            'asyncRoute'   => $this->asyncRoute(),
        ]);

        return view($this->async ? 'platform::layouts.blank' : $this->template, $variables);
    }

    /**
     * Return URL for screen template requests from browser.
     *
     * @return string|null
     */
    private function asyncRoute(): ?string
    {
        $screen = Dashboard::getCurrentScreen();

        if (! $screen) {
            return null;
        }

        return route('platform.async', [
            'screen'   => Crypt::encryptString(get_class($screen)),
            'method'   => $this->asyncMethod,
            'template' => $this->getSlug(),
        ]);
    }

    /**
     * @param array      $layouts
     * @param int|string $key
     * @param Repository $repository
     *
     * @return array
     */
    protected function buildChild(iterable $layouts, $key, Repository $repository)
    {
        return collect($layouts)
            ->flatten()
            ->map(function ($layout) {
                return is_object($layout) ? $layout : resolve($layout);
            })
            ->filter(function () {
                return $this->isSee();
            })
            ->reduce(function ($build, self $layout) use ($key, $repository) {
                $build[$key][] = $layout->build($repository);

                return $build;
            }, []);
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
     * @param string $slug
     *
     * @return Layout|null
     */
    public function findBySlug(string $slug)
    {
        if ($this->getSlug() === $slug) {
            return $this;
        }

        $layouts = method_exists($this, 'layouts')
            ? $this->layouts()
            : $this->layouts;

        return collect($layouts)
            ->flatten()
            ->map(static function ($layout) use ($slug) {
                $layout = is_object($layout)
                    ? $layout
                    : resolve($layout);

                return $layout->findBySlug($slug);
            })
            ->filter()
            ->filter(static function ($layout) use ($slug) {
                return $layout->getSlug() === $slug;
            })
            ->first();
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $props = collect(get_object_vars($this));

        return $props->except(['query'])->toArray();
    }
}
