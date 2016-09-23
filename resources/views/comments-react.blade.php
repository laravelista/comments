<div id="laravelista-comments"></div>

<script>
window.Laravelista = {
    // Eg. App\Post::class || App\\Post
    content_type: "{{ str_replace('\\', '\\\\', $content_type) }}",
    // Eg. 1
    content_id: "{{ $content_id }}"
};
</script>

<link href="{{ asset('vendor/comments/css/comments-react.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/comments/js/comments-react.js') }}"></script>
