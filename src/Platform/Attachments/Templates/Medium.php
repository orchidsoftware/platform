<?php

declare(strict_types=1);

namespace Orchid\Platform\Attachments\Templates;

use Orchid\Platform\Attachments\BaseTemplate;

/**
 * Class Medium
 */
class Medium extends BaseTemplate
{
    /**
     * @var int
     */
    public $width = 600;

    /**
     * @var int
     */
    public $height = 300;

    /**
     * @var int
     */
    public $quality = 75;
}
