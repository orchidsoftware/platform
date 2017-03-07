<?php

namespace Orchid\Filters\Transformer;

use Orchid\Kernel\Storage;

class TransformerStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'content.transformers';
}
