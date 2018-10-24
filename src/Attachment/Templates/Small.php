<?php

declare(strict_types=1);

namespace Orchid\Attachment\Templates;

use Orchid\Attachment\BaseTemplate;

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
