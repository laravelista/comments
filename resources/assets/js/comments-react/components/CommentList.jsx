var React = require('react');
var Comment = require('./Comment.jsx');

var CommentList = React.createClass({
    _handleCommentUpdate: function(comment) {
        this.props.onCommentUpdate(comment);
    },
    render: function() {
        var that = this;
        var comments = this.props.comments.map(function(comment, index) {
            return (
                <Comment user={that.props.user} onCommentUpdate={that._handleCommentUpdate} comment={comment} key={index} />
            );
        })
        return (
            <div>
                {comments}
            </div>
        );
    }
})

module.exports = CommentList;
