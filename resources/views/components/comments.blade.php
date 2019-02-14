@if($model->comments->count() < 1)
    <div class="alert alert-warning">There are no comments yet.</div>
@endif

<ul class="list-unstyled">
    @foreach($model->comments->where('parent', null) as $comment)
        @include('comments::_comment')
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
