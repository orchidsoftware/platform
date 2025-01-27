<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Accordion.
 */
abstract class Accordion extends Layout
{
    protected string $template = 'platform::layouts.accordion';

    protected array $variables = [
        'stayOpen' => false,
        'open'     => [],
    ];

    /**
     * Layout constructor.
     *
     * @param Layout[] $layouts
     */
    public function __construct(array $layouts = [])
    {
        $this->layouts = $layouts;
        $this->variables['open'] = [array_key_first($this->layouts)];
    }

    public function build(Repository $repository): ?View
    {
        return $this->buildAsDeep($repository);
    }

    /**
     * Make accordion items stay open when another item is opened.
     */
    public function stayOpen(bool $stayOpen = true): static
    {
        $this->variables['stayOpen'] = $stayOpen;

        return $this;
    }

    /**
     * Set active accordion(s).
     *
     * @param string|array $activeAccordion
     *
     * @return $this
     */
    public function open(string|array $activeAccordion): static
    {
        $this->variables['open'] = Arr::wrap($activeAccordion);

        return $this;
    }
}
