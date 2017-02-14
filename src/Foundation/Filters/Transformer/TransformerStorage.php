<?php

namespace Orchid\Foundation\Filters\Transformer;

use Orchid\Foundation\Kernel\Storage;

class TransformerStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'content.transformers';
}
