<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MailingList extends Model
{

	 use Sortable;
     
     protected $table = 'mailing_list'; 


     public $timestamps = true;	

    
    protected $fillable = [
 
    'type_mailing',
	'mail_list', 
	'company_registry_id', 
	'created_id',
	'updated_id'

    ];



	public function company() {
	
	return $this->belongsTo('App\AdminCompany','company_registry_id', 'id');
	
	}

    public function mailing_list() {

    return $this->belongsTo('App\MailingList');


    }


   public static function deleteEmail($email) {

  
    MailingList::where(['mail' => $email])->delete();

   return true;


   



   }

   public static function addEmail($email, $mailing_id)
    {
       $mail_list = MailingList::where('mailing_id', '=', $mailing_id)->first();
        return $mail_list;
        $mail_list->mail = $email;

        $mail_list->save();
    

    return true;

   
    }


}


