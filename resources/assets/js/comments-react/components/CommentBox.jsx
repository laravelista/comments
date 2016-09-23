var React = require('react');
var $ = require('jquery');
var CommentList = require('./CommentList.jsx');
var CommentForm = require('./CommentForm.jsx');

var CommentBox = React.createClass({
    getInitialState: function() {
        return {
            comments: [],
            user: {}
        };
    },
    componentDidMount: function() {
        this.loadCommentsFromServer();
    },
    loadCommentsFromServer: function() {
        var url = '/api/v1/comments';
        $.ajax({
            url: url,
            data: {
                content_type: this.props.content_type,
                content_id: this.props.content_id
            },
            success: function(data) {
                var user = this.state.user;
                if(data.meta) {
                    user = data.meta.user.data;
                }

                this.setState({
                    comments: data.data,
                    user: user
                });
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(url, status, err.toString());
            }.bind(this)
        });
    },
    _handleCommentSubmit: function(comment) {
        var url = '/api/v1/comments';
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                content_type: this.props.content_type,
                content_id: this.props.content_id,
                comment: comment
            },
            success: function(data) {
                this.loadCommentsFromServer();
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(url, status, err.toString());
            }.bind(this)
        });
    },
    _handleCommentUpdate: function(comment) {
        var url = '/api/v1/comments/' + comment.comment_id;
        $.ajax({
            url: url,
            method: 'PUT',
            data: {
                comment: comment.comment
            },
            success: function(data) {
                // do nothing
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(url, status, err.toString());
            }.bind(this)
        });
    },
    _handleCommentDelete: function(comment) {
        var url = '/api/v1/comments/' + comment.id;
        $.ajax({
            url: url,
            method: 'DELETE',
            success: function(data) {
                this.loadCommentsFromServer();
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(url, status, err.toString());
            }.bind(this)
        });
    },
    render: function() {
        return (
            <div>
                <CommentList
                    user={this.state.user}
                    onCommentUpdate={this._handleCommentUpdate}
                    onCommentDelete={this._handleCommentDelete}
                    comments={this.state.comments} />
                <CommentForm
                    user={this.state.user}
                    onCommentSubmit={this._handleCommentSubmit} />
            </div>
        );
    }
})

module.exports = CommentBox;
