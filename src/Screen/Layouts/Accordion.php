<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

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
     * @var array
     */
    protected $variables = [
        'stayOpen' => false,
    ];

    /**
     * Layout constructor.
     *
     * @param Layout[] $layouts
     */
    public function __construct(array $layouts = [])
    {
        $this->layouts = $layouts;
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
}
