<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminCompany as Company;
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
use App\FareFamily;
use App\BCType;
use App\Currency;
use App\Schedule;
use DB;


use App\Http\Requests\AddScheduleRequest; 
use App\Http\Requests\EditScheduleRequest;
use App\Http\Requests\SearchScheduleRequest; 


class SchedulesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }


    public function index () {
    	$user = Auth::user();
      $user_id =  Auth::user()->id;
      $profile = Profile::where('user_id', '=', $user_id)->first();
      $schedules =  Schedule::paginate(10);
      $airlines = Airline::paginate(10);
      $farefamilies = FareFamily::paginate(10);
      


      $menuActiveItem['schedules'] = 1;

      return view('schedules.index')->with('schedules', $schedules)->with('profile', $profile)->with('menuActiveItem', $menuActiveItem)->with('airlines', $airlines)->with('farefamilies',$farefamilies);

    }








public function getScheduleAdd() {
  
    $user = Auth::user();
    $user_id =  Auth::user()->id;
    $profile = Profile::where('user_id','=',$user_id)->first();
    $schedules =  Schedule::paginate(10);
    $farefamilies =  FareFamily::paginate(10);
    $airlines = Airline::paginate(10);
    $currencies = Currency::paginate(10);
    $countries = Country::paginate(10);
    $airoports = Aeroport::paginate(10);
    $bc_types = BCType::paginate(10);
    $menuActiveItem['schedules'] = 1;


return view('schedules.schedule-add')->with('profile', $profile)->with('menuActiveItem', $menuActiveItem)->with('schedules', $schedules)->with('airlines', $airlines)->with('farefamilies',$farefamilies)->with('currencies',$currencies)->with('airoports', $airoports)->with('countries', $countries)->with ('bc_types',$bc_types);
}


