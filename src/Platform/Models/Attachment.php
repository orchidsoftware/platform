<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

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
    public function user() : BelongsTo
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
    public function url($size = '', $prefix = 'public') : string
    {
        if (! empty($size)) {
            $size = '_'.$size;

            if (! Storage::disk($prefix)->exists($this->path.$this->name.$size.'.'.$this->extension)) {
                return $this->url(null, $prefix);
            }
        }

        return Storage::disk($prefix)->url($this->path.$this->name.$size.'.'.$this->extension);
    }

    /**
     * @param string $storage
     *
     * @throws \Exception
     *
     * @return bool|null
     */
    public function delete($storage = 'public')
    {
        if ($this->exists) {
            if (self::where('hash', $this->hash)->count() <= 1) {
                $this->removePhysicalFile($this, $storage);
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
}
