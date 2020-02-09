<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{


      public $timestamps = true;	
    
      protected $table = 'companies';
   

      protected $fillable = ['title', 'slug', 'description', 'address', 'email', 'phone' , 'sex' ];




}
