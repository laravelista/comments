<?php

namespace Laravelista\Comments;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->publishes([
            __DIR__ . '/../config/comments.php' => config_path('comments.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'comments');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/comments'),
        ], 'views');

        Blade::component('comments::components.comments', 'comments');

        // if the current user is the user that posted the comment
        // then the current user can delete the comment.
        Gate::define('delete-comment', function ($user, $comment) {
            return $user->id == $comment->commenter_id;
        });

        // if the current user is the user that posted the comment
        // then the current user can edit the comment.
        Gate::define('edit-comment', function ($user, $comment) {
            return $user->id == $comment->commenter_id;
        });

        // The user can only reply to other peoples comments and
        // not to his own comments.
        Gate::define('reply-to-comment', function ($user, $comment) {
            return $user->id != $comment->commenter_id;
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/comments.php',
            'comments'
        );
    }
}