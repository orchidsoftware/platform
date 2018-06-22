<?php

declare(strict_types=1);

namespace Orchid\Platform\Attachments\Templates;

use Orchid\Platform\Attachments\BaseTemplate;

/**
 * Class Large.
 */
class Large extends BaseTemplate
{
    /**
     * @var int
     */
    public $width = 1000;

    /**
     * @var int
     */
    public $height = 500;

    /**
     * @var int
     */
    public $quality = 95;
}
