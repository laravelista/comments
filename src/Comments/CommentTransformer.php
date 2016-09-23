<?php namespace Laravelista\Comments\Comments;

use League\Fractal\TransformerAbstract;
use Laravelista\Comments\Comments\Comment;

class CommentTransformer extends TransformerAbstract
{

    public function transform(Comment $comment)
    {
        return [
            'id' => (int) $comment->id,
            'comment' => $comment->comment,
            'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'),
            'user_id' => $comment->user->id
        ];
    }

}
