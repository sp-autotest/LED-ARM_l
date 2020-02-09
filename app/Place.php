<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public $timestamps = true;

    protected $table = 'places';

    protected $fillable = [
        'schedule_id',
        'flights_id',
        'fare_families_id',
        'date_at',
        'day_week',
        'count_begin_places',
        'count_sale_places',
        'count_end_places'
    ];
}
