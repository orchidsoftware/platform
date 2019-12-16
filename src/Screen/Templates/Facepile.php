<?php

declare(strict_types=1);

namespace Orchid\Screen\Templates;

use Orchid\Screen\Content;
use Orchid\Screen\Presenters\Personable;

class Facepile extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::templates.facepile';

    /**
     * @param Personable[] $users
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(array $users)
    {
        return view($this->template, [
            'users' => $users,
        ]);
    }
}
