var React = require('react');
var ReactDOM = require('react-dom');
var CommentBox = require('./components/CommentBox.jsx');

window.Laravelista = window.Laravelista || {content_type: null, content_id: null};

ReactDOM.render(
  <CommentBox content_type={Laravelista.content_type} content_id={Laravelista.content_id} />,
  document.getElementById('laravelista-comments')
);
