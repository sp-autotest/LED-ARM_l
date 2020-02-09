<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller; 
use Auth;
use App\User;
use View;
use Carbon\Carbon; 
use App\Profile;
use App\Country;
use App\City;
use App\Airline;




use  App\Http\Requests\SearchAirlineRequest;
use  App\Http\Requests\AirlineAddRequest;
use  App\Http\Requests\AirlineEditRequest;




 
class AirlenesController  extends Controller
{
  public $successStatus = 200;
  public $errorStatus = '400';





  public function index(){


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airlines'] = 1;
         $airlines = Airline::all();


       return response()->json(['airlines' => $airlines, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);

  }





  public function getEditAirline($id){


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airlines'] = 1;
         $airline = Airline::findOrFail($id);
         $cities = City::all();


       return response()->json(['airline' => $airline,'cities' => $cities, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);

  }






  public function getAirline(){


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airlines'] = 1;
         $airlines = Airline::all();


       return response()->json(['airlines' => $airlines, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);

  }



public function postAirlineAdd(AirlineAddRequest $request) {

   $airline = new Airline;
   $airline->code_tkp = $request->code_tkp;
   $airline->aviacompany_name_ru = $request->aviacompany_name_ru;
   $airline->short_aviacompany_name_ru = $request->short_aviacompany_name_ru;
   $airline->aviacompany_name_eng = $request->aviacompany_name_eng;
   $airline->code_iata = $request->code_iata;
   $airline->account_code_iata = $request->account_code_iata;
   $airline->account_code_tkp = $request->account_code_tkp;
   $airline->city_id = $request->city_id;
   $airline->date_begin_at = $request->date_begin_at;
   $airline->date_end_at = $request->date_end_at;
   $airline->created_at=Carbon::now(); 
   $airline->save();



  return response()->header('Access-Control-Allow-Origin', '*')->json(['airline' => $airline], $this->successStatus); 

}



public function postAirlineEdit(AirlineEditRequest $request) {
 

   $id = intval($request->get('id'));
   $airline = Airline::findOrFail($id);
   $airline->code_tkp = $request->code_tkp;
   $airline->aviacompany_name_ru = $request->aviacompany_name_ru;
   $airline->short_aviacompany_name_ru = $request->short_aviacompany_name_ru;
   $airline->aviacompany_name_eng = $request->aviacompany_name_eng;
   $airline->code_iata = $request->code_iata;
   $airline->account_code_iata = $request->account_code_iata;
   $airline->account_code_tkp = $request->account_code_tkp;
   $airline->city_id = $request->city_id;
   $airline->date_begin_at = $request->date_begin_at;
   $airline->date_end_at = $request->date_end_at;
   $airline->updated_at=Carbon::now(); 
   $airline->save();



  return response()->header('Access-Control-Allow-Origin', '*')->json(['airline' => $airline], $this->successStatus); 
; 

}




   public function searchAirline(SearchAirlineRequest $request) {

        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['airlines'] = 1;

        $query = $request->get('query');
        $search_airline = Airline::where('aviacompany_name_ru', 'LIKE', "%$query%")->paginate(10);

        $total = Airline::where('aviacompany_name_ru', 'LIKE', "%$query%")->count();

       if ($total > 0) {
        
         return response()->json(['search_airline' => $search_airline, 'profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);
     
     
       }
       

       else {

      return response()->json(['profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);
     

       }  



    }








}