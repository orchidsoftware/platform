<?php

declare(strict_types=1);

namespace Orchid\Screen\Contents;

use Orchid\Screen\Action;
use Orchid\Screen\Content;
use Orchid\Screen\Contracts\ActionContract;
use Orchid\Screen\Presenters\Card;

/**
 * Class HorizontalCard
 */
class HorizontalCard extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::contents.card';

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
     * @param Card $card
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Card $card)
    {
        return view($this->template, [
            'title'        => $card->title(),
            'descriptions' => $card->descriptions(),
            'image'        => $card->image(),
            'commandBar'   => $this->buildCommandBar(),
            'status'       => $card->status(),
            'users'        => [],//$card->buildUserBar(),
        ]);
    }

    /**
     * @return array
     */
    private function buildCommandBar(): array
    {
        return collect($this->commandBar)
            ->map(function (ActionContract $command) {
                return $command->build($this->query);
            })->all();
    }
}
