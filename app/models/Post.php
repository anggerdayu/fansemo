<?php

class Post extends Eloquent {
	use SoftDeletingTrait;

    protected $table = 'posts';
    protected $dates = ['deleted_at'];

    public function votes()
    {
        return $this->hasMany('Vote','post_id','id');
    }

    public function comments()
    {
        return $this->hasMany('Comment','post_id','id');
    }

    public function user()
    {
        return $this->belongsTo('User', 'id', 'user_id');
    }

}