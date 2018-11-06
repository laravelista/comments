<?php

namespace Laravelista\Comments\Policies;

use Laravelista\Comments\Entity\Comment;

class CommentPolicy
{
    /**
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function delete($user, Comment $comment):bool
    {
        return $user->id === $comment->commenter_id && \count($comment->children) === 0;
    }

    /**
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function update($user, Comment $comment):bool
    {
        return $user->id === $comment->commenter_id;
    }
    /**
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function reply($user, Comment $comment):bool
    {
        dd(1);
        return $user->id !== $comment->commenter_id;
    }
}