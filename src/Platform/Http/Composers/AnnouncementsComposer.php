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
     */
    public function compose(View $view)
    {
        $announcement = Dashboard::modelClass(Announcement::class)
            ->first();


        $view->with('announcement', $announcement);
    }
}