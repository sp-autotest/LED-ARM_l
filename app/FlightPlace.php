<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlightPlace extends Model
{
     
     public $timestamps = true;	
    
    protected $table = 'flights_places';

    public function schedule(){
        return $this->belongsToMany('App\Schedule', 'flightplaces_schedule', 'flight_places_id', 'schedule_id');
        //return $this->belongsTo('App\Schedule', 'id', 'flight_places_id');
    }

    public function currency(){
        return $this->hasOne('App\Currency', 'id', 'currency_id');
    }

    public function farefamily(){
        return $this->hasOne('App\FareFamily', 'id', 'fare_families_id');
    }

    protected $fillable = [
 
    'code',
	'created_at',
    'updated_at',
    'created_id',
    'updated_id',
    'schedule_id',
    'count_places', 
    'cost_ow__adults', 
    'cost_ow_infants', 
    'cost_rt__adults', 
    'cost_rt_infants', 
    'currency_id',
    'infant',
    'fare_families_id'

    ];
}
