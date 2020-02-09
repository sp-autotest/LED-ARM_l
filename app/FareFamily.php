<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class FareFamily extends Model
{
    
   
use Sortable;


     public $timestamps = true;	
    
     protected $table = 'fare_families';


   public $sortable  =  [
 
    'code',
	'name_eng', 
	'name_ru', 
	'luggage_adults',
	'luggage_children',
	'luggage_infants',
	'max_stay',
	'note_fare'

    ];




    protected $fillable = [
 
    'code',
	'name_eng', 
	'name_ru', 
	'luggage_adults',
	'luggage_children',
	'luggage_infants',
	'max_stay',
	'note_fare'

    ];



}
