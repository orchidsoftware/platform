<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Components;

class UserTDView extends UserTDArguments
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('exemplar::components.user-td-view');
    }
}
