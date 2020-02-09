<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Currency extends Model
{
     
 use Sortable;

 public $sortable  = [
 
        'name_eng', 'name_ru', 'code_literal_iso_4217', 
        'code_numeric_iso_4217'
    ];

     public $timestamps = true;	
    
     protected $table = 'currencies';


    protected $fillable = [
 
        'name_eng', 'name_ru', 'code_literal_iso_4217', 
        'code_numeric_iso_4217'
    ];


    public function users()
    {
        return $this->belongsTo('App\AdminCompany');
    }


}
