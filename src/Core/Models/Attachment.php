<?php

namespace Orchid\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    /**
     * The relationships entities model.
     *
     * @var string
     */
    protected static $relationshipsModel = 'Orchid\Core\Models\AttachmentRelationships';

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
    ];

    /**
     * Attachment constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->types = config('content.attachment', []);
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
     * Returns the polymorphic relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachmentRelationships()
    {
        return $this->morphTo();
    }

    /**
     * Relation Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @param $type
     *
     * @return Attachment
     */
    public function type($type): Attachment
    {
        if (array_key_exists($type, $this->types)) {
            return $this->whereIn('extension', $this->types[$type]);
        }

        return $this;
    }

    /**
     * Return the address by which you can access the file
     *
     * @param string $size
     * @param string $prefix
     *
     * @return string
     */
    public function url($size = '', $prefix = 'public'): string
    {
        if (!empty($size)) {
            $size = '_' . $size;

            if (!Storage::disk($prefix)->exists(
                $this->path .
                $this->name .
                $size .
                '.' .
                $this->extension
            )
            ) {
                return $this->url(null, $prefix);
            }
        }

        return Storage::disk($prefix)->url(
            $this->path .
            $this->name .
            $size .
            '.' .
            $this->extension
        );
    }

    /**
     * @return bool|null
     */
    public function delete()
    {
        if ($this->exists) {
            $this->relationships()->delete();
        }

        $this->removePhysicalFile($this);

        return parent::delete();
    }

    /**
     * Returns this tag tagged entities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationships()
    {
        return $this->hasMany(static::$relationshipsModel, 'attachment_id');
    }

    /**
     * Physical removal of all copies of a file
     *
     * @param Attachment $attachment
     */
    private function removePhysicalFile(Attachment $attachment)
    {
        $storage = Storage::disk('public');

        $storage->delete($attachment->path . $attachment->name . '.' . $attachment->extension);

        foreach (array_keys(config('content.images', [])) as $format) {
            $storage->delete($attachment->path . $attachment->name . '_' . $format . '.' . $attachment->extension);
        }
    }
}
