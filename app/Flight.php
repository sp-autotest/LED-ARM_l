<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    public $timestamps = true;

    protected $table = 'flights';

    public function flightplaces(){
        return $this->hasOne('App\FlightPlace', 'id', 'flights_places_id');
    }

    protected $fillable = [
        'schedule_id',
        'fare_families_id',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'count_places'
    ];
}
