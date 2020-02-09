<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Passenger;
use Carbon\Carbon;
use Auth;
use App\User;
use View;



class APIPassengersController extends Controller
{

   public $successStatus = 200;
   public $errorStatus = 400;



    public function add(Request $request){

	    $passenger = new Passenger;
	    $passenger->name = $request->name;
	    $passenger->surname = $request->surname;
	    $passenger->country_id = $request->country_id;
	    $passenger->sex_u = $request->sex_u;
	    $passenger->type_documents = $request->type_documents;
	    $passenger->type_passengers = $request->type_passengers;
	    $passenger->passport_number = $request->passport_number;
	    $passenger->patronymic = $request->patronymic;
	    $passenger->date_birth_at = $request->date_birth_at;
	    $passenger->expired = $request->expired;
	    $passenger->save();

 		return response()->json(['passenger' => $passenger], $this->successStatus);   
    }



    public function search(Request $request) {
    
    	$bypage = (isset($request->bypage))?$request->bypage:15;
    	if (isset($request->q)) {
    		$passengers = Passenger::with(['country'])->where([['name', 'ilike', '%'.$request->q.'%'], ['expired' ,'>', Carbon::now()]])->orWhere([['surname', 'ilike', $request->q], ['expired' ,'>', Carbon::now()]])->orWhere([['passport_number', 'ilike', $request->q], ['expired' ,'>', Carbon::now()]])->paginate($bypage);
    	}
    	 else

    	     {
    		
    		$passengers = Passenger::with(['country'])->paginate($bypage);
    	}

 		return response()->json(['passengers' => $passengers], $this->successStatus);   
    }


}


