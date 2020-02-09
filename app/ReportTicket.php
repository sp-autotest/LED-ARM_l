<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportTicket extends Model
{
     public $timestamps = true;	
    
     protected $table = 'tickets';


   

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

}
