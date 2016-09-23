var React = require('react');
var Comment = require('./Comment.jsx');

var CommentList = React.createClass({
    _handleCommentUpdate: function(comment) {
        this.props.onCommentUpdate(comment);
    },
    _handleCommentDelete: function(comment) {
        this.props.onCommentDelete(comment);
    },
    render: function() {
        var that = this;
        var comments = this.props.comments.map(function(comment, index) {
            return (
                <Comment
                    user={that.props.user}
                    onCommentDelete={that._handleCommentDelete}
                    onCommentUpdate={that._handleCommentUpdate}
                    comment={comment}
                    key={comment.id} />
            );
        })
        if(comments.length == 0) {
            comments = (
                <p className="lead">There are no comments yet. Be the first to comment.</p>
            )
        }
        return (
            <div>
                {comments}
            </div>
        );
    }
})

module.exports = CommentList;
