<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\View;
use Orchid\Screen\Action;
use Orchid\Screen\Content;
use Orchid\Screen\Contracts\Actionable;
use Orchid\Screen\Contracts\Cardable;

class Card extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.card';

    /**
     * @var array|Action[]
     */
    protected $commandBar;

    /**
     * Card constructor.
     *
     * @param string   $target
     * @param Action[] $commandBar
     */
    public function __construct(string $target, array $commandBar = [])
    {
        parent::__construct($target);

        $this->commandBar = $commandBar;
    }

    /**
     * @param Cardable $card
     *
     * @return View
     */
    public function render(Cardable $card) : View
    {
        return view($this->template, [
            'title'        => $card->title(),
            'descriptions' => $card->descriptions(),
            'image'        => $card->image(),
            'commandBar'   => $this->buildCommandBar(),
            'status'       => $card->status(),
        ]);
    }

    /**
     * @return array
     */
    private function buildCommandBar(): array
    {
        return collect($this->commandBar)
            ->map(function (Actionable $command) {
                return $command->build($this->query);
            })->all();
    }
}
