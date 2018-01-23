<?php

namespace Orchid\Platform\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    /**
     * Attachment types.
     *
     * @var array
     */
    public $types = [];

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
        $this->types = config('platform.attachment', []);
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
     * Relation Post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function post() : \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        //TODO: сделать
        return $this->morphToMany(self::class, 'attachmentable', 'attachmentable', 'attachmentable_id',
            'attachment_id');
    }

    /**
     * @param $type
     *
     * @return Attachment
     */
    public function type($type) : self
    {
        if (array_key_exists($type, $this->types)) {
            return $this->whereIn('extension', $this->types[$type]);
        }

        return $this;
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
     * @return bool|null
     * @throws \Exception
     */
    public function delete($storage = 'public')
    {
        if ($this->exists) {
            $this->relationships()->delete();
        }

        $this->removePhysicalFile($this, $storage);

        return parent::delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationships()
    {
        return $this->hasMany(Attachmentable::class, 'attachment_id');
    }

    /**
     * Physical removal of all copies of a file.
     *
     * @param Attachment $attachment
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
