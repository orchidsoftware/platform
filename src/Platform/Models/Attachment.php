<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Mimey\MimeTypes;
use Orchid\Platform\Dashboard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
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
    ];

    /**
     * Attachment constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

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
     * @param string $prefix
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
    public function physicalPath() : string
    {
        return $this->path.$this->name.'.'.$this->extension;
    }

    /**
     * @return bool|null
     */
    public function delete()
    {
        if ($this->exists) {
            if (self::where('hash', $this->hash)->count() <= 1) {
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
     * @param self   $attachment
     * @param string $storageName
     */
    private function removePhysicalFile(self $attachment, $storageName)
    {
        $storage = Storage::disk($storageName);

        $storage->delete($attachment->path.$attachment->name.'.'.$attachment->extension);

        if (substr($this->mime, 0, 5) !== 'image') {
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
    public function getMimeType() : string
    {
        $mimes = new MimeTypes();

        $type = $mimes->getMimeType(static::getAttribute('extension'));

        if (is_null($type)) {
            return 'unknown';
        }

        return $type;
    }
}
