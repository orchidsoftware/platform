<?php

declare(strict_types=1);

namespace Orchid\Platform\Components;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Orchid\Platform\Notifications\DashboardMessage;

class Notification extends Component
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public $user;

    /**
     * Create a new component instance.
     */
    public function __construct(Guard $guard)
    {
        $this->user = $guard->user();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        $notifications = $this->user
            ->unreadNotifications()
            ->where('type', DashboardMessage::class)
            ->limit(15)
            ->get();

        return view('platform::components.notification', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Determine if the component should be rendered.
     *
     * @return bool
     */
    public function shouldRender(): bool
    {
        return config('platform.notifications.enabled', true);
    }
}
