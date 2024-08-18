<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Support\Arr;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Dashboard;
use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;
use Orchid\Support\Assert;
use Orchid\Support\Init;

/**
 * Class Attach.
 *
 * @method Attach accept(string $value)
 * @method Attach required($value = true)
 * @method Attach multiple($value = true)
 * @method Attach maxSize(int $value)
 * @method Attach placeholder(string $value)
 * @method Attach errorMaxSizeMessage(string $value)
 * @method Attach errorTypeMessage(string $value)
 * @method Attach help(string $value = null)
 * @method Attach title(string $value = null)
 * @method Attach uploadUrl(string $value = null)
 * @method Attach sortUrl(string $value = null)
 * @method Attach path(string $value = null)
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
        'uploadUrl'           => null,
        'sortUrl'             => null,
        'path'                => null,
        'storage'             => 'public',
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

        // if is not multiple, then set maxCount to 1
        $this->addBeforeRender(function () {
            if (! $this->get('multiple')) {
                $this->set('maxCount', 1);
            }
        });
    }

    /**
     * @throws \Throwable
     *
     * @return $this
     */
    public function storage(string $storage): self
    {
        $disk = config('filesystems.disks.'.$storage);

        throw_if($disk === null, 'The selected storage was not found');

        return $this
            ->set('storage', $storage)
            ->set('visibility', $disk['visibility'] ?? null);
    }
}