public function postScheduleAdd(AddScheduleRequest $request) {
 

   $user = Auth::user();
   $uid=intval($request->get('uid'));
   $user_id =  Auth::user()->id;
   $user_email = Auth::user()->email;
   $schedule = new Schedule;
   $schedule->departure_at = intval($request->get('departure_at'));
   $schedule->arrival_at = intval($request->get('arrival_at'));
   $schedule->is_transplantation = intval($request->get('is_transplantation'));
   $schedule->monday = 1;//$request->get('monday');
   $schedule->tuesday = 1;//$request->get('tuesday');
   $schedule->wednesday = 1;// $request->get('wednesday');
   $schedule->friday = 1;//$request->get('friday');
   $schedule->saturday = 1;//$request->get('saturday');
   $schedule->sunday = 1;//$request->get('sunday');
   $schedule->airlines_id = intval($request->get('airlines_id'));
   $schedule->created_id=$user_id; 
   $schedule->updated_id=$user_id; 
   $schedule->created_at =  Carbon::now();
   $schedule->period_begin_at = Carbon::now();//intval($request->get('period_begin_at'));
   $schedule->period_end_at = Carbon::now();//intval($request->get('period_end_at'));
   $schedule->flights = $request->get('flights');
   $schedule->leg = intval($request->get('leg'));
   $schedule->bc_types_id = intval($request->get('bc_types_id'));
   //$schedule->time_arrival_transfer_at = Carbon::now();
   $schedule->time_departure_at = Carbon::now();
   $schedule->time_arrival_at =  Carbon::now();
   $schedule->next_day = $request->get('next_day');
   $schedule->save();


  $data = [

  'date_start' => $request->get('date_start'),
  'date_stop' => $request->get('date_stop'), 
  'period_begin_at'=> $request->get('period_begin_at'), 
  'airlines_id'  => $request->get('airlines_id'), 
  //'departure_city' => $request->get('departure_city'), 
 // 'arrival_city' => $request->get('arrival_city'), 
  'type_action'  => $request->get('type_action'), 
  'non_return' => $request->get('non_return'), 
  'fare_families_id' => $request->get('fare_families_id'), 
  'type_flight'  => $request->get('type_flight'), 
  'infant'  => $request->get('infant'), 
  'country_id_departure' => $request->get('country_id_departure'), 
  'country_id_arrival'  => $request->get('country_id_arrival'), 
  'type_fees_inscribed'  => $request->get('type_fees_inscribed'), 
  'type_fees_charge'  => $request->get('type_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'max_fees_inscribed'  => $request->get('max_fees_inscribed'), 
  'max_fees_charge'  => $request->get('max_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'type_deviation'  => $request->get('type_deviation'), 
  'size_deviation'  => $request->get('size_deviation'),
   'departure_at' => $request->get('departure_at'),
   'arrival_at' =>$request->get('arrival_at'),
   'is_transplantation' => $request->get('is_transplantation'),
   'monday' => $request->get('monday'),
   'tuesday' => $request->get('tuesday'),
   'wednesday' => $request->get('wednesday'),
   'friday' => $request->get('friday'),
   'saturday' => $request->get('saturday'),
   'sunday' => $request->get('sunday'),
   'airlines_id' => intval($request->get('airlines_id')),
   'created_id' => $user_id,
   'updated_id'=>$user_id,
   'created_at' =>  Carbon::now(),
   'period_begin_at' => intval($request->get('period_begin_at')),
   'period_end_at' => intval($request->get('period_end_at')),
   'flights' => $request->get('flights'),
   'leg' => intval($request->get('leg')),
   'bc_types_id' => intval($request->get('bc_types_id')),
   'time_arrival_transfer_at' => Carbon::now(),
   'time_departure_at' => Carbon::now(),
   'time_arrival_at' =>  Carbon::now(),
   'next_day' => $request->get('next_day')



];
 


\Mail::send('emails.schedule_add', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новое расписание создано');
});


  return redirect('schedules');

}




public function postScheduleEdit(EditScheduleRequest $request) {


  $user = Auth::user();
  $user_id =  Auth::user()->id;
  $user_email = Auth::user()->email;
   
   $schedule_id = intval($request->get('schedule_id'));
   $schedule =  Schedule::where( 'id', '=', $schedule_id)->first();
   $schedule->departure_at = intval($request->get('departure_at'));
   $schedule->arrival_at = intval($request->get('arrival_at'));
   $schedule->is_transplantation = intval($request->get('is_transplantation'));
   $schedule->monday = 1;//$request->get('monday');
   $schedule->tuesday = 1;//$request->get('tuesday');
   $schedule->wednesday = 1;// $request->get('wednesday');
   $schedule->friday = 1;//$request->get('friday');
   $schedule->saturday = 1;//$request->get('saturday');
   $schedule->sunday = 1;//$request->get('sunday');
   $schedule->airlines_id = intval($request->get('airlines_id'));
   $schedule->created_id=$user_id; 
   $schedule->updated_id=$user_id; 
   $schedule->created_at =  Carbon::now();
   $schedule->period_begin_at = Carbon::now();//intval($request->get('period_begin_at'));
   $schedule->period_end_at = Carbon::now();//intval($request->get('period_end_at'));
   $schedule->flights = $request->get('flights');
   $schedule->leg = intval($request->get('leg'));
   $schedule->bc_types_id = intval($request->get('bc_types_id'));
   //$schedule->time_arrival_transfer_at = Carbon::now();
   $schedule->time_departure_at = Carbon::now();
   $schedule->time_arrival_at =  Carbon::now();
   $schedule->next_day = $request->get('next_day');
   $schedule->save();


  $data = [

  'date_start' => $request->get('date_start'),
  'date_stop' => $request->get('date_stop'), 
  'period_begin_at'=> $request->get('period_begin_at'), 
  'airlines_id'  => $request->get('airlines_id'), 
  //'departure_city' => $request->get('departure_city'), 
  //'arrival_city' => $request->get('arrival_city'), 
  'type_action'  => $request->get('type_action'), 
  'non_return' => $request->get('non_return'), 
  'fare_families_id' => $request->get('fare_families_id'), 
  'type_flight'  => $request->get('type_flight'), 
  'infant'  => $request->get('infant'), 
  'country_id_departure' => $request->get('country_id_departure'), 
  'country_id_arrival'  => $request->get('country_id_arrival'), 
  'type_fees_inscribed'  => $request->get('type_fees_inscribed'), 
  'type_fees_charge'  => $request->get('type_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'max_fees_inscribed'  => $request->get('max_fees_inscribed'), 
  'max_fees_charge'  => $request->get('max_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'type_deviation'  => $request->get('type_deviation'), 
  'size_deviation'  => $request->get('size_deviation'),
   'departure_at' => $request->get('departure_at'),
   'arrival_at' =>$request->get('arrival_at'),
   'is_transplantation' => $request->get('is_transplantation'),
   'monday' => $request->get('monday'),
   'tuesday' => $request->get('tuesday'),
   'wednesday' => $request->get('wednesday'),
   'friday' => $request->get('friday'),
   'saturday' => $request->get('saturday'),
   'sunday' => $request->get('sunday'),
   'airlines_id' => intval($request->get('airlines_id')),
   'created_id' => $user_id,
   'updated_id'=>$user_id,
   'created_at' =>  Carbon::now(),
   'period_begin_at' => intval($request->get('period_begin_at')),
   'period_end_at' => intval($request->get('period_end_at')),
   'flights' => $request->get('flights'),
   'leg' => intval($request->get('leg')),
   'bc_types_id' => intval($request->get('bc_types_id')),
   'time_arrival_transfer_at' => Carbon::now(),
   'time_departure_at' => Carbon::now(),
   'time_arrival_at' =>  Carbon::now(),
   'next_day' => $request->get('next_day')

];
 


\Mail::send('emails.schedule_edit', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to($user_email)->cc(env('MAIL_FROM'), env('MAIL_NAME'));
$message->subject('Расписание отредактировано');
});


  return redirect('schedules');

}



public function getScheduleEdit($id) {
    $user = Auth::user();
    $user_id =  Auth::user()->id;
    $profile = Profile::where('user_id','=',$user_id)->first();
    $schedule =  Schedule::findOrFail($id);
    $airlines = Airline::paginate(10);
    $schedules =  Schedule::paginate(10);
    $farefamilies =  FareFamily::paginate(10);
    $currencies = Currency::paginate(10);
    $countries = Country::paginate(10);
    $airoports = Aeroport::paginate(10);
    $bc_types = BCType::paginate(10);
    $menuActiveItem['schedules'] = 1;


return view('schedules.schedule-edit')->with('schedule', $schedule)->with('airlines', $airlines)->with('farefamilies',$farefamilies)->with('currencies',$currencies)->with('airoports', $airoports)->with('countries', $countries)->with ('bc_types',$bc_types);

 }

   public function search(SearchScheduleRequest $request) {

    $user = Auth::user();
    $user_id =  Auth::user()->id;
    $profile = Profile::where('user_id', '=', $user_id)->first();
    $airlines = Airline::paginate(10);
    $farefamilies = FareFamily::paginate(10);
    $airlines = Airline::paginate(10);
    $currencies = Currency::paginate(10);
    $schedules =  Schedule::paginate(10);
    $farefamilies =  FareFamily::paginate(10);
    $currencies = Currency::paginate(10);
    $countries = Country::paginate(10);
    $airports = Aeroport::paginate(10);
    $bc_types = BCType::paginate(10);

      $menuActiveItem['schedules'] = 1;

      
      $query = $request->get('query');

      $schedule_search = Schedule::where('flights', 'LIKE', "%$query%")->paginate(10);

      $total = Schedule::where('flights', 'LIKE', "%$query%")->count();
       
       if ($total > 0) {

        return view('schedules.search')->with('schedule_search',$schedule_search)->with('total',$total)->with('profile',$profile)->with('query',$query)->with('menuActiveItem', $menuActiveItem)->with('airlines', $airlines)->with('farefamilies',$farefamilies); 
    }
    
     else {

       return view('schedules.nosearch')->with('schedule_search',$schedule_search)->with('total',$total)->with('profile',$profile)->with('query',$query)->with('menuActiveItem', $menuActiveItem);

      }     

    }







}


  