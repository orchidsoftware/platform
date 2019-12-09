<?php

declare(strict_types=1);

namespace Orchid\Screen\Contents;

use Orchid\Screen\Content;
use Orchid\Screen\Presenters\Profilable;

/**
 * Class Profile.
 */
class Profile extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::contents.profile';

    /**
     * @param Profilable $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Profilable $user)
    {
        return view($this->template, [
            'title'    => $user->title(),
            'subTitle' => $user->subTitle(),
            'image'    => $user->image(),
            'url'      => $user->url(),
        ]);
    }
}
