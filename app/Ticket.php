<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Ticket extends Model
{

 use Sortable;


     public $timestamps = true;	
    
     protected $table = 'tickets';


     protected $sortable = [

     	  'ticket_number',
     	  'rate_fare',
     	   'tax_fare',
     	   'types_fees_ fare',
     	   'types_fees_ fare',
     	   'types_fees_id',
     	   'types_fees_id',
     	   'commission_fare',
     	   'summ_ticket',
     	   'passengers_id',
     	   'created_at', 
     	   'updated_at',
     	   'created_id',
     	   'updated_id' 

   
    ];


     protected $fillable = [

     	  'ticket_number',
     	  'rate_fare',
     	   'tax_fare',
     	   'types_fees_ fare',
     	   'types_fees_ fare',
     	   'types_fees_id',
     	   'types_fees_id',
     	   'commission_fare',
     	   'summ_ticket',
     	   'passengers_id',
     	   'created_at', 
     	   'updated_at',
     	   'created_id',
     	   'updated_id' 

   
    ];



   public function passenger() {

        return $this->hasOne('App\Passenger');
    }  

 
      public function typefee() {

        return $this->hasOne('App\TypeFee');
    }  









}

