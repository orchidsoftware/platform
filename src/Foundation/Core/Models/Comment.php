<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Post relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * Original relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function original()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Replies relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Verify if the current comment is approved.
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->attributes['comment_approved'] == 1;
    }

    /**
     * Verify if the current comment is a reply from another comment.
     *
     * @return bool
     */
    public function isReply()
    {
        return $this->attributes['comment_parent'] > 0;
    }

    /**
     * Verify if the current comment has replies.
     *
     * @return bool
     */
    public function hasReplies()
    {
        return count($this->replies) > 0;
    }

    /**
     * Find a comment by post ID.
     *
     * @param int $postId
     *
     * @return Comment
     */
    public static function findByPostId($postId)
    {
        $instance = new static();

        return $instance->where('comment_post_id', $postId)->get();
    }
}
