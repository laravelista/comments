import React from 'react';
import ReactDOM from 'react-dom';
import CommentBox from './components/CommentBox.jsx';

window.Laravelista = window.Laravelista || {content_type: null, content_id: null, login_path: '/login'};

ReactDOM.render(
  <CommentBox content_type={Laravelista.content_type} content_id={Laravelista.content_id} login_path={Laravelista.login_path} />,
  document.getElementById('laravelista-comments')
);
