var React = require('react');
var md5 = require('md5');
var Remarkable = require('remarkable');
var md = new Remarkable();
var moment = require('moment')

var Comment = React.createClass({
    getInitialState: function() {
        return {
            type: 'read',
            comment: this.props.comment.comment
        };
    },
    rawMarkup: function() {
        var rawMarkup = md.render(this.state.comment);
        return { __html: rawMarkup };
    },
    _handleEdit: function() {
        this.setState({
            type: 'edit'
        });
    },
    _handleUpdate: function() {
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
    },
    _handleCommentChange: function(e) {
        this.setState({
            comment: e.target.value
        });
    },
    render: function() {
        var email_hash = "//www.gravatar.com/avatar/" + md5(this.props.comment.user.data.email) + ".jpg?s=60";
        var datetime = moment(this.props.comment.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow();

        var content = (
            <p>
                <span dangerouslySetInnerHTML={this.rawMarkup()} />
            </p>
        );

        var edit_button = (
            <button onClick={this._handleEdit} className="btn btn-xs btn-default">Edit</button>
        );

        var delete_button = (
            <button className="btn btn-xs btn-danger">Delete</button>
        );

        if(this.props.user.id != this.props.comment.user.data.id) {
            edit_button = null;
            delete_button = null;
        }

        if(this.state.type == 'edit') {
            content = (
                <textarea rows="6" className="form-control" onChange={this._handleCommentChange} value={this.state.comment}></textarea>
            );

            edit_button = (
                <button onClick={this._handleUpdate} className="btn btn-xs btn-primary">Update</button>
            );
        }

        var footer = (
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
})

module.exports = Comment;
