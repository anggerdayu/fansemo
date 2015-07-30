<?php

class Team extends Eloquent {
	use SoftDeletingTrait;

    protected $table = 'teams';
    protected $fillable = ['name','type','logo_image','jersey_image'];

}