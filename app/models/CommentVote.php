<?php

class CommentVote extends Eloquent {
	use SoftDeletingTrait;

    protected $table = 'comment_votes';
    protected $dates = ['deleted_at'];

    public function comment()
    {
        return $this->belongsTo('Comment', 'id', 'comment_id');
    }

    public function user()
    {
        return $this->belongsTo('User', 'id', 'user_id');
    }
}