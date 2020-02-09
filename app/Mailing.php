<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Mailing extends Model
{
    use Sortable;


  public $timestamps = true;	
    
  protected $table = 'mailing';


   public $sortable  =  [
 
    'status',
	'type_mailing', 
	'mail_list', 
	'created_id',
	'updated_id'
	

    ];




    protected $fillable = [
 
    'status',
	'type_mailing', 
	'mail_list', 
	'created_id',
	'updated_id'

    ];

	public function isActive() {
		if ($this->status ==true)
		 return true;

		return false;
	}

	public function company() {
	
	return $this->belongsTo('App\AdminCompany','company_registry_id', 'id');
	
	}

 
   
    public function mailing_list() {

    return $this->hasMany('App\MailingList');

   }


   
    public function mailing() {

    return $this->hasMany('App\Mailing');

   }



}




 