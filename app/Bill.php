<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    
      public $timestamps = true;	
    
     protected $table = 'bills';

    protected $with = ["currency", "company", "created_by"];

    protected $fillable = [
 
        'invoice_date', 'company_id', 'invoice_amount', 'path'
    ];

    public function created_by() {
        return $this->hasOne('App\User','id','created_id') ;
    }
    public function company()
    {
        return $this->belongsTo('App\AdminCompany', 'company_id', 'id');
    }
    public function currency()
    {
        return $this->belongsTo('App\Currency', 'currency_id', 'id');
    }

}
