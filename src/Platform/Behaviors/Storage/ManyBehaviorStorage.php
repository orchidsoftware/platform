<?php

declare(strict_types=1);

namespace Orchid\Platform\Behaviors\Storage;

use Orchid\Platform\Kernel\Storage;

class ManyBehaviorStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'platform.many';
}
