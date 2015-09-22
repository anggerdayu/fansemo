<?php

class Banner extends Eloquent {
	use SoftDeletingTrait;

    protected $table = 'banners';
    protected $dates = ['deleted_at'];

}