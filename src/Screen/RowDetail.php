<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Closure;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Orchid\Support\Facades\Orchid;

class RowDetail
{
    protected ?Closure $repository = null;

    protected ?Closure $render = null;

    protected iterable $layouts = [];

    protected ?string $dataLoadingMethod = null;

    protected array|object $parameters = [];

    protected string $buttonLabel = 'Show details';

    protected string $icon = 'bs.chevron-down';

    protected bool $openByDefault = false;

    public static function make(): self
    {
        return new self;
    }

    public function repository(Closure $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function layouts(iterable $layouts): self
    {
        $this->layouts = $layouts;

        return $this;
    }

    public function render(Closure $render): self
    {
        $this->render = $render;

        return $this;
    }

    public function async(string $method): self
    {
        if (! Str::startsWith($method, 'async')) {
            $method = Str::start(Str::ucfirst($method), 'async');
        }

        return $this->deferred($method);
    }

    public function deferred(string $method): self
    {
        $this->dataLoadingMethod = $method;

        return $this;
    }

    public function parameters(array|object $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function buttonLabel(string $label): self
    {
        $this->buttonLabel = $label;

        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function openByDefault(bool $open = true): self
    {
        $this->openByDefault = $open;

        return $this;
    }

    public function isDeferred(): bool
    {
        return $this->dataLoadingMethod !== null;
    }

    public function isOpenByDefault(): bool
    {
        return $this->openByDefault;
    }

    public function buttonLabelValue(): string
    {
        return __($this->buttonLabel);
    }

    public function iconValue(): string
    {
        return $this->icon;
    }

    public function build($source, ?object $loop = null, ?Repository $parent = null): string
    {
        if ($this->render !== null) {
            return (string) call_user_func($this->render, $source, $loop, $parent);
        }

        return $this->buildFromRepository(
            $this->repositoryFromSource($source, $loop, $parent)
        );
    }

    public function buildFromRepository(Repository $repository): string
    {
        if ($this->render !== null) {
            return (string) call_user_func($this->render, $repository);
        }

        return $this->collectLayouts($this->layouts)
            ->map(fn ($layout) => is_object($layout) ? $layout : resolve($layout))
            ->filter(fn ($layout) => $layout instanceof Layout)
            ->map(fn (Layout $layout) => $layout->build($repository))
            ->filter()
            ->map(fn ($view) => (string) $view)
            ->implode('');
    }

    public function deferredPayload(string $layoutSlug, string $target, $source, ?object $loop = null): array
    {
        $screen = Orchid::getCurrentScreen();

        if (! $screen || ! $this->isDeferred()) {
            return [];
        }

        return [
            'body' => [
                '_screen' => Crypt::encryptString(get_class($screen)),
                '_call'   => $this->dataLoadingMethod,
                '_layout' => $layoutSlug,
                '_target' => $target,
            ],
            'query' => $this->preparedParameters($source, $loop),
        ];
    }

    protected function repositoryFromSource($source, ?object $loop = null, ?Repository $parent = null): Repository
    {
        if ($this->repository !== null) {
            $items = call_user_func($this->repository, $source, $loop, $parent);

            return $items instanceof Repository ? $items : new Repository($items);
        }

        if ($source instanceof Repository) {
            return $source;
        }

        return new Repository([
            'source' => $source,
        ]);
    }

    protected function collectLayouts(iterable $layouts): Collection
    {
        return collect($layouts)->reduce(function (Collection $items, $layout) {
            if (is_iterable($layout) && ! is_object($layout)) {
                return $items->merge($this->collectLayouts($layout));
            }

            return $items->push($layout);
        }, collect());
    }

    protected function preparedParameters($source, ?object $loop = null): array|object
    {
        $parameters = value($this->parameters, $source, $loop);

        if (! is_array($parameters)) {
            return $parameters;
        }

        return collect($parameters)
            ->filter(fn ($value) => filled($value))
            ->map(fn ($value) => $value instanceof UrlRoutable ? $value->getRouteKey() : $value)
            ->all();
    }
}
