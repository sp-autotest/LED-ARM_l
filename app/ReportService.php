<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportService extends Model
{
   

    public $timestamps = true;	
    
     protected $table = 'services';


    protected $fillable = [
 
     'user_id',
	'departure_at',
	'arrival_at',
	'type_flight',
	'departure_date',
	'arrival_date',
	'service_status',
	'orders_system',
	'booking_date',
	'summary_summ',
	'passenger_id',
	'pnr',
	'provider_id',
	'segment_number'
    ];
   
}
