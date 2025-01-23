<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Support\Arr;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Accordion.
 */
abstract class Accordion extends Layout
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.accordion';

    /**
     * @var bool
     */
    private $openSet = false;

    /**
     * @var array
     */
    protected $variables = [
        'stayOpen' => false,
        'open' => [],
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
     * @param bool $stayOpen
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
     * @param string|array $activeAccordion
     *
     * @return $this
     */
    public function open(string|array $activeAccordion): self
    {
        $activeAccordion = Arr::wrap($activeAccordion);

        $this->variables['open'] = $this->openSet
            ? array_merge($this->variables['open'], $activeAccordion)
            : $activeAccordion;

        $this->openSet = true;

        return $this;
    }

}
