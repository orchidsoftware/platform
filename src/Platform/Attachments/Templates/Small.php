<?php

declare(strict_types=1);

namespace Orchid\Platform\Attachments\Templates;

use Orchid\Platform\Attachments\BaseTemplate;

/**
 * Class Small.
 */
class Small extends BaseTemplate
{
    /**
     * @var int
     */
    public $width = 100;

    /**
     * @var int
     */
    public $height = 100;

    /**
     * @var int
     */
    public $quality = 50;
}
