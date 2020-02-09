<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class CurrencyController extends Controller
{
	  public $successStatus = 200;
	  public $currentlink = "https://www.cbr-xml-daily.ru/daily_json.js";

	public function __construct() {
        $this->middleware('auth');
       
    }

    

   public function index() {

   $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile =Profile::where('user_id','=',$user_id)->first();
      
   return response()->json(['profile' => $profile], $this->successStatus);

   }

    public function convert($summ, $from, $to){
    	$cur = json_decode(file_get_contents($this->currentlink), 1);
    	
    }
}
