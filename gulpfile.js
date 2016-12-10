var elixir = require('laravel-elixir');

require('laravel-elixir-webpack-react');

elixir(function (mix) {
    mix.webpack('comments-react/app.js', 'public/js/comments-react.js');
});
