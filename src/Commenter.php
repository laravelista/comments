<?php

namespace Laravelista\Comments;

/**
 * Add this trait to your User model so
 * that you can retrieve the comments for a user.
 */
trait Commenter
{
    /**
     * Returns all comments that this user has made.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'commenter_id');
    }
}
