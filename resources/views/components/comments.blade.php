@php
    if (isset($approved) and $approved == true) {
        $comments = $model->approvedComments;
    } else {
        $comments = $model->comments;
    }
@endphp

@if($comments->count() < 1)
    <div class="alert alert-warning">There are no comments yet.</div>
@endif

<ul class="list-unstyled">
    @php
        $comments = $comments->sortBy('created_at');

        if (isset($perPage)) {
            $page = request()->query('page', 1) - 1;

            $grouped_comments = new \Illuminate\Pagination\LengthAwarePaginator(
                $comments->slice($page * $perPage, $perPage)->groupBy('child_id'),
                $comments->count(),
                $perPage
            );

            $grouped_comments->withPath(request()->path());
        } else {
            $grouped_comments = $comments->groupBy('child_id');
        }
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

@isset ($perPage)
    {{ $grouped_comments->links() }}
@endisset

@auth
    @include('comments::_form')
@elseif(config('comments.guest_commenting') == true)
    @include('comments::_form', [
        'guest_commenting' => true
    ])
@else
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Authentication required</h5>
            <p class="card-text">You must log in to post a comment.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
        </div>
    </div>
@endauth
