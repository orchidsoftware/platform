<?php

declare(strict_types=1);

namespace Orchid\Screen\Contents;

use Orchid\Screen\Content;
use Orchid\Screen\Presenters\Quotation;

class Quote extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::contents.note';

    /**
     * @param Quotation $quotation
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Quotation $quotation)
    {
        $profile = new Profile($quotation);

        return view($this->template, [
            'profile' => $profile,
            'message' => $quotation->message(),
            'date'    => $quotation->date(),
        ]);
    }
}
