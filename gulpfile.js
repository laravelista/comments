var elixir = require('laravel-elixir');

elixir(function (mix) {
    mix.browserify('comments-react/app.js', 'public/js/comments-react.js');
});
