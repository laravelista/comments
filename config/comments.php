<?php

return [

    /**
     * To extend the base Comment model one just needs to create a new
     * CustomComment model extending the Comment model shipped with the
     * package and change this configuration option to their extended model.
     */
    'model' => \Laravelista\Comments\Comment::class,

    /**
     * You can customize the behaviour of these permissions by
     * creating your own and pointing to it here.
     */
    'permissions' => [
        'create-comment' => 'Laravelista\Comments\CommentPolicy@create',
        'delete-comment' => 'Laravelista\Comments\CommentPolicy@delete',
        'edit-comment' => 'Laravelista\Comments\CommentPolicy@update',
        'reply-to-comment' => 'Laravelista\Comments\CommentPolicy@reply',
    ],

    /**
     * The Comment Controller.
     * Change this to your own implementation of the CommentController.
     * You can use the \Laravelista\Comments\CommentControllerInterface.
     */
    'controller' => '\Laravelista\Comments\CommentController',

    /**
     * Disable/enable the package routes.
     * If you want to completely take over the way this package handles
     * routes and controller logic, set this to false and provide your
     * own routes and controller for comments.
     */
    'routes' => true,

    /**
     * By default comments posted are marked as approved. If you want
     * to change this, set this option to true. Then, all comments
     * will need to be approved by setting the `approved` column to
     * `true` for each comment.
     *
     * To see only approved comments use this code in your view:
     *
     *     @comments([
     *         'model' => $book,
     *         'approved' => true
     *     ])
     *
     */
    'approval_required' => false,

    /**
     * Set this option to `true` to enable guest commenting.
     *
     * Visitors will be asked to provide their name and email
     * address in order to post a comment.
     */
    'guest_commenting' => false,

	/**
     * Set this option to `true` to enable soft deleting of comments.
     *
     * Comments will be soft deleted using laravels "softDeletes" trait.
     */
    'soft_deletes' => false

];
