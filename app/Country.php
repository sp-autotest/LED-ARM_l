<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Country extends Model
{
   
use Sortable;



   public $sortable  = [
   
        'code_iso', 'name_ru', 'name_eng', 'metropolis' ];
 
  
    public $timestamps = true;	
    
     protected $table = 'countries';


    protected $fillable = [
 
        'code_iso', 'name_ru', 'name_eng', 'metropolis'
    ];



	public function cities(){
    	return $this->hasMany('App\City');
    }



    public function citiesWithAirports(){
    	return $this->hasMany('App\City')->with('airports');
    }

}
