import React, { Component } from 'react';
import md5 from 'md5';
import Remarkable from 'remarkable';
import moment from 'moment';

const md = new Remarkable();

class Comment extends Component
{
    constructor() {
        super();

        this.state = {
            type: 'read',
            comment: ''
        };
    }

    componentDidMount() {
        this.setState({
            comment: this.props.comment.comment
        });
    }

    rawMarkup() {
        let rawMarkup = md.render(this.state.comment);

        return {
            __html: rawMarkup
        };
    }

    handleDelete() {
        this.props.onCommentDelete(this.props.comment);
    }

    handleEdit() {
        this.setState({
            type: 'edit'
        });
    }

    handleUpdate() {
        this.setState({
            type: 'read'
        });

        // If the comment did not change, do nothing.
        if(this.props.comment.comment == this.state.comment) {
            return;
        }

        this.props.onCommentUpdate({
            comment: this.state.comment,
            comment_id: this.props.comment.id
        });
    }

    handleCommentChange(e) {
        this.setState({
            comment: e.target.value
        });
    }

    render() {
        let email_hash = "//www.gravatar.com/avatar/" + this.props.comment.user.data.email_hash + ".jpg?s=60";
        let datetime = moment(this.props.comment.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow();

        let content = (
            <p>
                <span dangerouslySetInnerHTML={this.rawMarkup()} />
            </p>
        );

        let edit_button = (
            <button onClick={this.handleEdit.bind(this)} className="btn btn-xs btn-default">Edit</button>
        );

        let delete_button = (
            <button onClick={this.handleDelete.bind(this)} className="btn btn-xs btn-danger">Delete</button>
        );

        if(this.props.user.id != this.props.comment.user.data.id) {
            edit_button = null;
            delete_button = null;
        }

        if(this.state.type == 'edit') {
            content = (
                <textarea rows="6" className="form-control" onChange={this.handleCommentChange.bind(this)} value={this.state.comment}></textarea>
            );

            edit_button = (
                <button onClick={this.handleUpdate.bind(this)} className="btn btn-xs btn-primary">Update</button>
            );
        }

        let footer = (
            <div className="panel-footer text-right">
                {edit_button}
                {delete_button}
            </div>
        );

        if(edit_button == null && delete_button == null) {
            footer = null;
        }

        return (
            <div className="panel panel-default">
                <div className="panel-body">
                    <div className="media">
                        <div className="media-left">
                            <img className="media-object img-thumbnail img-circle" src={email_hash} />
                        </div>
                        <div className="media-body">
                            <p>
                                <small><b>{this.props.comment.user.data.name}</b></small> <small className="text-muted">- {datetime}</small>
                            </p>
                            {content}
                        </div>
                    </div>
                </div>
                {footer}
            </div>
        );
    }
}

export default Comment;
