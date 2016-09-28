<div id="laravelista-comments"></div>

<script>
window.Laravelista = {
    // Eg. App\Post::class || App\\Post
    content_type: "{{ str_replace('\\', '\\\\', $content_type) }}",
    // Eg. 1
    content_id: "{{ $content_id }}",
    login_path: "{{ config('comments.login_path') }}"
};
</script>

<script src="{{ asset('vendor/comments/js/comments-react.js') }}"></script>
