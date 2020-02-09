<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class TypeFee extends Model
{
    
 use Sortable;


     public $timestamps = true;	
    
     protected $table = 'types_fees';

    protected $sortable  = [
 
    'name_eng', 
	'name_ru',
	'date_of_start',
	'date_of_stop'

    ];




    protected $fillable = [
 
    'name_eng', 
	'name_ru',
	'date_of_start',
	'date_of_stop'

    ];

    public function feeplace(){

    	return $this->belongsTo('App\FeePlace');
    }


    public function ticket(){

    	return $this->belongsTo('App\Ticket');
    }


}
