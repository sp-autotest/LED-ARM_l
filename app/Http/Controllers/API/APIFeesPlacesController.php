<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller; 
use App\AdminCompany as Company;
use Auth;
use App\User;
use View;
use Carbon\Carbon; 
use App\Profile;
use App\Currency;
use App\Country;
use App\City;
use App\FeePlace;
use App\FareFamily;
use App\TypeFee;
use App\Airline;
use App\Aeroport;
use App\BCType;
use DB;



use App\Http\Requests\SearchFeePlaceRequest;
use App\Http\Requests\CopyFeePlaceRequest;
use App\Http\Requests\EditFeePlaceRequest;
use App\Http\Requests\AddFeePlaceRequest;
use App\Http\Requests\FeelPlaceCopyReplaceRequest;



class APIFeesPlacesController  extends Controller
{
   public $successStatus = 200;


  public function index(Request $request) {

         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $company = (isset($request->company))?$request->company:Auth::user()->company_id;
         $feesplaces = FeePlace::where('company_id', '=', $company)->get()->toArray();
         $menuActiveItem['feesplaces'] = 1;
         $typefees =  TypeFee::all();
         $cities = City::all();
         $countries = Country::all();
         $airlines = Airline::all();
         $airports = Aeroport::all();
         $farefamilies = FareFamily::all();


return response()->json(['feesplaces' => $feesplaces, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'typefees' => $typefees, 'cities' => $cities, 'countries' => $countries, 'airlines' => $airlines,  'farefamilies' => $farefamilies, 'airports' => $airports], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

        

 }


    public function search(SearchFeePlaceRequest $request) {

         $user = Auth::user();
         $user_id = Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $query = $request->query;
         $menuActiveItem['feesplaces'] = 1;
         $typefees =  TypeFee::all();
         $cities = City::all();
         $airlines = Airline::all();
         $farefamilies = FareFamily::all();
     
         
         $feesplaces_search  = DB::table('fees_places')
        ->join('fare_families', 'fees_places.fare_families_id', '=', 'fare_families.id')
        ->select('fees_places.*', 'fare_families.*')->where('fare_families.name_ru', 'like', '%'.$query.'%')->paginate(10); 
       

       $total = DB::table('fees_places')
        ->join('fare_families', 'fees_places.fare_families_id', '=', 'fare_families.id')
        ->select('fees_places.*', 'fare_families.*')->where('fare_families.name_ru', 'like', '%'.$query.'%')->count();
    
       if ($total > 0) {

       $fare =  FareFamily::where('name_ru','like', '%'.$query.'%')->first();
       $fare_id = intval ($fare->id);

       $feesplace = FeePlace::where('fare_families_id','=', $fare_id)->first();
       $feesplace_id = intval( $feesplace->id);

return response()->json(['feesplaces_search' => $feesplaces_search, 'total' => $total, 'profile' => $profile, 'query' => $query, 'menuActiveItem' => $menuActiveItem, 'typefees' => $typefees, 'cities' => $cities, 'airlines' => $airlines, 'feesplace_id' => $feesplace_id, 'farefamilies' => $farefamilies], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

        
    }
    
     else {

    return response()->json(['feesplaces_search' => $feesplaces_search, 'total' => $total, 'profile' => $profile, 'query' => $query, 'menuActiveItem' => $menuActiveItem], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

       

      }   	

    }


public function edit(EditFeePlaceRequest $request) {
    
  
  $user = Auth::user();
  //$user->email = $user_email;
  $user_id =  $user->id;
  $feeplace = (isset($request->feeplace_id))?FeePlace::where( 'id', '=', $request->feeplace_id )->first():new FeePlace;

  $savedfeeplace = json_decode(json_encode($feeplace->toArray()), true);

  $feeplace->date_start =  $request->date_start;
  $feeplace->date_stop = $request->date_stop ;
  $feeplace->company_id = $request->company_id;
  $feeplace->period_begin_at = $request->period_begin_at; 
  $feeplace->period_end_at= $request->period_end_at ;
  $feeplace->airlines_id  = $request->airlines_id;
  $feeplace->departure_city = $request->departure_city;
  $feeplace->arrival_city = $request->arrival_city;
 /// $feeplace->type_action  = intval(1);//$request->type_action 
  $feeplace->non_return = $request->non_return; 
  $feeplace->fare_families_id = $request->fare_families_id; 
  $feeplace->type_flight  = $request->type_flight; 
  $feeplace->types_fees_id =  $request->types_fees_id;
  $feeplace->infant  = $request->infant;
  $feeplace->country_id_departure=$request->country_id_departure;
  $feeplace->country_id_arrival  = $request->country_id_arrival;
  $feeplace->type_fees_inscribed  = $request->type_fees_inscribed;
  $feeplace->type_fees_charge  = $request->type_fees_charge;
  $feeplace->type_deviation  = $request->type_deviation;
  $feeplace->size_fees_exchange  = $request->size_fees_exchange;
  $feeplace->max_fees_inscribed  = $request->max_fees_inscribed;
  $feeplace->size_fees_inscribed  = $request->size_fees_inscribed; 
  $feeplace->max_fees_inscribed  = $request->max_fees_inscribed;
  $feeplace->min_fees_inscribed  = $request->min_fees_inscribed;
  $feeplace->max_fees_charge  = $request->max_fees_charge;
  $feeplace->min_fees_charge  = $request->min_fees_charge;
  $feeplace->max_fees_exchange  = $request->max_fees_exchange;
  $feeplace->min_fees_exchange  = $request->min_fees_exchange;
  $feeplace->size_fees_exchange  = $request->size_fees_exchange;
  $feeplace->size_fees_charge  = $request->size_fees_charge;
  $feeplace->size_deviation  =$request->size_deviation;  
  $feeplace->updated_id=$user_id; 
  $feeplace->save();
 event(new \App\Events\HistoryEvent($feeplace,  $savedfeeplace, "Редактирование сбора" ));
 return response()->json(['feesplace' => $feeplace], $this->successStatus)->header('Access-Control-Allow-Origin', '*');  

 }




public function postFeePlaceCopyReplace(FeelPlaceCopyReplaceRequest  $request) {
    
   
   $user = Auth::user();
   $user_id =  $user->id;

 
   $company_id1 = $request->company_id1;
   $company_id2 = $request->company_id2;


  

   $feesplaces1 = FeePlace::where('company_id','=',$company_id1)->get();

   $delfeesplaces2 = FeePlace::where('company_id','=',$company_id2)->delete();  

  
   FeePlace::insert($feesplaces1);
   


  
 $data = [

  'date_start' => $request->date_start,
  'date_stop' => $request->date_stop, 
  'period_begin_at'=> $request->period_begin_at, 
  'airlines_id'  => $request->airlines_id, 
  'departure_city' => $request->departure_city, 
  'arrival_city' => $request->arrival_city, 
  'type_action'  => $request->type_action, 
  'non_return' => $request->non_return, 
  'fare_families_id' => $request->fare_families_id, 
  'type_flight'  => $request->type_flight, 
  'infant'  => $request->infant, 
  'country_id_departure' => $request->country_id_departure, 
  'country_id_arrival'  => $request->country_id_arrival, 
  'type_fees_inscribed'  => $request->type_fees_inscribed, 
  'type_fees_charge'  => $request->type_fees_charge, 
  'size_fees_exchange'  => $request->size_fees_exchange, 
  'max_fees_inscribed'  => $request->max_fees_inscribed, 
  'max_fees_charge'  => $request->max_fees_charge, 
  'size_fees_exchange'  => $request->size_fees_exchange, 
  'type_deviation'  => $request->type_deviation, 
  'size_deviation'  => $request->size_deviation


];
 


\Mail::send('emails.feeplace_copy', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
//$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый сбор скопирован с заменой');
});


  return redirect('feesplaces');

 }

public function getChild($data){
      
      $ids[] = $data['id'];

      if(count($data['childs']) > 0){
       foreach ($data['childs'] as $key => $value) {
         $ids = array_merge($ids, $this->getChild($value));
       }
      }
      return $ids;
    }



public function replace(Request $request) {
  $feeplace = [];
  event(new \App\Events\HistoryEvent($feeplace, [], "Копирование с изменением сбора" ));
}
public function copy(Request $request) {
  $user = Auth::user();
  //$user->email = $user_email;
  Company::where('id', '=', Auth::user()->company_id)->with(['currency', 'childs', 'parent', 'manager', 'feeplaces', 'ads', 'account', 'staff'])->first();

  $user_id =  $user->id;
  $feeplace = FeePlace::find($request->id);
  $newFeeplace = $feeplace->replicate();
  $newFeeplace->created_id=$user_id; 
  $newFeeplace->updated_id=$user_id; 
  $newFeeplace->save();
   event(new \App\Events\HistoryEvent($feeplace,  $newFeeplace, "Копирование сбора" ));
  return response()->json(['feesplace' => $newFeeplace], $this->successStatus)->header('Access-Control-Allow-Origin', '*');  
 }


 public function add(AddFeePlaceRequest  $request) {


  $user = Auth::user();
  $user_email = $user->email;
  $user_id =  $user->id;
     $feeplace = (isset($request->feeplace_id))?FeePlace::where( 'id', '=', $request->feeplace_id )->first():new FeePlace;

  $feeplace->date_start =  $request->date_start;
  $feeplace->date_stop = $request->date_stop ;
  $feeplace->company_id = $request->company_id;
  $feeplace->period_begin_at= $request->period_begin_at ;
  $feeplace->period_end_at= $request->period_end_at ;
  $feeplace->airlines_id  = $request->airlines_id; 
  $feeplace->departure_city = $request->departure_city; 
  $feeplace->arrival_city = $request->arrival_city; 
  //$feeplace->type_action  = intval(1);//$request->type_action 
  $feeplace->non_return = $request->non_return; 
  $feeplace->fare_families_id = $request->fare_families_id; 
  $feeplace->type_flight  = $request->type_flight; 
  $feeplace->types_fees_id =  $request->types_fees_id;
  $feeplace->infant  = $request->infant; 
  $feeplace->country_id_departure=$request->country_id_departure; 
  $feeplace->country_id_arrival  = $request->country_id_arrival; 
  $feeplace->type_fees_inscribed  = $request->type_fees_inscribed; 
  $feeplace->type_fees_charge  = $request->type_fees_charge; 
  $feeplace->type_deviation  = $request->type_deviation; 
  $feeplace->size_fees_exchange  = $request->size_fees_exchange; 
  $feeplace->max_fees_inscribed  = $request->max_fees_inscribed; 
  $feeplace->size_fees_inscribed  = $request->size_fees_inscribed; 
  $feeplace->max_fees_inscribed  = $request->max_fees_inscribed;
  $feeplace->min_fees_inscribed  = $request->min_fees_inscribed;
  $feeplace->max_fees_charge  = $request->max_fees_charge; 
  $feeplace->min_fees_charge  = $request->min_fees_charge; 
  $feeplace->max_fees_exchange  = $request->max_fees_exchange; 
  $feeplace->min_fees_exchange  = $request->min_fees_exchange; 
  $feeplace->size_fees_exchange  = $request->size_fees_exchange; 
  $feeplace->size_fees_charge  = $request->size_fees_charge; 
  $feeplace->size_deviation  =$request->size_deviation; 
  $feeplace->created_id=$user_id; 
  $feeplace->updated_id=$user_id; 
  $feeplace->created_at =  Carbon::now();
  $feeplace->save();
  event(new \App\Events\HistoryEvent($feeplace, [], "Создание сбора" ));
 $data = [

  'date_start' => $request->date_start,
  'date_stop' => $request->date_stop, 
  'period_begin_at'=> $request->period_begin_at, 
  'airlines_id'  => $request->airlines_id, 
  'departure_city' => $request->departure_city, 
  'arrival_city' => $request->arrival_city, 
  'type_action'  => $request->type_action, 
  'non_return' => $request->non_return, 
  'fare_families_id' => $request->fare_families_id, 
  'type_flight'  => $request->type_flight, 
  'infant'  => $request->infant, 
  'country_id_departure' => $request->country_id_departure, 
  'country_id_arrival'  => $request->country_id_arrival, 
  'type_fees_inscribed'  => $request->type_fees_inscribed, 
  'type_fees_charge'  => $request->type_fees_charge, 
  'size_fees_exchange'  => $request->size_fees_exchange, 
  'max_fees_inscribed'  => $request->max_fees_inscribed, 
  'max_fees_charge'  => $request->max_fees_charge, 
  'size_fees_exchange'  => $request->size_fees_exchange, 
  'type_deviation'  => $request->type_deviation, 
  'size_deviation'  => $request->size_deviation


];
 


\Mail::send('emails.feeplace_add', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
//$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый сбор создан');
});


return response()->json(['feesplace' => $feeplace], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

 
  }
 










}
