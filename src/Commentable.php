<?php

namespace Laravelista\Comments;

use Illuminate\Support\Facades\Config;

/**
 * Add this trait to any model that you want to be able to
 * comment upon or get comments for.
 */
trait Commentable
{
    /**
     * This static method does voodoo magic to
     * delete leftover comments once the commentable
     * model is deleted.
     */
    protected static function bootCommentable()
    {
        static::deleted(function($commentable) {
            foreach ($commentable->comments as $comment) {
                $comment->delete();
            }
        });
    }

    /**
     * Returns all comments for this model.
     */
    public function comments()
    {
        return $this->morphMany(Config::get('comments.model'), 'commentable');
    }

    /**
     * Returns only approved comments for this model.
     */
    public function approvedComments()
    {
        return $this->morphMany(Config::get('comments.model'), 'commentable')->where('approved', true);
    }
}
