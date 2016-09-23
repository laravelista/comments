<?php namespace Laravelista\Comments\Comments;

use League\Fractal\TransformerAbstract;
use Laravelista\Comments\Comments\Comment;
use Laravelista\Comments\Comments\UserTransformer;

class CommentTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user',
    ];

    public function transform(Comment $comment)
    {
        return [
            'id' => (int) $comment->id,
            'comment' => $comment->comment,
            'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'),
            'user' => $comment->user->id
        ];
    }

    public function includeUser(Comment $comment)
    {
        $user = $comment->user()->first();

        return $this->item($user, new UserTransformer);
    }

}
