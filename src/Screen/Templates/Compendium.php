<?php

declare(strict_types=1);

namespace Orchid\Screen\Templates;

use Orchid\Screen\Content;

class Compendium extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::templates.compendium';

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
