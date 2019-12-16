<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Dashboard;
use Orchid\Screen\Field;

/**
 * Class Picture.
 *
 * @method Picture name(string $value = null)
 * @method Picture required(bool $value = true)
 * @method Picture size($value = true)
 * @method Picture src($value = true)
 * @method Picture type($value = true)
 * @method Picture value($value = true)
 * @method Picture help(string $value = null)
 * @method Picture popover(string $value = null)
 * @method Picture title(string $value = null)
 */
class Picture extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.picture';

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
