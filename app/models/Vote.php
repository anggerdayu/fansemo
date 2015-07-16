<?php

class Vote extends Eloquent {
	use SoftDeletingTrait;

    protected $table = 'votes';
    protected $dates = ['deleted_at'];

    public function post()
    {
        return $this->belongsTo('Post', 'id', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo('User', 'id', 'user_id');
    }

}