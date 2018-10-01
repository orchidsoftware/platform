<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Orchid\Platform\Dashboard;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Traits\LogsActivityTrait;
use Orchid\Platform\Traits\MultiLanguageTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Term extends Model
{
    use MultiLanguageTrait, LogsActivityTrait;

    /**
     * @var string
     */
    protected $table = 'terms';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'slug',
        'content',
        'term_group',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'content' => 'array',
        'slug'    => 'string',
    ];

    /**
     * @var string
     */
    protected static $logAttributes = ['*'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'slug';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function taxonomy() : HasOne
    {
        return $this->hasOne(Dashboard::model(Taxonomy::class), 'term_id');
    }
}
