<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $guarded = [
  	];
	protected $appends = ['selfMessage'];


	public function getSelfMessageAttribute()
	{
		return $this->user_id === auth()->user()->id;
	} 

	public function conversation()
	{
		return $this->belongsTo('App\Conversation');
	}
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
