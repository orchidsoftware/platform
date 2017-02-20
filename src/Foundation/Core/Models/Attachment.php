<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
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
     * Attachment types
     * @var array
     */
    protected $types = [
        'image' => [
            'png',
            'jpg',
            'jpeg',
            'gif',
        ],
        'video' => [
            'mp4',
            'mkv',
        ],
        'docs' =>[
            'doc',
            'docx',
            'pdf',
            'xls',
            'xlsx',
            'xml',
            'txt',
            'zip',
            'rar',
            'svg',
        ]
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
     * @param $type
     * @return $this
     */
    public function whereType($type){

        if(key_exists($type,$this->types)) {
            return $this->whereIn('extension',$this->types[$type]);
        }
        return $this;
    }

    /**
     * @param string $size
     * @param string $prefix
     *
     * @return string
     */
    public function url($size = '', $prefix = 'public')
    {
        if (!empty($size)) {
            $size = '_'.$size;

            if (!Storage::disk($prefix)->exists(
                $this->path.
                $this->name.
                $size.
                '.'.
                $this->extension
            )
            ) {
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
