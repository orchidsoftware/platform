<?php

declare(strict_types=1);

namespace Orchid\Screen\Templates;

use Orchid\Screen\Content;
use Orchid\Screen\Presenters\Personable;

class Persona extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::templates.persona';

    /**
     * @param Personable $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Personable $user)
    {
        return view($this->template, [
            'title'    => $user->title(),
            'subTitle' => $user->subTitle(),
            'image'    => $user->image(),
            'url'      => $user->url(),
        ]);
    }
}
