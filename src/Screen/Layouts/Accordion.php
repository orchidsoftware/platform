<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Illuminate\View\View;

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

}
