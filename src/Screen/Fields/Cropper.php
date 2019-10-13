<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;
use Orchid\Platform\Dashboard;
use Orchid\Attachment\Models\Attachment;

/**
 * Class Cropper.
 *
 * @method Cropper accept($value = true)
 * @method Cropper accesskey($value = true)
 * @method Cropper autocomplete($value = true)
 * @method Cropper autofocus($value = true)
 * @method Cropper checked($value = true)
 * @method Cropper disabled($value = true)
 * @method Cropper form($value = true)
 * @method Cropper formaction($value = true)
 * @method Cropper formenctype($value = true)
 * @method Cropper formmethod($value = true)
 * @method Cropper formnovalidate($value = true)
 * @method Cropper formtarget($value = true)
 * @method Cropper list($value = true)
 * @method Cropper max(int $value)
 * @method Cropper maxlength(int $value)
 * @method Cropper min(int $value)
 * @method Cropper multiple($value = true)
 * @method Cropper name(string $value = null)
 * @method Cropper pattern($value = true)
 * @method Cropper placeholder(string $value = null)
 * @method Cropper readonly($value = true)
 * @method Cropper required(bool $value = true)
 * @method Cropper size($value = true)
 * @method Cropper src($value = true)
 * @method Cropper step($value = true)
 * @method Cropper tabindex($value = true)
 * @method Cropper type($value = true)
 * @method Cropper value($value = true)
 * @method Cropper help(string $value = null)
 * @method Cropper width($value = true)
 * @method Cropper height($value = true)
 * @method Cropper popover(string $value = null)
 */
class Cropper extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.cropper';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'value'  => null,
        'target' => 'url',
        'url'    => null,
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
        'multiple',
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
        'target',
        'url',
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }

    /**
     * The stored value will be in the form
     * of id attachment.
     *
     * @return self
     */
    public function targetId(): self
    {
        $this->set('target', 'id');

        return $this->addBeforeRender(function () {
            $value = (string) $this->get('value');

            if (! ctype_digit($value)) {
                return;
            }

            /** @var Attachment $attach */
            $attach = Dashboard::model(Attachment::class);

            $url = optional($attach::find($value))->url();

            $this->set('url', $url);
        });
    }

    /**
     * The saved value will be in the form
     * of a full address before the file.
     *
     * @return self
     */
    public function targetUrl(): self
    {
        $this->set('target', 'url');

        return $this;
    }

    /**
     * The saved value will be in the form
     * of a relative address before the file.
     *
     * @return self
     */
    public function targetRelativeUrl(): self
    {
        $this->set('target', 'relativeUrl');

        return $this;
    }
}
