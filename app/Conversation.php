<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $guarded = [];
    protected $with = ['users'];
    public function messages()
    {
        return $this->hasMany('App\Message');
    }
    public function users()
    {
        return $this->belongsToMany('App\User', 'conversation_user');
    }

}
