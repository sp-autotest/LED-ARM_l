<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Passenger extends Model
{
   
   use Sortable;


    public $timestamps = true;

    protected $table = 'passengers';

    protected $sortable = [
        'name',
        'surname',
        'date_birth_at',
        'passport_number',
        'country_id',
        'user_id',
        'expired',
        'type_passengers',
        'type_documents',
        'sex_u'
    ];




       protected $fillable = [
        'name',
        'surname',
        'date_birth_at',
        'passport_number',
        'country_id',
        'user_id',
        'expired',
        'type_passengers',
        'type_documents',
        'sex_u'
    ];



 public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function country()
    {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }
  public function ticket()
    {
        return $this->belongsTo('App\Ticket', 'id', 'passengers_id');
    }


/*
   public function passenger() {

        return $this->hasMany('App\Passenger');
    }  */





}
	