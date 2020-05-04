<?php

namespace Laravelista\Comments;

use Laravelista\Comments\Comment;

class CommentPolicy
{
    /**
     * Can user create the comment
     *
     * @param $user
     * @return bool
     */
    public function create($user) : bool
    {
        return true;
    }

    /**
     * Can user delete the comment
     *
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function delete($user, Comment $comment) : bool
    {
        return $user->getKey() == $comment->commenter_id;
    }

    /**
     * Can user update the comment
     *
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function update($user, Comment $comment) : bool
    {
        return $user->getKey() == $comment->commenter_id;
    }

    /**
     * Can user reply to the comment
     *
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function reply($user, Comment $comment) : bool
    {
        return $user->getKey() != $comment->commenter_id;
    }
}

