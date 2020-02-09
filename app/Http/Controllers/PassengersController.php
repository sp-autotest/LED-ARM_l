<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Passenger;
use Carbon\Carbon;
class PassengersController extends Controller
{
	public $successStatus = 200;

    public function add(Request $request){
	    $passenger = new Passenger;
	    $passenger->name = $request->name;
	    $passenger->surname = $request->surname;
	    $passenger->country_id = $request->country_id;
	    $passenger->sex_u = $request->sex_u;
	    $passenger->type_documents = $request->type_documents;
	    $passenger->type_passengers = $request->type_passengers;
	    $passenger->passport_number = $request->passport_number;
	    $passenger->date_birth_at = $request->date_birth_at;
	    $passenger->expired = $request->expired;
	    $passenger->save();

 		return response()->json(['passenger' => $passenger], $this->successStatus);   
    }

    public function edit(Request $request){
    	$passenger = Passenger::where('id', '=', $request->id)->first();

  		if(!empty($request->name) && isset($request->name)){$passenger->name = $request->name;}
  		if(!empty($request->surname) && isset($request->surname)){$passenger->surname = $request->surname;}
  		if(!empty($request->country_id) && isset($request->country_id)){$passenger->country_id = $request->country_id;}
  		if(!empty($request->sex_u) && isset($request->sex_u)){$passenger->sex_u = $request->sex_u;}
  		if(!empty($request->type_documents) && isset($request->type_documents)){$passenger->type_documents = $request->type_documents;}
  		if(!empty($request->type_passengers) && isset($request->type_passengers)){$passenger->type_passengers = $request->type_passengers;}
  		if(!empty($request->passport_number) && isset($request->passport_number)){$passenger->passport_number = $request->passport_number;}
  		if(!empty($request->date_birth_at) && isset($request->date_birth_at)){$passenger->date_birth_at = $request->date_birth_at;}
  		if(!empty($request->expired) && isset($request->expired)){$passenger->expired = $request->expired;}

	    $passenger->save();

 		return response()->json(['passenger' => $passenger], $this->successStatus);   
    }

    public function search(Request $request)
    {
    
    	$bypage = (isset($request->bypage))?$request->bypage:15;
    	if (isset($request->q)) {
    		$passengers = Passenger::with(['country'])->where([['name', 'ilike', '%'.$request->q.'%'], ['expired' ,'>', Carbon::now()]])->orWhere([['surname', 'ilike', $request->q], ['expired' ,'>', Carbon::now()]])->orWhere([['passport_number', 'ilike', $request->q], ['expired' ,'>', Carbon::now()]])->paginate($bypage);
    	}else{
    		$passengers = Passenger::with(['country'])->paginate($bypage);
    	}

 		return response()->json(['passengers' => $passengers], $this->successStatus);   
    }


}


