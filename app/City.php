<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class City extends Model
{
    
  
use Sortable;


  public $timestamps = true;	
    
  protected $table = 'cities';


  protected $sortable = [
 
        'code_iat', 'name_ru', 'name_eng'
    ];

    protected $fillable = [
 
        'code_iat', 'name_ru', 'name_eng'
    ];

    public function airports(){
    	return $this->hasMany('App\Aeroport');
    }

    public function country(){
    	return $this->belongsTo('App\Country');
    }

       public function airline(){
    	return $this->belongsTo('App\Airline');
    }


  
	public function feeplaces(){
    	return $this->hasMany('App\FeePlace');
    }




}
