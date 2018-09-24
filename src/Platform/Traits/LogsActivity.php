<?php

declare(strict_types=1);

namespace Orchid\Platform\Traits;

use Base64Url\Base64Url;
use Orchid\Platform\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\Traits\LogsActivity as SpatieLogsActivity;

trait LogsActivity
{
    use SpatieLogsActivity;

    /**
     * Actually changed.
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * @var string
     */
    protected static $causerRoute = 'platform::systems.user';

    /**
     * @var string
     */
    protected static $subjectRoute;

    /**
     * @return string
     */
    public function classEncodeBase64Url() : string
    {
        return Base64Url::encode(get_class($this));
    }

    /**
     * Display header description.
     *
     * @return string
     */
    public function historyDescription() : string
    {
        return 'История изменений модели';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
