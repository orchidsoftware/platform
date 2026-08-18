<?php

declare(strict_types=1);

namespace Orchid\Platform\Components;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Orchid\Platform\Notifications\DashboardMessage;
use Orchid\Platform\Notifications\OrchidMessage;

class Notification extends Component
{
    private const COUNT_INDICATOR_THRESHOLD = 10;

    /**
     * @var Authenticatable|null
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
        $unreadCount = $this->user
            ->unreadNotifications()
            ->whereIn('type', [OrchidMessage::class, DashboardMessage::class])
            ->reorder()
            ->limit(self::COUNT_INDICATOR_THRESHOLD)
            ->pluck('id')
            ->count();

        return view('orchid::components.notification', [
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Determine if the component should be rendered.
     */
    public function shouldRender(): bool
    {
        return config('orchid.notifications.enabled', true);
    }
}
