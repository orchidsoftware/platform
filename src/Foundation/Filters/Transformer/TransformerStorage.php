<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 07.02.17
 * Time: 14:30
 */

namespace Orchid\Foundation\Filters\Transformer;


use Orchid\Foundation\Kernel\Storage;

class TransformerStorage extends Storage
{
    protected $configField = 'content.transformers';
}