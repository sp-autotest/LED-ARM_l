<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Provider extends Model
{
     public $timestamps = true;	
    
     protected $table = 'providers';


   use Sortable;


    protected $sortable = [
   
     	'created_at',

     	'updated_at', 

		'created_id',

		'updated_id',

		'name_ru',

		'name_full_ru',

		'name_eng',

		'name_full_eng',

		'date_begin_at', 

		'date_end_at'
 
    ];







     protected $fillable = [
     	  
     	'created_at',

     	'updated_at', 

		'created_id',

		'updated_id',

		'name_ru',

		'name_full_ru',

		'name_eng',

		'name_full_eng',

		'date_begin_at', 

		'date_end_at'
 
   
    ];










    
}
