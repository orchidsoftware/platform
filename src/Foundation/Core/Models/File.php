<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    /**
     * @var string
     */
    protected $table = 'files';

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @param string $size
     * @param string $prefix
     * @return string
     */
    public function url($size = '', $prefix = 'public')
    {
        if (! empty($size)) {
            $size = '_'.$size;

            if (! Storage::disk($prefix)->exists(
                $this->path.
                $this->name.
                $size.
                '.'.
                $this->extension
            )) {
                return $this->url(null, $prefix);
            }
        }

        return Storage::disk($prefix)->url(
            $this->path.
            $this->name.
            $size.
            '.'.
            $this->extension
        );
    }
}
