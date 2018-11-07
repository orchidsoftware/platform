<?php

declare(strict_types=1);

namespace Orchid\Attachment\Models;

use Mimey\MimeTypes;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Attachment.
 */
class Attachment extends Model
{
    use LogsActivity;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'original_name',
        'mime',
        'extension',
        'size',
        'path',
        'user_id',
        'post_id',
        'description',
        'alt',
        'hash',
        'disk',
        'group',
    ];

    /**
     * @var string
     */
    protected static $logAttributes = ['*'];

    /**
     * @var array
     */
    protected $appends = [
        'url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return the address by which you can access the file.
     *
     * @param string $size
     *
     * @return string
     */
    public function url($size = ''): string
    {
        $disk = $this->getAttribute('disk');

        if (! empty($size)) {
            $size = '_'.$size;

            if (! Storage::disk($disk)->exists($this->physicalPath())) {
                return $this->url(null);
            }
        }

        return Storage::disk($disk)->url($this->path.$this->name.$size.'.'.$this->extension);
    }

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->url();
    }

    /**
     * @return string
     */
    public function physicalPath(): string
    {
        return $this->path.$this->name.'.'.$this->extension;
    }

    /**
     * Get the contents of a file.
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function read(): string
    {
        return Storage::disk($this->getAttribute('disk'))->get($this->physicalPath());
    }

    /**
     * @param null $width
     * @param null $height
     * @param int $quality
     *
     * @return \Intervention\Image\Image
     */
    public function getSizeImage($width = null, $height = null, $quality = 100)
    {
        return Image::cache(function ($image) use ($width, $height, $quality) {
            $image->make(static::read())->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode(static::getAttribute('extension'), $quality);
        }, 10, true);
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        if ($this->exists) {
            if (self::where('hash', $this->hash)->where('disk', $this->disk)->count() <= 1) {
                $this->removePhysicalFile($this, $this->getAttribute('disk'));
            }
            $this->relationships()->delete();
        }

        return parent::delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationships()
    {
        return $this->hasMany(Dashboard::model(Attachmentable::class), 'attachment_id');
    }

    /**
     * Physical removal of all copies of a file.
     *
     * @param self $attachment
     * @param string $storageName
     */
    private function removePhysicalFile(self $attachment, string $storageName)
    {
        $storage = Storage::disk($storageName);

        $storage->delete($this->physicalPath());

        if (strpos($this->mime, 'image') !== 0) {
            return;
        }

        foreach (array_keys(config('platform.images', [])) as $format) {
            $storage->delete($attachment->path.$attachment->name.'_'.$format.'.'.$attachment->extension);
        }
    }

    /**
     * Get MIME type for file.
     *
     * @return string
     */
    public function getMimeType(): string
    {
        $mimes = new MimeTypes();

        $type = $mimes->getMimeType($this->getAttribute('extension'));

        return $type ?? 'unknown';
    }
}
