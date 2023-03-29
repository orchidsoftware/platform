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
     * @deprecated usage `method` property
     */
    protected $asyncMethod;

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * @var string
     */
    protected $method;

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
     * @return mixed
     */
    abstract public function build(Repository $repository);

    public function currentAsync(): self
    {
        $this->async = true;

        return $this;
    }

    public function async(string $method): self
    {
        if (! Str::startsWith($method, 'async')) {
            $method = Str::start(Str::ucfirst($method), 'async');
        }

        $this->asyncMethod = $method;
        $this->method = $method;

        return $this;
    }

    /**
     * @return mixed
     */
    protected function buildAsDeep(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $build = collect($this->layouts)
            ->map(fn ($layouts) => Arr::wrap($layouts))
            ->map(fn (iterable $layouts, string $key) => $this->buildChild($layouts, $key, $repository))
            ->collapse()
            ->all();

        $variables = array_merge($this->variables, [
            'manyForms'    => $build,
            'templateSlug' => $this->getSlug(),
            'asyncEnable'  => empty($this->method ?? $this->asyncMethod) ? 0 : 1,
            'asyncRoute'   => $this->asyncRoute(),
        ]);

        return view($this->async ? 'platform::layouts.blank' : $this->template, $variables);
    }

    /**
     * Return URL for screen template requests from browser.
     */
    private function asyncRoute(): ?string
    {
        $screen = Dashboard::getCurrentScreen();

        if (! $screen) {
            return null;
        }

        return route('platform.async', [
            'screen'   => Crypt::encryptString(get_class($screen)),
            'method'   => $this->method ?? $this->asyncMethod,
            'template' => $this->getSlug(),
        ]);
    }

    /**
     * @param array      $layouts
     * @param int|string $key
     *
     * @return array
     */
    protected function buildChild(iterable $layouts, $key, Repository $repository)
    {
        return collect($layouts)
            ->flatten()
            ->map(fn ($layout) => is_object($layout) ? $layout : resolve($layout))
            ->filter(fn () => $this->isSee())
            ->reduce(function ($build, self $layout) use ($key, $repository) {
                $build[$key][] = $layout->build($repository);

                return $build;
            }, []);
    }

    /**
     * Returns the system layer name.
     * Required to define an asynchronous layer.
     */
    public function getSlug(): string
    {
        return sha1(json_encode($this));
    }

    /**
     * @return Layout|null
     */
    public function findBySlug(string $slug)
    {
        if ($this->getSlug() === $slug) {
            return $this;
        }

        // Trying to find the right layer inside
        return collect($this->layouts)
            ->flatten()
            ->map(static function ($layout) use ($slug) {
                $layout = is_object($layout)
                    ? $layout
                    : resolve($layout);

                return $layout->findBySlug($slug);
            })
            ->filter()
            ->filter(static fn ($layout) => $layout->getSlug() === $slug)
            ->first();
    }

    public function jsonSerialize(): array
    {
        $props = collect(get_object_vars($this));

        return $props->except(['query'])->toArray();
    }
}
