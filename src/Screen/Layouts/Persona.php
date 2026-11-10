<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\View;
use Orchid\Screen\Contracts\Personable;

/** @phpstan-consistent-constructor */
class Persona extends Content
{
    public static function make(mixed $target): static
    {
        return new static($target);
    }

    /**
     * @var string
     */
    protected $template = 'orchid::layouts.persona';

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
