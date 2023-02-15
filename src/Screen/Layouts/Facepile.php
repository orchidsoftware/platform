<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use ArrayAccess;
use Illuminate\View\View;
use Orchid\Screen\Contracts\Personable;

class Facepile extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.facepile';

    /**
     * @param Personable[] $users
     */
    public function render(ArrayAccess $users): View
    {
        return view($this->template, [
            'users' => $users,
        ]);
    }
}
