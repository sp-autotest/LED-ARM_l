<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Aeroport extends Model
{
  

use Sortable;

public $sortable = [ 'code_iat', 'name_ru', 'name_eng'];


     public $timestamps = true;	
    
     protected $table = 'airports';


    protected $fillable = [
 
        'code_iat', 'name_ru', 'name_eng'
    ];

    public function city(){
    	return $this->belongsTo('App\City');
    }

    public function country(){
    	return $this->belongsTo('App\City')->with('country');
    }




}



