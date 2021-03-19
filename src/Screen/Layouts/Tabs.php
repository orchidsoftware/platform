<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Tabs.
 */
abstract class Tabs extends Layout
{
    /**
     * @var string
     */
    public $template = 'platform::layouts.tabs';

    protected $titles = [];

    /**
     * Layout constructor.
     *
     * @param Layout[] $layouts
     * @param string[] $titles
     */
    public function __construct(array $layouts = [], array $titles = [])
    {
        $this->layouts = $layouts;
        $this->titles = $titles;
    }

    /**
     * @param array $titles
     *
     * @return Tabs
     */
    public function titles(array $titles = [])
    {
        $this->titles = $titles;

        return $this;
    }

    /**
     * @param Repository $repository
     *
     * @return mixed
     */
    public function build(Repository $repository)
    {
        return $this->buildAsDeep($repository)->with([
            'titles' => $this->titles,
        ]);
    }
}
