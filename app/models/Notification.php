<?php

class Notification extends Eloquent {
	use SoftDeletingTrait;

    protected $table = 'notifications';
    protected $dates = ['deleted_at'];

    public function receiver()
    {
        return $this->belongsTo('User', 'id', 'receiver_id');
    }

    public function sender()
    {
    	return $this->belongsTo('User', 'id', 'sender_id');	
    }

	public function post()
    {
    	return $this->belongsTo('Post', 'id', 'other_id');	
    }

    public function comment()
    {
    	return $this->belongsTo('Comment', 'id', 'other_id');	
    }

    public function vote()
    {
    	return $this->belongsTo('Vote', 'id', 'other_id');	
    }    

}