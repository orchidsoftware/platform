<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;

/**
 * Class Attach.
 *
 * @method Attach   accept(string $value)
 * @method Attach   required($value = true)
 * @method Attach   multiple($value = true)
 * @method Attach   maxSize(int $value)
 * @method Attach   placeholder(string $value)
 * @method Attach   errorMaxSizeMessage(string $value)
 * @method Attach   errorTypeMessage(string $value)
 * @method CheckBox help(string $value = null)
 * @method CheckBox title(string $value = null)
 */
class Attach extends Field
{
    use Multipliable;

    /**
     * @var string
     */
    protected $view = 'platform::fields.attach';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'maxCount'            => 999,
        'maxSize'             => 8, // MB
        'accept'              => '*/*',
        'placeholder'         => 'Upload file',
        'errorMaxSizeMessage' => 'File ":name" is too large to upload',
        'errorTypeMessage'    => 'The attached file must be an image',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accept',
        'multiple',
        'required',
    ];
}
