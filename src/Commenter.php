<?php

namespace Laravelista\Comments;

use Illuminate\Support\Facades\Config;

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
        return $this->morphMany(Config::get('comments.model'), 'commenter');
    }

    /**
     * Returns only approved comments that this user has made.
     */
    public function approvedComments()
    {
        return $this->morphMany(Config::get('comments.model'), 'commenter')->where('approved', true);
    }
}
