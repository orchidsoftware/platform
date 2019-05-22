<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;
use Orchid\Platform\Dashboard;
use Orchid\Attachment\Models\Attachment;

/**
 * Class Picture.
 *
 * @method self name(string $value = null)
 * @method self required(bool $value = true)
 * @method self size($value = true)
 * @method self src($value = true)
 * @method self type($value = true)
 * @method self value($value = true)
 * @method self help(string $value = null)
 * @method self popover(string $value = null)
 */
class Picture extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.picture';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'value'  => null,
        'target' => 'url',
        'url'    => null,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
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

        $this->addBeforeRender(function () {
            $value = (string) $this->get('value');

            if (! ctype_digit($value)) {
                return;
            }

            /** @var Attachment $attach */
            $attach = Dashboard::model(Attachment::class);

            $url = optional($attach::find($value))->url();

            $this->set('url', $url);
        });

        return $this;
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
