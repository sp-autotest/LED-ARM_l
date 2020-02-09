<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AdminCompany extends Model
{
    
use Sortable;

public $sortable = ['company_name','phone','first_name', 'third_name','finance_mail','currency_id'];


 public $timestamps = true;	
    
 protected $table = 'companies';

 protected $guarded = [];
    /*protected $fillable = [
        'legal_company_name', 'post_address', 'city', 'phone', 'finance_mail','report_mail','logo','fax','currency_id','okud','inn','okonh','kpp','ogrn','bik','correspondent_account','first_name','second_name','third_name','position',
             'agreement','contract_number', 'countnumber'
    ];*/



    public function currency() {
         return $this->hasOne('App\Currency', 'id', 'currency_id');
    }

    public function childs() {

        return $this->hasMany('App\AdminCompany','parent','id')->with(['childs', 'manager', 'currency']) ;

    }

    public function manager() {
        return $this->hasOne('App\User','id','manager_id') ;
    }
    public function parent() {

        return $this->hasOne('App\AdminCompany','id','parent') ;

    }
    public function feeplaces(){

    return $this->hasMany('App\FeePlace', 'company_id', 'id');

    }


   public function currencies(){

    return $this->hasMany('App\Currency');

    }

   public function ads(){

    return $this->hasMany('App\ElectronicTicketsPicture', 'companies_id', 'id');

    }


  public static function getFullName() {
        return trim(self::first_name . ' ' . self::second_name . ' ' .self::third_name);
    }


  public function order()
    {
        return $this->hasMany('App\Order');
    }



    public function mailing() {

    return $this->hasMany('App\Mailing');


    }


     
    public function staff() {
         return $this->hasMany('App\User', 'company_id', 'id');
    }

    public function mailing_list() {

    return $this->hasMany('App\MailingList');

   }




  public function getSubCategoriesIds($parent_id, &$ids = [])
    {
        array_push($ids, $parent_id);

        $children = AdminCompany::query()->where('parent_id','=', $parent_id)->pluck('id')->all();
        collect($children)->each(function ($id) use (&$ids) {
            $this->getSubCategoriesIds($id, $ids);
        });
    }

    public function account(){
        return $this->belongsTo('App\Accounts', 'id', 'company_registry_id');
    }

    public function getSubCategoriesCounter($parent_id, &$counter = 0)
    {
        $counter += AdminCompany::query()->where('id', '=', $parent_id)->first()->count();

        $children = AdminCompany::query()->where('parent_id', '=', $parent_id)->pluck('id')->all();
        collect($children)->each(function ($id) use (&$counter) {
            $this->getSubCategoriesCounter($id, $counter);
        });
    }

    


}



