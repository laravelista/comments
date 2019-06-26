@if($model->comments->count() < 1)
    <div class="alert alert-warning">There are no comments yet.</div>
@endif

<ul class="list-unstyled">
    @php
        if (isset($approved) and $approved == true) {
            $grouped_comments = $model->approvedComments;
        } else {
            $grouped_comments = $model->comments;
        }

        $grouped_comments = $grouped_comments->sortBy('created_at')->groupBy('child_id');
    @endphp
    @foreach($grouped_comments as $comment_id => $comments)
        {{-- Process parent nodes --}}
        @if($comment_id == '')
            @foreach($comments as $comment)
                @include('comments::_comment', [
                    'comment' => $comment,
                    'grouped_comments' => $grouped_comments
                ])
            @endforeach
        @endif
    @endforeach
</ul>

@auth
    @include('comments::_form')
@else
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Authentication required</h5>
            <p class="card-text">You must log in to post a comment.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
        </div>
    </div>
@endauth
