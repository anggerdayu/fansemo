<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
	protected $fillable = ['username','password','email','phone','team_id','jersey_no','status'];
	protected $guarded = ['id', 'password'];

	public function posts()
    {
        return $this->hasMany('Post','user_id','id');
    }

    public function comments()
    {
        return $this->hasMany('Comment','user_id','id');
    }

    public function commentvotes()
    {
    	return $this->hasMany('Comment','user_id','id');
    }

    public function votes()
    {
    	return $this->hasMany('Vote','user_id','id');
    }


}
