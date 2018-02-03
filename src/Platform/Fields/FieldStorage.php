<?php

declare(strict_types=1);

namespace Orchid\Platform\Fields;

use Orchid\Platform\Kernel\Storage;

class FieldStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'platform.fields';
}
