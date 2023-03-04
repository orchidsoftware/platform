<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Support\Arr;
use Orchid\Screen\Action;
use Orchid\Screen\Commander;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Block.
 */
abstract class Block extends Layout
{
    use Commander;

    /**
     * @var string
     */
    protected $template = 'platform::layouts.block';

    /**
     * @var false[]
     */
    protected $variables = [
        'vertical' => false,
    ];

    /**
     * Button commands.
     *
     * @var array
     */
    protected $commandBar = [];

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
     * @return Action[]
     */
    protected function commandBar(): array
    {
        return $this->commandBar;
    }

    /**
     * @return mixed
     */
    public function build(Repository $repository)
    {
        $this->variables['commandBar'] = $this->buildCommandBar($repository);

        return $this->buildAsDeep($repository);
    }

    /**
     * Used to create the title of a group of form elements.
     */
    public function title(string $title): self
    {
        $this->variables['title'] = $title;

        return $this;
    }

    /**
     * Used to create the description of a group of form elements.
     *
     * @param string|\Illuminate\View\View description
     */
    public function description($description): self
    {
        $this->variables['description'] = $description;

        return $this;
    }

    /**
     * Used to define block orientation.
     *
     * @param bool $vertical
     */
    public function vertical($vertical = true): self
    {
        $this->variables['vertical'] = $vertical;

        return $this;
    }

    /**
     * @param Action|Action[] description
     */
    public function commands($commands): self
    {
        $this->commandBar = Arr::wrap($commands);

        return $this;
    }
}
