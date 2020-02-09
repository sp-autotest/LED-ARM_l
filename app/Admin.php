<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    
 public $timestamps = true;	
    
 protected $table = 'users';


    protected $fillable = [
        'name', 'email', 'password', 'is_admin'
    ];



 public function profile()
    {
        return $this->hasOne('App\User','user_id');
    }





}
