<?php

class FeaturedPost extends Eloquent {
	use SoftDeletingTrait;

    protected $table = 'featured_posts';
    protected $dates = ['deleted_at'];

    public function post()
    {
        return $this->belongsTo('Post', 'post_id', 'id');
    }

}