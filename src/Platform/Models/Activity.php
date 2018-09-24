<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Orchid\Platform\Traits\FilterTrait;
use Orchid\Platform\Traits\MultiLanguage;

class Activity extends \Spatie\Activitylog\Models\Activity
{
    use FilterTrait, MultiLanguage;

    /**
     * @return int
     */
    public function countChanges() : int
    {
        return \count($this->changes()['attributes'] ?? []);
    }

}