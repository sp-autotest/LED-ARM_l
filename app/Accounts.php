<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class Accounts extends Model
{
    public $timestamps = true;

    protected $table = 'accounts';

    protected $fillable = [
        'company_registry_id',
        'account_number',
        'payment_terms',
        'credit_limit',
        'balance'
    ];


    public function company(){
    	return $this->hasOne('App\AdminCompany', 'id', 'company_registry_id');
    }


 
     public function payments() {
        
        return $this->hasMany('App\Payment');
    }


   
  public  function getCompanyInfo($company_id)
    {
        return self::where([
            'company_registry_id' => $company_id
     
        ])->get();
    }



  




}
