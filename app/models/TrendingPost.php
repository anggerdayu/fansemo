<?php

class TrendingPost extends Eloquent {

    protected $table = 'trending_posts';

    public function user()
    {
        return $this->belongsTo('Post', 'post_id', 'id');
    }

}