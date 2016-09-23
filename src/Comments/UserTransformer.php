<?php namespace Laravelista\Comments\Comments;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform($user)
    {
        return [
            'id' => (int) $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];
    }

}
