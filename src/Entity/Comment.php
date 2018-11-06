<?php

namespace Laravelista\Comments\Entity;

use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Events\CommentCreated;
use Laravelista\Comments\Events\CommentDeleted;
use Laravelista\Comments\Events\CommentUpdated;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['comment'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CommentCreated::class,
        'updated' => CommentUpdated::class,
        'deleted' => CommentDeleted::class,
    ];

    /**
     * The user who posted the comment.
     */
    public function commenter()
    {
        return $this->belongsTo(config('comments.commenter'));
    }

    /**
     * The model that was commented upon.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Returns all comments that this comment is the parent of.
     */
    public function children()
    {
        return $this->hasMany(Comment::class, 'child_id');
    }

    /**
     * Returns the comment to which this comment belongs to.
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'child_id');
    }

    /**
     * @param string $message
     * @return Comment
     */
    public function updateComment(string $message):Comment {
        $this->update([
            'comment' => $message
        ]);

        return $this;
    }

    /**
     * @param $user
     * @param $model
     * @param string $message
     * @param null $parent
     * @return Comment
     */
    public function createComment($user, $model, string $message, $parent = null):Comment {

        $this->commenter()->associate($user);
        $this->commentable()->associate($model);
        if ($parent !== null) {
            $this->parent()->associate($parent);
        }
        $this->comment = $message;
        $this->save();

        return $this;
    }
}
