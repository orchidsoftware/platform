<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Field;
use Orchid\Support\Facades\Dashboard;
use Orchid\Support\Init;

/**
 * Class Picture.
 *
 * @method $this acceptedFiles(string $value = null)
 * @method $this name(string $value = null)
 * @method $this required(bool $value = true)
 * @method $this size($value = true)
 * @method $this src($value = true)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this title(string $value = null)
 * @method $this maxFileSize($value = true)
 * @method $this storage($value = null)
 * @method $this groups($value = true)
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
        'value'          => null,
        'target'         => 'url',
        'url'            => null,
        'maxFileSize'    => null,
        'acceptedFiles'  => 'image/*',
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
        'placeholder',
        'readonly',
        'required',
        'tabindex',
        'value',
        'target',
        'url',
        'groups',
        'path',
    ];

    /**
     * Picture constructor.
     */
    public function __construct()
    {
        // Set max file size
        $this->addBeforeRender(function () {
            $maxFileSize = $this->get('maxFileSize');

            $serverMaxFileSize = Init::maxFileUpload(Init::MB);

            if ($maxFileSize === null) {
                $this->set('maxFileSize', $serverMaxFileSize);

                return;
            }

            throw_if(
                $maxFileSize > $serverMaxFileSize,
                'Cannot set the desired maximum file size. This contradicts the settings specified in .ini');
        });
    }

    /**
     * The stored value will be in the form
     * of id attachment.
     */
    public function targetId(): static
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
     */
    public function targetUrl(): static
    {
        $this->set('target', 'url');

        return $this;
    }

    /**
     * The saved value will be in the form
     * of a relative address before the file.
     */
    public function targetRelativeUrl(): static
    {
        $this->set('target', 'relativeUrl');

        return $this;
    }

    /**
     * Set custom attachment upload path
     */
    public function path(string $path): static
    {
        return $this->set('path', $path);
    }
}
