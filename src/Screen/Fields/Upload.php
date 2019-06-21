<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;
use Orchid\Support\Assert;
use Illuminate\Support\Arr;
use Orchid\Platform\Dashboard;
use Orchid\Attachment\Models\Attachment;

/**
 * Class Upload.
 *
 * @method self accept($value = true)
 * @method self accesskey($value = true)
 * @method self autocomplete($value = true)
 * @method self autofocus($value = true)
 * @method self checked($value = true)
 * @method self disabled($value = true)
 * @method self form($value = true)
 * @method self formaction($value = true)
 * @method self formenctype($value = true)
 * @method self formmethod($value = true)
 * @method self formnovalidate($value = true)
 * @method self formtarget($value = true)
 * @method self list($value = true)
 * @method self max(int $value)
 * @method self maxlength(int $value)
 * @method self min(int $value)
 * @method self multiple($value = true)
 * @method self name(string $value = null)
 * @method self pattern($value = true)
 * @method self placeholder(string $value = null)
 * @method self readonly($value = true)
 * @method self required(bool $value = true)
 * @method self size($value = true)
 * @method self src($value = true)
 * @method self step($value = true)
 * @method self tabindex($value = true)
 * @method self type($value = true)
 * @method self value($value = true)
 * @method self help(string $value = null)
 * @method self storage($value = true)
 * @method self parallelUploads($value = true)
 * @method self maxFileSize($value = true)
 * @method self maxFiles($value = true)
 * @method self acceptedFiles($value = true)
 * @method self resizeQuality($value = true)
 * @method self resizeWidth($value = true)
 * @method self resizeHeight($value = true)
 * @method self popover(string $value = null)
 * @method self groups($value = true)
 * @method self media($value = true)
 * @method self closeOnAdd($value = true)
 */
class Upload extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.upload';

    /**
     * All attributes that are available to the field.
     *
     * @var array
     */
    public $attributes = [
        'value'           => null,
        'multiple'        => true,
        'parallelUploads' => 10,
        'maxFileSize'     => 9999,
        'maxFiles'        => 9999,
        'acceptedFiles'   => null,
        'resizeQuality'   => 0.8,
        'resizeWidth'     => null,
        'resizeHeight'    => null,
        'media'           => false,
        'closeOnAdd'      => false
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
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
        'groups',
        'storage',
        'media',
        'closeOnAdd'
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
     * Upload constructor.
     */
    public function __construct()
    {
        $this->addBeforeRender(function () {
            $value = Arr::wrap($this->get('value'));

            if (! Assert::isIntArray($value)) {
                return;
            }

            /** @var Attachment $attach */
            $attach = Dashboard::model(Attachment::class);

            $value = $attach::whereIn('id', $value)->get()->toArray();

            $this->set('value', $value);
        });
    }
}
