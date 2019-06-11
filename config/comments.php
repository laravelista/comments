<?php

return [
    'permissions' => [
        'create-comment' => 'Laravelista\Comments\CommentPolicy@create',
        'delete-comment' => 'Laravelista\Comments\CommentPolicy@delete',
        'edit-comment' => 'Laravelista\Comments\CommentPolicy@update',
        'reply-to-comment' => 'Laravelista\Comments\CommentPolicy@reply',
    ]
];
