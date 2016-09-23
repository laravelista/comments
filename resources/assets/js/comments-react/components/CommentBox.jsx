var React = require('react');
var $ = require('jquery');
var CommentList = require('./CommentList.jsx');
var CommentForm = require('./CommentForm.jsx');

var CommentBox = React.createClass({
    getInitialState: function() {
        return {
            comments: []
        };
    },
    componentDidMount: function() {
        this.loadCommentsFromServer();
    },
    loadCommentsFromServer: function() {
        $.ajax({
            url: '/api/v1/comments',
            data: {
                content_type: this.props.content_type,
                content_id: this.props.content_id
            },
            success: function(data) {
                this.setState({
                    comments: data.data
                });
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(this.state.url, status, err.toString());
            }.bind(this)
        });
    },
    _handleCommentSubmit: function(comment) {
        $.ajax({
            url: '/api/v1/comments',
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
                console.error(this.state.url, status, err.toString());
            }.bind(this)
        });
    },
    _handleCommentUpdate: function(comment) {
        $.ajax({
            url: '/api/v1/comments/' + comment.comment_id,
            method: 'PUT',
            data: {
                comment: comment.comment
            },
            success: function(data) {
                // do nothing
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(this.state.url, status, err.toString());
            }.bind(this)
        });
    },
    render: function() {
        return (
            <div>
                <CommentList onCommentUpdate={this._handleCommentUpdate} comments={this.state.comments} />
                <CommentForm onCommentSubmit={this._handleCommentSubmit} />
            </div>
        );
    }
})

module.exports = CommentBox;
