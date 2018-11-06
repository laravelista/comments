<?php

namespace Laravelista\Comments\Events;

use Illuminate\Queue\SerializesModels;
use Laravelista\Comments\Entity\Comment;

class CommentUpdated
{
    use SerializesModels;

    public $comment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
