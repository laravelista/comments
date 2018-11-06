<?php

namespace Laravelista\Comments\Events;

use Illuminate\Queue\SerializesModels;
use Laravelista\Comments\Entity\Comment;

class CommentDeleted
{
    use SerializesModels;

    public $comment;

    /**
     * CommentDeleted constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
