<?php namespace Laravelista\Comments\Comments;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment'];

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function content()
    {
        return $this->morphTo()->withTimestamps();
    }
}
