<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Order extends Model
{
    

 use Sortable;

   public $timestamps = true;	
    
     protected $table = 'orders';


     protected $fillable = [
     	  'user_id','status', 'type_order','order_summary', 'order_currency', 'passengers', 'passengers.ticket','time_limit','type_payment','services'
 
   
    ];


    protected $with = ["services", "services.ticket", "services.passenger", "services.flight", "services.flight.flightplaces", "services.flight.flightplaces.schedule", "services.flight.flightplaces.schedule.arrival", "services.flight.flightplaces.schedule.departure", "services.fare", "company", "user", "company.currency"];

     protected $sortable = [
     	  'user_id','status', 'type_order','order_summary', 'order_currency', 'passengers','time_limit','type_payment','services'
 
   
    ];


  public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }




  public function company()
    {
        return $this->belongsTo('App\AdminCompany', 'company_registry_id', 'id');
    }


  public function user()
    {
        return $this->belongsTo('App\User');
    }

      public function createdby()
    {
        return $this->belongsTo('App\User', 'created_id', 'id');
    }

    public function services()
    {
       return $this->hasMany('App\Service', 'order_id', 'id');
    }
  
  public function order()
    {
        return $this->belongsTo('App\Passender');
    }



}
