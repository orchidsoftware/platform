<?php

declare(strict_types=1);

namespace Orchid\Platform\Observers;

use Spatie\Activitylog\Models\Activity;

class ActivityLogObserver
{
    /**
     * Handle to the Activity "created" event.
     *
     * @param  \Spatie\Activitylog\Models\Activity $activity
     *
     * @return void
     */
    public function creating(Activity $activity)
    {
        $request = request();

        $activity->properties = $activity->properties->put('request', [
            'referer'    => $request->header('referer'),
            'user-agent' => $request->header('user-agent'),
            'ip'         => $request->ip(),
        ]);
    }
}
