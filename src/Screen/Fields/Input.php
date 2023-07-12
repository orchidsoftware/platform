<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;

/**
 * Class Input.
 *
 * @method Input accept($value = true)
 * @method Input accesskey($value = true)
 * @method Input autocomplete($value = true)
 * @method Input autofocus($value = true)
 * @method Input checked($value = true)
 * @method Input disabled($value = true)
 * @method Input form($value = true)
 * @method Input formaction($value = true)
 * @method Input formenctype($value = true)
 * @method Input formmethod($value = true)
 * @method Input formnovalidate($value = true)
 * @method Input formtarget($value = true)
 * @method Input max(int $value)
 * @method Input maxlength(int $value)
 * @method Input min(int $value)
 * @method Input minlength(int $value)
 * @method Input name(string $value = null)
 * @method Input pattern($value = true)
 * @method Input placeholder(string $value = null)
 * @method Input readonly($value = true)
 * @method Input required(bool $value = true)
 * @method Input size($value = true)
 * @method Input src($value = true)
 * @method Input step($value = true)
 * @method Input tabindex($value = true)
 * @method Input type($value = true)
 * @method Input value($value = true)
 * @method Input help(string $value = null)
 * @method Input popover(string $value = null)
 * @method Input mask($value = true)
 * @method Input title(string $value = null)
 * @method Input inputmode(string $value = null)
 */
class Input extends Field
{
    use Multipliable;

    /**
     * @var string
     */
    protected $view = 'platform::fields.input';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'    => 'form-control',
        'datalist' => [],
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accept',
        'accesskey',
        'autocomplete',
        'autofocus',
        'checked',
        'disabled',
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'list',
        'max',
        'maxlength',
        'min',
        'minlength',
        'name',
        'pattern',
        'placeholder',
        'readonly',
        'required',
        'size',
        'src',
        'step',
        'tabindex',
        'type',
        'value',
        'mask',
        'inputmode',
    ];

    /**
     * Input constructor.
     */
    public function __construct()
    {
        $this->addBeforeRender(function () {
            $mask = $this->get('mask');

            if (is_array($mask)) {
                $this->set('mask', json_encode($mask));
            }
        });
    }

    public function datalist(array $datalist = []): self
    {
        if (empty($datalist)) {
            return $this;
        }

        $this->set('datalist', $datalist);

        return $this->addBeforeRender(function () {
            $this->set('list', 'datalist-'.$this->get('name'));
        });
    }
}
