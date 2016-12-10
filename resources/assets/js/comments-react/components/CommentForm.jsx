import React, { Component } from 'react';

class CommentForm extends Component
{
    constructor() {
        super();

        this.state = {
            comment: ''
        };
    }

    handleCommentChange(e) {
        this.setState({
            comment: e.target.value
        });
    }

    handleSubmit(e) {
        e.preventDefault();

        var comment = this.state.comment.trim();
        if(!comment) {
            return;
        }

        this.props.onCommentSubmit(comment);

        this.setState({
            comment: ''
        });
    }

    render() {
        var form = (
            <form onSubmit={this.handleSubmit.bind(this)}>
                <div className="panel panel-default">
                    <div className="panel-body">
                        <textarea rows="6" value={this.state.comment} onChange={this.handleCommentChange.bind(this)} className="form-control" placeholder="Enter your comment here..."></textarea>
                        <span className="help-block"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax/">Markdown</a> cheatsheet.</span>
                    </div>
                    <div className="panel-footer">
                        <button className="btn btn-xs btn-raised btn-success" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        );

        if(this.props.user.id == undefined) {
            form = (
                <p className="lead">You must <a href={this.props.login_path}>login</a> to post a comment.</p>
            );
        }
        return (
            <div>
                {form}
            </div>
        );
    }

}

export default CommentForm;
