<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Component;
use Orchid\Platform\Models\User;

class UserTDArguments extends Component
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var Application
     */
    public $application;

    /**
     * @var string
     */
    public $from;

    /**
     * Create a new component instance.
     *
     * @param Application $application
     * @param User        $user
     * @param string      $from
     */
    public function __construct(Application $application, User $user, string $from = 'Alexandr')
    {
        $this->user = $user;
        $this->application = $application;
        $this->from = $from;
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
    Hello {{ $user->email }} from {{ $from }}
    Is {{ $application->version() }} version.
</div>
blade;
    }
}
