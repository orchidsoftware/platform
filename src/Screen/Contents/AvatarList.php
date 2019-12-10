<?php

declare(strict_types=1);

namespace Orchid\Screen\Contents;

use Orchid\Screen\Content;
use Orchid\Screen\Presenters\Profilable;

class AvatarList extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::contents.avatarList';

    /**
     * @param Profilable[] $user
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
