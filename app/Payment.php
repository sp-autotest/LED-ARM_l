<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ticket;
use App\AdminCompany as Company;




class Payment extends Model
{
    
  public $timestamps = true;

    protected $table = 'payments';

    protected $fillable = [
    'accounts_id',
	'payment_date', 
	'payment_summ',
	'comment',
	'created_id',
	'updated_id' 
    ];



    protected $with = ["currency", "account", "account.company", "manager"];

    public function manager() {
        return $this->hasOne('App\User','id','created_id') ;
    }

   public function account()
    {
        return $this->hasOne('App\Accounts', "id", "accounts_id");
    }


    public function currency() {
        return $this->hasOne('App\Currency', 'id', 'currency_id');
    }

    


}
