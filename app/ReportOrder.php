<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportOrder extends Model
{
    

     public $timestamps = true;	
    
     protected $table = 'orders';


     protected $fillable = [
     	  'user_id','status', 'type_order','order_summary', 'order_currency', 'passengers','time_limit','type_payment','services'
 
   
    ];
}
