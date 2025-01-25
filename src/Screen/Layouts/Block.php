<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Support\Arr;
use Orchid\Screen\Action;
use Orchid\Screen\Commander;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Illuminate\Contracts\View\View;

/**
 * Class Block.
 */
abstract class Block extends Layout
{
    use Commander;

    protected string $template = 'platform::layouts.block';

    /**
     * @var false[]
     */
    protected array $variables = [
        'vertical' => false,
    ];

    /**
     * Button commands.
     */
    protected array $commandBar = [];

    /**
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

    public function build(Repository $repository): ?View
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
     */
    public function description(string|View $description): self
    {
        $this->variables['description'] = $description;

        return $this;
    }

    /**
     * Used to define block orientation.
     */
    public function vertical(bool $vertical = true): self
    {
        $this->variables['vertical'] = $vertical;

        return $this;
    }

    /**
     * @param Action|Action[] $commands
     */
    public function commands(Action|array $commands): self
    {
        $this->commandBar = Arr::wrap($commands);

        return $this;
    }
}
