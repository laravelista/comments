<div class="card">
    <div class="card-body">
        @if($errors->has('commentable_type'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('commentable_type') }}
            </div>
        @endif
        @if($errors->has('commentable_id'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('commentable_id') }}
            </div>
        @endif
        <form method="POST" action="{{ route('comments.store') }}">
            @csrf
            @honeypot
            <input type="hidden" name="commentable_type" value="\{{ get_class($model) }}" />
            <input type="hidden" name="commentable_id" value="{{ $model->getKey() }}" />

            {{-- Guest commenting --}}
            @if(isset($guest_commenting) and $guest_commenting == true)
                <div class="form-group">
                    <label for="message">Enter your name here:</label>
                    <input type="text" class="form-control @if($errors->has('guest_name')) is-invalid @endif" name="guest_name" />
                    @error('guest_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="message">Enter your email here:</label>
                    <input type="email" class="form-control @if($errors->has('guest_email')) is-invalid @endif" name="guest_email" />
                    @error('guest_email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif

            <div class="form-group">
                <label for="message">Enter your message here:</label>
                <textarea class="form-control @if($errors->has('message')) is-invalid @endif" name="message" rows="3"></textarea>
                <div class="invalid-feedback">
                    Your message is required.
                </div>
                <small class="form-text text-muted"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a> cheatsheet.</small>
            </div>
            <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">Submit</button>
        </form>
    </div>
</div>
<br />