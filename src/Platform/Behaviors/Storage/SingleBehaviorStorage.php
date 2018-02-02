<?php

declare(strict_types=1);

namespace Orchid\Platform\Behaviors\Storage;

use Orchid\Platform\Kernel\Storage;

class SingleBehaviorStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'platform.single';
}
