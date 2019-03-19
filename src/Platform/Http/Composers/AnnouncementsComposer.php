<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

use Illuminate\View\View;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\Announcement;

class AnnouncementsComposer
{
    /**
     * Registering the main menu items.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $announcement = Dashboard::modelClass(Announcement::class)
            ->getActive();

        $view->with('announcement', $announcement);
    }
}
