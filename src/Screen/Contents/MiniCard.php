<?php

declare(strict_types=1);

namespace Orchid\Screen\Contents;

use Orchid\Screen\Content;
use Orchid\Screen\Presenters\MiniCard as Presentor;

class MiniCard extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::contents.miniCard';

    /**
     * @param Presentor $card
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Presentor $card)
    {
        return view($this->template, [
            'id'    => $card->id(),
            'image' => $card->image(),
        ]);
    }
}
