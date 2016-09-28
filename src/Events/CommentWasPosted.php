<?php namespace Laravelista\Comments\Events;

use Laravelista\Comments\Comments\Comment;

class CommentWasPosted extends Event
{
    public $comment;

    /**
     * Create a new event instance.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
