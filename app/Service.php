<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
     public $timestamps = true;	
    
     protected $table = 'services';

    public function passenger()
    {
        return $this->belongsTo('App\Passenger', 'passenger_id', 'id');
    }
	public function flight()
    {
        return $this->belongsTo('App\Flight', 'flight_id', 'id');
    }
    public function fare()
    {
        return $this->belongsTo('App\FareFamily', 'fare_families_id', 'id');
    }
    public function ticket()
    {
        return $this->belongsTo('App\Ticket', 'tickets_id', 'id');
    }
    public function order()
    {
    	return $this->belongsTo('App\Order', 'order_id', 'id');
    }
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
