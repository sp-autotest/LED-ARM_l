<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class FeePlace extends Model
{

   use Sortable;

    public $timestamps = true;	
    
     protected $table = 'fees_places';



    protected $fillable = [
 
        'company_id', 'non_return', 'period_begin_at', 
        'fare_families_id','period_end_at','country_id_departure',
        'country_id_arrival', 'date_start','types_fees_id','date_stop',
        'airlines_id', 'departure_cities','arrival_cities','type_action',
        'type_flight', 'infant','type_fees_inscribed','type_fees_charge',
         'size_fees_inscribed', 'size_fees_charge','size_fees_exchange',
         'max_fees_inscribed','max_fees_charge', 'max_fees_exchange',
         'min_fees_inscribed','min_fees_charge','min_fees_exchange', 
         'type_deviation','size_deviation'

    ];



    protected $sortable  = [
 
        'company_id', 'non_return', 'period_begin_at', 
        'fare_families_id','period_end_at','country_id_departure',
        'country_id_arrival', 'date_start','types_fees_id','date_stop',
        'airlines_id', 'departure_cities','arrival_cities','type_action',
        'type_flight', 'infant','type_fees_inscribed','type_fees_charge',
         'size_fees_inscribed', 'size_fees_charge','size_fees_exchange',
         'max_fees_inscribed','max_fees_charge', 'max_fees_exchange',
         'min_fees_inscribed','min_fees_charge','min_fees_exchange', 
         'type_deviation','size_deviation'

    ];







    public function city(){
    	return $this->belongsTo('App\City');
    }

    public function typefees(){
    	return $this->hasMany('App\TypeFee');
    }



    public function company(){
    	return $this->belongsTo('App\Company');
    }





}


