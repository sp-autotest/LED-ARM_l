<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Profile;
use View;
use Carbon\Carbon; 
use App\Order;
use App\AdminCompany as Company;
use App\Ticket;
use App\Passenger;
use App\Service;
use App\Currency;
use App\Country;
use App\City;
use App\FeePlace;
use App\TypeFee;
use App\BCType;
use App\FareFamily;
use App\Aeroport;
use App\Flight;
use App\Airline;
use App\Schedule;
use App\Provider;
use App\Accounts;

 use App\Http\Requests\OrderBlockEditRequest;
 use App\Http\Requests\TicketBlockEditRequest;




class APIBlocksOrdersController extends Controller
{
  
   public $successStatus = 200;
   public $errorStatus = '400';




 public function index(Request $request) {
      $limit = (isset($request->limit)?$request->limit:10);
      $orders= Order::paginate($limit);
      return response()->json(['orders'=>$orders ], $this->successStatus);
    }






 public function getBlockTickets() {
      
    
        $user =  Auth::user();
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['blocksorders'] = 1;
        $services = Service::paginate(10);
        $flights = Flight::paginate(10);
        $tickets = Ticket::paginate(10);
        $companies = Company::paginate(10);
        $farefamilies = FareFamily::paginate(10);
        $airoports = Aeroport::paginate(10);
        $cities = City::paginate(10); 

       return response()->json(['companies' => $companies, 'flights'=>$flights,'farefamilies'=> $farefamilies, 'profile' => $profile,  'airoports'=> $airoports, 'cities'=>$cities, 
         'menuActiveItem' => $menuActiveItem, 'tickets' => $tickets, 'user' => $user, 'profile' => $profile,'orders'=>$orders ], $this->successStatus); 

    
    }





  
 public function getBlockTicket($id) {
      
    
        $user =  Auth::user();
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['blocksorders'] = 1;
        $services = Service::paginate(10);
        $flight = Flight::findOrFail($id);
        $ticket = Ticket::paginate(10);
        $companies = Company::paginate(10);
        $farefamilies = FareFamily::paginate(10);
        $airoports = Aeroport::paginate(10);
        $cities = City::paginate(10); 

       return response()->json(['companies' => $companies, 'flight'=>$flight,'farefamilies'=> $farefamilies, 'profile' => $profile,  'airoports'=> $airoports, 'cities'=>$cities, 
         'menuActiveItem' => $menuActiveItem, 'tickets' => $tickets, 'user' => $user, 'profile' => $profile,'orders'=>$orders ], $this->successStatus); 
 
    
    }







 public function getBlockOrder($id) {
      
     
        $user =  Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['blocksorders'] = 1;
        $flight= Flight::findOrFail($id);
        $services = Service::paginate(10);
        $orders = Orders::paginate(10);
        $tickets = Ticket::paginate(10);
        $companies = Company::paginate(10);
        $pessangers = Passenger::paginate(10);
        $airlines = Airline::paginate(10);
        $prefix=542;
        $rand = random_int(1,10000000000000);
        $ticket_number =$prefix.$rand;
        $countries = Country::all();

       return response()->json(['companies' => $companies, 'flight'=>$flight,'profile' => $profile,  'services'=> $services, 'menuActiveItem' => $menuActiveItem, 'tickets' => $tickets, 'user' => $user,'user_id'=>$user_id,'countries'=>$countries,'ticket_number'=> $ticket_number,'airlines'=>$airlines,'pessangers' =>$pessangers, 'profile' => $profile,'orders'=>$orders ], $this->successStatus); 
  

    
    }


public function postTicketBlockEdit(TicketBlockEditRequest $request) {
 
   $id = intval($request->get('id'));
   $count_places = intval($request->count_places);
   $count_places_reservation= intval($request->count_places_reservation);
   $new_count_places_reservation = $count_places - $count_places_reservation;

   $flight = Flight::findOrFail($id);
   $flight->count_places = $count_places;
   $flight->count_places_reservation = $new_count_places_reservation;
   $flight->updated_at = Carbon::now(); 
   $flight->save();



  return response()->json(['flight' => $flight], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}



public function postOrderBlockEdit(Request $request) {
 
 $user =  Auth::user();
 $user_id =  Auth::user()->id;
 $id = intval($request->id);
 $order = Order::findOrFail($id);
 foreach ($request->tickets as $tickets){
     $ticket = Ticket::where('id','=',$tickets['id'])->first();
     $rate_fare = floatval($tickets['rate_fare']);
     $tax_fare = floatval($tickets['tax_fare']);
     $summ_ticket = $tax_fare + $rate_fare;
     $ticket->ticket_number = intval($tickets['ticket_number']);
     $ticket->rate_fare= $rate_fare;
     $ticket->types_fees_fare= $tickets['types_fees_fare'];
     $ticket->tax_fare= $tax_fare;
     $ticket->summ_ticket = $summ_ticket;
     $ticket->save();
 }
 $passenger_id = $order->passengers;
 $service_id = $order->services()->get();




 $passenger = Passenger::where('id','=',$passenger_id)->first();


foreach ( $service_id as $serviced){
    $service = Service::where('id','=',$serviced->id)->first();
    $service->pnr= $request->pnr;
    $service->updated_at = Carbon::now();
    $service->save();

    $order_id= $service->order_id;

    $order = Order::where('id','=',$order_id)->first();
    $order->status= $request->status;
    $order->updated_at = Carbon::now();
    $order->time_limit = $request->time_limit;
    $order->gds_ticket = ($request->gds_ticket == "true")?true:false;
    $order->save();
}




return response()->json(['order' => $order], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}






}
