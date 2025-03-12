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
 * @method static accept(string $value)
 * @method static required($value = true)
 * @method static multiple($value = true)
 * @method static maxSize(int $value)
 * @method static placeholder(string $value)
 * @method static errorMaxSizeMessage(string $value)
 * @method static errorTypeMessage(string $value)
 * @method static help(string $value = null)
 * @method static title(string $value = null)
 * @method static uploadUrl(string $value = null)
 * @method static sortUrl(string $value = null)
 * @method static path(string $value = null)
 * @method static group(string $value = null)
 */
class Attach extends Field
{
    use Multipliable;

    /**
     * The view that will be used to render the attachment field.
     *
     * @var string
     */
    protected $view = 'platform::fields.attach';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'maxCount'            => 0,
        'maxSize'             => 0, // MB
        'accept'              => '*/*',
        'placeholder'         => 'Upload file',
        'errorMaxSizeMessage' => 'File ":name" is too large to upload',
        'errorTypeMessage'    => 'The attached file must be an image',
        'uploadUrl'           => null,
        'sortUrl'             => null,
        'path'                => null,
        'storage'             => 'public',
        'group'               => null,
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
     * Attach constructor.
     *
     * Set up initial configuration, ensuring file size limits,
     * loading attachment relations, and filtering by group.
     */
    public function __construct()
    {
        // Ensure file size does not exceed server limits
        $this->addBeforeRender(fn () => $this->ensureMaxSizeWithinServerLimits());

        // Load attachment relations if applicable
        $this->addBeforeRender(fn () => $this->loadRelatedAttachments());

        // Filter attachments by the specified group
        $this->addBeforeRender(fn () => $this->filterAttachmentsByGroup());

        // Set the max count to 1 if multiple file uploads are not enabled
        $this->addBeforeRender(function () {
            if (! $this->get('multiple')) {
                $this->set('maxCount', 1);
            }
        });
    }

    /**
     * Set the storage disk and visibility for attachments.
     *
     * @param string $storage
     *
     * @throws \Throwable if the specified storage disk is not found in configuration.
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
     * Ensure the maximum file size is within server limits.
     *
     * This method checks if the specified file size is not greater than the maximum allowed
     * size configured in the server's `php.ini`. If no size is specified, it sets the size to
     * the server's maximum.
     *
     * @throws \Throwable if the desired maximum file size exceeds server settings.
     *
     * @return static
     */
    protected function ensureMaxSizeWithinServerLimits(): static
    {
        $maxFileSize = $this->get('maxFileSize');

        $serverMaxFileSize = Init::maxFileUpload(Init::MB);

        if ($maxFileSize === null) {
            $this->set('maxFileSize', $serverMaxFileSize);

            return $this;
        }

        throw_if(
            $maxFileSize > $serverMaxFileSize,
            'Cannot set the desired maximum file size. This contradicts the settings specified in .ini'
        );

        return $this;
    }

    /**
     * Filter attachments by their group.
     *
     * This method filters the existing attachments by the specified group and
     * updates the field's value to include only attachments that belong to the group.
     *
     * @return static
     */
    protected function filterAttachmentsByGroup(): static
    {
        $group = $this->get('group');

        if ($group === null) {
            return $this;
        }

        $value = collect($this->get('value', []))
            ->where('group', $group)
            ->values();

        return $this->set('value', $value);
    }

    /**
     * Load related attachments based on their IDs.
     *
     * This method fetches related attachments from the database based on their IDs,
     * sorts them by the `sort` field, and updates the field's value with the sorted attachments.
     *
     * @return static
     */
    protected function loadRelatedAttachments(): static
    {
        $value = Arr::wrap($this->get('value'));

        if (! Assert::isIntArray($value)) {
            return $this;
        }

        /** @var Attachment $attach */
        $attach = Dashboard::model(Attachment::class);

        $value = $attach::whereIn('id', $value)
            ->orderBy('sort')
            ->get()
            ->toArray();

        return $this->set('value', $value);
    }
}
