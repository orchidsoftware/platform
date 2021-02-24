<?php

declare(strict_types=1);

namespace Orchid\Platform\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\View\Component;
use Orchid\Platform\Notifications\DashboardMessage;

class Notification extends Component
{
    /**
     * @var \Illuminate\Support\Collection
     */
    public $notifications;

    /**
     * Create a new component instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->notifications = $request->user()
            ->unreadNotifications()
            ->where('type', DashboardMessage::class)
            ->limit(15)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('platform::components.notification');
    }

    /**
     * Determine if the component should be rendered.
     *
     * @return bool
     */
    public function shouldRender()
    {
        return config('platform.notifications.enabled', true);
    }
}
