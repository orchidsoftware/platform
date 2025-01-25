<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use ArrayAccess;
use Illuminate\View\View;

class Facepile extends Content
{
    /**
     * @var string
     */
    protected string $template = 'platform::layouts.facepile';

    /**
     * @param ArrayAccess $users
     * @return View
     */
    public function render(ArrayAccess $users): View
    {
        return view($this->template, [
            'users' => $users,
        ]);
    }
}
