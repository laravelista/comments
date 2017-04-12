import request from 'superagent';
import React, { Component } from 'react';
import CommentList from './CommentList.jsx';
import CommentForm from './CommentForm.jsx';
import handleAjaxError from '../helpers/handleAjaxError';

class CommentBox extends Component {

    constructor() {
        super();

        this.url = '/api/v1/comments';

        this.state = {
            comments: [],
            user: {}
        };
    }

    loadCommentsFromServer() {
        request
            .get(this.url)
            .query({
                content_type: this.props.content_type,
                content_id: this.props.content_id
            })
            .on('error', (error, response) => {
                handleAjaxError(this.url, error, response);
            })
            .end((error, response) => {
                let user = this.state.user;

                if(response.body.meta) {
                    user = response.body.meta.user.data;
                }

                this.setState({
                    comments: response.body.data,
                    user: user
                });
            });
    }

    componentDidMount() {
        this.loadCommentsFromServer();
    }

    handleCommentSubmit(comment) {
        request
            .post(this.url)
            .send({
                content_type: this.props.content_type,
                content_id: this.props.content_id,
                comment: comment
            })
            .on('error', (error, response) => {
                handleAjaxError(this.url, error, response);
            })
            .end((error, response) => {
                this.loadCommentsFromServer();
            });
    }

    handleCommentUpdate(comment) {
        let url = this.url + '/' + comment.comment_id;

        request
            .put(url)
            .send({
                comment: comment.comment
            })
            .on('error', (error, response) => {
                handleAjaxError(url, error, response);
            })
            .end((error, response) => {

            });
    }

    handleCommentDelete(comment) {
        let url = this.url + '/' + comment.id;

        request
            .delete(url)
            .on('error', (error, response) => {
                handleAjaxError(url, error, response);
            })
            .end((error, response) => {
                this.loadCommentsFromServer();
            });
    }

    render() {
        return (
            <div>
                <CommentList
                    user={this.state.user}
                    onCommentUpdate={this.handleCommentUpdate.bind(this)}
                    onCommentDelete={this.handleCommentDelete.bind(this)}
                    comments={this.state.comments} />
                <CommentForm
                    user={this.state.user}
                    login_path={this.props.login_path}
                    onCommentSubmit={this.handleCommentSubmit.bind(this)} />
            </div>
        );
    }

}

export default CommentBox;
