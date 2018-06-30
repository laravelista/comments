<?php

namespace Laravelista\Comments;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentsController extends Controller
{
    use ValidatesRequests, AuthorizesRequests;

    public function __construct()
    {
        $this->middleware(['web', 'auth']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer|min:1',
            'comment' => 'required|string'
        ]);

        $model = $request->commentable_type::findOrFail($request->commentable_id);

        $comment = new Comment;
        $comment->commenter()->associate(auth()->user());
        $comment->commentable()->associate($model);
        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->back();
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete-comment', $comment);

        $comment->delete();

        return redirect()->back();
    }
}
