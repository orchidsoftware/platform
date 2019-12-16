<?php

declare(strict_types=1);

namespace Orchid\Screen\Templates;

use Orchid\Screen\Content;
use Orchid\Screen\Presenters\Compactable;

class Compact extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::templates.compact';

    /**
     * @param Compactable $card
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Compactable $card)
    {
        return view($this->template, [
            'id'    => $card->id(),
            'image' => $card->image(),
        ]);
    }
}
