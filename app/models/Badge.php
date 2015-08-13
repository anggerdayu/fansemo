<?php

class Badge extends Eloquent {
	use SoftDeletingTrait;

    protected $table = 'badges';
    protected $dates = ['deleted_at'];

}