<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use ArrayAccess;
use Illuminate\View\View;
use Orchid\Screen\Contracts\Personable;

/** @phpstan-consistent-constructor */
class Facepile extends Content
{
    public static function make(mixed $target): static
    {
        return new static($target);
    }

    /**
     * @var string
     */
    protected $template = 'orchid::layouts.facepile';

    /**
     * @param ArrayAccess<int, Personable> $users
     */
    public function render(ArrayAccess $users): View
    {
        return view($this->template, [
            'users' => $users,
        ]);
    }
}
