<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderAccount extends Model
{
    
     public $timestamps = true;	
    
     protected $table = 'providers_accounts';

    public function provider(){
        return $this->hasOne('App\Provider', 'id', 'providers_id');
    }
     protected $fillable = [
     	  
     	'created_at',

     	'updated_at', 

		'created_id',

		'updated_id',

		'providers_id',

		'login_a',

		'login_b',
         
         'ordering_a',

		'ordering_p', 
		
		'adding'
 
   
    ];













    
}

