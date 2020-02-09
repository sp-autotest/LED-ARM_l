<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
	protected $table = 'histories';
	protected $fillable = [
		'past_json',
		'now_json',
		'author'
	];
	protected $with = ["author"];

	    public function author() {

        return $this->hasOne('App\User','id','author') ;

    }
}
