<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Support\Arr;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Accordion.
 *
 * @phpstan-consistent-constructor
 */
class Accordion extends Layout
{
    public static function make(array $layouts = []): static
    {
        return new static($layouts);
    }

    /**
     * @var string
     */
    protected $template = 'orchid::layouts.accordion';

    /**
     * @var array
     */
    protected $variables = [
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

    /**
     * @return mixed
     */
    public function build(Repository $repository)
    {
        return $this->buildAsDeep($repository);
    }

    /**
     * Make accordion items stay open when another item is opened.
     *
     *
     * @return $this
     */
    public function stayOpen(bool $stayOpen = true): self
    {
        $this->variables['stayOpen'] = $stayOpen;

        return $this;
    }

    /**
     * Set active accordion(s).
     *
     *
     * @return $this
     */
    public function open(string|array $activeAccordion): self
    {
        $this->variables['open'] = Arr::wrap($activeAccordion);

        return $this;
    }
}
