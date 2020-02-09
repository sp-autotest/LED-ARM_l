<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Fare_families extends Model
{

   
use Sortable;

    public $timestamps = true;

    protected $table = 'fare_families';


    public $sortable  = [ 'code',
        'name_eng',
        'name_ru',
        'luggage_adults',
        'luggage_children',
        'luggage_infants',
        'max_stay'
    ];


    protected $fillable = [
        'code',
        'name_eng',
        'name_ru',
        'luggage_adults',
        'luggage_children',
        'luggage_infants',
        'max_stay'
    ];
}
