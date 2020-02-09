<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    

 public $timestamps = true;	
    
 protected $table = 'profiles';

  protected $fillable = [
        'first_name', 'second_name', 'middle_name', 'phone','avatar','additional_phone','additional_email'
    ];

 public function user()
    {
        return $this->belongsTo('App\User');
    }



}
