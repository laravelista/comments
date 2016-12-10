import React, { Component } from 'react';
import Comment from './Comment.jsx';

class CommentList extends Component
{
    handleCommentUpdate(comment) {
        this.props.onCommentUpdate(comment);
    }

    handleCommentDelete(comment) {
        this.props.onCommentDelete(comment);
    }

    render() {
        let comments = this.props.comments.map((comment, index) => {
            return (
                <Comment
                    user={this.props.user}
                    onCommentDelete={this.handleCommentDelete.bind(this)}
                    onCommentUpdate={this.handleCommentUpdate.bind(this)}
                    comment={comment}
                    key={comment.id} />
            );
        });

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

}

export default CommentList;
