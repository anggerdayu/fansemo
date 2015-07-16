<?php

class Comment extends Eloquent {
	use SoftDeletingTrait;

    protected $table = 'comments';
    protected $dates = ['deleted_at'];

    public function post()
    {
        return $this->belongsTo('Post', 'id', 'post_id');
    }

    public function votes()
    {
        return $this->hasMany('CommentVote','comment_id','id');
    }

    public function user()
    {
        return $this->belongsTo('User', 'id', 'user_id');
    }

}