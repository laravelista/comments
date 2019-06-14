<?php

return [
    // The model which creates the comments aka the User model
    'commenter' => \App\User::class,

    'model' => \Laravelista\Comments\Comment::class,

    'permissions' => [
        'create-comment' => 'Laravelista\Comments\CommentPolicy@create',
        'delete-comment' => 'Laravelista\Comments\CommentPolicy@delete',
        'edit-comment' => 'Laravelista\Comments\CommentPolicy@update',
        'reply-to-comment' => 'Laravelista\Comments\CommentPolicy@reply',
    ]
];
