<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    
     public $timestamps = true;

    protected $table = 'schedule';
protected $with = ["childs"];

     public function arrival()
    {
        return $this->belongsTo('App\Aeroport', 'arrival_at', 'id');
    }
     public function departure()
    {
        return $this->belongsTo('App\Aeroport', 'departure_at', 'id');
    }
	public function airline(){
        return $this->hasOne('App\Airline', 'id', 'airlines_id');
    }
    public function childs(){
    	return $this->hasMany('App\Schedule')->with('childs');
    }



    protected $fillable = [
     "departure_at",
	"arrival_at",
	"flights",
	"period_begin_at",
	"airlines_id",
	"period_end_at",
	"time_departure_at" ,
	"time_arrival_at",
	"is_transplantation" ,
	"monday",
	"tuesday",
	"wednesday",
	"thursday",
	"friday",
	"saturday",
	"sunday",
	"airlines_id"
    ];
}
