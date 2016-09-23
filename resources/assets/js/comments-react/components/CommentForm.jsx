var React = require('react');

var CommentForm = React.createClass({
    getInitialState: function() {
        return {
            comment: ''
        };
    },
    _handleCommentChange: function(e) {
        this.setState({
            comment: e.target.value
        });
    },
    _handleSubmit: function(e) {
        e.preventDefault();

        var comment = this.state.comment.trim();
        if(!comment) {
            return;
        }

        this.props.onCommentSubmit(comment);

        this.setState({
            comment: ''
        });
    },
    render: function() {
        return (
            <form onSubmit={this._handleSubmit}>
                <div className="panel panel-default">
                    <div className="panel-body">
                        <textarea rows="6" value={this.state.comment} onChange={this._handleCommentChange} className="form-control" placeholder="Enter your comment here..."></textarea>
                        <span className="help-block"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax/">Markdown</a> cheatsheet.</span>
                    </div>
                    <div className="panel-footer">
                        <button className="btn btn-xs btn-raised btn-success" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        );
    }
});

module.exports = CommentForm;
