<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Components;

use Illuminate\View\Component;
use Orchid\Platform\Models\User;

class UserTD extends Component
{
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new component instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div>
    Hello {{ $user->email }}
</div>
blade;
    }
}
