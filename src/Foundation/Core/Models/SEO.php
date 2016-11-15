<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Foundation\Services\SEO\SeoTrait;
use Route;

class SEO extends Model
{
    use SeoTrait;

    /**
     * @var string
     */
    protected $table = 'seo';

    /**
     * @var array
     */
    protected $fillable = [
        'story_id',
        'url',
        'route',
        'title',
        'description',
        'keywords',
        'robots',
        'image',
        'video',
        'audio',
        'custom',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'custom' => 'array',
        'image' => 'array',
    ];
}
