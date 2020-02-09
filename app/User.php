<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',  'last_login_at',
        'last_login_ip', 'company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $with = ["profile", "admincompany", "admincompany.account", "admincompany.currency"];


     public function passenger() {

        return $this->hasOne('App\Passenger');
    }  


     public function company()
    {
        return $this->belongsTo('App\Company');
    } 
    public function admincompany()
    {
        return $this->belongsTo('App\AdminCompany', 'company_id', 'id');
    } 
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

     public function order(){
        return $this->hasOne('App\Orders');
    }

  

    public static function getEmail($id) {

        return self::find($id)->email;
    }
 
    public static function getName($id) {

        return self::find($id)->name;
    }
    public function conversations()
    {
        return $this->belongsToMany('App\Conversation' , 'conversation_user')->where('name', 'not like', '%system_message%');
    }

	public function isAdmin() {
        
		return ! $this->is_admin();
	}
}





