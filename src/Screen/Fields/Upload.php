<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Support\Arr;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Dashboard;
use Orchid\Screen\Field;
use Orchid\Support\Assert;
use Orchid\Support\Init;

/**
 * Class Upload.
 *
 * @method static form($value = true)
 * @method static formaction($value = true)
 * @method static formenctype($value = true)
 * @method static formmethod($value = true)
 * @method static formnovalidate($value = true)
 * @method static formtarget($value = true)
 * @method static name(string $value = null)
 * @method static placeholder(string $value = null)
 * @method static value($value = true)
 * @method static help(string $value = null)
 * @method static parallelUploads($value = true)
 * @method static maxFileSize($value = true)
 * @method static maxFiles($value = true)
 * @method static timeOut(int $second = null)
 * @method static acceptedFiles($value = true)
 * @method static resizeQuality($value = true)
 * @method static resizeWidth($value = true)
 * @method static resizeHeight($value = true)
 * @method static popover(string $value = null)
 * @method static groups($value = true)
 * @method static media($value = true)
 * @method static closeOnAdd($value = true)
 * @method static title(string $value = null)
 */
class Upload extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.upload';

    /**
     * All attributes that are available to the field.
     *
     * @var array
     */
    protected $attributes = [
        'value'           => null,
        'multiple'        => true,
        'parallelUploads' => 10,
        'maxFileSize'     => null,
        'maxFiles'        => 9999,
        'timeOut'         => 0,
        'acceptedFiles'   => null,
        'resizeQuality'   => 0.8,
        'resizeWidth'     => null,
        'resizeHeight'    => null,
        'media'           => false,
        'closeOnAdd'      => false,
        'visibility'      => 'public',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accept',
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'name',
        'multiple',
        'placeholder',
        'required',
        'groups',
        'storage',
        'media',
        'closeOnAdd',
        'path',
    ];

    /**
     * Upload constructor.
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
                'Cannot set the desired maximum file size. This contradicts the settings specified in .ini'
            );
        });

        // set load relation attachment
        $this->addBeforeRender(function () {
            $value = Arr::wrap($this->get('value'));

            if (! Assert::isIntArray($value)) {
                return;
            }

            /** @var Attachment $attach */
            $attach = Dashboard::model(Attachment::class);

            $value = $attach::whereIn('id', $value)->orderBy('sort')->get()->toArray();

            $this->set('value', $value);
        });

        // Division into groups
        $this->addBeforeRender(function () {
            $group = $this->get('groups');

            if ($group === null) {
                return;
            }

            $value = collect($this->get('value', []))
                ->where('group', $group)
                ->toArray();

            $this->set('value', $value);
        });
    }

    /**
     * @param string $storage
     *
     * @return static
     */
    public function storage(string $storage): static
    {
        $disk = config('filesystems.disks.'.$storage);

        throw_if($disk === null, 'The selected storage was not found');

        return $this
            ->set('storage', $storage)
            ->set('visibility', $disk['visibility'] ?? null);
    }

    /**
     * Set custom attachment upload path
     */
    public function path(string $path): static
    {
        return $this->set('path', $path);
    }
}
