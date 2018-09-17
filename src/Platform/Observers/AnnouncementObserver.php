<?php

declare(strict_types=1);

namespace Orchid\Platform\Observers;

use Orchid\Platform\Models\Announcement;

class AnnouncementObserver
{
    public function saving()
    {
        Announcement::disableAll();
    }
}
