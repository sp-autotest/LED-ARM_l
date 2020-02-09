<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\AdminCompany as Company;

use App\Http\Controllers\Controller; 
use Auth;
use App\User;
use View;
use Carbon\Carbon; 
use App\Profile;
use App\Flight;
use App\Country;
use App\FeePlace;
use App\TypeFee;
use App\Airline;
use App\Aeroport;
use App\City;
use App\FareFamily;
use App\BCType;
use App\Currency;
use App\Schedule;
use DB;


use App\Http\Requests\AddScheduleRequest; 
use App\Http\Requests\EditScheduleRequest;
use App\Http\Requests\SearchScheduleRequest; 


class APISchedulesController extends Controller
{
  public $successStatus = 200;
  


    public function index () {
    	$user = Auth::user();
      $user_id =  Auth::user()->id;
      $profile = Profile::where('user_id', '=', $user_id)->first();
      $schedules =  Schedule::all();
      $airlines = Airline::all();
      $farefamilies = FareFamily::all();
      $cities = City::all();


      $menuActiveItem['schedules'] = 1;

return response()->json(['schedules' => $schedules, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'airlines' => $airlines, 'farefamilies' => $farefamilies, 'cities' => $cities], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
    

    }


public function add(Request $request) {

  $schedules = [];
  $req = $request->all();
  $user = Auth::user();
  $user_email = $user->email;
  $user_id =  $user->id;
    $schedule_id = null;
foreach ($req['segments'] as $key => $value) {

   $schedule = new Schedule;
   $schedule->departure_at = $value['departure_at'];
   $schedule->arrival_at = $value['arrival_at'];
   $schedule->flight_duration = $value['flight_duration'];
   $schedule->is_transplantation = $request->is_transplantation;
   $schedule->monday = $request->monday;
   $schedule->tuesday = $request->tuesday;
   $schedule->wednesday = $request->wednesday;
   $schedule->thursday = $request->thursday;
   $schedule->friday = $request->friday;
   $schedule->saturday = $request->saturday;
   $schedule->sunday = $request->sunday;
   $schedule->airlines_id = $value['airlines_id'];
   $schedule->created_id=$user_id; 
   $schedule->updated_id=$user_id; 
   $schedule->created_at =  Carbon::now();
   $schedule->period_begin_at = $request->period_begin_at;
   $schedule->period_end_at = $request->period_end_at;
   $schedule->flights = $value['flights'];
   $schedule->leg = $value['leg'];
   $schedule->bc_types_id = $value['bc_types_id'];
   //$schedule->time_arrival_transfer_at = Carbon::now();
   $schedule->time_departure_at = $value['time_departure_at'];//Carbon::now();
   $schedule->time_arrival_at =  $value['time_arrival_at'];//Carbon::now();
   $schedule->next_day = $value['next_day'];
   $schedule->save();
   
   if($key == 0){
    $schedule_id =  $schedule->id;
   }else{
    $schedule->schedule_id =  $schedule_id;
    $schedule->save();
   }
   $schedules[] = $schedule;
}
  




  return response()->json(['schedules' => $schedules], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
  
}




public function edit(Request $request) {
$schedules = [];
$req = $request->all();
   $user = Auth::user();
   $user_email = $user->email;
   $user_id =  $user->id;
   $schedule_id = $request->schedule_id;
  foreach ($req['segments'] as $key => $value) {
    $schedule =  Schedule::where( 'id', '=', $schedule_id)->first();
   $schedule->departure_at = $value['departure_at'];
   $schedule->arrival_at = $value['arrival_at'];
   $schedule->is_transplantation = $request->is_transplantation;
   $schedule->flight_duration = $value['flight_duration'];
   $schedule->monday = $request->monday;
   $schedule->tuesday = $request->tuesday;
   $schedule->wednesday = $request->wednesday;
   $schedule->thursday = $request->thursday;
   $schedule->friday = $request->friday;
   $schedule->saturday = $request->saturday;
   $schedule->sunday = $request->sunday;
   $schedule->airlines_id = $value['airlines_id'];
   $schedule->created_id=$user_id; 
   $schedule->updated_id=$user_id; 
   $schedule->created_at =  Carbon::now();
   $schedule->period_begin_at = $request->period_begin_at;
   $schedule->period_end_at = $request->period_end_at;
   $schedule->flights = $value['flights'];
   $schedule->leg = $value['leg'];
   $schedule->bc_types_id = $value['bc_types_id'];
   //$schedule->time_arrival_transfer_at = Carbon::now();
   $schedule->time_departure_at = $value['time_departure_at'];//Carbon::now();
   $schedule->time_arrival_at =  $value['time_arrival_at'];//Carbon::now();
   $schedule->next_day = $value['next_day'];
   $schedule->save();
   
   if($key == 0){
    $schedule_id =  $schedule->id;
   }else{
    $schedule->schedule_id =  $schedule_id;
    $schedule->save();
   }
   $schedules[] = $schedule;
}
  

  return response()->json(['schedules' => $schedules], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
   
}



   public function search(SearchScheduleRequest $request) {

    $user = Auth::user();
    $user_id =  Auth::user()->id;
    $profile = Profile::where('user_id', '=', $user_id)->first();
    $airlines = Airline::all();
    $farefamilies = FareFamily::all();
    $airlines = Airline::all();
    $currencies = Currency::all();
    $schedules =  Schedule::all();
    $farefamilies =  FareFamily::all();
    $currencies = Currency::all();
    $cities = City::all();
    $countries = Country::all();
    $airports = Aeroport::all();
    $bc_types = BCType::all();

      $menuActiveItem['schedules'] = 1;

      
      $query = $request->get('query');

      $schedule_search = Schedule::where('flights', 'LIKE', "%$query%")->paginate(10);

      $total = Schedule::where('flights', 'LIKE', "%$query%")->count();
       
       if ($total > 0) {

return response()->json(['schedule_search' => $schedule_search, 'total' => $total, 'profile' => $profile, 'query' => $query, 'menuActiveItem' => $menuActiveItem, 'airlines' => $airlines, 'farefamilies' => $farefamilies, 'cities' => $cities], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}
    

else {
      
  return response()->json(['schedule_search' => 
    $schedule_search, 'total' => $total, 'profile' => $profile, 'query' => $query, 'menuActiveItem' => $menuActiveItem], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 


      }     

    }







}


  