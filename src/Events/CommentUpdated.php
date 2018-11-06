<?php

namespace Laravelista\Comments\Events;

use Illuminate\Queue\SerializesModels;
use Laravelista\Comments\Entity\Comment;

class CommentUpdated
{
    use SerializesModels;

    public $comment;

    /**
     * CommentUpdated constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
