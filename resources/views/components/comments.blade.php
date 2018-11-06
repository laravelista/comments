@php
    $count = $model->comments()->parentless()->count();
    $comments = $model->comments()->parentless()->get();
@endphp
@if($count < 1)
    <p class="lead">There are no comments yet.</p>
@endif
<ul class="list-unstyled">
    @foreach($comments as $comment)
        @include('comments::_comment')
    @endforeach
</ul>
@auth
    @include('comments::_form')
@else
    @include('comments::_login-message')
@endauth