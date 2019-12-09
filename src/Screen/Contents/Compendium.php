<?php

declare(strict_types=1);

namespace Orchid\Screen\Contents;

use Orchid\Screen\Content;

/**
 * Class Compendium.
 */
class Compendium extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::contents.compendium';

    /**
     * @param array $list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(array $list)
    {
        return view($this->template, [
            'list' => $list,
        ]);
    }
}
