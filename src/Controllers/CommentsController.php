<?php

namespace Laravelista\Comments\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravelista\Comments\Entity\Comment;

class CommentsController extends Controller
{
    use ValidatesRequests, AuthorizesRequests;

    public function __construct()
    {
        $this->middleware(['web', 'auth']);
    }

    /**
     * Creates a new comment for given model.
     */
    public function store(Request $request, Comment $comment)
    {
        $this->validate($request, [
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer|min:1',
            'message' => 'required|string'
        ]);

        $model = $request->commentable_type::findOrFail($request->commentable_id);
        $comment = $comment->createComment(auth()->user(), $model, $request->message);

        return redirect()->to(url()->previous() . '#comment-' . $comment->id);
    }

    /**
     * Updates the message of the comment.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('edit-comment', $comment);

        $this->validate($request, [
            'message' => 'required|string'
        ]);

        $comment->updateComment($request->message);

        return redirect()->to(url()->previous() . '#comment-' . $comment->id);
    }

    /**
     * Deletes a comment.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete-comment', $comment);

        $comment->delete();

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param Comment $comment
     * @return mixed
     */
    public function reply(Request $request, Comment $comment)
    {
        $this->authorize('reply-to-comment', $comment);

        $this->validate($request, [
            'message' => 'required|string'
        ]);

        $reply = (new Comment)->createComment(auth()->user(), $comment->commentable, $request->message, $comment);

        return redirect()->to(url()->previous() . '#comment-' . $reply->id);
    }
}
