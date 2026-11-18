<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Engine;

use Orchid\Attachment\Engines\Generator;

class CustomAttachmentGenerator extends Generator
{
    public function name(): string
    {
        return pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);
    }

    public function path(): string
    {
        return 'custom';
    }
}
