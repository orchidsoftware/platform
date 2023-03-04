<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\View;
use Orchid\Screen\Contracts\Personable;

class Persona extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.persona';

    public function render(Personable $user): View
    {
        return view($this->template, [
            'title'    => $user->title(),
            'subTitle' => $user->subTitle(),
            'image'    => $user->image(),
            'url'      => $user->url(),
        ]);
    }
}
