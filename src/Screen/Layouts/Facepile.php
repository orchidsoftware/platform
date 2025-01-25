<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use ArrayAccess;
use Illuminate\View\View;
use Orchid\Screen\Contracts\Personable;

class Facepile extends Content
{

    protected string $template = 'platform::layouts.facepile';

    public function render(ArrayAccess $users): View
    {
        return view($this->template, [
            'users' => $users,
        ]);
    }
}
