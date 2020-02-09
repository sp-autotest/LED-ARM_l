<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminCompany as Company;
use Auth;
use App\User;
use Image;
use View;
use Carbon\Carbon; 
use App\Profile;
use App\Schedule;
use App\FareFamily;
use App\Aeroport;
use App\FlightPlace;
use App\BCType;
use App\Flight;
use App\City;
use App\Airline;
use App\Currency;
use App\Http\Requests\SearchBlockRequest;
use App\Http\Requests\AddBlockRequest;
use App\Http\Requests\EditBlockRequest;
use App\Http\Requests\DuplcatedBlockRequest;

use Illuminate\Http\UploadedFile;

class BlocksController extends Controller
{
   public $successStatus = 200;
   public $errorStatus = 400;

   public function __construct()
    {
        $this->middleware('auth');
    }




    public function index () {
    	  $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $schedules =  Schedule::all();
        $airports = Aeroport::all();
        $places = FlightPlace::with(['schedule', 'farefamily'])->get();
        $farefamilies = FareFamily::all();
        $flights = Flight::all();
        $cities = City::all();
        $bc_types = BCType::all();
        $menuActiveItem['blocks'] = 1;

return response()->json(['profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'airports' => $airports, 'bc_types' => $bc_types, 'schedules' => $schedules, 'flights' => $flights, 'places' => $places, 'farefamilies' => $farefamilies, 'cities' => $cities], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

    }




    public function getBlockAdd() {
        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $schedules =  Schedule::paginate(10);
        $places = FlightPlace::paginate(10);
        $airports = Aeroport::paginate(10);
        $bc_types = BCType::paginate(10);
        $cities = City::paginate(10);
        $farefamilies = FareFamily::paginate(10);
        $airlines = Airline::paginate(10);
        $currencies = Currency::paginate(10);
        $menuActiveItem['blocks'] = 1;

        return view('blocks.block-add')->with('profile', $profile)->with('menuActiveItem', $menuActiveItem)->with('airports', $airports)->with('bc_types',$bc_types)->with('schedules',$schedules)->with('places',$places)->with('cities', $cities)->with('airlines', $airlines)->with('farefamilies',$farefamilies)->with('currencies', $currencies);
    }

  




    public function getBlockEdit($id) {
        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $place= FlightPlace::findOrFail($id);
        $schedules =  Schedule::paginate(10);
        $airports = Aeroport::paginate(10);
        $bc_types = BCType::paginate(10);
        $cities = City::paginate(10);
        $airlines = Airline::paginate(10);
        $farefamilies = FareFamily::paginate(10);
        $currencies = Currency::paginate(10);
        $menuActiveItem['blocks'] = 1;

        return view('blocks.block-edit')->with('profile', $profile)->with('menuActiveItem', $menuActiveItem)->with('airports', $airports)->with('bc_types',$bc_types)->with('schedules',$schedules)->with('place',$place)->with('airports', $airports)->with('cities', $cities)->with('airlines', $airlines)->with('farefamilies',$farefamilies)->with('currencies', $currencies);
    }



   public function search(SearchBlockRequest $request) {
       $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $schedules =  Schedule::paginate(10);
        $airports = Aeroport::paginate(10);
        $flights = Flight::paginate(10);
        $farefamilies = FareFamily::paginate(10);
        $bc_types = BCType::paginate(10);
        $menuActiveItem['blocks'] = 1;


   
      
       $query = $request->get('query');

        $blocks_search =FlightPlace::where('count_places', 'LIKE', "%$query%")->paginate(10);

        $total =FlightPlace::where('count_places', 'LIKE', "%$query%")->count();
       
      if ($total > 0) {
        return response()->json(['blocks_search' => $blocks_search, 'total' => $total, 'profile' => $profile, 'query' => $query, 'menuActiveItem' => $menuActiveItem, 'airports' => $airports, 'farefamilies' => $farefamilies, 'schedules' => $schedules], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
        
      }
    
     else {
        return response()->json(['blocks_search' => $blocks_search, 'total' => $total, 'profile' => $profile, 'query' => $query, 'menuActiveItem' => $menuActiveItem], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
       

      }     

    }




public function postBlockAdd(AddBlockRequest $request) {
 
  $user = Auth::user();
  $user_email = $user->email;
  $user_id =  $user->id;

   $place = new FlightPlace;
   $place->count_places = $request->count_places;
   $place->ow = $request->ow;
   $place->infant_ow = $request->infant_ow;
   $place->created_id=$user_id; 
   $place->updated_id=$user_id; 
   $place->created_at =  Carbon::now();
   $place->rt = $request->rt;
   $place->infant_rt = $request->infant_rt;
   $place->infant_ow = $request->infant_ow;
   $place->currency_id = $request->currency_id;
   $place->infant = (isset($request->infant))?$request->infant:false;
   $place->fare_families_id = $request->fare_families_id;
    $place->period_begin_at = $request->period_begin_at;
    $place->period_end_at = $request->period_end_at;
   $place->save();

   $place->schedule()->attach($request->schedule_id);
  


  return response()->json(['place' => $place], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}

public function edit(Request $request) {
 
  $user = Auth::user();
  $user_email = $user->email;
  $user_id =  $user->id;

   $place = FlightPlace::where('id', '=', $request->place_id)->first();
   $place->count_places = $request->count_places;
   $place->ow = $request->ow;
   $place->infant_ow = $request->infant_ow;
   $place->created_id=$user_id; 
   $place->updated_id=$user_id; 
   $place->rt = $request->rt;
   $place->infant_rt = $request->infant_rt;
   $place->infant_ow = $request->infant_ow;
   $place->currency_id = $request->currency_id;
   $place->fare_families_id = $request->fare_families_id;
   $place->period_begin_at = $request->period_begin_at;
   $place->period_end_at = $request->period_end_at;
   $place->save();

   $place->schedule()->attach($request->schedule_id);
  


  return response()->json(['place' => $place], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}


public function getBlockDuplicated($id) {
 
  $flights = [];
   $user = Auth::user();
   //$user_email = $user->email;
   $user_id = $user->id;

   $place = FlightPlace::where('id', '=', $id)->with('schedule')->first()->toArray();
   //dd($place);
   if($place['flight_generated'] == true){return response()->json(['Error' => 'Flights was generated early!'], $this->errorStatus)->header('Access-Control-Allow-Origin', '*'); }
   
   $placef = FlightPlace::where('id', '=', $id)->with('schedule')->first();
   $placef->flight_generated = true;
   $placef->save();

   foreach ($place['schedule'] as $key => $value) {

    $week = [
        0 => $value['sunday'],
        1 => $value['monday'],
        2 => $value['tuesday'],
        3 => $value['wednesday'],
        4 => $value['thursday'],
        5 => $value['friday'],
        6 => $value['saturday'],
    ];
    //dd(Carbon::parse($value['period_begin_at']));
   $datetime1 = Carbon::parse($place['period_begin_at']);
   $datetime2 = Carbon::parse($place['period_end_at']);
   $interval = date_diff($datetime1, $datetime2);
   $days = $interval->days;

     for ($i=0; $i<$days; $i++) {
      
      $currentdate = $datetime1->addDays(1);

        if($week[$currentdate->dayOfWeek] == true){
            $flight = new  Flight;
            $flight->count_places = $place['count_places'];
            $flight->flights_places_id = $place['id'];
            $flight->count_places_reservation = 0;
            $flight->created_id=$user_id; 
            $flight->ow=$place['ow']; 
            $flight->rt=$place['rt']; 
            $flight->infant_ow=$place['infant_ow']; 
            $flight->infant_rt=$place['infant_rt']; 

            $flight->updated_id=$user_id; 
            $flight->created_at =  Carbon::now();
            $flight->date_departure_at = $currentdate->toDateString();
            $flight->save();
            $flights[] = $flight;
        }
     }
   }
   
    return response()->json(['flights' => $flights], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}









}


  