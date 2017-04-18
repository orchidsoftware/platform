<?php

namespace Orchid\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Orchid\Facades\Dashboard;

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
    public function user() : BelongsTo
    {
        return $this->belongsTo(Dashboard::model('user', User::class));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post() : BelongsTo
    {
        return $this->belongsTo(Dashboard::model('post', Post::class));
    }

    /**
     * @param $type
     *
     * @return Attachment
     */
    public function type($type) : Attachment
    {
        if (array_key_exists($type, $this->types)) {
            return $this->whereIn('extension', $this->types[$type]);
        }

        return $this;
    }

    /**
     * @param string $size
     * @param string $prefix
     *
     * @return string
     */
    public function url($size = '', $prefix = 'public') : string
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
}
