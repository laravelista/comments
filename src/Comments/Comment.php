<?php namespace Laravelista\Comments\Comments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Comment extends Model
{
    protected $fillable = ['comment'];

    public function user()
    {
        return $this->belongsTo(config('comments.user_model'));
    }

    public function content()
    {
        return $this->morphTo()->withTimestamps();
    }

    /**
     * Gets users who commented on content,
     * except the user of this comment.
     *
     * Useful for notifying users about a new comment.
     *
     * @return Collection
     */
    public function getUsersWhoCommented()
    {
        $content_id = $this->content->id;
        $content_type = $this->content()->first()->getMorphClass();
        $user_id = $this->user->id;

        return $this
            ->where('content_id', $content_id)
            ->where('content_type', $content_type)
            ->where('user_id', '!=', $user_id)
            ->get()
            ->pluck('user')
            ->unique();
    }
}
