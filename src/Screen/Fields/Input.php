<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Support\HtmlString;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;

/**
 * Class Input.
 *
 * @method $this accept($value = true)
 * @method $this accesskey($value = true)
 * @method $this autocomplete($value = true)
 * @method $this autofocus($value = true)
 * @method $this checked($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this formaction($value = true)
 * @method $this formenctype($value = true)
 * @method $this formmethod($value = true)
 * @method $this formnovalidate($value = true)
 * @method $this formtarget($value = true)
 * @method $this max(int $value)
 * @method $this maxlength(int $value)
 * @method $this min(int $value)
 * @method $this minlength(int $value)
 * @method $this name(string $value = null)
 * @method $this pattern($value = true)
 * @method $this placeholder(string $value = null)
 * @method $this readonly($value = true)
 * @method $this required(bool $value = true)
 * @method $this size($value = true)
 * @method $this src($value = true)
 * @method $this step($value = true)
 * @method $this tabindex($value = true)
 * @method self  type($value = true)
 * @method $this value($value = true)
 * @method Input help(string|HtmlString $value = null)
 * @method $this popover(string $value = null)
 * @method $this mask($value = true)
 * @method $this title(string|HtmlString $value = null)
 * @method $this inputmode(string $value = null)
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

    public function datalist(array $datalist = []): static
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
