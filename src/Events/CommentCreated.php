<?php

namespace Laravelista\Comments\Events;

use Illuminate\Queue\SerializesModels;
use Laravelista\Comments\Entity\Comment;

class CommentCreated
{
    use SerializesModels;

    public $comment;

    /**
     * CommentCreated constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
