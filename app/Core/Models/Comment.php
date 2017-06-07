<?php

namespace Orchid\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Core\Builders\CommentBuilder;

class Comment extends Model
{
    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * @var array
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'approved',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'post_id'   => 'integer',
        'user_id'   => 'integer',
        'parent_id' => 'integer',
        'approved'  => 'boolean',
    ];

    /**
     * Find a comment by post ID.
     *
     * @param int $postId
     *
     * @return Comment
     */
    public static function findByPostId($postId): Comment
    {
        $instance = new static();

        return $instance->where('post_id', $postId)->get();
    }

    /**
     * Post relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * Original relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function original(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Replies relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Verify if the current comment is approved.
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->attributes['approved'] == 1;
    }

    /**
     * Verify if the current comment is a reply from another comment.
     *
     * @return bool
     */
    public function isReply(): bool
    {
        return $this->attributes['parent_id'] > 0;
    }

    /**
     * Verify if the current comment has replies.
     *
     * @return bool
     */
    public function hasReplies(): bool
    {
        return count($this->replies) > 0;
    }

    /**
     *   Author relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Override the parent newQuery() to the custom CommentBuilder class.
     *
     * @param bool $excludeDeleted
     *
     * @return CommentBuilder
     */
    public function newQuery($excludeDeleted = true): CommentBuilder
    {
        $builder = new CommentBuilder($this->newBaseQueryBuilder());
        $builder->setModel($this)->with($this->with);
        if ($excludeDeleted && $this->softDelete) {
            $builder->whereNull($this->getQualifiedDeletedAtColumn());
        }

        return $builder;
    }
}
