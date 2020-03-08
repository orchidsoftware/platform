<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\View;
use Orchid\Screen\Content;
use Orchid\Screen\Contracts\Compactable;

class Compact extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.compact';

    /**
     * @param Compactable $card
     *
     * @return View
     */
    public function render(Compactable $card) : View
    {
        return view($this->template, [
            'id'    => $card->id(),
            'image' => $card->image(),
        ]);
    }
}
