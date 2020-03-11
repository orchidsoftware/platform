<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\View;
use Orchid\Screen\Content;

class Compendium extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.compendium';

    /**
     * @var string
     */
    protected $label = '';

    /**
     * @param array $list
     *
     * @return View
     */
    public function render(array $list): View
    {
        return view($this->template, [
            'list'  => $list,
            'label' => $this->label,
        ]);
    }

    /**
     * @param string $label
     *
     * @return Compendium
     */
    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
