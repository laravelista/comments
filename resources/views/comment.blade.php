@inject('markdown', 'Parsedown')

@if(isset($reply) && $reply === true)
  <div id="comment-{{ $comment->id }}-{{ str_replace('\\', '-', get_class($model)) }}" class="media">
@else
  <li id="comment-{{ $comment->id }}-{{ str_replace('\\', '-', get_class($model)) }}" class="media">
@endif
    <img class="mr-3" src="https://www.gravatar.com/avatar/{{ md5($comment->commenter->email) }}.jpg?s=64" alt="{{ $comment->commenter->name }} Avatar">
    <div class="media-body">
        <h5 class="mt-0 mb-1">{{ $comment->commenter->name }} <small class="text-muted">- {{ $comment->created_at->diffForHumans() }}</small></h5>
        <div style="white-space: pre-wrap;">{!! $markdown->line($comment->comment) !!}</div>

        <p>
            {{-- <a href="#" class="btn btn-sm btn-link text-uppercase">Reply</a>
            <button class="btn btn-sm btn-link text-uppercase comments-edit-button">Edit</button> --}}
            @can('delete-comment', $comment)
                <a href="{{ url('comments/' . $comment->id) }}" onclick="event.preventDefault();document.getElementById('comment-delete-form-{{ $comment->id }}-{{ str_replace('\\', '-', get_class($model)) }}').submit();" class="btn btn-sm btn-link text-danger text-uppercase">Delete</a>
                <form id="comment-delete-form-{{ $comment->id }}-{{ str_replace('\\', '-', get_class($model)) }}" action="{{ url('comments/' . $comment->id) }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            @endcan
        </p>

        {{-- @include('comments::form', [
            'hidden' => true
        ]) --}}

        @foreach($comment->children as $child)
            @include('comments::comment', [
                'comment' => $child,
                'reply' => true
            ])
        @endforeach


    </div>
@if(isset($reply) && $reply === true)
  </div>
@else
  </li>
@endif