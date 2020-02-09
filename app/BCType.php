<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class BCType extends Model
{
    
  
use Sortable;


     public $timestamps = true;	
    
     protected $table = 'bc_types';


    public $sortable =  [
     'code_tkp', 
	'aviacompany_name_ru',
	'short_aviacompany_name_ru',
	'aviacompany_name_eng',
	'short_aviacompany_name_eng',
	'code_iata',
	'account_code_iata', 
	'account_code_tkp',
	'city_id',
	'date_begin_at',
	'date_end_at' ];

    protected $fillable = [
     'code_tkp', 
	'aviacompany_name_ru',
	'short_aviacompany_name_ru',
	'aviacompany_name_eng',
	'short_aviacompany_name_eng',
	'code_iata',
	'account_code_iata', 
	'account_code_tkp',
	'city_id',
	'date_begin_at',
	'date_end_at' ];
 


}
