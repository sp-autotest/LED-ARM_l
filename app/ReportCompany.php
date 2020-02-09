<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportCompany extends Model
{
    
 public $timestamps = true;	
    
 protected $table = 'companies';


    protected $fillable = [
        'legal_company_name', 'post_address', 'city', 'phone', 'finance_mail','report_mail','logo','fax','currency_id','okud','inn','okonh','kpp','ogrn','bik','correspondent_account','first_name','second_name','third_name','position',
             'agreement','contract_number', 'countnumber'
    ];

}
